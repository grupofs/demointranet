var otblListalertainf;


$(document).ready(function() { 
    parametros = paramListalertainf();
    getlistalertainf(parametros);  
});


paramListalertainf = function (){    
       
    var param = {
        "idempleado"  : $('#hdidempleado').val(),
    }; 
    return param;    
};

getlistalertainf = function(parametros){    
    otblListalertainf = $('#tblListalertainf').DataTable({ 
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true, 
        'ajax'	: {
            "url"   : baseurl+"pt/calerta/getlistalertainf/",
            "type"  : "POST",             
            "data"  : parametros, 
            dataSrc : ''        
        },
        'columns'	: [
            {data : null, "class" : "col-xxs", orderable : false},
            {data: 'nro_informe', "class": "col-sm"},
            {data: 'fecha_informe', "class": "col-s"},
            {data: 'RAZONSOCIAL', "class": "col-lm"},
            {data: 'descripcion_serv', "class": "col-lm"},
            {"orderable": false, "class": "col-s", 
              render:function(data, type, row){                
                  return  '<div>'+
                  '<a data-toggle="modal" title="Editar" style="cursor:pointer; color:#3c763d;" data-target="#modalCreaInfor" onClick="javascript:selInforme(\''+row.idptinforme+'\',\''+row.idptevaluacion+'\',\''+row.nro_informe+'\',\''+row.fecha_informe+'\',\''+row.idresponsable+'\',\''+row.archivo_informe+'\',\''+row.ruta_informe+'\',\''+row.descripcion+'\',\''+row.descripcion_archivo+'\');"><span class="fas fa-edit" aria-hidden="true"> </span> </a>'+
                  '</div>'
              }
            },
        ],
        "columnDefs": [{
            "targets": [1], 
            "data": null, 
            "render": function(data, type, row) { 
                if(row.archivo_informe != "") {
                    return '<p><a href="'+baseurl+row.ruta_informe+row.archivo_informe+'" target="_blank" class="pull-left">'+row.nro_informe+'&nbsp;<i class="fas fa-cloud-download-alt" data-original-title="Descargar" data-toggle="tooltip"></i></a><p>';
                }else{
                    return '<p>'+row.nro_informe+'</p>';
                }                      
            }
        }]
    });
    // Enumeracion 
    otblListalertainf.on( 'order.dt search.dt', function () { 
        otblListalertainf.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
}

selInforme= function(idptinforme,idptevaluacion,nro_informe,fecha_informe,idresponsable,archivo_informe,ruta_informe,descripcion,descripcion_archivo){
    $('#mhdnAccionInfor').val('A');
        
    $('#mhdnIdInfor').val(idptinforme);
    $('#mhdnIdpteval').val(idptevaluacion);
    $('#mtxtNroinfor').val(nro_informe);
    $('#mtxtFinfor').val(fecha_informe);
    $('#mcboContacInfor').val(idresponsable).trigger("change");
    $('#mtxtNomarchinfor').val(descripcion_archivo);
    $('#mtxtRutainfor').val(ruta_informe);
    $('#mtxtDetaInfor').val(descripcion);
    $('#mtxtArchinfor').val(archivo_informe);
    
    $('#lbchkinf').show();
};

$('#modalCreaInfor').on('shown.bs.modal', function (e) {  
    $("#mtxtNroinfor").prop({readonly:true}); 
});

escogerArchivo = function(){    
    var archivoInput = document.getElementById('mtxtArchivoinfor');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.pdf|.docx|.xlsx|.doc|.xls)$/i;
    
    var filename = $('#mtxtArchivoinfor').val().replace(/.*(\/|\\)/, '');
    $('#mtxtNomarchinfor').val(filename);

    if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado un PDF, DOCX, XSLX');
        archivoInput.value = '';  
        $('#mtxtNomarchinfor').val('');
        return false;
    }      
    $('#sArchivo').val('S');
};

$('#frmCreaInfor').submit(function(event){
    event.preventDefault();
    
    var request = $.ajax({
        url:$('#frmCreaInfor').attr("action"),
        type:$('#frmCreaInfor').attr("method"),
        data:$('#frmCreaInfor').serialize(),
        error: function(){
            Vtitle = 'No se puede registrar por error';
            Vtype = 'error';
            sweetalert(Vtitle,Vtype);
        }
    });
    request.done(function( respuesta ) {
        var posts = JSON.parse(respuesta);        
        $.each(posts, function() {   
            $('#mhdnIdInfor').val(this.id_informe);
            if($('#sArchivo').val() == 'S'){          
                subirArchivo();
            }else{                   
                $('#mbtnCCreaInfor').click();     
                Vtitle = this.respuesta;
                Vtype = 'success';
                sweetalert(Vtitle,Vtype); 
                
                parametros = paramListalertainf();
                getlistalertainf(parametros);       
            } 
            $('#sArchivo').val('N');  
        });
    });
});
subirArchivo=function(){
    var parametrotxt = new FormData($("#frmCreaInfor")[0]);
    var request = $.ajax({
        data: parametrotxt,
        method: 'post',
        url: baseurl+"pt/cinforme/subirArchivo/",
        dataType: "JSON",
        async: true,
        contentType: false,
        processData: false,
        error: function(){
            alert('Error, no se cargó el archivo');
        }
    });
    request.done(function( respuesta ) {         
        Vtitle = 'Guardo Correctamente';
        Vtype = 'success';
        sweetalert(Vtitle,Vtype);
        otblListalertainf.ajax.reload(null,false);
        $('#mbtnCCreaInfor').click();
    });
};