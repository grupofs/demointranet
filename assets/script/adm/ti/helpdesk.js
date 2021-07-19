var otblListTicket;
var varfdesde = '%', varfhasta = '%';

$(document).ready(function() {
    $('#tabsis a[href="#tabsis-list-tab"]').attr('class', 'disabled');
    $('#tabsis a[href="#tabsis-reg-tab"]').attr('class', 'disabled active');

    $('#tabsis a[href="#tabsis-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tabsis a[href="#tabsis-list"]').attr('class', 'active');
        $('#tabsis a[href="#tabsis-reg"]').attr('class', '');
        return true;
    });
    $('#tabsis a[href="#tabsis-reg-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabsis a[href="#tabsis-reg"]').attr('class' ,'active');
        $('#tabsis a[href="#tabsis-list"]').attr('class', '');
        return true;
    });
    
    $('#tabsis a[href="#tabsis-list"]').click(function(event){return false;});
    $('#tabsis a[href="#tabsis-reg"]').click(function(event){return false;});
 
    listarbusqueda();
});

$('#btnNuevo').click(function(){    
    $('#tabsis a[href="#tabsis-reg"]').tab('show');
    listarEmpleados(); 
});

$('#btnRetornarLista').click(function(){
    $('#tabsis a[href="#tabsis-list"]').tab('show');  
});

listarEmpleados = function(){
    /*var params = { 
        "ccia" : v_ccia,
        "carea" : v_carea
    }; */
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/ti/chelpdesk/getempleados",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboempleado').html(result);
        },
        error: function(){
          alert('Error, No se puede autenticar por error');
        }
    });
}

listarbusqueda = function(){
    otblListTicket = $('#tblListTicket').DataTable({  
        "processing"  	: true,
        "serverSide"    : true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "280px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: true,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true, 
        "order"         : [], 
        'ajax'        : {
            "url"   : baseurl+"adm/ti/chelpdesk/getlistarbanco/",
            "type"  : "POST", 
            "data"  : function (d) {  
            },     
            dataSrc : ''        
        },
        'columns'     : [
            {data: 'idbanco'},
            {data: 'nombanco'},
            {data: 'indvigencia'}
        ],
    });
};

$('#tblListTicket').on('draw.dt', function(){
    $('#tblListTicket').Tabledit({
     url:baseurl+"adm/ti/chelpdesk/setactionbanco/",
     //eventType: 'dblclick',
     editButton: true,
     deleteButton: false,
     dataType:'json',
     columns:{
      identifier : [0, 'idbanco'],
      editable:[[1, 'nombanco'], [2, 'indvigencia', '{"A":"Activo","I":"Inactivo"}']]
     },
     restoreButton:false,
    });
});