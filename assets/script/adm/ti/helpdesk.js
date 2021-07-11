var otblListCotizacion;
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
 
    var params = { 
        "ccia" : v_ccia,
        "carea" : v_carea
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/ti/chelpdesk/getempleados",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboempleado').html(result);
        },
        error: function(){
          alert('Error, No se puede autenticar por error');
        }
    });
});

$('#btnNuevo').click(function(){    
    $('#tabsis a[href="#tabsis-reg"]').tab('show'); 
});

$('#btnRetornarLista').click(function(){
    $('#tabsis a[href="#tabsis-list"]').tab('show');  
});