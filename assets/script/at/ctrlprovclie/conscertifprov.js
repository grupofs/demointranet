
var otblconscertifprov;
var varfdesde = '%', varfhasta = '%', varperiodo = '1';

$(document).ready(function() {

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

$("#btnBuscar").click(function (){    
    var v_mes, v_anio

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
    };  

    getListConscertifprov(parametros);
    
});

getListConscertifprov = function(param){       
    otblconscertifprov = $('#tblconscertifprov').DataTable({
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
            "url"   : baseurl+"at/ctrlprovclie/cconscertifprov/getconscertifprov",
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