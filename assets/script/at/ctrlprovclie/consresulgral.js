
var otblListctrlprov;
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
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        "ajax"	: {
            "url"   : baseurl+"at/ctrlprovclie/cconsresulgral/getconsresulgral",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'AREACLIENTE', "class": "col-sm"},
            {data: 'PROVEEDOR', "class": "col-lm"},
            {data: 'DIREST', "class": "col-lm"},
            {data: 'FECHASERVICIO', "class": "col-s"},
            {data: 'CALIFICACION', "class": "col-s"},
            {data: 'CHECKLIST', "class": "col-m"},
            {data: '01', "class": "col-xs"},
            {data: '02', "class": "col-xs"},
            {data: '03', "class": "col-xs"},
            {data: null,
                render:function(data, type, row){
                    return '<div style="text-align: center;">'+
                        '<a data-toggle="modal" title="Leyenda" style="cursor:pointer; color:#3c763d;" data-target="#modalLeyenda" onClick="javascript:verLeyenda(\''+row.CCHECKLIST+'\',\''+row.CHECKLIST+'\');"><span class="fas fa-tags fa-2x" aria-hidden="true"> </span> </a>'+
                    '</div>';
                }
            },
        ],  
        /*"columnDefs": [{
            "targets": [9],
            "render": function ( data, type, row ) {
                return '<div>'+
                    '<a data-title ="' + row.LEYENDA + '"><span class="fas fa-edit fa-2x" aria-hidden="true"></span></a>'
                    '</div>';
            }
        }],
        createdRow: function ( row, data, index ) {
            $("td:first", row).attr("title", data.LEYENDA);
        }*/
    });
    // Enumeracion 
    /*otblListConsolcencosud.on( 'order.dt search.dt', function () { 
        otblListConsolcencosud.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw(); */
     
};

verLeyenda = function(cchecklist,checklist){
    document.querySelector('#nameChkl').innerText = checklist;
    
    var params = {"cchecklist" : cchecklist};    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprovclie/cconsresulgral/getleyendachecklist",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#nameLeyenda').html(result);
        },
        error: function(){
          alert('Error, No se puede autenticar por error :: nameLeyenda');
        }
    });
};