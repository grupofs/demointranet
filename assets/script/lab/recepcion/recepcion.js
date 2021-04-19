
var otblListRecepcion, otblListdetrecepcion, otblListProducto;
var varfdesde = '%', varfhasta = '%';


$(document).ready(function() {
    $('#tablab a[href="#tablab-list-tab"]').attr('class', 'disabled');
    $('#tablab a[href="#tablab-reg-tab"]').attr('class', 'disabled active');

    $('#tablab a[href="#tablab-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tablab a[href="#tablab-list"]').attr('class', 'active');
        $('#tablab a[href="#tablab-reg"]').attr('class', '');
        return true;
    });
    $('#tablab a[href="#tablab-reg-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tablab a[href="#tablab-reg"]').attr('class' ,'active');
        $('#tablab a[href="#tablab-list"]').attr('class', '');
        return true;
    });
    
    $('#tablab a[href="#tablab-list"]').click(function(event){return false;});
    $('#tablab a[href="#tablab-reg"]').click(function(event){return false;});

    $('#txtFDesde,#txtFHasta,#mtxtFRecep').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });

    fechaAnioActual();
    $('#chkFreg').prop("checked", true);
    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboclieserv",
        dataType: "JSON",
        async: true,
        success:function(result){
            $('#cboclieserv').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });

    $('#frmRecepcion').validate({
        rules: {
            mtxtmproductoreal: {
                required: true,
            },
        },
        messages: {
            mtxtmproductoreal: {
                required: "Por Favor ingrese Nombre del Producto"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },        
        submitHandler: function (form) {
            var request = $.ajax({
                url:$('#frmRecepcion').attr("action"),
                type:$('#frmRecepcion').attr("method"),
                data:$('#frmRecepcion').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    otblListProducto.ajax.reload(null,false);
                    Vtitle = 'La Recepcion esta Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                    $('#mbtnCCreaProduc').click();    
                });
            });
            return false;
        }
    });
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

fechaAnioActual = function(){
    $("#txtFIni").prop("disabled",false);
    $("#txtFFin").prop("disabled",false);
        
    varfdesde = '';
    varfhasta = '';
    
    var fecha = new Date();		
    var fechatring1 = "01/01/" + (fecha.getFullYear() - 1) ;
    var fechatring2 = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring1, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring2, 'DD/MM/YYYY') );
};
	
