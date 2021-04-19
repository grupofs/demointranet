
var otblListCotizacion, otblListProducto, otblListEnsayos, otblbuscarEnsayos;
var collapsedGroupsEq = {};
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

    $('#txtFDesde,#txtFHasta,#mtxtFCoti').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });

    fechaAnioActual();
    $('#chkFreg').prop("checked", true);

    $("#mtxtregnumcoti").prop({readonly:true});  
    $("#mtxtregestado").prop({readonly:true});
    
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

    $('#frmRegCoti').validate({
        rules: {
          cboregserv: {
            required: true,
          },
          cboregclie: {
            required: true,
          },
        },
        messages: {
          cboregserv: {
            required: "Por Favor escoja un Servicio"
          },
          cboregclie: {
            required: "Por Favor escoja un Cliente"
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
            const botonEvaluar = $('#btnRegistrar');
            var request = $.ajax({
                url:$('#frmRegCoti').attr("action"),
                type:$('#frmRegCoti').attr("method"),
                data:$('#frmRegCoti').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                },
                beforeSend: function() {
                    objPrincipal.botonCargando(botonEvaluar);
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    $('#regProductos').show(); 
                    $('#hdnAccionregcoti').val('A'); 
                    $('#mtxtidcotizacion').val(this.cinternocotizacion);
                    $('#mtxtnroversion').val(0);
                    $('#mtxtregnumcoti').val(this.dcotizacion);

                    varisubtotal = this.var_isubtotal;
                    variigev = this.var_iigev;
                    varitotal = this.var_itotal;
                    varddescuento = this.var_ddescuento;
                    varmontosinigv = this.var_montosinigv;

                    $('#txtmontsubtotal').val(varisubtotal);
                    $('#txtmonttotal').val(varitotal);
                    $('#txtporctigv').val(variigev);
                    $('#txtdescuento').val(varddescuento);
                    $('#txtmontsinigv').val(varmontosinigv);
                    
                    recuperaListproducto();
                    Vtitle = 'Cotizacion Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);   
                    objPrincipal.liberarBoton(botonEvaluar);    
                });
            });
            return false;
        }
    });

    $('#frmCreaProduc').validate({
        rules: {
            mcboregLocalclie: {
                required: true,
            },
            mtxtregProducto: {
                required: true,
            },
            mtxtregmuestra: {
                required: true,
            },
        },
        messages: {
            mcboregLocalclie: {
                required: "Por Favor escoja un Local del Cliente"
            },
            mtxtregProducto: {
                required: "Por Favor ingrese Nombre del Producto"
            },
            mtxtregmuestra: {
                required: "Por Favor ingrese un numero de muestra"
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
            const botonEvaluar = $('#mbtnGCreaProduc');
            var request = $.ajax({
                url:$('#frmCreaProduc').attr("action"),
                type:$('#frmCreaProduc').attr("method"),
                data:$('#frmCreaProduc').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                    objPrincipal.liberarBoton(botonEvaluar); 
                },
                beforeSend: function() {
                    objPrincipal.botonCargando(botonEvaluar);
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {  
                    if ($('#mhdnAccionProduc').val() == 'A'){
                        Vtitle = 'Producto Actualizado!!!';  
                    }else{
                        Vtitle = 'Producto Guardado!!!';  
                    }    

                    $('#mhdnAccionProduc').val('A');
                    $('#mhdnIdProduc').val(this.nordenproducto);

                    $('#txtmontsubtotal').val(this.var_isubtotal);
                    $('#txtmonttotal').val(this.var_itotal);
                    $('#txtporctigv').val(this.var_iigev);
                    $('#txtdescuento').val(this.var_ddescuento);
                    $('#txtmontsinigv').val(this.var_montosinigv);

                    $('#mtxtmIMonto').val(this.var_imonto);

                    recuperaListensayo(this.cinternocotizacion,this.nversioncotizacion,this.nordenproducto);
                    
                    Vtitle = 'Producto Guardado!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);  
                    objPrincipal.liberarBoton(botonEvaluar); 
                });
            });
            return false;
        }
    });

    $('#frmEnsayosLab').validate({
        rules: {
            mtxtmCosto: {
                required: true,
            },
        },
        messages: {
            mtxtmCosto: {
                required: "Tiene que ingresar un monto"
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
                url:$('#frmEnsayosLab').attr("action"),
                type:$('#frmEnsayosLab').attr("method"),
                data:$('#frmEnsayosLab').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    varIDCOTIZACION = this.cinternocotizacion;
                    varNVERSION = this.nversioncotizacion;
                    varIDPROD = this.nordenproducto;
                    varisubtotal = this.var_isubtotal;
                    varddescuento = this.var_ddescuento;
                    varmontosinigv = this.var_montosinigv;
                    variigev = this.var_iigev;
                    varitotal = this.var_itotal;
                    varimonto = this.var_imonto;
                    
                    $('#txtmontsubtotal').val(varisubtotal);
                    $('#txtmonttotal').val(varitotal);                    
                    $('#txtporctigv').val(variigev);
                    $('#txtdescuento').val(varddescuento);
                    $('#txtmontsinigv').val(varmontosinigv);

                    $('#mtxtmIMonto').val(varimonto);
                    
                    recuperaListensayo(varIDCOTIZACION,varNVERSION,varIDPROD);
                    Vtitle = 'Ensayo registrado Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                    
                    $('#mbtnCerrarEnsayo').click(); 

                    if ($('#hdnmAccion').val() == 'N'){
                        $('#btnRetornarEnsayo').click();
                    };  
                });
            });
            return false;
        }
    });
 
});

