
var otblconslicfunciona, otbllistlicprovdet;
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
     
    var parametros = {
        "ccliente"      : $('#hdnCCliente').val(),
        "anio"          : v_anio,
        "mes"           : v_mes,
        "fini"          : varfdesde,
        "ffin"          : varfhasta,
    };  

    getListConslicfunciona(parametros);
    
});

getListConslicfunciona = function(param){       
    otblconslicfunciona = $('#tblconslicfunciona').DataTable({
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
            "url"   : baseurl+"at/ctrlprovclie/cconslicfunciona/getconslicfunciona",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'LICENCIA', "class": "col-xl"},
            {data: 'NROINSPECCIONES', "class": "dt-body-right col-sm"},
            {data: 'PNROINSP', "class": "dt-body-right col-sm"},
        ]
    });
     
    $("#btnexcel").prop("disabled",false);
     
};

$('#tblconslicfunciona tbody').on('dblclick', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblconslicfunciona.row(tr);
    var rowData = row.data();

    var v_mes, v_anio, v_cliente, v_estado

    v_cliente = $('#hdnCCliente').val();

    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 

    if(varperiodo != '0'){ 
        v_anio = $('#cboAnio').val(); 
        v_mes = $('#cboMes').val(); 
    }else{
        v_anio = 0;
        v_mes = 0;
    } 
    
    $("#modalDet").modal('show');

    v_estado = rowData.ESTADO

    parametros = paramListdet(v_cliente,v_anio,v_mes,varfdesde,varfhasta,v_estado);
    getListdet(parametros);
} );

paramListdet = function (ccliente,v_anio,v_mes,varfdesde,varfhasta,v_estado){    
      
    $('#hddnmdetccliente').val(ccliente);     
    $('#hddnmdetanio').val(v_anio); 
    $('#hddnmdetmes').val(v_mes);     
    $('#hddnmdetfini').val(varfdesde);    
    $('#hddnmdetffin').val(varfhasta);     
    $('#hddnmdetestado').val(v_estado);

    var parametros = {
        "ccliente"  : ccliente,
        "anio"      : v_anio,
        "mes"       : v_mes,
        "fini"     : varfdesde,
        "ffin"     : varfhasta,
        "estado"    : v_estado
    };  

    return parametros;
    
};

getListdet = function(param){    
    var groupColumn = 0;      
    otbllistlicprovdet = $('#tbllistlicprovdet').DataTable({
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
            "url"   : baseurl+"at/ctrlprovclie/cconslicfunciona/getlicprovdet",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'ESTADO'},
            {data: null, "class": "col-xxs"},
            {data: 'PROVEEDOR', "class": "col-lm"},
            {data: 'LINEAPROCESO', "class": "col-m"},
            {data: 'DIRESTABLECIMIENTO', "class": "col-m"},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="4">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    });
    // Enumeracion 
    otbllistlicprovdet.on( 'order.dt search.dt', function () { 
        otbllistlicprovdet.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw();  

    otbllistlicprovdet.column(0).visible( false );   
     
    $("#btnexcelDet").prop("disabled",false);
};
