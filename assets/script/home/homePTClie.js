

$(document).ready(function() {     
    var v_ccliente = $('#hdccliente').val(); 
    var params = { 
        "ccliente":v_ccliente 
    };

    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"home/chomePTClie/getserviciosclie",
        dataType: "JSON",
        async: true,
        data: params,
        error: function(){
        alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });
    request.done(function( respuesta ) {
        $.each(respuesta, function() {    
            v_mapter = this.mapter;   
            v_proconv = this.proconv;   
            v_calfrio = this.calfrio;   
            v_proacep = this.proacep;   
            v_evaldesvi = this.evaldesvi;   
            v_cocsechor = this.cocsechor;
            
            if(v_mapter == 0){
                $('#divmapter').hide(); 
            }else{
                $('#divmapter').show();
            }
            if(v_proconv == 0){
                $('#divproconv').hide(); 
            }else{
                $('#divproconv').show();
            }
            if(v_calfrio == 0){
                $('#divcalfrio').hide(); 
            }else{
                $('#divcalfrio').show();
            }
            if(v_proacep == 0){
                $('#divproacep').hide(); 
            }else{
                $('#divproacep').show();
            }
            if(v_evaldesvi == 0){
                $('#divevaldesvi').hide(); 
            }else{
                $('#divevaldesvi').show();
            }
            if(v_cocsechor == 0){
                $('#divcocsechor').hide(); 
            }else{
                $('#divcocsechor').show();
            }
        });
    });

});