function goToId(idName){
	if($("#"+idName).length)
	{
		var target_offset = $("#"+idName).offset();
		var target_top = target_offset.top;
		$('html,body').animate({scrollTop:target_top},{duration:"slow"});
	}
}

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#mtxtFCoti').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

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

    var vlvigencia;
    if($('#swVigencia').prop('checked')){
        vlvigencia = 'A';
    }else{
        vlvigencia = 'I';
    }
    
    var groupColumn = 0;   
    otblListCotizacion = $('#tblListCotizacion').DataTable({  
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true,
        "scrollCollapse": false, 
        'AutoWidth'     : false,
        "paging"      	: true,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true, 
        'ajax'	: {
            "url"   : baseurl+"lab/coti/ccotizacion/getbuscarcotizacion/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente  = $('#cboclieserv').val();
                d.fini      = varfdesde; 
                d.ffin      = varfhasta;   
                d.descr     = $('#txtdescri').val(); 
                d.estado    = $('#cboestado').val(); 
                d.tieneot   = $('#cbotieneot').val(); 
                d.activo    = vlvigencia;  
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
            {"orderable": false, data: 'NROCOTI', "class" : "col-m", targets: 2},
            {"orderable": false, data: 'DFECHA', "class" : "col-s dt-body-center", targets: 3},
            {"orderable": false, data: 'ORDENTRABA', "class" : "col-xm", targets: 4},
            {"orderable": false, data: 'IMUESTREO', "class" : "col-s dt-body-right", targets: 5},
            {"orderable": false, data: 'ISUBTOTAL', "class" : "col-s dt-body-right", targets: 6},
            {"orderable": false, data: 'DESCUENTO', "class" : "col-s dt-body-right", targets: 7},
            {"orderable": false, data: 'MONTOSINIGV', "class" : "col-s dt-body-right", targets: 8},
            {"orderable": false, data: 'DIGV', "class" : "col-s dt-body-right", targets: 9},
            {"orderable": false, data: 'ITOTAL', "class" : "col-s dt-body-right", targets: 10},
            {"orderable": false, data: 'ELABORADO', "class" : "col-m", targets: 11},
            {"orderable": false, "class" : "col-s", 
                render:function(data, type, row){                    
                    if(row.SCOTIZACION == "S"){
                        varCerrar = '<a id="aAbrirCoti" href="'+row.IDCOTIZACION+'" nver="'+row.NVERSION+'" title="Abrir" style="cursor:pointer; color:blue;"><span class="far fa-folder-open fa-2x" aria-hidden="true"> </span></a>'
                    };

                    return '<div style="text-align: center;">' +
                        '<a title="Editar" style="cursor:pointer; color:green;" onClick="selCoti(\'' + row.IDCOTIZACION + '\',\'' + row.NVERSION + '\',\'' + row.DFECHA + '\',\'' + row.NROCOTI + '\',\'' + row.SCOTIZACION + '\',\'' + row.VIGENCIACOTI + '\',\'' + row.SREGISTRO + '\',\'' + row.CCLIENTE + '\',\'' + row.CPROVEEDOR + '\',\'' + row.SUBSERVICIO + '\',\'' + row.MONEDA + '\',\'' + row.SMUESTREO + '\',\'' + row.CONTACTO + '\',\'' + row.PERMANMUESTRA + '\',\'' + row.TIPOPAGO + '\',\'' + row.OTROPAGO + '\',\'' + row.NTIEMPOENTREGAINFO + '\',\'' + row.STIEMPOENTREGAINFO + '\',\'' + row.OBSERVA + '\',\'' + row.VERPRECIO + '\',\'' + row.IMUESTREO + '\',\'' + row.DIGV + '\',\'' + row.PDESCUENTO + '\',\'' + row.ISUBTOTAL + '\',\'' + row.ITOTAL + '\',\'' + row.ZPERMANMUESTRA + '\',\'' + row.DDESCUENTO + '\',\'' + row.MONTOSINIGV + '\');"><span class="fas fa-edit fa-2x" aria-hidden="true"> </span> </a>'+
                        '&nbsp;&nbsp;'+
                        varCerrar
                    '</div>';
                }
            }
        ],  
        "columnDefs": [
            {
                "targets": [2], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                    '    <p><a title="Cotozacion" style="cursor:pointer;" onclick="pdfCoti(\'' + row.IDCOTIZACION + '\',\'' + row.NVERSION + '\');"  class="pull-left">'+row.NROCOTI+'&nbsp;&nbsp;'+row.DESTADO+'&nbsp;<i class="fas fa-file-pdf fa-2x" style="color:#FF0000;"></i></a><p>' +
                    '</div>';
                }
            },
            {
                "targets": [10], 
                "data": null, 
                "render": function(data, type, row) {
                    if(row.MONEDA == 'D'){
                        $tipmoneda = '$'
                    }else{
                        $tipmoneda = 'S/.'
                    }
                    return '<div>'+
                    '    <p> '+$tipmoneda+'&nbsp;&nbsp;'+row.ITOTAL+'<p>' +
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
                        '<tr class="group"><td colspan=11"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        }
    }); 
    otblListCotizacion.column(0).visible( false ); 
    otblListCotizacion.column(1).visible( false );      
    // Enumeracion 
    otblListCotizacion.on( 'order.dt search.dt', function () { 
        otblListCotizacion.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();   

    $("#btnexcel").prop("disabled",false);
};

$("#swVigencia").on('switchChange.bootstrapSwitch',function (event, state) {
    listarBusqueda();
});

function pulsarListarCoti(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        listarBusqueda();
    }
}   

/*$("#cboestado").change(function(){
    listarBusqueda();
}); 

$("#cbotieneot").change(function(){
    listarBusqueda();
});*/

PDFvistaPrevia = function(){
    var_idcoti = $('#mtxtidcotizacion').val();
    var_nversion = $('#mtxtnroversion').val();
    window.open(baseurl+"lab/coti/ccotizacion/pdfCoti/"+var_idcoti+"/"+var_nversion);
};

pdfCoti = function(idcoti,nversion){
    window.open(baseurl+"lab/coti/ccotizacion/pdfCoti/"+idcoti+"/"+nversion);
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

$('#btnNuevo').click(function(){
    
    $('#tablab a[href="#tablab-reg"]').tab('show'); 
    $('#frmRegCoti').trigger("reset");

    fechaActualReg();
    iniRegCoti("%","%","%","%");

    $('#hdnAccionregcoti').val('N');
    
    $('#mtxtidcoti').val(''); 
    $('#hdnregestado').val('N');
    $('#mtxtregestado').val('ABIERTO');    
    $('#txtregtipodias').val('C');  
    $('#txtregformapagos').val('061');  
    $('#mtxtregtipopagos').val('S');  


    $('#mtxtregpagotro').hide();
    $('#mtxtregtipocambio').hide();
    $('#regProductos').hide(); 
    $('#divBuscarEnsayo').hide();
        
    $("#txtmontmuestreo").prop({readonly:true});
    $("#txtmontsubtotal").prop({readonly:true}); 
    $("#txtdescuento").prop({readonly:true});
    $("#txtmontsinigv").prop({readonly:true});
    $("#txtporctigv").prop({readonly:true});
    $("#txtmonttotal").prop({readonly:true});
});

fechaActualReg = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
    $('#mtxtFCoti').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

iniRegCoti = function(subservicio,ccliente,cproveedor,ccontacto){

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboregserv",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboregserv').html(result);
            $('#cboregserv').val(subservicio).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcliente",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboregclie').html(result);
            $('#cboregclie').val(ccliente).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 
};

$("#cboregclie").change(function(){ 
    var v_idcliente = $('#cboregclie').val();

    var params = { "ccliente":v_idcliente};
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getprovcliente",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboregprov').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcontaccliente",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboregcontacto').html(result); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 
});

na=function(){
    $('#btntipocontramuestra').html("NA");
    $('#mtxtcontramuestra').val(0);   
    $('#mtxtregpermane').val('N');
};
dias=function(){
    $('#btntipocontramuestra').html("Días"); 
    $('#mtxtregpermane').val('D');
};

calen=function(){
    $('#btntipodias').html("Días Calend.");
    $('#txtregtipodias').val('C');
};
util=function(){
    $('#btntipodias').html("Días Útiles");
    $('#txtregtipodias').val('U');
};

conta=function(){
    $('#btnformapagos').html("Contado");
    $('#txtregformapagos').val('061');
    $('#mtxtregpagotro').hide(); 
};
credi=function(){
    $('#btnformapagos').html("Crédito");
    $('#txtregformapagos').val('062');
    $('#mtxtregpagotro').show(); 
};
otro=function(){
    $('#btnformapagos').html("Otros");
    $('#txtregformapagos').val('063');
    $('#mtxtregpagotro').show();
};

soles=function(){
    $('#btntipopagos').html("S/.");
    $('#mtxtregtipopagos').val('S');
    $('#mtxtregtipocambio').val(0);
    $("#txtmonttotal").prop({readonly:true});
    document.querySelector('#divtotal').innerText = 'Total S/.';
};
dolares=function(){
    $('#btntipopagos').html("$");
    $('#mtxtregtipopagos').val('D');
    $('#mtxtregtipocambio').val(0);
    
    $('#txtmontmuestreo').val(0.00);
    $('#txtmontsubtotal').val(0.00);
    $('#txtporcdescuento').val(0.00);
    $('#txtdescuento').val(0.00);
    $('#txtmontsinigv').val(0.00);    
    $('#txtporctigv').val(0.00);
    $('#txtmonttotal').val(0.00); 
    $("#txtmonttotal").prop({readonly:false});
    document.querySelector('#divtotal').innerText = 'Total $';
};

$("#chksmuestreo").on("change", function () {
    if($("#chksmuestreo").is(":checked") == true){ 
        $("#txtmontmuestreo").prop({readonly:false}); 
    }else if($("#chksmuestreo").is(":checked") == false){ 
        $("#txtmontmuestreo").prop({readonly:true}); 
        $('#txtmontmuestreo').val(0);
    }; 
}); 

$("#chkregverpago").on("change", function () {   
    var IDCOTIZACION = $('#mtxtidcotizacion').val();
    var NVERSION = $('#mtxtnroversion').val();
    var VERPRECIO; 

    
    if($("#chkregverpago").is(":checked") == true){
        VERPRECIO = 'S';
    }else if($("#chkregverpago").is(":checked") == false){
        VERPRECIO = 'N';
    };   

    $.post(baseurl+"lab/coti/ccotizacion/precioxcoti", 
    {
        idcotizacion    : IDCOTIZACION,
        nversion        : NVERSION,
        smostrarprecios : VERPRECIO
    });
}); 

selCoti= function(IDCOTIZACION,NVERSION,DFECHA,NROCOTI,SCOTIZACION,VIGENCIACOTI,SREGISTRO,CCLIENTE,CPROVEEDOR,SUBSERVICIO,MONEDA,SMUESTREO,CONTACTO,PERMANMUESTRA,TIPOPAGO,OTROPAGO,NTIEMPOENTREGAINFO,STIEMPOENTREGAINFO,OBSERVA,VERPRECIO,IMUESTREO,DIGV,PDESCUENTO,ISUBTOTAL,ITOTAL,ZPERMANMUESTRA,DDESCUENTO,MONTOSINIGV){  
    
    $('#tablab a[href="#tablab-reg"]').tab('show'); 
    $('#frmRegCoti').trigger("reset");
    
    $('#regProductos').show(); 
    $('#mtxtregtipocambio').hide();

    $('#hdnAccionregcoti').val('A'); 

    $('#mtxtidcotizacion').val(IDCOTIZACION); 
    $('#mtxtnroversion').val(NVERSION);
    $('#mtxtFcotizacion').val(DFECHA);  
    $('#mtxtregnumcoti').val(NROCOTI); 
    $('#hdnregestado').val(SCOTIZACION); 
    if(SCOTIZACION == 'S'){
        $('#mtxtregestado').val('CERRADO');
    }else{    
        $('#mtxtregestado').val('ABIERTO');
    } 

    $('#mtxtregvigen').val(VIGENCIACOTI);  
    $('#cboregserv').val(SUBSERVICIO); 
    $('#cboregclie').val(CCLIENTE); 
    $('#cboregprov').val(CPROVEEDOR); 
    $('#cboregcontacto').val(CONTACTO);  
    $('#mtxtcontramuestra').val(PERMANMUESTRA);
    $('#mtxtregentregainf').val(NTIEMPOENTREGAINFO); 
    $('#mtxtobserv').val(OBSERVA);  
    $('#mtxtregpagotro').val(OTROPAGO);
    
    if(ZPERMANMUESTRA == 'N'){       
        na(); 
    }else{
        dias();
    }

    if(STIEMPOENTREGAINFO == 'C'){       
        calen(); 
    }else{
        util();
    }

    if(TIPOPAGO == '061'){       
        conta(); 
    }else if(TIPOPAGO == '062'){       
        credi(); 
    }else{
        otro();
    }  
    
    if(MONEDA == 'D'){
        dolares();  
    }else{     
        soles(); 
    }

    if(SMUESTREO == 'S'){
        $(document.getElementById('chksmuestreo')).prop('checked', true);
        $("#txtmontmuestreo").prop({readonly:false});
    }else{
        $(document.getElementById('chksmuestreo')).prop('checked', false);
        $("#txtmontmuestreo").prop({readonly:true});
    }  
   
    //$('#txtmontsubtotal').val(new Intl.NumberFormat("en-IN").format(ISUBTOTAL));
    $('#txtmontmuestreo').val(IMUESTREO);
    $('#txtmontsubtotal').val(ISUBTOTAL);
    $('#txtporcdescuento').val(PDESCUENTO);
    $('#txtdescuento').val(DDESCUENTO);
    $('#txtmontsinigv').val(MONTOSINIGV);    
    $('#txtporctigv').val(DIGV);
    $('#txtmonttotal').val(ITOTAL); 
    if(VERPRECIO == 'S'){
        $(document.getElementById('chkregverpago')).prop('checked', true);
    }else{
        $(document.getElementById('chkregverpago')).prop('checked', false);
    }      
    
    $("#txtmontsubtotal").prop({readonly:true}); 
    $("#txtporctigv").prop({readonly:true});
    $("#txtmonttotal").prop({readonly:true});
    $("#txtdescuento").prop({readonly:true});
    $("#txtmontsinigv").prop({readonly:true});
    
    iniRegCoti(SUBSERVICIO,CCLIENTE,CPROVEEDOR,CONTACTO);

    recuperaListproducto();
    goToId('regCoti');
};

$('#btnRetornarLista').click(function(){
    $('#tablab a[href="#tablab-list"]').tab('show');  
    $('#btnBuscar').click();
});

recuperaListproducto = function(){
    otblListProducto = $('#tblListProductos').DataTable({  
        'responsive'    : false,
        'bJQueryUI'     : true,
        'scrollY'     	: '400px',
        'scrollX'     	: true, 
        'paging'      	: false,
        'processing'  	: true,     
        'bDestroy'    	: true,
        'AutoWidth'     : false,
        'info'        	: false,
        'filter'      	: true, 
        'ordering'		: false,
        'stateSave'     : true,
        'ajax'	: {
            "url"   : baseurl+"lab/coti/ccotizacion/getlistarproducto/",
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
            {"orderable": false, data: 'LOCALCLIE', targets: 2},
            {"orderable": false, data: 'PRODUCTO', targets: 3, "class" : 'col-lm'},
            {"orderable": false, data: 'CONDI', targets: 4},
            {"orderable": false, data: 'NMUESTRA', targets: 5},
            {"orderable": false, data: 'IMONTO', targets: 6},
            {"orderable": false,   
                render:function(data, type, row){
                    return '<div style="text-align: center;">'+
                                '<a href="javascript:;" onclick="objFormulario.editProducto(\'' + row.IDCOTI + '\',\'' + row.NVERSION + '\',\'' + row.IDPROD + '\',\'' + row.CLOCALCLIE + '\',\'' + row.PRODUCTO + '\',\'' + row.CCONDI + '\',\'' + row.NMUESTRA + '\',\'' + row.CPROCEDE + '\',\'' + row.CANTMIN + '\',\'' + row.ETIQUETA + '\',\'' + row.CTIPOPROD + '\',\'' + row.PORCION + '\',\'' + row.CUM + '\',\'' + row.CCLIENTE + '\',\'' + row.IMONTO + '\');">'+
                                    '<i class="fas fa-pencil-alt"></i>&nbsp; &nbsp;Editar'+
                                '</a>'+
                    '</div>';
                }
            },
            {"orderable": false,   
                render:function(data, type, row){
                    return '<div style="text-align: center;">'+
                            '<a href="javascript:;" onclick="copiCotiprodu(\'' + row.IDCOTI + '\',\'' + row.NVERSION + '\',\'' + row.IDPROD + '\');">'+
                                '<i class="fas fa-copy"></i>&nbsp; &nbsp;Duplicar'+
                            '</a>'+
                    '</div>';
                }
            },
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
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        },
        dom: 'Bfrtip',
        buttons: [
            {
             text: '<a id="addProducto" name="addProducto" ><img src="assets/images/details_open.png" border="0" align="absmiddle"> Agregar Producto </a>',
             action: function (e, dt, node, config ){
                objFormulario.addProducto();
             },
             className: 'btn btn-default btn-sm btnadd'
            },
            {
             text: '<a id="delProducto" name="delProducto" ><img src="assets/images/details_close.png" border="0" align="absmiddle"> Eliminar Producto </a>',
             action: function (e, dt, node, config ){
                delProducto();
             },
             className: 'btn btn-default btn-sm btndel'
            }
        ],
        /*createdRow: function ( row, data, index ) {
            if (data.extn === '') {
              var td = $(row).find("td:first");
              td.removeClass( 'details-control' );
            }
        },*/
    }); 
    otblListProducto.column(2).visible( false );   
    // Enumeracion 
    otblListProducto.on( 'order.dt search.dt', function () { 
        otblListProducto.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();
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
           '<thead style="background-color:#FFFFFF;"><tr><th></th><th>Codigo</th><th>Acred.</th><th>Ensayo</th><th>Precio S/.</th><th>Vias</th><th>Cantidad</th><th>Costo S/.</th></tr></thead><tbody>' +
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
                    d.idcoti    = rowData.IDCOTI; 
                    d.nversion  = rowData.NVERSION;
                    d.idproduc  = rowData.IDPROD;  
                },     
                dataSrc : ''        
            },
            'columns'	: [
                {"class" : "col-xxs", "orderable": false, data : 'ENUMERAR', targets : 0},
                {"orderable": false, data: 'CODIGO', targets: 1},
                {"orderable": false, data: 'ACRE', targets: 2},
                {"orderable": false, data: 'DENSAYO', targets: 3},
                {"orderable": false, data: 'CONSTOENSAYO', targets: 4},
                {"orderable": false, data: 'NVIAS', targets: 5},
                {"orderable": false, data: 'CANTIDAD', targets: 6},
                {"orderable": false, data: 'COSTO', targets: 7}
            ]
        });
        tr.addClass('details');
    }
});

