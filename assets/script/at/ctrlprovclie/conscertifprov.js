
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
    var groupColumn = 0;   

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
            {data: 'NOTIENE', "class": "dt-body-center col-s"},
            {data: 'SITIENE', "class": "dt-body-center col-s"},
            {data: 'CONVALIDADO', "class": "dt-body-center col-s"},
            {data: 'TOTAL', "class": "dt-body-center col-s"},
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
                "targets": [4], 
                "data": null, 
                "render": function(data, type, row) {
                    return '<div>'+
                        '<a data-toggle="modal" style="cursor:pointer; color:black;" data-target="#modalDet" onClick="mostrarDetalle(\'' + row.CCLIENTE + '\',\'S\',\'ST\',\'' + row.ANIO + '\', \'' + row.MES + '\', \'' + row.TCCERTIFICACION + '\', \'I\');">'+row.SITIENE+'</a>'+
                    '</div>';
                }
            },
            {
                "targets": [3], 
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

    otblconscertifprov.column(0).visible( false );
     
    $("#btnexcel").prop("disabled",false);
     
};

mostrarDetalle = function(ccliente,varver,varestado,varanio,varmes,varcerti,varcondi){     
    parametros = paramListdet(ccliente,varver,varestado,varanio,varmes,varcerti,varcondi);
    getListdet(parametros);
};


paramListdet = function (ccliente,varver,varestado,varanio,varmes,varcerti,varcondi){    
                 
    $('#hddnmdetccliente').val(ccliente);     
    $('#hddnmdetanio').val(varanio); 
    $('#hddnmdetmes').val(varmes);     
    $('#hddnmdetcerti').val(varcerti);    
    $('#hddnmdetestado').val(varestado);   

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
    var groupColumn = 0;      
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
            {data: 'CERTIFICACION'},
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
    otbllistcertidet.on( 'order.dt search.dt', function () { 
        otbllistcertidet.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        });
    } ).draw();  

    otbllistcertidet.column(0).visible( false );   
     
    $("#btnexcelDet").prop("disabled",false);
};