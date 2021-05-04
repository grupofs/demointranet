
var otblconscertifprov, otbllistcertidet;
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
            {data: 'CERTIFICADORA', "class": "col-sm"},
            {data: 'CERTIFICACION', "class": "col-lm"},
            {data: 'NOAPLICA', "class": "dt-body-center col-s"},
            {data: 'NOTIENE', "class": "col-s"},
            {data: 'SITIENE', "class": "col-s"},
            {data: 'CONVALIDADO', "class": "col-s"},
            {data: 'TOTAL', "class": "col-s"},
        ], 
        "columnDefs": [
            {
                "targets": [2], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalDet" onClick="mostrarDetalle(\'' + row.CCLIENTE + '\',\'S\',\'NA\',\'' + row.ANIO + '\', \'' + row.MES + '\', \'' + row.TCCERTIFICACION + '\', \'I\');">'+row.NOAPLICA+'</a>'+
                    '</div>';
                }
            },
            {
                "targets": [3], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalDet" onClick="mostrarDetalle(\'' + row.CCLIENTE + '\',\'S\',\'ST\',\'' + row.ANIO + '\', \'' + row.MES + '\', \'' + row.TCCERTIFICACION + '\', \'I\');">'+row.SITIENE+'</a>'+
                    '</div>';
                }
            },
            {
                "targets": [4], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalDet" onClick="mostrarDetalle(\'' + row.CCLIENTE + '\',\'S\',\'NT\',\'' + row.ANIO + '\', \'' + row.MES + '\', \'' + row.TCCERTIFICACION + '\', \'I\');">'+row.NOTIENE+'</a>'+
                    '</div>';
                }
            },
            {
                "targets": [5], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalDet" onClick="mostrarDetalle(\'' + row.CCLIENTE + '\',\'S\',\'ST\',\'' + row.ANIO + '\', \'' + row.MES + '\', \'' + row.TCCERTIFICACION + '\', \'C\');">'+row.CONVALIDADO+'</a>'+
                    '</div>';
                }
            },
        ], 
    });
     
};

mostrarDetalle = function(ccliente,varver,varestado,varanio,varmes,varcerti,varcondi){     
    parametros = paramListdet(ccliente,varver,varestado,varanio,varmes,varcerti,varcondi);
    getListdet(parametros);
};


paramListdet = function (ccliente,varver,varestado,varanio,varmes,varcerti,varcondi){    
         
    var parametros = {
        "CCLIENTE" : ccliente,
        "ANIO"     : varanio,
        "MES"     : varmes,
        "CERTI"     : varcerti,
        "ESTADO"     : varestado
    };  

    return parametros;
    
};

getListdet = function(param){       
    otbllistcertidet = $('#tbllistcertidet').DataTable({
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
            "url"   : baseurl+"at/ctrlprovclie/cconscertifprov/getcertidet",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: null, "class": "col-xxs"},
            {data: 'PROVEEDOR', "class": "col-m"},
            {data: 'MAQUILADOR', "class": "col-m"},
            {data: 'ESTABLECIMIENTO', "class": "col-m"},
            {data: 'LINEAPROCESO', "class": "col-m"},
            {data: 'DIRESTABLECIMIENTO', "class": "col-m"},
        ]
    });
    // Enumeracion 
    otbllistcertidet.on( 'order.dt search.dt', function () { 
        otbllistcertidet.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw(); 
     
};