$('#txtFDesde').on('change.datetimepicker',function(e){	
    
    $('#txtFHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    var fecha = moment(e.date).format('DD/MM/YYYY');		
    
    $('#txtFHasta').datetimepicker('minDate', fecha);
    $('#txtFHasta').datetimepicker('date', fecha);

});

$("#chkFreg").on("change", function () {
    if($("#chkFreg").is(":checked") == true){ 
        $("#txtFIni").prop("disabled",false);
        $("#txtFFin").prop("disabled",false);
        
        varfdesde = '';
        varfhasta = '';

        
        var fecha = new Date();		
        var fechatring1 = "01/01/" + (fecha.getFullYear() - 1) ;
        var fechatring2 = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
        $('#txtFDesde').datetimepicker('date', fechatring1);
        $('#txtFHasta').datetimepicker('date', fechatring2);

    }else if($("#chkFreg").is(":checked") == false){ 
        $("#txtFIni").prop("disabled",true);
        $("#txtFFin").prop("disabled",true);
        
        varfdesde = '%';
        varfhasta = '%';

        fechaActual();
    }; 
});

$("#btnBuscar").click(function (){
    listarBusqueda();
});

listarBusqueda = function(){
    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 
    
    var groupColumn = 0;   
    otblListRecepcion = $('#tblListRecepcion').DataTable({  
        'responsive'    : false,
        'bJQueryUI'     : true,
        'scrollY'     	: '400px',
        'scrollX'     	: true, 
        'paging'      	: true,
        'processing'  	: true,     
        'bDestroy'    	: true,
        'AutoWidth'     : false,
        'info'        	: true,
        'filter'      	: true, 
        'ordering'		: false,  
        'stateSave'     : true,
        'ajax'	: {
            "url"   : baseurl+"lab/recepcion/crecepcion/getbuscarrecepcion/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente  = $('#cboclieserv').val();
                d.fini      = varfdesde; 
                d.ffin      = varfhasta;   
                d.descr     = $('#txtdescri').val(); 
                d.estado    = $('#cboestado').val(); 
                d.tieneot   = $('#cbotieneot').val(); 
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {
              "class"     :   "index col-xs",
              orderable   :   false,
              data        :   null,
              targets     :   0,
            },
            {"orderable": false, data: 'DCLIENTE', targets: 1},
            {"orderable": false, data: null, defaultContent: '', "className":"details-control col-xs", targets: 2},
            {"orderable": false, data: 'NROCOTI', targets: 3},
            {"orderable": false, data: 'DFECHA', targets: 4},
            {"orderable": false, data: 'ENTREGAINFO', targets: 5},
            {"orderable": false, data: 'MONTOSINIGV', "class" : "col-s dt-body-right", targets: 6},
            {"orderable": false, data: 'ITOTAL', "class" : "col-s dt-body-right", targets: 7},
            {"orderable": false, data: 'ELABORADO', targets: 8},
            {"orderable": false, 
                render:function(data, type, row){            
                    if(row.SCOTIZACION == "S"){
                        varCerrar = '<a id="aAbrirCoti" href="'+row.IDCOTIZACION+'" nver="'+row.NVERSION+'" title="Abrir" style="cursor:pointer; color:blue;"><span class="far fa-folder-open fa-2x" aria-hidden="true"> </span></a>'
                    }else{
                        varCerrar = '<a id="aCerrarCoti" href="'+row.IDCOTIZACION+'" nver="'+row.NVERSION+'" title="Cerrar" style="cursor:pointer; color:red;"><span class="far fa-folder fa-2x" aria-hidden="true"> </span></a>'
                    };
                    return '<div class="text-left" >' +
                        '<a title="Recepcion" style="cursor:pointer; color:green;" onClick="selRecep(\'' + row.IDCOTIZACION + '\',\'' + row.NVERSION + '\',\'' + row.DCLIENTE + '\',\'' + row.NROCOTI + '\');"><span class="fas fa-edit fa-2x" aria-hidden="true"> </span> </a>'+
                        '&nbsp;&nbsp;'+
                        varCerrar
                    '</div>';
                }
            }
        ],  
        "columnDefs": [
            {
                "targets": [2], 
                "createdCell": function (td, cellData, rowData, row, col) {
                        if (rowData.TIENEOT == 'N') {
                            $(td).removeClass( 'details-control' );
                        }
                }
            },{
                "targets": [3], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                    '    <p><a title="Cotozacion" style="cursor:pointer;" onclick="pdfCoti(\'' + row.IDCOTIZACION + '\',\'' + row.NVERSION + '\');"  class="pull-left">'+row.NROCOTI+'&nbsp;&nbsp;<i class="fas fa-file-pdf" style="color:#FF0000;"></i></a><p>' +
                    '</div>';
                }
            }
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([1], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(1).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        }
    }); 
    otblListRecepcion.column(0).visible( false ); 
    otblListRecepcion.column(1).visible( false );      
    // Enumeracion 
    otblListRecepcion.on( 'order.dt search.dt', function () { 
        otblListRecepcion.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();   
};
/* DETALLE RECEPCION */
$('#tblListRecepcion tbody').on( 'click', 'td.details-control', function () {
    var tr = $(this).parents('tr');
    var row = otblListRecepcion.row(tr);
    var rowData = row.data();
    
        if ( row.child.isShown() ) {                    
            row.child.hide();
            tr.removeClass( 'details' );
        }
        else {
            otblListRecepcion.rows().every(function(){
                // If row has details expanded
                if(this.child.isShown()){
                    // Collapse row details
                    this.child.hide();
                    $(this.node()).removeClass('details');
                }
            })
            row.child( 
            '<table id="tblListdetrecepcion" class="display compact" style="width:100%; padding-left:75px; background-color:#D3DADF; padding-top: -10px; border-bottom: 2px solid black;">'+
            '<thead style="background-color:#FFFFFF;"><tr><th></th><th>Nro OT</th><th>Fecha OT</th><th>Archivo</th><th></th></tr></thead><tbody>' +
                '</tbody></table>').show();

                otblListdetrecepcion = $('#tblListdetrecepcion').DataTable({
                    "bJQueryUI": true,
                    'bStateSave': true,
                    'scrollY':        false,
                    'scrollX':        true,
                    'scrollCollapse': false,
                    'bDestroy'    : true,
                    'paging'      : false,
                    'info'        : false,
                    'filter'      : false,   
                    'stateSave'   : true,
                    'ajax'        : {
                        "url"   : baseurl+"lab/recepcion/crecepcion/getlistdetrecepcion",
                        "type"  : "POST", 
                        "data": function ( d ) {
                            d.cinternocotizacion = rowData.IDCOTIZACION;
                            d.nversioncotizacion = rowData.NVERSION;
                        },     
                        dataSrc : ''        
                    },
                    'columns'     : [
                        {
                          "class"     :   "index col-xxs",
                          orderable   :   false,
                          data        :   null,
                          targets     :   0
                        },
                        { "orderable": false,"data": "nordentrabajo", "class" : "col-sm", targets: 1},
                        { "orderable": false,"data": "fordentrabajo", "class" : "col-sm", targets: 2},
                        {"orderable": false, "class" : "col-m", 
                            render:function(data, type, row){
                                return  '<div>'+                                  
                                '</div>' 
                            }
                        },
                        {"orderable": false, "class" : "col-l", 
                            render:function(data, type, row){
                                return  '<div>'+                                  
                                '</div>' 
                            }
                        },        
                    ], 
                });
                // Enumeracion 
                otblListdetrecepcion.on( 'order.dt search.dt', function () { 
                    otblListdetrecepcion.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                      cell.innerHTML = i+1;
                      } );
                }).draw(); 

            tr.addClass('details');
        }
});

function pulsarListarCoti(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        listarBusqueda();
    }
}  

