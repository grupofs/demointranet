
var otblCdroFactura;

$(document).ready(function() {

    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboclieserv",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboclieserv').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboclieserv');
        }
    });

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"cglobales/getanios",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcboanio').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
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
            $('#mcbomes').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });

});

$("#cboclieserv").change(function(){

    var v_cboclieserv = $('#cboclieserv').val();
    var params = { "ccliente":v_cboclieserv };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboprovxclie",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboprovxclie").html(result);          
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboprovxclie');
        }
    });   
});

$("#btnBuscar").click(function (){   
    var param = {
        "ccliente"      : $('#cboclieserv').val(),
        "cproveedor"    : $('#cboprovxclie').val(),
        "anio"          : $('#mcboanio').val(),
        "mes"           : $('#mcbomes').val(),
        "estado"        : $('#cboestado').val(),
        "monto"         : $('#txtmonto').val(),
    }; 

    listarBusqueda(param);
});

listarBusqueda = function(param){
    
    var groupColumn = 1;   

    otblCdroFactura = $('#tblCdroFactura').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true,
        "scrollCollapse": true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : false,  
        'ajax'	: {
            "url"   : baseurl+"at/ctrlprov/cconsfactura/getbuscarfactura/",
            "type"  : "POST", 
            "data"  : param,      
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'ESPACIO', targets: 0, "class": "col-xxs"},
            {"orderable": false, data: 'cliente', targets: 1},
            {"orderable": false, data: 'proveedor', targets: 2},
            {"orderable": false, data: 'nruc', targets: 3},
            {"orderable": false, data: 'dareacliente', targets: 4},
            {"orderable": false, data: 'costo', targets: 5},
            {"orderable": false, data: 'mes_fact', targets: 6},
            {"orderable": false, data: 'dir_estab', targets: 7},
            {"orderable": false, data: 'dlineaclientee', targets: 8},
            {"orderable": false, data: 'fservicio', targets: 9},
            {"orderable": false, data: 'dinformefinal', targets: 10},
            {"orderable": false, data: 'estado', targets: 11},
            {"orderable": false, data: 'INSPECTOR', targets: 12},
        ]
    });  
    // Enumeracion 
    otblCdroFactura.on( 'order.dt search.dt', function () { 
        otblCdroFactura.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();   
};