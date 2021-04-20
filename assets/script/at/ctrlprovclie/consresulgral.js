
var otblListctrlprov;
var varfdesde = '%', varfhasta = '%';

$(document).ready(function() {

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
    }else if ($('#rdFechas').prop('checked')){     
        $('#divAnio').hide();
        $('#divMes').hide();
        $('#divDesde').show();
        $('#divHasta').show();
        varfdesde = '';
        varfhasta = '';
        varperiodo = '0';
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

    var parametros = {
        "ccliente"      : $('#hdnCCliente').val(),
        "anio"          : v_anio,
        "mes"           : v_mes,
        "fini"          : varfdesde,
        "ffin"          : varfhasta,
        "cclienteprov"  : $('#cboProveedor').val(),
        "area"          : $('#cboareaclie').val(),
        "dcalificacion" : $('#cbocalificacion').val(),
    };  

    getListConsresulgral(parametros);
    
});

getListConsresulgral = function(param){       
    otblconsresulgral = $('#tblconsresulgral').DataTable({
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
        "ordering"		: true,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconsresulgral/getconsresulgral",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'VENTASMARCAS', "class": "col-xs"},
            {data: 'ANIO', "class": "col-xs"},
            {data: 'DIVISION', "class": "col-xs"},
            {data: 'CATEGORIASECCION', "class": "col-sm"},
            {data: 'RUC', "class": "col-s"},
            {data: 'PROVEEDOR', "class": "col-xm"},
            {data: 'LINEADEPRODUCCION', "class": "col-xm"},
            {data: 'MARCA', "class": "col-xl"},
            {data: 'DIRECCIONLOCALINSPECCIONADO', "class": "col-l"},
            {data: 'TIPO', "class": "col-s"},
            {data: 'PROG', "class": "col-s"},
            {data: 'MESPROG', "class": "col-s"},
            {data: 'MESEJE', "class": "col-s"},
            {data: 'FECHAEJE', "class": "col-s"},
            {data: 'LABORATORIO', "class": "col-s"},
            {data: 'ESTADO', "class": "col-s"},
            {data: 'OBSERVACIONES', "class": "col-l"},
            {data: 'CALIFICACION', "class": "col-s"},
            {data: 'CLASIFICACION', "class": "col-s"},
            {data: 'COSTOSIGV', "class": "col-s"},
            {data: 'GASTOSPORVIATICOS', "class": "col-sm"},
            {data: 'EMAIL', "class": "col-m"},
        ], 
        "order": [[ 14, "asc" ]] 
    });
    // Enumeracion 
    otblListConsolcencosud.on( 'order.dt search.dt', function () { 
        otblListConsolcencosud.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw(); 
     
};