pdfCoti = function(idcoti,nversion){
    window.open(baseurl+"lab/coti/ccotizacion/pdfCoti/"+idcoti+"/"+nversion);
};


fechaActualRecep = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
    $('#mtxtFrecepcion').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
};

selRecep= function(IDCOTIZACION,NVERSION,DCLIENTE,NROCOTI){  
    
    $('#tablab a[href="#tablab-reg"]').tab('show'); 
    $('#frmRegCoti').trigger("reset");
    $('#hdnAccionregcoti').val('A'); 
    $('#mtxtidcotizacion').val(IDCOTIZACION); 
    $('#mtxtnroversion').val(NVERSION);
  
    document.querySelector('#lblclie').innerText = DCLIENTE;
    document.querySelector('#lblcoti').innerText = NROCOTI;
     
    recuperaListproducto();
    /*$('#btnParticiopantes').show();*/
};

  
$("body").on("click","#aCerrarCoti",function(event){
    event.preventDefault();
    
    IDCOTI = $(this).attr("href");
    NVERSION = $(this).attr("nver");
    
    Swal.fire({
        title: 'Confirmar Cerrar',
        text: "¿Está seguro de Cerrar la Cotizacion?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cerrarlo!'
    }).then((result) => {
        if (result.value) {
            $.post(baseurl+"lab/coti/ccotizacion/cerrarcotizacion/", 
            {
                idcotizacion    : IDCOTI,
                nversion        : NVERSION,
            },      
            function(data){     
                otblListCotizacion.ajax.reload(null,false); 
                Vtitle = 'Se Cerro Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);      
            });
        }
    }) 
});
   
$("body").on("click","#aAbrirCoti",function(event){
    event.preventDefault();
    
    IDCOTI = $(this).attr("href");
    NVERSION = $(this).attr("nver");
    
    Swal.fire({
        title: 'Confirmar Abrir',
        text: "¿Está seguro de Abrir la Cotizacion?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, abrirlo!'
    }).then((result) => {
        if (result.value) {
            $.post(baseurl+"lab/coti/ccotizacion/abrircotizacion/", 
            {
                idcotizacion    : IDCOTI,
                nversion        : NVERSION,
            },      
            function(data){     
                otblListCotizacion.ajax.reload(null,false); 
                Vtitle = 'Se Abrio Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);      
            });
        }
    }) 
});