const objFormulario = {
};
$(function() {    
    /**
     * Muestra la lista ocultando el formulario
     */
    objFormulario.mostrarCotizacion = function () {
        const boton = $('#btnAccionContenedorLista');
        const icon = boton.find('i');
        if (icon.hasClass('fa-minus')) icon.removeClass('fa-minus');
        icon.addClass('fa-plus');
        boton.click();

        $('#contenedorRegensayo').hide();
        $('#contenedorCotizacion').show();
    };

    /**
     * Muestra el formulario ocultando la lista
     */
    objFormulario.addProducto = function () {
        const boton = $('#btnAccionContenedorLista');
        const icon = boton.find('i');
        if (icon.hasClass('fa-plus')) icon.removeClass('fa-plus');
        icon.addClass('fa-minus');
        boton.click();
        
        $('#frmCreaProduc').trigger("reset");
    
        v_IDCOTIZACION = $('#mtxtidcotizacion').val();
        v_NVERSION = $('#mtxtnroversion').val();
        v_CUSUARIO = $('#mtxtcusuario').val();
        
        v_NROCOTI = $('#mtxtregnumcoti').val();
        document.querySelector('#lblNrocoti').innerText = v_NROCOTI;

        $('#mhdnAccionProduc').val('N');
        $('#mhdnidcotizacion').val(v_IDCOTIZACION);
        $('#mhdnnroversion').val(v_NVERSION);
        $('#mhdncusuario').val(v_CUSUARIO); 
    
        var v_idcliente = $('#cboregclie').val();
        iniRegCotiprodu(v_idcliente,0,0,0);
        
        recuperaListensayo(v_IDCOTIZACION,v_NVERSION,0) 

        $('#contenedorCotizacion').hide();
        $('#contenedorRegensayo').show();
        $("#mtxtregProducto").focus();
    };

    /**
     * Muestra el formulario ocultando la lista
     */
    objFormulario.editProducto = function (IDCOTIZACION,NVERSION,IDPROD,CLOCALCLIE,PRODUCTO,CCONDI,NMUESTRA,CPROCEDE,CANTMIN,ETIQUETA,CTIPOPROD,PORCION,CUM,CCLIENTE,IMONTO) {
        const boton = $('#btnAccionContenedorLista');
        const icon = boton.find('i');
        if (icon.hasClass('fa-plus')) icon.removeClass('fa-plus');
        icon.addClass('fa-minus');
        boton.click();

        v_NROCOTI = $('#mtxtregnumcoti').val();
        document.querySelector('#lblNrocoti').innerText = v_NROCOTI;
        
        selCotiprodu(IDCOTIZACION,NVERSION,IDPROD,CLOCALCLIE,PRODUCTO,CCONDI,NMUESTRA,CPROCEDE,CANTMIN,ETIQUETA,CTIPOPROD,PORCION,CUM,CCLIENTE,IMONTO);
        recuperaListensayo(IDCOTIZACION,NVERSION,IDPROD) 

        $('#contenedorCotizacion').hide();
        $('#contenedorRegensayo').show();
        goToId('regProd');
    };

});

