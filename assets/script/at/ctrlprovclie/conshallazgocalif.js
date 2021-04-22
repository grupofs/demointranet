
var otblconshallazgocalif;
var varfdesde = '%', varfhasta = '%', varperiodo = '1';

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
        ]
    });
     
};
