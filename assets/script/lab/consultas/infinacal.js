
var otblListinfinacal;
var varfdesde = '%', varfhasta = '%', varperiodo = '1', varsemestre = '0', vartipodesc = 'INF';

$(document).ready(function() {
    
    $('#divAnio').show();
    $('#divMes').show();
    $('#divDesde').hide();
    $('#divHasta').hide();
    $('#divSemestre').hide();

    $('#txtFDesde,#txtFHasta').datetimepicker({
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
        $('#divSemestre').hide();
        varfdesde = '%';
        varfhasta = '%';
        varperiodo = '1';
        varsemestre = '0';
        $('#hrdbuscar').val('P'); 
    }else if ($('#rdFechas').prop('checked')){     
        $('#divAnio').hide();
        $('#divMes').hide();
        $('#divDesde').show();
        $('#divHasta').show();
        $('#divSemestre').hide();
        varfdesde = '';
        varfhasta = '';
        varperiodo = '0';
        varsemestre = '0';
        $('#hrdbuscar').val('F'); 
    }else if ($('#rdSemestre').prop('checked')){  
        $('#divAnio').show();
        $('#divMes').hide();
        $('#divDesde').hide();
        $('#divHasta').hide();
        $('#divSemestre').show();
        varfdesde = '%';
        varfhasta = '%';
        varperiodo = '0';
        varsemestre = '1';
        $('#hrdbuscar').val('S'); 
    } 
});

$('input[type=radio][name=rBDesc]').change(function() {
    if($('#rdBInf').prop('checked')){   
        vartipodesc = 'INF';
        $('#hrdtipodes').val('INF'); 
    }else if ($('#rdBOT').prop('checked')){    
        vartipodesc = 'OT';
        $('#hrdtipodes').val('OT'); 
    }else if ($('#rdBCliente').prop('checked')){  
        vartipodesc = 'CLI';
        $('#hrdtipodes').val('CLI'); 
    } 
});

$("#btnBuscar").click(function (){ 
    parametros = paramListinfinacal();
    listarBusqueda(parametros); 
});

paramListinfinacal = function (){    
    var v_mes, v_anio, v_sem

    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 

    if(varperiodo != '0'){ 
        v_anio = $('#cboAnio').val(); 
        v_mes = $('#cboMes').val(); 
    }else{
        v_anio = 0;
        v_mes = 0;
    } 

    if(varsemestre != '0'){ 
        v_anio = $('#cboAnio').val(); 
        v_sem = $('#cboSem').val(); 
    }else{
        v_sem = 0;
    }     
     
    var parametros = {
        "anio"          : v_anio,
        "mes"           : v_mes,
        "fini"          : varfdesde,
        "ffin"          : varfhasta,
        "sem"           : v_sem,
        "tipodesc"      : vartipodesc,
        "descripcion"   : $('#txtdescripcion').val(),
    };  

    return parametros;
    
};

listarBusqueda = function(){ 
    otblListinfinacal = $('#tblListinfinacal').DataTable({  
        'responsive'    : false,
        'bJQueryUI'     : true,
        'scrollY'     	: '600px',
        'scrollX'     	: true, 
        'paging'      	: true,
        'processing'  	: true,     
        'bDestroy'    	: true,
        'AutoWidth'     : false,
        'info'        	: true,
        'filter'      	: true, 
        'ordering'		: false,  
        'stateSave'     : true,
        'select'        : true,
        'ajax'	: {
            "url"   : baseurl+"lab/consultas/cconsultas/infinacal/",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''        
        },
        'columns'	: [
            {data : null,"class":"col-xs"},
            {data: 'NROINFORME', "class" : "col-sm"},
            {data: 'FEMISION', "class" : "col-sm dt-body-center"},
            {data: 'PRODUCTO', "class" : "col-xl"},
            {data: 'DISCIPLINA'},
        ],
    });   
    // Enumeracion 
    otblListinfinacal.on( 'order.dt search.dt', function () { 
        otblListinfinacal.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
    
    $("#btnexcel").prop("disabled",false); 
};