iniRegCotiprodu = function(ccliente,clocalclie,ccondi,cprocede){
    var params = { "ccliente":ccliente};

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboregLocalclie",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboregLocalclie').html(result);
            $('#mcboregLocalclie').val(clocalclie).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboregcondi",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboregcondicion').html(result);
            $('#mcboregcondicion').val(ccondi).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });  

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboregprocede",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboregprocedencia').html(result);
            $('#mcboregprocedencia').val(cprocede).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 
};

selCotiprodu= function(IDCOTIZACION,NVERSION,IDPROD,CLOCALCLIE,PRODUCTO,CCONDI,NMUESTRA,CPROCEDE,CANTMIN,ETIQUETA,CTIPOPROD,PORCION,CUM,CCLIENTE,IMONTO){
    $('#frmCreaProduc').trigger("reset");
    $('#mhdnAccionProduc').val('A'); 
    $('#mhdnidcotizacion').val(IDCOTIZACION); 
    $('#mhdnnroversion').val(NVERSION);
    $('#mhdnIdProduc').val(IDPROD);

    $('#mcboregLocalclie').val(CLOCALCLIE);
    $('#mtxtregProducto').val(PRODUCTO);
    $('#mcboregcondicion').val(CCONDI);
    $('#mtxtregmuestra').val(NMUESTRA);
    $('#mcboregprocedencia').val(CPROCEDE);
    $('#mtxtregcantimin').val(CANTMIN);
    $('#mcboregetiquetado').val(ETIQUETA);
    $('#mcboregoctogono').val(CTIPOPROD);
    $('#mtxtregtamporci').val(PORCION);
    $('#mcboregumeti').val(CUM);
    $('#mtxtmIMonto').val(IMONTO);

    iniRegCotiprodu(CCLIENTE,CLOCALCLIE,CCONDI,CPROCEDE);
};

