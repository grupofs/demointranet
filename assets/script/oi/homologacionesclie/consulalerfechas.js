
var otblalertasfecha;
var varfvence = '%'

$(document).ready(function() {

    $('#txtFvencido').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });
    fechaActual();

    var vccliente = $('#hdnCCliente').val();
    
    /*LLENADO DE COMBOS*/
    var params = { "ccliente":vccliente };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"oi/homologacionesclie/cconsulhomo/getproveedoreshomo",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboProveedor').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboProveedor');
        }
    });
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFvencido').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

$("#btnBuscar").click(function (){    
    parametros = paramListalertasfecha();
    getListalertasfecha(parametros);
    
});

paramListalertasfecha = function (){    
        
    varfvence = $('#txtFvence').val();
   
    var parametros = {
        "ccia"          : '2',
        "ccliente"      : $('#hdnCCliente').val(),
        "proveedor"     : $('#cboProveedor').val(),
        "vence"         : varfvence,
    };  
  
    return parametros;    
};

getListalertasfecha = function(parametros){       
    otblalertasfecha = $('#tblalertasfecha').DataTable({
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
            "url"   : baseurl+"oi/homologacionesclie/cconsulhomo/getalertasfecha",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: null, "class": "col-xxs"},
            {data: 'drazonsocial', "class": "col-m"},
            {data: 'dproducto', "class": "col-m"},
            {data: 'dmarca', "class": "col-sm"},
            {data: 'dpresentacion', "class": "col-sm"},
            {data: 'ddocumento', "class": "col-l"},
            {data: 'fcumplimiento', "class": "dt-body-center col-s"},
            {"orderable": false, 
              render:function(data, type, row){
              }
            }
        ],
        "columnDefs": [
          {
              "defaultContent": " ",
              "targets": "_all"
          }
        ],
        'order'       : [[ 1, "desc" ]] 
    });
    // Enumeracion 
    otblalertasfecha.on( 'order.dt search.dt', function () { 
        otblalertasfecha.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        } );
    } ).draw();
};