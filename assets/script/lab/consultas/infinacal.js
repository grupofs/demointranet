
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
        $('#divAnio').hide();
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
    }else if ($('#rdBOT').prop('checked')){    
        vartipodesc = 'OT';
    }else if ($('#rdBCliente').prop('checked')){  
        vartipodesc = 'CLI';
    } 
});

$("#btnBuscar").click(function (){
    listarBusqueda();
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
            {"class":"col-xs", orderable : false, data : null},
            {data: 'NROINFORME', "class" : "col-sm"},
            {data: 'FEMISION', "class" : "col-s dt-body-center"},
            {data: 'PRODUCTO', "class" : "col-lm"},
            {"orderable": false, data: 'NROOT', targets: 4},
            {"orderable": false, data: 'FOT', "class" : "col-s dt-body-center", targets: 5},
            {"orderable": false, data: 'INFORMES', "class" : "col-xm", targets: 7},
            {"orderable": false, data: 'ELABORADO', targets: 6},
            {"orderable": false, 
                render:function(data, type, row){      
                    return '<div>' +
                        '</div>';
                }
            }
        ],  
        "columnDefs": [{
            "targets": [2], 
            "data": null, 
            "render": function(data, type, row) {
                return '<div>'+
                '    <p><a title="Cotozacion" style="cursor:pointer;" onclick="pdfCoti(\'' + row.IDCOTIZACION + '\',\'' + row.NVERSION + '\');"  class="pull-left">'+row.NROCOTI+'&nbsp;&nbsp;<i class="fas fa-file-pdf fa-2x" style="color:#FF0000;"></i></a><p>' +
                '</div>';
            }
        }],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([1], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(1).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="7"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        }
    }); 
    otblListconsinf.column(1).visible( false );      
    // Enumeracion 
    otblListconsinf.on( 'order.dt search.dt', function () { 
        otblListconsinf.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
};

pdfCoti = function(idcoti,nversion){
    window.open(baseurl+"lab/coti/ccotizacion/pdfCoti/"+idcoti+"/"+nversion);
};
pdfInforme = function(cinternoordenservicio,cmuestra){
    window.open(baseurl+"lab/consinf/cconsinf/pdfInforme/"+cinternoordenservicio+"/"+cmuestra);
};