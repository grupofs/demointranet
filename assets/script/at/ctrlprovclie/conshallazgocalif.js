
var otblconshallazgocalif, otbldetresumen, otbldethallazgocalif, otblproducto, otblcriterio;
var varfdesde = '%', varfhasta = '%', varperiodo = '1';

$(document).ready(function() {
    $('#tabhallazgocalif a[href="#tabhallazgocalif-list-tab"]').attr('class', 'disabled');
    $('#tabhallazgocalif a[href="#tabhallazgocalif-det-tab"]').attr('class', 'disabled active');

    $('#tabhallazgocalif a[href="#tabhallazgocalif-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tabhallazgocalif a[href="#tabhallazgocalif-list"]').attr('class', 'active');
        $('#tabhallazgocalif a[href="#tabhallazgocalif-det"]').attr('class', '');
        return true;
    });
    $('#tabhallazgocalif a[href="#tabhallazgocalif-det-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabhallazgocalif a[href="#tabhallazgocalif-det"]').attr('class' ,'active');
        $('#tabhallazgocalif a[href="#tabhallazgocalif-list"]').attr('class', '');
        return true;
    });
    
    $('#tabhallazgocalif a[href="#tabhallazgocalif-list"]').click(function(event){return false;});
    $('#tabhallazgocalif a[href="#tabhallazgocalif-det"]').click(function(event){return false;});

    $('#divAnio').show();
    $('#divMes').show();
    $('#divDesde').hide();
    $('#divHasta').hide();

    $('#txtFDesde,#txtFHasta,#txtFInspeccion').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });

    fechaActual();

    /*LLENADO DE COMBOS*/         
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"cglobales/getanios",
            dataType: "JSON",
            async: true,
            success:function(result)
            {
                $('#cboAnio').html(result);
            },
            error: function(){
              alert('Error, No se puede autenticar por error :: cboAnio');
            }
        });  

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"cglobales/getmeses",
            dataType: "JSON",
            async: true,
            success:function(result)
            {
                $('#cboMes').html(result);
            },
            error: function(){
              alert('Error, No se puede autenticar por error :: cboMes');
            }
        }); 

        var paramscliente = {"ccliente" : $('#hdnCCliente').val()};
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/ctrlprovclie/cconsresulgral/getcboprovxclie",
            dataType: "JSON",
            async: true,
            data: paramscliente,
            success:function(result)
            {
                $('#cboProveedor').html(result);
            },
            error: function(){
              alert('Error, No se puede autenticar por error :: cboProveedor');
            }
        });
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/ctrlprovclie/cconsresulgral/getcboareaclie",
            dataType: "JSON",
            async: true,
            data: paramscliente,
            success:function(result)
            {
                $('#cboareaclie').html(result);
            },
            error: function(){
              alert('Error, No se puede autenticar por error :: cboareaclie');
            }
        });
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/ctrlprovclie/cconsresulgral/getcbocalifiusuario",
            dataType: "JSON",
            async: true,
            success:function(result)
            {
                $('#cbocalificacion').html(result);
            },
            error: function(){
              alert('Error, No se puede autenticar por error :: cbocalificacion');
            }
        });
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

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

$('input[type=radio][name=rFbuscar]').change(function() {
    if($('#rdPeriodo').prop('checked')){        
        $('#divAnio').show();
        $('#divMes').show();
        $('#divDesde').hide();
        $('#divHasta').hide();
        varfdesde = '%';
        varfhasta = '%';
        varperiodo = '1';
        $('#hrdbuscar').val('P'); 
    }else if ($('#rdFechas').prop('checked')){     
        $('#divAnio').hide();
        $('#divMes').hide();
        $('#divDesde').show();
        $('#divHasta').show();
        varfdesde = '';
        varfhasta = '';
        varperiodo = '0';
        $('#hrdbuscar').val('F'); 
    } 
});

$("#btnBuscar").click(function (){    
    var v_mes, v_anio

    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 

    if(varperiodo != '0'){ 
        v_anio = $('#cboAnio').val(); 
        v_mes = $('#cboMes').val(); 
    }else{
        v_anio = 0;
        v_mes = 0;
    } 
   
    var select = document.getElementById("cbocalificacion"), 
    value = select.value, 
    text_calif = select.options[select.selectedIndex].innerText;

    var parametros = {
        "ccliente"      : $('#hdnCCliente').val(),
        "anio"          : v_anio,
        "mes"           : v_mes,
        "fini"          : varfdesde,
        "ffin"          : varfhasta,
        "cclienteprov"  : $('#cboProveedor').val(),
        "area"          : $('#cboareaclie').val(),
        "dcalificacion" : text_calif,
    };  

    getListConshallazgocalif(parametros);
    
});