delProducto = function(){
    event.preventDefault();
    var table = $('#tblListProductos').DataTable();
    var seleccionados = table.rows({ selected: true });

    var IDPRODUCTO;
    var IDCOTIZACION = $('#mtxtidcotizacion').val();
    var NVERSION = $('#mtxtnroversion').val();

    Swal.fire({
        title: 'Confirmar Eliminación',
        text: "¿Está seguro de eliminar el Ensayo?",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, bórralo!'
    }).then((result) => {
        if (result.value) {             
            seleccionados.every(function(key,data){
                IDPRODUCTO = this.data().IDPROD;
                delProductoOK(IDCOTIZACION,NVERSION,IDPRODUCTO); 
            });
            delProductoMensajeOK();
        }
    }) 
};
delProductoOK = function(IDCOTIZACION,NVERSION,IDPRODUCTO){  
    $.post(baseurl+"lab/coti/ccotizacion/deleteprodxcoti", 
    {
        idcotizacion    : IDCOTIZACION,
        nversion        : NVERSION,
        idcotiproducto  : IDPRODUCTO,
    });
}
delProductoMensajeOK = function(){ 
    otblListProducto.ajax.reload(null,false); 
    Vtitle = 'Se Elimino Correctamente';
    Vtype = 'success';
    sweetalert(Vtitle,Vtype);
    $('#btnRegistrar').click();  
}