$('#btnRetornarLista').click(function(){
    $('#tablab a[href="#tablab-list"]').tab('show');  
    //$('#btnBuscar').click();
});

recuperaListproducto = function(){
    otblListProducto = $('#tblListProductos').DataTable({         
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true,
        "scrollCollapse": true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : false,  
        'ajax'	: {
            "url"   : baseurl+"lab/recepcion/crecepcion/getrecepcionmuestra/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.idcoti    = $('#mtxtidcotizacion').val(); 
                d.nversion  = $('#mtxtnroversion').val();  
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {
                "className":        'details-control col-xxs',
                "orderable":        false,
                data:               'SPACE',
                "defaultContent":   '', 
                targets:            0
            },
            {"orderable": false, data: 'SPACE', targets: 1},
            {"orderable": false, data : 'NROORDEN', targets : 2},
            {"orderable": false, data: 'frecepcionmuestra', targets: 3, "class" : "col-s"},
            {"orderable": false, data: 'cmuestra', targets: 4},
            {"orderable": false, data: 'drealproducto', targets: 5, "class" : "col-l"},
            {"orderable": false, data: 'dpresentacion', targets: 6, "class" : "col-l"},
            {"orderable": false, data: 'dtemperatura', targets: 7},
            {"orderable": false, data: 'dcantidad', targets: 8},
            {"orderable": false, data: 'dproveedorproducto', targets: 9},
            {"orderable": false, data: 'dlote', targets: 10},
            {"orderable": false, data: 'fenvase', targets: 11},
            {"orderable": false, data: 'fmuestra', targets: 12},
            {"orderable": false, data: 'hmuestra', targets: 13},
            {"orderable": false, data: 'dobservacion', targets: 14},
            {"orderable": false, data: 'dotraobservacion', targets: 15},
            {"orderable": false, data: 'IDORDEN', targets: 16},
            {responsivePriority: 1,"orderable": false, 
                render:function(data, type, row){
                    return '<div class="text-left" >' +
                        '<a href="javascript:;" data-toggle="modal" title="Editar" style="cursor:pointer; color:green;" data-target="#modalRecepcion" onClick="selCotiprodu(\'' + row.cinternocotizacion + '\',\'' + row.nversioncotizacion + '\',\'' + row.nordenproducto + '\',\'' + row.cmuestra + '\',\'' + row.frecepcionmuestra + '\',\'' + row.drealproducto + '\',\'' + row.dpresentacion + '\',\'' + row.dtemperatura + '\',\'' + row.dcantidad + '\',\'' + row.dproveedorproducto + '\',\'' + row.dlote + '\',\'' + row.fenvase + '\',\'' + row.fmuestra + '\',\'' + row.hmuestra + '\',\'' + row.stottus + '\',\'' + row.ntrimestre + '\',\'' + row.zctipomotivo + '\',\'' + row.careacliente + '\',\'' + row.zctipoitem + '\',\'' + row.dubicacion + '\',\'' + row.dcondicion + '\',\'' + row.dobservacion + '\',\'' + row.dotraobservacion + '\');"><span class="fas fa-edit fa-2x" aria-hidden="true"> </span> </a>'+
                    '</div>';
                }
            }
        ],
        "columnDefs": [
            {
                "targets": [1], 
                "className": 'index select-checkbox',           
                "checkboxes": {
                    'selectRow': true
                },
                "orderable": false            
            }
        ],
        "select": {
            style:    'multi',  
            selector: 'td:nth-child(2)'      
        },
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([2], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(2).data()[i];                
                grupo1 = api.column(16).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="1">'+grupo1+'</td><td colspan="8"><strong> OT :: '+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        },
    }); 

    otblListProducto.column(2).visible( false );  
    otblListProducto.column(16).visible( false );  
    // Enumeracion 
    otblListProducto.on( 'order.dt search.dt', function () { 
        otblListProducto.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();

    $('#tblListProductos tbody').on( 'click', 'tr.group', function () {
        var val = $(this).closest('tr').find('td:eq(0)').text();

        
        var nro = $(this).closest('tr').find('td:eq(1)').text().substr(7,17);
        
        $('#modalFechaOT').modal({show:true});
        $('#mhdncinternoordenservicio').val(val);
        $('#mhdnnroordenservicio').val(nro);
               
    } ); 
};
$('#tblListProductos tbody').on( 'click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    //var tr = $(this).parents('tr');
    var row = otblListProducto.row( tr );
    var rowData = row.data();
      
    //get index to use for child table ID
    var index = row.index();

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('details');
    }
    else {
        otblListProducto.rows().every(function(){
            // If row has details expanded
            if(this.child.isShown()){
                // Collapse row details
                this.child.hide();
                $(this.node()).removeClass('details');
            }
        })
        // Open this row
        row.child( 
           '<table class="display compact" id = "child_details' + index + '"  style="width:100%; padding-left:75px; background-color:#D3DADF; padding-top: -10px; border-bottom: 2px solid black;">'+
           '<thead style="background-color:#FFFFFF;"><tr><th></th><th>Codigo</th><th>Ensayo</th><th>Vias</th></tr></thead><tbody>' +
            '</tbody></table>').show();
        
        var childTable = $('#child_details' + index).DataTable({ 
            "processing"  	: true,
            "bDestroy"    	: true,
            "stateSave"     : true,
            "bJQueryUI"     : true,
            "scrollResize"  : true,
            "scrollY"     	: "400px",
            "scrollX"     	: true,
            "scrollCollapse": true, 
            'AutoWidth'     : true,
            "paging"      	: false,
            "info"        	: false,
            "filter"      	: false, 
            "ordering"		: false,
            "responsive"    : false,
            "select"        : false,
            'ajax'	: {
                "url"   : baseurl+"lab/coti/ccotizacion/getlistarensayo/",
                "type"  : "POST", 
                "data": function ( d ) {
                    d.idcoti    = rowData.cinternocotizacion; 
                    d.nversion  = rowData.nversioncotizacion;
                    d.idproduc  = rowData.nordenproducto;  
                },     
                dataSrc : ''        
            },
            'columns'	: [
                {"class" : "col-xs", "orderable": false, data : 'ENUMERAR', targets : 0},
                {"class" : "col-m", "orderable": false, data: 'CODIGO', targets: 1},
                {"class" : "col-l", "orderable": false, data: 'DENSAYO', targets: 2},
                {"class" : "col-xs", "orderable": false, data: 'NVIAS', targets: 3},
            ]
        });
        tr.addClass('details');
    }
});

$('#modalFechaOT').on('shown.bs.modal', function (e) {    
    $('#txtFOT').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });
});