getListConshallazgocalif = function(param){    
    var groupColumn = 0;    

    otblconshallazgocalif = $('#tblconshallazgocalif').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "540px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getconshallazgocalif",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'CALIFICACION', "class": "col-s"},
            {data: 'AREA', "class": "col-m"},
            {data: 'NC', "class": "dt-body-center col-sm"},
            {data: 'NRC', "class": "dt-body-center col-sm"},
            {data: 'OB', "class": "dt-body-center col-sm"},
            {data: 'OBR', "class": "dt-body-center col-sm"},
            {data: 'OM', "class": "dt-body-center col-sm"},
            {data: 'OL', "class": "dt-body-center col-sm"},
            {data: 'NCL', "class": "dt-body-center col-sm"},
            {data: 'OPL', "class": "dt-body-center col-sm"},
            {data: 'NCPL', "class": "dt-body-center col-sm"},
        ],  
        "columnDefs": [
            { "visible": false, "targets": groupColumn },
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="10">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });

    otblconshallazgocalif.column(0).visible( false );
     
    $("#btnexcel").prop("disabled",false);
     
};

$('#tblconshallazgocalif tbody').on('dblclick', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblconshallazgocalif.row(tr);
    var rowData = row.data();
    $('#tabhallazgocalif a[href="#tabhallazgocalif-det"]').tab('show');
    parametros = paramListDethallazgocalif(rowData.CALIFICACION,rowData.CAREACLIENTE);
    getListDethallazgocalif(parametros);
} );

$('#btnRetornarLista').click(function(){
    $('#tabhallazgocalif a[href="#tabhallazgocalif-list"]').tab('show'); 
    $('#btnBuscar').click();
});

paramListDethallazgocalif = function (dcalificacion,careacliente){    
    var v_mes, v_anio, v_ccliente, v_cproveedor

    v_ccliente = $('#hdnCCliente').val();
    v_cproveedor = $('#cboProveedor').val();

    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 

    if(varperiodo != '0'){ 
        v_anio = $('#cboAnio').val(); 
        v_mes = $('#cboMes').val(); 
    }else{
        v_anio = 0;
        v_mes = 0;
    } 
           
    $('#hddnmdetccliente').val(v_ccliente);     
    $('#hddnmdetanio').val(v_anio); 
    $('#hddnmdetmes').val(v_mes);     
    $('#hddnmdetfini').val(varfdesde);    
    $('#hddnmdetffin').val(varfhasta);   
    $('#hddnmdetcclienteprov').val(v_cproveedor);
    $('#hddnmdetarea').val(careacliente);
    $('#hddnmdetdcalificacion').val(dcalificacion);

    var parametros = {
        "ccliente"      : v_ccliente,
        "anio"          : v_anio,
        "mes"           : v_mes,
        "fini"          : varfdesde,
        "ffin"          : varfhasta,
        "cclienteprov"  : v_cproveedor,
        "area"          : careacliente,
        "dcalificacion" : dcalificacion,
    };   

    return parametros;
    
};