copiCotiprodu = function(IDCOTIZACION,NVERSION,IDPROD){
    event.preventDefault();

    Swal.fire({
        title: 'Confirmar Duplicar Producto',
        text: "¿Está seguro de duplicar Producto?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, duplicar!'
    }).then((result) => {
        if (result.value) {
            $.post(baseurl+"lab/coti/ccotizacion/setduplicarprodxcoti/", 
            {
                idcotizacion    : IDCOTIZACION,
                nversion        : NVERSION,
                idcotiproducto  : IDPROD,
            },      
            function(data){ 
                var c = JSON.parse(data);
                $.each(c,function(i,item){ 
                    alert(item.respuesta); 
                    otblListProducto.ajax.reload(null,false); 
                    Vtitle = 'Se Duplico Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                })      
            });
        }
    })
}

$('#mbtnCCreaProduc').click(function(){
    objFormulario.mostrarCotizacion();
    recuperaListproducto();
});

recuperaListensayo = function(vIDCOTIZACION,vNVERSION,vIDPROD){
    otblListEnsayos = $('#tblListEnsayos').DataTable({  
        'responsive'    : false,
        'bJQueryUI'     : true,
        'scrollY'     	: '400px',
        'scrollX'     	: true, 
        'paging'      	: false,
        'processing'  	: true,     
        'bDestroy'    	: true,
        'AutoWidth'     : false,
        'info'        	: false,
        'filter'      	: true, 
        'ordering'		: false,
        'stateSave'     : true,
        'ajax'	: {
            "url"   : baseurl+"lab/coti/ccotizacion/getlistarensayo/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.idcoti    = vIDCOTIZACION; 
                d.nversion  = vNVERSION;
                d.idproduc  = vIDPROD;  
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {
              "class"     :   "col-xxs",
              orderable   :   false,
              data        :   'SPACE',
              targets     :   0,
            },
            {"orderable": false, data: 'SPACE', targets: 1},
            {"orderable": false, data: 'CODIGO', targets: 2},
            {"orderable": false, data: 'ACRE', targets: 3},
            {"orderable": false, data: 'DENSAYO', targets: 4},
            {"orderable": false, data: 'ANIO', targets: 5},
            {"orderable": false, data: 'NORMA', targets: 6, "class": "col-lm"},
            {"orderable": false, data: 'CONSTOENSAYO', targets: 7},
            {"orderable": false, data: 'NVIAS', targets: 8},
            {"orderable": false, data: 'CANTIDAD', targets: 9},
            {"orderable": false, data: 'COSTO', targets: 10},
            {"orderable": false, 
                render:function(data, type, row){
                    return '<div class="text-left" >' +
                        '<a data-toggle="modal" title="Editar" style="cursor:pointer; color:green;" data-target="#modalselensayo" onClick="selCotiensayo(\'' + row.cinternocotizacion + '\',\'' + row.nversioncotizacion + '\',\'' + row.nordenproducto + '\',\'' + row.dproducto + '\',\'' + row.CENSAYO + '\',\'' + row.CODIGO + '\',\'' + row.DENSAYO + '\',\'' + row.CONSTOENSAYO + '\',\'' + row.claboratorio + '\',\'' + row.NVIAS + '\');"><span class="fas fa-edit fa-2x" aria-hidden="true"> </span> </a>'+
                    '</div>';
                }
            },
            {"orderable": false, 
                render:function(data, type, row){
                    return '<div>'+
                        '<a id="aDelEnsayoprod" href="'+row.CENSAYO+'" idcoti="'+row.cinternocotizacion+'" nver="'+row.nversioncotizacion+'" idprod="'+row.nordenproducto+'" title="Eliminar" style="cursor:pointer; color:#FF0000;"><span class="fas fa-trash-alt fa-2x" aria-hidden="true"> </span></a>'+      
                    '</div>';
                }
            }
        ], 
        "columnDefs": [
            {
                "targets": [6],
                "render": function ( data, type, row ) {
                    return type === 'display' && data.length > 50 ?
                            '<div data-title ="' + data + '">'+data.substr( 0, 50 ) +'…' :
                            data;
                }
            },{
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
            selector: 'td:nth-child(1)'      
        },
        dom: 'Bfrtip',
        buttons: [
            {
             text: '<a data-toggle="modal" title="Agregar" style="cursor:pointer;" data-target="#modaladdEnsayo"  id="addEnsayo" name="addEnsayo" ><img src="assets/images/details_open.png" border="0" align="absmiddle"> Agregar Ensayos </a>',
             action: function (e, dt, node, config ){
                addEnsayo();
             },
             className: 'btn btn-default btn-sm btnadd'
            },{
             text: '<a id="delEnsayo" name="delEnsayo" ><img src="assets/images/details_close.png" border="0" align="absmiddle"> Eliminar Ensayos </a>',
             action: function (e, dt, node, config ){
                delEnsayo();
             },
             className: 'btn btn-default btn-sm btndel'
            }
        ]
    });  
    otblListEnsayos.column(0).visible( false ); 
    // Enumeracion 
    otblListEnsayos.on( 'order.dt search.dt', function () { 
        otblListEnsayos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();
};

addEnsayo = function(){  
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getmcbobustipoensayo",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcbobustipoensayo').html(result); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });
}

$('#modaladdEnsayo').on('shown.bs.modal', function (e) {
    buscarEnsayos(); 
});

$("#btnBuscarEnsayo").click(function (){
    buscarEnsayos(); 
});

buscarEnsayos = function(){
    otblbuscarEnsayos = $('#tblbuscarEnsayos').DataTable({  
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
            "url"   : baseurl+"lab/coti/ccotizacion/getbuscarensayos/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.descripcion   = $('#mtxtbusdescrensayo').val(); 
                d.sacnoac       = $('#mcbobusacredensayo').val(); 
                d.tipoensayo    = $('#mcbobustipoensayo').val(); 
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {
              "class"     :   "col-xxs",
              orderable   :   false,
              data        :   null,
              targets     :   0,
            },
            {"orderable": false, data: 'densayo', targets: 1, "class": "col-m"},
            {"orderable": false, data: 'censayofs', targets: 2, "class": "col-xs"},
            {"orderable": false, data: 'naniopublicacion', targets: 3, "class": "col-xxs"},
            {"orderable": false, data: 'sacnoac', targets: 4, "class": "col-xs"},
            {"orderable": false, data: 'dnorma', targets: 5, "class": "col-l"},
            {"orderable": false, data: 'dlaboratorio', targets: 6},
            {"class": "dt-body-right col-s", "orderable": false, data: 'icosto', targets: 7},
            {"orderable": false, data: 'dregistro', targets: 8},
            {"orderable": false, data: 'MATRIZ', targets: 9},
            {"orderable": false, 
                render:function(data, type, row){
                    return '<div style="text-align: center;">'+
                        //'<a href="javascript:;" onClick="objFormulario.editarMantEnsayo(\'' +row.IDPROD+ '\',\'' +row.IDCOTI+ '\',\'' +row.NVERSION+ '\',\'' +row.PRODUCTO+ '\');" title="Editar Ensayo" style="cursor:pointer; color:#357A50;"><span class="fas fa-edit fa-2x" aria-hidden="true"> </span></a>'+      
                    '</div>';
                }
            }
        ],
        rowGroup: {
            startRender : function ( rows, group ) {
                var collapsed = !!collapsedGroupsEq[group];
    
                rows.nodes().each(function (r) {
                    r.style.display = collapsed ? 'none' : '';
                }); 
                return $('<tr/>')
                .append('<td colspan="9" style="cursor: pointer;">' + group + '</td>')
                .attr('data-name', group)
                .toggleClass('collapsed', collapsed);
            },
            dataSrc: "dregistro"
        },  
        "columnDefs": [{
            "targets": [2], 
            "data": null, 
            "render": function(data, type, row) {
                return '<div>'+
                '    <div class="col_ellipsis" data-title ="' + row.MATRIZ + '" data-title-position="bottom"><p><a href="javascript:;" data-toggle="modal" data-target="#modalselensayo" style="cursor:pointer;" onclick="selEnsayo(\'' + row.censayo + '\',\'' + row.censayofs + '\',\'' + row.densayo + '\',\'' + row.icosto + '\',\'' + row.claboratorio + '\');"  class="pull-left">'+row.censayofs+'</a><p>' +
                '</div>';
            }
        } ,{
            "targets": [5,9],
            "render": function ( data, type, row ) {
                return type === 'display' && data.length > 100 ?
                        '<div data-title ="' + data + '">'+data.substr( 0, 100 ) +'…' :
                        data;
            }
        }],
    });  
    // Enumeracion 
    otblbuscarEnsayos.on( 'order.dt search.dt', function () { 
        otblbuscarEnsayos.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();
    otblbuscarEnsayos.column(8).visible( false ); 
    otblbuscarEnsayos.column(9).visible( false ); 
};

// COMPRIMIR GRUPO 
/*$('#tblbuscarEnsayos tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblbuscarEnsayos.draw(true);
}); */

selEnsayo = function(CENSAYO,CENSAYOFS,DENSAYO,ICOSTO,CLAB){
    var idcoti = $('#mhdnidcotizacion').val();
    var nvers = $('#mhdnnroversion').val();
    var idprod = $('#mhdnIdProduc').val();
    var dprod = $('#mtxtregProducto').val();
    
    $('#hdnmAccion').val('N');

    $('#hdnmIdcoti').val(idcoti);
    $('#hdnmNvers').val(nvers);
    $('#hdnmIdprod').val(idprod);
    $('#mhdnmcensayo').val(CENSAYO);
    $('#mtxtmCosto').val(ICOSTO);
    $('#mtxtmCLab').val(CLAB);
    $('#mtxtmvias').val(1);
    
    document.querySelector('#lblmProducto').innerText = dprod;
    document.querySelector('#lblmCodigo').innerText = CENSAYOFS;
    document.querySelector('#lblmEnsayo').innerText = DENSAYO;
};

selCotiensayo = function(idcoti,nvers,idprod,dprod,CENSAYO,CENSAYOFS,DENSAYO,ICOSTO,CLAB,NVIAS){    
    $('#hdnmAccion').val('A');

    $('#hdnmIdcoti').val(idcoti);
    $('#hdnmNvers').val(nvers);
    $('#hdnmIdprod').val(idprod);
    $('#mhdnmcensayo').val(CENSAYO);
    $('#mtxtmCosto').val(ICOSTO);
    $('#mtxtmCLab').val(CLAB);
    $('#mtxtmvias').val(NVIAS);
    
    document.querySelector('#lblmProducto').innerText = dprod;
    document.querySelector('#lblmCodigo').innerText = CENSAYOFS;
    document.querySelector('#lblmEnsayo').innerText = DENSAYO;
};
   
$("body").on("click","#aDelEnsayoprod",function(event){
    event.preventDefault();
    
    CENSAYO = $(this).attr("href");
    IDCOTIZACION = $(this).attr("idcoti");
    NVERSION = $(this).attr("nver");
    IDPROD = $(this).attr("idprod");

    var params = { 
        "idcotizacion"    : IDCOTIZACION,
        "nversion"        : NVERSION,
        "idcotiproducto"  : IDPROD,
        "censayo"         : CENSAYO,
    };
    
    Swal.fire({
        title: 'Confirmar Eliminación',
        text: "¿Está seguro de eliminar el Ensayo?",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, bórralo!'
    }).then((result) => {
        if (result.value) {
            var request = $.ajax({
                type: 'POST',
                url: baseurl+"lab/coti/ccotizacion/deleteensayoxprod",
                async: true,
                data: params,
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    $('#mtxtmIMonto').val(this.var_imonto);

                    otblListEnsayos.ajax.reload(null,false); 
                    Vtitle = 'Se Elimino Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);
                });
            });

            /*$.post(baseurl+"lab/coti/ccotizacion/deleteensayoxprod/", 
            {
                idcotizacion    : IDCOTIZACION,
                nversion        : NVERSION,
                idcotiproducto  : IDPROD,
                censayo         : CENSAYO,
            },      
            function(data){     
                otblListEnsayos.ajax.reload(null,false); 
                Vtitle = 'Se Elimino Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);      
            });*/
        }
    }) 
});

delEnsayo = function(){
    event.preventDefault();
    var table = $('#tblListEnsayos').DataTable();
    var seleccionados = table.rows({ selected: true });

    var IDCENSAYO;
    var IDCOTIZACION = $('#mhdnidcotizacion').val();
    var NVERSION = $('#mhdnnroversion').val();
    var IDPRODUCTO= $('#mhdnIdProduc').val();

    Swal.fire({
        title: 'Confirmar Eliminación',
        text: "¿Está seguro de eliminar el Ensayo?",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, bórralo!'
    }).then((result) => {
        if (result.value) {             
            seleccionados.every(function(key,data){
                IDCENSAYO = this.data().CENSAYO;
                delEnsayoOK(IDCOTIZACION,NVERSION,IDPRODUCTO,IDCENSAYO); 
            });
            delEnsayoMensajeOK();
        }
    }) 
};
delEnsayoOK = function(IDCOTIZACION,NVERSION,IDPRODUCTO,IDCENSAYO){  
    $.post(baseurl+"lab/coti/ccotizacion/deleteensayoxprod", 
    {
        idcotizacion    : IDCOTIZACION,
        nversion        : NVERSION,
        idcotiproducto  : IDPRODUCTO,
        censayo         : IDCENSAYO,
    });
}
delEnsayoMensajeOK = function(){ 
    otblListEnsayos.ajax.reload(null,false); 
    Vtitle = 'Se Elimino Correctamente';
    Vtype = 'success';
    sweetalert(Vtitle,Vtype);
    $('#mbtnGCreaProduc').click();  
}



