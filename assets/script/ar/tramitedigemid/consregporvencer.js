var otblListRegporvencer;
var varporvencer = 180;

$(document).ready(function() {


    /*LLENADO DE COMBOS*/  
    
    var params = { 
        "idusuario"   : $('#hdnIdUsuario').val(),
    };        
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"ar/tramites/cbusctramdigemid/getclientexusu",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cbocliente').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });
});

$('input[type=radio][name=rporvencer]').change(function() {    
    if($('#rdPV180').prop('checked')){
        varporvencer = 180;
    }else if ($('#rdPV360').prop('checked')){
        varporvencer = 360;
    }  
});

$("#btnBuscar").click(function (){   
    var param = {
        "ccliente"          : $('#cbocliente').val(),
        "descripcion"       : $('#txtdescripcion').val(),
        "porvencer"         : varporvencer,
    }; 

    listarBusqueda(param);
    
    $("#btnexcel").prop("disabled",false);
});

listarBusqueda = function(param){
    
    otblListRegporvencer = $('#tblListRegporvencer').DataTable({
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
        "ordering"		: true,
        "responsive"    : false,
        "select"        : false,  
        'ajax'	: {
            "url"   : baseurl+"ar/tramites/cconsregporvencer/getbuscarregporvencer/",
            "type"  : "POST", 
            "data"  : param,      
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'ESPACIO', targets: 0, "class": "col-xxs"},
            {data: 'CPRODUCTOCLIENTE', targets: 1, "class": "col-s"},
            {data: 'DPRODUCTOCLIENTE', targets: 2, "class": "col-lm"},
            {data: 'DNOMBREPRODUCTO', targets: 3, "class": "col-lm"},
            {data: 'DMODELOPRODUCTO', targets: 4, "class": "col-lm"},
            {"orderable": false, data: 'DMARCA', targets: 5, "class": "col-xm"},
            {"orderable": false, data: 'DREGISTRO', targets: 6, "class": "col-xm"},
            {"orderable": false, data: 'FABRICANTES', targets: 7, "class": "col-xm"},
            {"orderable": false, data: 'PAISFABRICANTES', targets: 8, "class": "col-xm"},
            {"orderable": false, data: 'DREGISTROSANITARIO', targets: 9, "class": "col-sm"},
            {"orderable": false, data: 'FFINREGSANITARIO', targets: 10, "class": "col-s"},
        ], 
    });    
    // Enumeracion 
    otblListRegporvencer.on( 'order.dt search.dt', function () { 
        otblListRegporvencer.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();   
};