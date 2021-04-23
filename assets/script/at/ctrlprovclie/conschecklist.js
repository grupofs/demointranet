
var otblconschecklist;
var varfdesde = '%', varfhasta = '%', varperiodo = '1';

$(document).ready(function() {
 
});

$("#btnBuscar").click(function (){    
   
    var parametros = {
        "ccliente"      : $('#hdnCCliente').val(),
    };  

    getListConschecklist(parametros);
    
});

getListConschecklist = function(param){       
    otblconschecklist = $('#tblconschecklist').DataTable({
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
            "url"   : baseurl+"at/ctrlprovclie/cconschecklist/getconschecklist",
            "type"  : "POST", 
            "data"  : param,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: 'cchecklist', "class": "col-xs"},
            {data: 'dchecklist', "class": "col-lm"},
            {data: 'dservicio', "class": "col-m"},
            {data: 'dsistema', "class": "col-m"},
            {data: 'dnorma', "class": "col-sm"},
            {data: 'dsubnorma', "class": "col-m"},
            {data: 'suso', "class": "col-xxs"},
            {data: null,
                render:function(data, type, row){
                    return '<div style="text-align: center;">'+
                        '<a data-toggle="modal" title="Leyenda" style="cursor:pointer; color:#3c763d;" data-target="#modalLeyenda" onClick="javascript:verLeyenda(\''+row.CCHECKLIST+'\',\''+row.CHECKLIST+'\');"><span class="fas fa-tags fa-2x" aria-hidden="true"> </span> </a>'+
                    '</div>';
                }
            },
        ],  
    });
     
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