getListDethallazgocalif = function(param){     
    var groupColumn = 0;   
  
    otbldethallazgocalif = $('#tbldethallazgocalif').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "500px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getdethallazgocalif",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'AREA'},
            {data: null, "class": "col-xxs"},
            {data: 'PROVEEDOR', "class": "col-xl"},
            {data: 'ESTABLEMAQUI', "class": "col-lm"},
            {data: 'LINEACLIENTE', "class": "col-lm"},
            {data: 'NROINFORME', "class": "dt-body-center col-sm"},
            {data: 'FSERVICIO', "class": "dt-body-center col-s"},
            {data: 'NC', "class": "dt-body-center col-sm"},
            {data: 'NRC', "class": "dt-body-center col-sm"},
            {data: 'OB', "class": "dt-body-center col-sm"},
            {data: 'OBR', "class": "dt-body-center col-sm"},
            {data: 'OM', "class": "dt-body-center col-sm"},
            {data: 'OL', "class": "dt-body-center col-sm"},
            {data: 'NCL', "class": "dt-body-center col-sm"},
            {data: 'OPL', "class": "dt-body-center col-sm"},
            {data: 'NCPL', "class": "dt-body-center col-sm"},
        ], 
        "columnDefs": [
            {
                "targets": [2], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalResumen" onClick="mostrarResumen(\'' + row.CAUDITORIAINSPECCION + '\', \'' + row.FSERVICIO + '\');">'+row.PROVEEDOR+'</a>'+
                    '</div>';
                }
            },
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });
    // Enumeracion 
    otbldethallazgocalif.on( 'order.dt search.dt', function () { 
        otbldethallazgocalif.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw();

    otbldethallazgocalif.column(0).visible( false );
     
    $("#btnexcelDet").prop("disabled",false);
     
};

mostrarResumen = function(cauditoriainspeccion,fservicio){
    var parametros = { 
        "cauditoriainspeccion":cauditoriainspeccion,
        "fservicio":fservicio,
    };
    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprovclie/cconshallazgocalif/getresumeninspeccion",
        dataType: "JSON",
        async: true,
        data: parametros,
        error: function(){
            alert('Error, No se puede autenticar por error = getresumeninspeccion');
        }
    });      
    request.done(function( respuesta ) {            
        $.each(respuesta, function() {
            $('#mtxtempresa').val(this.EMPRESA);
            $('#mtxtdirinspeccion').val(this.DIRINSPE);
            $('#mtxtlinea').val(this.LINEA);
            $('#mtxtpuntaje').val(this.PUNTAJE);
            $('#mtxtcalificacion').val(this.CALIFICACION);
            $('#mtxtnroinforme').val(this.NROINFORME);
            $('#mtxtlicfunestado').val(this.ESTADOLICENCIA);
            $('#mtxtlicfunnro').val(this.NROLICENCIA);
            $('#mtxtmunicipalidad').val(this.MUNICIPALIDAD);
            $('#mtxtobservacion').val(this.OBSERVACION);   
        });
    });     
    getListdetresumen(cauditoriainspeccion,fservicio);
    getListreqexcluye(cauditoriainspeccion,fservicio);
    getListproducto(cauditoriainspeccion,fservicio);
    getListcriterio(cauditoriainspeccion,fservicio);
};

getListdetresumen = function(cauditoriainspeccion,fservicio){     
    var groupColumn = 0; 
    
    var param = {
        "cauditoriainspeccion": cauditoriainspeccion,
        "fservicio"          : fservicio,
    };  
  
    otbldetresumen= $('#tbldetresumen').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "300px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: false,
        "filter"      	: false, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getdetresumen",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'dregistro'},
            {data: 'dinfoadicional', "class": "col-xl"},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="1">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });
    otbldetresumen.column(0).visible( false );
     
     
};

getListreqexcluye = function(cauditoriainspeccion,fservicio){     
    var groupColumn = 0; 
    
    var param = {
        "cauditoriainspeccion": cauditoriainspeccion,
        "fservicio"          : fservicio,
    };  
  
    otblreqexcluye= $('#tblreqexcluye').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "300px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: false,
        "filter"      	: false, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getreqexcluye",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'TITULO'},
            {data: 'DHALLAZGOTEXT', "class": "col-xl"},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="1">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });
    otblreqexcluye.column(0).visible( false );
     
     
};

getListproducto = function(cauditoriainspeccion,fservicio){      
    var param = {
        "cauditoriainspeccion": cauditoriainspeccion,
        "fservicio"          : fservicio,
    };  
  
    otblproducto= $('#tblproducto').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "250px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: false,
        "filter"      	: false, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getproducto",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'dproducto', "class": "col-sm"},
            {data: 'dpeligrocliente', "class": "col-s"},
            {data: 'dpeligroproveedor', "class": "col-s"},
            {data: 'dpeligroinspeccion', "class": "col-s"},
            {data: 'dobservacion', "class": "col-sm"},
        ]
    });
     
     
};

getListcriterio = function(cauditoriainspeccion,fservicio){      
    var param = {
        "cauditoriainspeccion": cauditoriainspeccion,
        "fservicio"          : fservicio,
    };  
  
    otblcriterio= $('#tblcriterio').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "250px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: false,
        "filter"      	: false, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconshallazgocalif/getcriterio",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'CDETALLEVALOR', "class": "col-xs"},
            {data: 'DDETALLEVALOR', "class": "col-sm"},
            {data: 'NROHALLAZGOS', "class": "col-s"},
        ]
    });
    // Enumeracion 
    otblcriterio.on( 'order.dt search.dt', function () { 
        otblcriterio.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw(); 
     
     
};