$('#frmFechaOT').submit(function(event){
    event.preventDefault();
    
    var request = $.ajax({
        url:$('#frmFechaOT').attr("action"),
        type:$('#frmFechaOT').attr("method"),
        data:$('#frmFechaOT').serialize(),
        error: function(){
            Vtitle = 'No se puede registrar por error';
            Vtype = 'error';
            sweetalert(Vtitle,Vtype);
        },
        success: function(data) { 
            Vtitle = 'Grabo Correctamente!!';
            Vtype = 'success';
            sweetalert(Vtitle,Vtype);        
            $('#mbtnGFechaOT').click();
        }
    });
});



$('#modalRecepcion').on('shown.bs.modal', function (e) {
    
    $('#mtxtFRecep').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });

    $("#mtxtregnumcoti").prop({readonly:true});  
    
    $('#divExtra').hide();
});

selCotiprodu = function(cinternocotizacion,nversioncotizacion,nordenproducto,cmuestra,frecepcionmuestra,drealproducto,dpresentacion,dtemperatura,dcantidad,dproveedorproducto,dlote,fenvase,fmuestra,hmuestra,stottus,ntrimestre,zctipomotivo,careacliente,zctipoitem,dubicacion,dcondicion,dobservacion,dotraobservacion){
    $('#frmRecepcion').trigger("reset");
    $('#mhdnAccionRecepcion').val('A');
    
    $('#mhdnidcotizacion').val(cinternocotizacion); 
    $('#mhdnnroversion').val(nversioncotizacion);
    $('#mhdnnordenproducto').val(nordenproducto);

    $('#mtxtmcodigo').val(cmuestra);
    
    if(frecepcionmuestra == 'null'){
        fechaActualRecep();
    }else{
        $('#mtxtFrecepcion').val(frecepcionmuestra);
    }
    
    $('#mtxtmproductoreal').val(drealproducto);
    $('#mtxtmpresentacion').val(dpresentacion);
    $('#mtxttemprecep').val(dtemperatura);
    $('#mtxtcantmuestra').val(dcantidad);    
    $('#mtxtproveedor').val(dproveedorproducto);
    $('#mtxtnrolote').val(dlote);
    
    if(fenvase == 'null'){
        $('#mtxtFenvase').val('');
    }else{
        $('#mtxtFenvase').val(fenvase);
        $('#mtxtFenvase').datetimepicker({
            format: 'DD/MM/YYYY',
            daysOfWeekDisabled: [0],
            locale:'es'
        });
    }
    
    if(fmuestra == 'null'){
        $('#mtxtFmuestra').val('');
    }else{
        $('#mtxtFmuestra').val(fmuestra);
        $('#mtxtFmuestra').datetimepicker({
            format: 'DD/MM/YYYY',
            daysOfWeekDisabled: [0],
            locale:'es'
        });
    }
    
    if(hmuestra == 'null'){
        $('#mtxthmuestra').val('');
    }else{
        $('#mtxthmuestra').val(hmuestra);
        $('#mtxthmuestra').datetimepicker({
            format: 'hh:mm A',
            locale:'es',
            stepping: 15
        });
    }

    $('#mcbotottus').val(stottus);
    $('#mcbomonitoreo').val(ntrimestre);
    $('#mcbomotivo').val(zctipomotivo);
    $('#mcboarea').val(careacliente);
    $('#mcboitem').val(zctipoitem);
    $('#mtxtubicacion').val(dubicacion);
    $('#mtxtestado').val(dcondicion);
    $('#mtxtObserva').val(dobservacion);
    $('#mtxtObsotros').val(dotraobservacion);
};

$('#btngenerarOT').click(function(){
    event.preventDefault();
    var table = $('#tblListProductos').DataTable();
    var seleccionados = table.rows({ selected: true });

    var IDPRODUCTO;
    var varsot = 'N';
    var CUSU = $('#mtxtcusuario').val();

    Swal.fire({
        title: 'Confirmar Generar OT',
        text: "¿Está seguro de Generar su OT?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, generarlo!'
    }).then((result) => {
        if (result.value) { 
                        
            seleccionados.every(function(key,data){
                IDCOTIZACION = this.data().cinternocotizacion;
                NVERSION = this.data().nversioncotizacion;
                IDPRODUCTO = this.data().nordenproducto;
                IDMUESTRA = this.data().cmuestra;

                var_NROORDEN = this.data().NROORDEN;
                
                if(var_NROORDEN == ''){
                    if(varsot == 'N'){
                        generarOT(IDCOTIZACION,NVERSION,CUSU); 
                        varsot = 'S';
                    }
                    generarResult(IDCOTIZACION,NVERSION,IDPRODUCTO,IDMUESTRA,CUSU); 
                }else{
                    alert("La muestra "+IDMUESTRA+", Seleccionada ya tiene OT");
                    return;
                }                
            });
            generarOTMensajeOK();
        }
    })
}); 
generarOT = function(IDCOTIZACION,NVERSION,CUSU){      
    $.post(baseurl+"lab/recepcion/crecepcion/setordentrabajo", 
    {
        cinternocotizacion    : IDCOTIZACION,
        nversioncotizacion    : NVERSION,
        cusuario : CUSU,
    });
}
generarResult = function(IDCOTIZACION,NVERSION,IDPRODUCTO,IDMUESTRA,CUSU){      
    $.post(baseurl+"lab/recepcion/crecepcion/setordentrabajoresult", 
    {
        cinternocotizacion    : IDCOTIZACION,
        nversioncotizacion    : NVERSION,
        nordenproducto  : IDPRODUCTO,
        cmuestra  : IDMUESTRA,
        cusuario : CUSU,
    });
}
generarOTMensajeOK = function(){ 
    otblListProducto.ajax.reload(null,false); 
    Vtitle = 'Se Genero Correctamente';
    Vtype = 'success';
    sweetalert(Vtitle,Vtype);
}