
var otblListRegInforme, otblListRegitro, otblListReg03equipo, otblListReg06equipo, otblListReg08equipo;
var varfdesde = '%', varfhasta = '%';
var iduser = $('#mtxtidusuinfor').val();

$(document).ready(function() { 
    
    $('#tabinforme a[href="#tabinforme-eval-tab"]').attr('class', 'disabled');
    $('#tabinforme a[href="#tabinforme-reg-tab"]').attr('class', 'disabled active');

    $('#tabinforme a[href="#tabinforme-eval-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabinforme a[href="#tabinforme-eval"]').attr('class' ,'active');
        $('#tabinforme a[href="#tabinforme-reg"]').attr('class', '');
        return true;
    });
    $('#tabinforme a[href="#tabinforme-reg-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabinforme a[href="#tabinforme-reg"]').attr('class' ,'active');
        $('#tabinforme a[href="#tabinforme-eval"]').attr('class', '');
        return true;
    });
    
    $('#tabinforme a[href="#tabinforme-eval"]').click(function(event){return false;});
    $('#tabinforme a[href="#tabinforme-reg"]').click(function(event){return false;});
   

    $('#mtxtFreginforme').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    $('#mtxtFreginformeedit').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    parametros = paramListalertareg();
    getlistalertareg(parametros);  
    
});

paramListalertareg = function (){    
       
    var param = {
        "idempleado"  : $('#hdidempleado').val(),
    }; 
    return param;    
};

getlistalertareg = function(parametros){
    document.querySelector('#lblInforme').innerText = '';

    otblListRegInforme = $('#tblListRegInforme').DataTable({  
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
            "url"   : baseurl+"pt/calerta/getlistalertareg/",
            "type"  : "POST",         
            "data"  : parametros, 
            dataSrc : ''        
        },
        'columns'	: [
            {data : null, "class" : "col-xxs", orderable : false},
            {data: 'nro_informe',"class": "col-sm"},
            {data: 'fecha_informe',"class": "col-xs"},
            {data: 'RAZONSOCIAL', "class": "col-lm"},
            {data: 'descripcion_serv', "class": "col-m"},
            {"orderable": false, "class": "col-xl", 
              render:function(data, type, row){ 
                             
                  return  '<div>'+    
                    ' <a onClick="javascript:insertRegistro(\''+row.idptinforme+'\',\''+row.idptevaluacion+'\',\''+row.idptservicio+'\',\''+row.descripcion_serv+'\',\''+row.nro_informe+'\');"class="btn btn-outline-success btn-sm hidden-xs hidden-sm"><i class="fas fa-plus-circle" style="cursor:pointer;"> Agregar Registro </i>  </a>'+
                    ' <a onClick="javascript:recuperaListregistro(\''+row.idptinforme+'\',\''+row.nro_informe+'\');"class="btn btn-outline-success btn-sm hidden-xs hidden-sm"><i class="fas fa-eye" style="cursor:pointer;"> Ver Registro </i>  </a>'+
                    '</div>'
              }
            }
        ]
    });
    // Enumeracion 
    otblListRegInforme.on( 'order.dt search.dt', function () { 
        otblListRegInforme.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
};


tramiteSid = function(idptinforme,ccliente,idptpropuesta,idptservicio,idpttramite){
    $('#frmCreaTram').trigger("reset");

    $('#mhdnIdinforme').val(idptinforme);
    $('#mhdnIdccliente').val(ccliente);
    $('#mcboTipotram').val(3);
    var params = { "ccliente":ccliente };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cpropuesta/getclientepropu",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcboClienprop').html(result);
            $('#mcboClienprop').val(ccliente).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    }); 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/ctramites/gettipotramite",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcboTipotramite').html(result);
            $('#mcboTipotramite').val(3).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error == Tipo de Tramite');
        }
    });
    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/getproputramsid",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
          $("#mcboNropropu").html(result); 
          $('#mcboNropropu').val(idptpropuesta).trigger("change"); 
        },
        error: function(){
          alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });
    $("#mcboClienprop").prop({disabled:true});  
    $("#mcboTipotramite").prop({disabled:true});  

    $('#mtxtFregtramite').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	
    fechaActualReg();

    if(idpttramite == 0){
        $('#mhdnAccionTram').val('N');
    }else{
        $('#mhdnAccionTram').val('A');
        gettramiteSid(idpttramite);
    }
    
}

gettramiteSid = function(idpttramite){  

    var parametros = { 
        "idpttramite":idpttramite 
    };
    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/gettramiteSid",
        dataType: "JSON",
        async: true,
        data: parametros,
        error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });      
    request.done(function( respuesta ) {   
        $.each(respuesta, function() {
            
            $('#mcboNropropu').val(this.idptpropuesta).trigger("change");
            $('#mtxtFtram').val(this.fecha_tramite);
            $('#mcboTipotramite').val(this.id_tipotramite);
            $('#mtxtCodigo').val(this.codigo);
            $('#mtxtNombprod').val(this.nombproducto);
            $('#mtxtDescrip').val(this.descripcion);
            $('#mcboRespon').val(this.idresponsable).trigger("change");
            $('#mtxtComentario').val(this.comentarios);
            $('#mtxtarchivo').val(this.adj_docum);
            $('#mtxtCarta').val(this.adj_carta);
            $('#mtxtRutaarch').val(this.ruta_docum);
            $('#mtxtRutacarta').val(this.ruta_carta);
            $('#mtxtNombarch').val(this.nomb_docum);
            $('#mtxtNombcarta').val(this.nomb_carta);            
            
        });
    });
}

escogerArchivoSID = function(){    
    var archivoInput = document.getElementById('mtxtArchivotram');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.pdf|.docx|.xlsx|.doc|.xls)$/i;
    
    var filename = $('#mtxtArchivotram').val().replace(/.*(\/|\\)/, '');
    $('#mtxtNombarch').val(filename);

    if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado un PDF, DOCX, XSLX');
        archivoInput.value = '';  
        $('#mtxtNombarch').val('');
        return false;
    }      
    $('#sArchivoSID').val('S');

    
};
subirArchivoSID=function(){
    var parametrotxt = new FormData($("#frmCreaTram")[0]);
    var request = $.ajax({
        data: parametrotxt,
        method: 'post',
        url: baseurl+"pt/cinforme/subirArchivoSID/",
        dataType: "JSON",
        async: true,
        contentType: false,
        processData: false,
        error: function(){
            alert('Error, no se cargó el archivo');
        }
    });
    request.done(function( respuesta ) {
        $('#btnBuscar').click(); 
        Vtitle = 'Se guardo el registro y adjunto correctamente!!';
        Vtype = 'success';
        sweetalert(Vtitle,Vtype);
        $('#mbtnCCreaTram').click();
    });
}; 
$('#frmCreaTram').submit(function(event){
    event.preventDefault();
    
    var request = $.ajax({
        url:$('#frmCreaTram').attr("action"),
        type:$('#frmCreaTram').attr("method"),
        data:$('#frmCreaTram').serialize(),
        error: function(){
            Vtitle = 'No se puede registrar por error';
            Vtype = 'error';
            sweetalert(Vtitle,Vtype);
        }
    });
    request.done(function( respuesta ) {
        var posts = JSON.parse(respuesta);        
        $.each(posts, function() {
            $('#mhdnIdTram').val(this.id_tramite);
            if($('#sArchivoSID').val() == 'S'){          
                subirArchivoSID();
            }else{      
                Vtitle = 'Se guardo el registro correctamente!!';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);        
                $('#mbtnCCreaTram').click();
                recuperaListinforme();
            }   
            $('#sArchivoSID').val('N');        
        });
    });
});

fechaActualReg = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#mtxtFregtramite').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

$("#mcboTipotram").change(function(){
    var v_Tipotram = $('#mcboTipotram').val();

    if (v_Tipotram == 1){
        $('#divProd').hide();
        $('#divDesc').hide();
        $('#divCarta').hide();
    }else if (v_Tipotram == 2){
        $('#divProd').hide();
        $('#divDesc').hide();
        $('#divCarta').hide();
    }else if (v_Tipotram == 3){
        $('#divProd').show();
        $('#divDesc').show();
        $('#divCarta').hide();
    }else if (v_Tipotram == 4){
        $('#divProd').hide();
        $('#divDesc').hide();
        $('#divCarta').show();
    }else{
        $('#divProd').hide();
        $('#divDesc').hide();
        $('#divCarta').hide();
    }
});

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

recuperaListregistro = function(Idinforme,nro_informe){
    document.querySelector('#lblInforme').innerText = nro_informe;
    
    otblListRegitro = $('#tblListRegitro').DataTable({
        'bJQueryUI'     : true, 
        'scrollY'     	: '200px',
        'scrollX'     	: true, 
        'paging'      	: false,
        'processing'  	: true,      
        'bDestroy'    	: true,
        'info'        	: true,
        'filter'      	: false, 
        'stateSave'     : true,
        "ordering"		: false, 
        'ajax'	: {
            "url"   : baseurl+"pt/cinforme/getlistregistro/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.idinforme  = Idinforme; 
                d.idptservicio  = $('#hdnidserv').val();
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'ESTUDIO', targets: 0},
            {"orderable": false, data: 'TIPO', targets: 1},
            {"orderable": false, data: 'DESC', targets: 2},
            {"orderable": false, 
              render:function(data, type, row){                
                  return  '<div>'+    
                    ' <a onClick="javascript:selRegistro(\''+row.idptregistro+'\',\''+row.idptinforme+'\',\''+row.idptregequipo+'\',\''+row.idptregproducto+'\',\''+row.idptservicio+'\',\''+row.descripcion_serv+'\',\''+row.idptregestudio+'\',\''+row.ESTUDIO+'\',\''+row.idptregrecinto+'\',\''+row.idptregprocestudio+'\');"><i class="fas fa-edit" style="color:#088A08; cursor:pointer;"> </i> </a>'+
                    ' <a onClick="javascript:dupRegistro(\''+row.idptregistro+'\',\''+row.idptregproducto+'\',\''+row.idptservicio+'\',\''+row.idptregestudio+'\');"><i class="fas fa-clone" style="color:#088A08; cursor:pointer;"> </i> </a>'+
                    ' <a id="delRegistro" href="'+row.idptregistro+'"  regest="'+row.idptregestudio+'" title="Eliminar" style="cursor:pointer; color:#F80606;"><span class="fas fa-trash-alt" aria-hidden="true"> </span></a>'+      
                  '</div>'
              }
            }
        ]
    }); 
};

$('#btnRetornarLista').click(function(){
    $('#btnBuscar').click();
    $('#tabinforme a[href="#tabinforme-list"]').tab('show');  
});

$("body").on("click","#delRegistro",function(event){
    event.preventDefault();
    idptregistro = $(this).attr("href");
    idptregestudio = $(this).attr("regest");

    Swal.fire({
        title: 'Confirmar Eliminación',
        text: "¿Está seguro de eliminar el Registro?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, bórralo!'
    }).then((result) => {
        if (result.value) {
            $.post(baseurl+"pt/cinforme/delregistro/", 
            {
                idptregistro   : idptregistro,
                idptregestudio   : idptregestudio,
            },      
            function(data){     
                otblListRegitro.ajax.reload(null,false); 
                Vtitle = 'Se Elimino Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);      
            });
        }
    }) 
});

// REGISTROS POR EVALUACION
insertRegistro= function(idptinforme,idptevaluacion,idptservicio,descripcion_serv,nro_informe){

    $('#tabinforme a[href="#tabinforme-reg"]').tab('show'); 

    $('#frmMantRegistro').trigger("reset");
    
    $('#txtRegEstudio').hide();
    $('#divRegEstudio').show();

    $('#01Registro').hide();
    $('#03Registro').hide();
    $('#06Registro').hide();
    $('#regEquipos06').hide();
    $('#08Registro').hide();
    $('#regEquipos08').hide();
    $('#09Registro').hide();
    $('#10Registro').hide();
    $('#11Registro').hide();
    $('#12Registro').hide();
    $('#13Registro').hide();
    $('#14Registro').hide();
    $('#15Registro').hide();

    $('#hdnAccionptreg').val('N');  
    $('#hdnIdreginfor').val(idptinforme);
    $('#hdnnroinforme').val(nro_informe);
    
    $('#hdnIdregservi').val(idptservicio);
    $('#txtregservi').val(descripcion_serv);
    
    $('#hdnIdregequipo').val();
    $('#hdnIdregproducto').val(); 
    $('#hdnIdregrecinto').val(); 
    $('#hdnIdregprocestudio').val(); 
        
    $('#btnNuevoReg').hide();
    $('#btnGrabarReg').show();
    
    var v_RegServi = $('#hdnIdregservi').val();
    var params = { 
        "cservicio":v_RegServi 
    };
    if(v_RegServi == 4){
        $('#hdnIdRegEstudio').val('6');
        $('#06Registro').show();
        $('#divEstudio').hide();        
        mostrarRegistro(6);
    }else if(v_RegServi == 3){
        $('#hdnIdRegEstudio').val('8');
        $('#08Registro').show();
        $('#divEstudio').hide();        
        mostrarRegistro(8);
    }else if(v_RegServi == 12){
        $('#hdnIdRegEstudio').val('14');
        $('#14Registro').show();
        $('#divEstudio').hide();        
        mostrarRegistro(14);
    }else if(v_RegServi == 6){
        $('#hdnIdRegEstudio').val('15');
        $('#15Registro').show();
        $('#divEstudio').hide();        
        mostrarRegistro(15);
    }else{
        $('#06Registro').hide();
        $('#08Registro').hide();
        $('#14Registro').hide();
        $('#divEstudio').show(); 
        $('#hdnIdRegEstudio').val('');

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEstudio",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
              $("#cboRegEstudio").html(result);  
            },
            error: function(){
              alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }
};

$("#cboRegEstudio").change(function(){
    var v_RegEstu = $('#cboRegEstudio').val();

    $('#btnGrabarReg').show();
    $('#hdnIdRegEstudio').val(v_RegEstu);

    mostrarRegistro(v_RegEstu);
}); 

mostrarRegistro = function(v_RegEstu){

    if(v_RegEstu == 1){

        $('#01Registro').show();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboTipoequipoReg01").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getMediocalen",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboMediocalientaReg01").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboFabricanteReg01").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboEnvaseReg01").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 3){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').show();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp').hide();
        $('#divphpf').hide();
        $('#divparticula').hide();
        $('#divliquido').hide();

        $('#cboDimenReg03').val('').trigger("change");
        $('#cbollevapartReg03').val('').trigger("change");

        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoproducto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoprodReg03").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboParticulasReg03").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getLiquidogob",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#txtLiqgobReg03").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboEnvaseReg03").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        var v_RegEstuEquipo = 2;
        var paramsEquipo = { 
            "idptregestudio":v_RegEstuEquipo 
        };
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: paramsEquipo,
            success:function(result)
            {
                $("#cboTipoequipoReg02").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getMediocalen",
            dataType: "JSON",
            async: true,
            data: paramsEquipo,
            success:function(result)
            {
                $("#cboMediocalientaReg02").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: paramsEquipo,
            success:function(result)
            {
                $("#cboFabricanteReg02").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 6){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').show();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp06').hide();
        $('#divphpf06').hide();
        $('#divparticula06').hide();

        $('#CreaReg04').hide();
        $('#CreaReg05').hide();
        
        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoproducto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
            $("#cboTipoprodReg06").html(result);  
            },
            error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
            $("#cboParticulasReg06").html(result);  
            },
            error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 8){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').show();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp08').hide();
        $('#divphpf08').hide();
        $('#divparticula08').hide();

        $('#CreaReg07').hide();

        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoproducto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboTipoprodReg08").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboParticulasReg08").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboEnvaseReg08").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 9){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').show();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divEvalrec').hide();

        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTiporecinto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTiporecintoReg09").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de tipo recinto');
            }
        });
    }else if(v_RegEstu == 10){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').show();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();


        var params = { 
            "idptregestudio":v_RegEstu 
        };
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFormaprodReg10").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de forma de producto');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboEnvaseReg10").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 11){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').show();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();


        var params = { 
            "idptregestudio":v_RegEstu 
        };
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFormaprodReg11").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de forma de producto');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboEnvaseReg11").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 12){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').show();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        
        var params = { 
            "idptregestudio":v_RegEstu 
        };


        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTiporecinto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboRecintoReg12").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de tipo recinto');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getMediocalen",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboMediocalReg12").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboPresentaReg12").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de forma de producto');
            }
        });
    }else if(v_RegEstu == 13){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').show();
        $('#14Registro').hide();
        $('#15Registro').hide();

                
        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoequipoReg13").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFabricanteReg13").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getMediocalen",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboMediocalReg13").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });         
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboPresentaReg13").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de forma de producto');
            }
        });
    }else if(v_RegEstu == 14){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').show();
        $('#15Registro').hide();


        $('#divphmp14').hide();
        $('#divphpf14').hide();
        $('#divparticula14').hide();
        $('#divliquido14').hide();

        $('#cboDimenReg14').val('').trigger("change");
        $('#cbollevapartReg14').val('').trigger("change");

        var params = { 
            "idptregestudio":v_RegEstu 
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoproducto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoprodReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getParticulas",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboParticulasReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getLiquidogob",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#txtLiqgobReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getEnvases",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboEnvaseReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboTipoequipoReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getMediocalen",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboMediocalientaReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboFabricanteReg14").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == 15){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').show();
    
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getServicioAudi",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $("#cboserviciosReg15").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }else if(v_RegEstu == ''){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();        
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();
    }
}

// EVENTO POR ESTUDIOS
/* Reg03 */
    $("#cboTipoprodReg03").change(function(){
        var v_Tipoprod = $('#cboTipoprodReg03').val();
        verDetTipoproducto03(v_Tipoprod);
    });
    verDetTipoproducto03=function(v_Tipoprod){
        
        if(v_Tipoprod != '2' && v_Tipoprod != ''){
            $('#divphmp').show();
            $('#divphpf').show();
        }else{
            $('#divphmp').hide();
            $('#divphpf').hide();
        }
    };

    $("#cbollevapartReg03").change(function(){
        var v_Llevapart = $('#cbollevapartReg03').val();
        verDetLlevaparticulas03(v_Llevapart);
    });
    verDetLlevaparticulas03=function(v_Llevapart){
        
        if(v_Llevapart == 'S'){
            $('#divparticula').show();
            $('#divliquido').show();
        }else{
            $('#divparticula').hide();
            $('#divliquido').hide();
        }
    };
/* fin Reg03 */

/* Reg06 */
    $("#cboTipoprodReg06").change(function(){
        var v_Tipoprod = $('#cboTipoprodReg06').val();
        verDetTipoproducto06(v_Tipoprod);
    });
    verDetTipoproducto06=function(v_Tipoprod){
        if(v_Tipoprod != '7' && v_Tipoprod != ''){
            $('#divphmp06').show();
            $('#divphpf06').show();
        }else{
            $('#divphmp06').hide();
            $('#divphpf06').hide();
        }
    };

    $("#cbollevapartReg06").change(function(){
        var v_Llevapart = $('#cbollevapartReg06').val();
        verDetLlevaparticulas06(v_Llevapart);
    });
    verDetLlevaparticulas06=function(v_Llevapart){
        
        if(v_Llevapart == 'S'){
            $('#divparticula06').show();
        }else{
            $('#divparticula06').hide();
        }
    };

    recuperaListReg06equipo = function(Idregprod){
        otblListReg06equipo = $('#tblListReg06equipo').DataTable({
            'bJQueryUI'     : true, 
            'scrollY'     	: '200px',
            'scrollX'     	: true, 
            'paging'      	: false,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: true,
            'filter'      	: false, 
            'stateSave'     : true,
            "ordering"		: false, 
            'ajax'	: {
                "url"   : baseurl+"pt/cinforme/getlistequipoxprod/",
                "type"  : "POST", 
                "data": function ( d ) {
                    d.Idregprod  = Idregprod; 
                },     
                dataSrc : ''        
            },
            'columns'	: [
                {"orderable": false, data: 'claseequipo', targets: 0},
                {"orderable": false, data: 'descripcion_equipo', targets: 1},
                {"orderable": false, data: 'tipoequipo', targets: 2},
                {"orderable": false, 
                render:function(data, type, row){                
                    return  '<div>'+    
                        ' <a title="Editar" onClick="javascript:selEquipoadj06(\''+row.idptregequipo+'\',\''+row.idptregistro+'\',\''+row.idptregproducto+'\',\''+row.tipo_estudio+'\',\''+row.descripcion_equipo+'\',\''+row.id_tipoequipo+'\',\''+row.id_equipofabricante+'\',\''+row.dimension+'\',\''+row.diametro+'\',\''+row.altura+'\',\''+row.grosor+'\',\''+row.volumen_llenado+'\',\''+row.modelo_equipo+'\',\''+row.identificacion+'\',\''+row.nro_equipos+'\');"><i class="fas fa-edit" style="color:#088A08; cursor:pointer;"> </i> </a>'+
                        ' <a title="Duplicar" onClick="javascript:dupliEquipoadj06(\''+row.idptregequipo+'\',\''+row.idptregistro+'\',\''+row.idptregproducto+'\',\''+row.tipo_estudio+'\');"><i class="fas fa-clone" style="color:#4C4CFC; cursor:pointer;"> </i> </a>'+
                        ' <a id="delEquipoadj06" href="'+row.idptregequipo+'" title="Eliminar" style="cursor:pointer; color:#F80606;"><span class="fas fa-trash-alt" aria-hidden="true"> </span></a>'+      
                    '</div>'
                }
                }
            ]
        }); 
        // Enumeracion 
        otblListRegitro.on( 'order.dt search.dt', function () { 
            otblListRegitro.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw(); 
    };

    selEquipoadj06= function(idptregequipo,idptregistro,idptregproducto,tipo_estudio,descripcion_equipo,id_tipoequipo,id_equipofabricante,dimension,diametro,altura,grosor,volumen_llenado,modelo_equipo,identificacion,nro_equipos){
        
        if(tipo_estudio == 'T'){
            $('#CreaReg04').show();
            $('#CreaReg05').hide();  
            
            $('#mhdnIdptreg04').val(idptregistro);
            $('#mhdnIdptregprod04').val(idptregproducto);
            $('#mhdnIdptregequipo04').val(idptregequipo);
            $('#txtDescriequipoReg04').val(descripcion_equipo);
            
            var v_RegEstu = 4;
            var params = { 
                "idptregestudio":v_RegEstu 
            };
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/getTipoequipo",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $("#cboTipoequipoReg04").html(result); 
                    $('#cboTipoequipoReg04').val(id_tipoequipo).trigger("change"); 
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/getFabricante",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $("#cboFabricanteReg04").html(result);
                    $('#cboFabricanteReg04').val(id_equipofabricante).trigger("change");   
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });
            
            $('#mhdnRegAdjunto').val('4');
            $('#mhdnAccionReg04').val('A');

        }else if(tipo_estudio == 'L'){
            $('#CreaReg04').hide();
            $('#CreaReg05').show(); 
            
            $('#mhdnIdptreg05').val(idptregistro);
            $('#mhdnIdptregprod05').val(idptregproducto);
            $('#mhdnIdptregequipo05').val(idptregequipo);
            $('#txtDescriequipoReg05').val(descripcion_equipo);
            
            var v_RegEstu = 5;
            var params = { 
                "idptregestudio":v_RegEstu 
            };
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/getTipoequipo",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $("#cboTipoequipoReg05").html(result); 
                    $('#cboTipoequipoReg05').val(id_tipoequipo).trigger("change"); 
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/getFabricante",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $("#cboFabricanteReg05").html(result);
                    $('#cboFabricanteReg05').val(id_equipofabricante).trigger("change");   
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });

            $('#txtModellenaReg05').val(modelo_equipo);
            $('#txtIdllenaReg05').val(identificacion);
            $('#txtNrollenaReg05').val(nro_equipos);
            $('#txtVolullenaReg05').val(volumen_llenado);
            $('#cboDimenReg05').val(dimension).trigger("change");  
            $('#txtDiamReg05').val(diametro);
            $('#txtAltuReg05').val(altura);
            $('#txtGrosReg05').val(grosor);
            
            $('#mhdnRegAdjunto').val('5');
            $('#mhdnAccionReg05').val('A');

        }
    };

    dupliEquipoadj06= function(idptregequipo,idptregistro,idptregproducto,tipo_estudio){
        
        var params = { 
            "idptregequipo"     : idptregequipo,
            "idptregistro"      : idptregistro, 
            "idptregproducto"   : idptregproducto, 
        };

        if(tipo_estudio == 'T'){
    
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/cloneregistro04",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    otblListReg06equipo.ajax.reload(null,false);
                    Vtitle = 'Se guardo Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });
        }else if(tipo_estudio == 'L'){
    
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/cloneregistro05",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    otblListReg06equipo.ajax.reload(null,false);
                    Vtitle = 'Se guardo Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);
                },
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });

        }
    };

    $("body").on("click","#delEquipoadj06",function(event){
        event.preventDefault();
        idptregequipo = $(this).attr("href");

        Swal.fire({
            title: 'Confirmar Eliminación',
            text: "¿Está seguro de eliminar el Equipo?",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, bórralo!'
        }).then((result) => {
            if (result.value) {
                $.post(baseurl+"pt/cinforme/delregistrodet06/", 
                {
                    idptregequipo   : idptregequipo,
                },      
                function(data){     
                    otblListReg06equipo.ajax.reload(null,false); 
                    Vtitle = 'Se Elimino Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);      
                });
            }
        }) 
    });
    
    $('#Buscaequipo06').click(function(){
        $('#modalBuscaequipoReg06').modal('show');
    });

    $('#addequipo06').click(function(){  
        $('#CreaReg04').show();
        $('#CreaReg05').hide();  

        $('#frmCreaReg04').trigger("reset");

        $('#mhdnIdptreg04').val($('#hdnIdptreg').val());
        $('#mhdnIdptregprod04').val($('#hdnIdregproducto').val());
        $('#mhdnIdptregequipo04').val();
        $('#txtDescriequipoReg04').val('');
        $('#mhdnRegAdjunto').val('4');
        
        $('#mhdnAccionReg04').val('N');
        var v_RegEstu = 4;
        var params = { 
            "idptregestudio":v_RegEstu 
        };
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoequipoReg04").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFabricanteReg04").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });

    $('#addllenadora06').click(function(){ 
        $('#CreaReg04').hide();
        $('#CreaReg05').show(); 

        $('#frmCreaReg05').trigger("reset");  

        $('#mhdnIdptreg05').val($('#hdnIdptreg').val());
        $('#mhdnIdptregprod05').val($('#hdnIdregproducto').val());
        $('#mhdnIdptregequipo05').val();
        $('#mhdnRegAdjunto').val('5');
        
        $('#mhdnAccionReg05').val('N');

        var v_RegEstu = 5;
        var params = { 
            "idptregestudio":v_RegEstu 
        };
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoequipoReg05").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFabricanteReg05").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });

    $('#btnCancelarReg04').click(function(){
        $('#CreaReg04').hide();
    });

    $('#btnCancelarReg05').click(function(){
        $('#CreaReg05').hide();
    });

    $('#btnGrabarReg04').click(function(){

        var params = { 
            "mhdnRegAdjunto"        : $('#mhdnRegAdjunto').val(),
            "idptregequipo"         : $('#mhdnIdptregequipo04').val(), 
            "idptregistro"          : $('#mhdnIdptreg04').val(), 
            "idptregproducto"       : $('#mhdnIdptregprod04').val(), 
            "clase_registro"        : 'T', 
            "descripcion_equipo"    : $('#txtDescriequipoReg04').val(), 
            "id_tipoequipo"         : $('#cboTipoequipoReg04').val(), 
            "id_equipofabricante"   : $('#cboFabricanteReg04').val(),
            "identificacion"        : $('#txtIdlineaReg04').val(),  
            "cserviaccionio"        : $('#mhdnAccionReg04').val(),
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/setregistroAdjunto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                otblListReg06equipo.ajax.reload(null,false);
                Vtitle = 'Se guardo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });

    $('#btnGrabarReg05').click(function(){

        var params = { 
            "mhdnRegAdjunto"        : $('#mhdnRegAdjunto').val(),
            "idptregequipo"         : $('#mhdnIdptregequipo05').val(), 
            "idptregistro"          : $('#mhdnIdptreg05').val(), 
            "idptregproducto"       : $('#mhdnIdptregprod05').val(), 
            "clase_registro"        : 'L', 
            "descripcion_equipo"    : $('#txtDescriequipoReg05').val(), 
            "id_tipoequipo"         : $('#cboTipoequipoReg05').val(),  
            "id_equipofabricante"   : $('#cboFabricanteReg05').val(), 
            "modelo_equipo"         : $('#txtModellenaReg05').val(),  
            "identificacion"        : $('#txtIdllenaReg05').val(), 
            "nro_equipos"           : $('#txtNrollenaReg05').val(), 
            "volumen_llenado"       : $('#txtVolullenaReg05').val(), 
            "dimension"             : $('#cboDimenReg05').val(), 
            "diametro"              : $('#txtDiamReg05').val(), 
            "altura"                : $('#txtAltuReg05').val(), 
            "grosor"                : $('#txtGrosReg05').val(), 
            "cserviaccionio"        : $('#mhdnAccionReg05').val(),
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/setregistroAdjunto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {            
                otblListReg06equipo.ajax.reload(null,false);
                Vtitle = 'Se guardo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);
            },
            error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });
/* fin Reg06 */

/* Reg08 */
    $("#cboTipoprodReg08").change(function(){
        var v_Tipoprod = $('#cboTipoprodReg08').val();
        verDetTipoproducto08(v_Tipoprod);
    });
    verDetTipoproducto08=function(v_Tipoprod){
        
        if(v_Tipoprod != '2' && v_Tipoprod != ''){
            $('#divphmp08').show();
            $('#divphpf08').show();
        }else{
            $('#divphmp08').hide();
            $('#divphpf08').hide();
        }
    };

    $("#cbollevapartReg08").change(function(){
        var v_Llevapart = $('#cbollevapartReg08').val();
        verDetLlevaparticulas08(v_Llevapart);
    });
    verDetLlevaparticulas08=function(v_Llevapart){
        
        if(v_Llevapart == 'S'){
            $('#divparticula08').show();
        }else{
            $('#divparticula08').hide();
        }
    };

    recuperaListReg08equipo = function(Idregprod){
        otblListReg08equipo = $('#tblListReg08equipo').DataTable({
            'bJQueryUI'     : true, 
            'scrollY'     	: '200px',
            'scrollX'     	: true, 
            'paging'      	: false,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: true,
            'filter'      	: false, 
            'stateSave'     : true,
            "ordering"		: false, 
            'ajax'	: {
                "url"   : baseurl+"pt/cinforme/getlistequipoxprod/",
                "type"  : "POST", 
                "data": function ( d ) {
                    d.Idregprod  = Idregprod; 
                },     
                dataSrc : ''        
            },
            'columns'	: [
                {"orderable": false, data: 'claseequipo', targets: 0},
                {"orderable": false, data: 'descripcion_equipo', targets: 1},
                {"orderable": false, data: 'tipoequipo', targets: 2},
                {"orderable": false, 
                render:function(data, type, row){                
                    return  '<div>'+    
                    ' <a onClick="javascript:selEquipoadj08(\''+row.idptregequipo+'\',\''+row.idptregistro+'\',\''+row.idptregproducto+'\',\''+row.tipo_estudio+'\',\''+row.descripcion_equipo+'\',\''+row.id_tipoequipo+'\',\''+row.id_equipofabricante+'\');"><i class="fas fa-edit" style="color:#088A08; cursor:pointer;"> </i> </a>'+
                    '</div>'
                }
                }
            ]
        }); 
        // Enumeracion 
        otblListRegitro.on( 'order.dt search.dt', function () { 
            otblListRegitro.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw(); 
    };

    selEquipoadj08= function(idptregequipo,idptregistro,idptregproducto,tipo_estudio,descripcion_equipo,id_tipoequipo,id_equipofabricante){

        $('#CreaReg07').show();
        
        $('#mhdnIdptreg07').val(idptregistro);
        $('#mhdnIdptregprod07').val(idptregproducto);
        $('#mhdnIdptregequipo07').val(idptregequipo);
        $('#txtDescriequipoReg07').val(descripcion_equipo);
        
        var v_RegEstu = 7;
        var params = { 
            "idptregestudio":v_RegEstu 
        };
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoequipoReg07").html(result); 
                $('#cboTipoequipoReg07').val(id_tipoequipo).trigger("change"); 
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFabricanteReg07").html(result);
                $('#cboFabricanteReg07').val(id_equipofabricante).trigger("change");   
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        
        $('#mhdnRegAdjunto').val('7');
        $('#mhdnAccionReg07').val('A');
    }

    $('#Buscaequipo08').click(function(){
        $('#modalBuscaequipoReg08').modal('show');
    });

    $('#addequipo08').click(function(){  
        $('#CreaReg07').show();  

        $('#frmCreaReg07').trigger("reset");

        $('#mhdnIdptreg07').val($('#hdnIdptreg').val());
        $('#mhdnIdptregprod07').val($('#hdnIdregproducto').val());
        $('#mhdnIdptregequipo07').val();
        $('#txtDescriequipoReg07').val('');
        $('#mhdnRegAdjunto').val('7');
        
        $('#mhdnAccionReg07').val('N');
        var v_RegEstu = 7;
        var params = { 
            "idptregestudio":v_RegEstu 
        };
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getTipoequipo",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboTipoequipoReg07").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getFabricante",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $("#cboFabricanteReg07").html(result);  
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });

    $('#btnCancelarReg07').click(function(){
        $('#CreaReg07').hide();
    });

    $('#btnGrabarReg07').click(function(){

        var params = { 
            "mhdnRegAdjunto"        : $('#mhdnRegAdjunto').val(),
            "idptregequipo"         : $('#mhdnIdptregequipo07').val(), 
            "idptregistro"          : $('#mhdnIdptreg07').val(), 
            "idptregproducto"       : $('#mhdnIdptregprod07').val(), 
            "clase_registro"        : 'T', 
            "descripcion_equipo"    : $('#txtDescriequipoReg07').val(), 
            "id_tipoequipo"         : $('#cboTipoequipoReg07').val(), 
            "id_equipofabricante"   : $('#cboFabricanteReg07').val(), 
            "cserviaccionio"        : $('#mhdnAccionReg07').val(),
        };

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/setregistroAdjunto",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                otblListReg08equipo.ajax.reload(null,false);
                Vtitle = 'Se guardo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    });
/* fin Reg08 */

/* Reg09 */
    $("#cboTiporecintoReg09").change(function(){
        var v_Tiporeci = $('#cboTiporecintoReg09').val();
        verDetTiporecinto09(v_Tiporeci);
    });
    verDetTiporecinto09=function(v_Tiporeci){
        if(v_Tiporeci != '1' && v_Tiporeci != ''){
            $('#divEvalrec').hide();
        }else{
            $('#divEvalrec').show();
        }
    };
/* fin Reg09 */

/* Reg14 */
    $("#cboTipoprodReg14").change(function(){
        var v_Tipoprod = $('#cboTipoprodReg14').val();
        verDetTipoproducto14(v_Tipoprod);
    });
    verDetTipoproducto14=function(v_Tipoprod){
        if(v_Tipoprod != '12' && v_Tipoprod != ''){
            $('#divphmp14').show();
            $('#divphpf14').show();
        }else{
            $('#divphmp14').hide();
            $('#divphpf14').hide();
        }
    };

    $("#cbollevapartReg14").change(function(){
        var v_Llevapart = $('#cbollevapartReg14').val();
        verDetLlevaparticulas(v_Llevapart);
    });
    verDetLlevaparticulas=function(v_Llevapart){
        
        if(v_Llevapart == 'S'){
            $('#divparticula14').show();
            $('#divliquido14').show();
        }else{
            $('#divparticula14').hide();
            $('#divliquido14').hide();
        }
    };
/* fin Reg14 */

$('#frmMantRegistro').submit(function(event){
    event.preventDefault();
    
    var request = $.ajax({
        url:$('#frmMantRegistro').attr("action"),
        type:$('#frmMantRegistro').attr("method"),
        data:$('#frmMantRegistro').serialize(),
        error: function(){
          alert('Error, No se puede autenticar por error');
        }
    });
    request.done(function( respuesta ) { 
        var posts = JSON.parse(respuesta);           
        $.each(posts, function() { 
            var $idregistro = this.id_registro;
            $('#hdnIdptreg').val($idregistro); 
            
            $('#btnNuevoReg').show();
            $('#btnGrabarReg').hide();   

            Vtitle = 'Se Grabo Correctamente';
            Vtype = 'success';
            sweetalert(Vtitle,Vtype);

            var v_tipoestu = $('#hdnIdRegEstudio').val();
            if (v_tipoestu == 6){
                $('#regEquipos06').show();

                var $idregistroproducto = this.id_regproducto;
                $('#hdnIdregproducto').val($idregistroproducto);
                recuperaListReg06equipo($idregistroproducto);
            }else if (v_tipoestu == 8){
                $('#regEquipos08').show();

                var $idregistroproducto = this.id_regproducto;
                $('#hdnIdregproducto').val($idregistroproducto);
                recuperaListReg08equipo($idregistroproducto);
            }
            
            $('#hdnIdregequipo').val();
            $('#hdnIdregproducto').val(); 
            $('#hdnIdregrecinto').val();
            $('#hdnIdregprocestudio').val();
            //otblListRegitro.ajax.reload(null,false);  
        });
    });
});

selRegistro= function(idptregistro,idptinforme,idptregequipo,idptregproducto,idptservicio,descripcion_serv,idptregestudio,descripcion_estudio,idptregrecinto,idptregprocestudio){
    
    $('#tabinforme a[href="#tabinforme-reg"]').tab('show'); 
    $('#hdnIdptreg').val(idptregistro);  
    $('#hdnAccionptreg').val('A');  
    $('#hdnIdreginfor').val(idptinforme);
    $('#hdnIdregequipo').val(idptregequipo);
    $('#hdnIdregproducto').val(idptregproducto); 
    $('#hdnIdregrecinto').val(idptregrecinto); 
    $('#hdnIdregprocestudio').val(idptregprocestudio);  
    
    $('#hdnIdregservi').val(idptservicio);
    $('#txtregservi').val(descripcion_serv);

    $('#txtRegEstudio').show();
    $('#divRegEstudio').hide();
    $('#btnGrabarReg').show();
  
    $('#txtRegEstudio').val(descripcion_estudio);
    $('#hdnIdRegEstudio').val(idptregestudio);

    if(idptregestudio == 6){
        $('#regEquipos06').show();
    }
    if(idptregestudio == 8){
        $('#regEquipos08').show();
    }
    
    
    recuperaRegistro(idptregestudio,idptregequipo,idptregproducto,idptregrecinto,idptregprocestudio);
};

dupRegistro = function(idptregistro,idptregproducto,idptservicio,idptregestudio){
    if(idptregestudio == '6'){
        var params = { 
            "idptregproducto"     : idptregproducto,
            "idptregistro"      : idptregistro, 
        };
    
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/cloneregistro06",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                otblListRegitro.ajax.reload(null,false);
                Vtitle = 'Se duplico Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);
            },
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });
    }
    
};

recuperaRegistro = function(v_RegEstu,idptregequipo,idptregproducto,idptregrecinto,idptregprocestudio){
    
    if(v_RegEstu == 1){
        
        $('#01Registro').show();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var parametros = { 
            "idptregequipo":idptregequipo 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregequi",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {   
            $.each(respuesta, function() {
                var $idtipoequipo = this.id_tipoequipo;
                var $idmediocalienta = this.id_mediocalienta;
                var $idequipofabricante = this.id_equipofabricante;
                var $idenvase = this.id_envase;
                
                $('#txtDescriequipoReg01').val(this.descripcion_equipo);
                $('#txtNroequipoReg01').val(this.nro_equipos);
                $('#txtNracanastReg01').val(this.nro_canastillas);
                $('#txtIdenequipoReg01').val(this.identificacion);

                $('#txtDiamReg01').val(this.diametro);
                $('#txtAltuReg01').val(this.altura);
                $('#txtGrosReg01').val(this.grosor);
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoequipo",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        console.log($idtipoequipo);
                        $("#cboTipoequipoReg01").html(result);  
                        $('#cboTipoequipoReg01').val($idtipoequipo).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getMediocalen",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboMediocalientaReg01").html(result);  
                        $('#cboMediocalientaReg01').val($idmediocalienta).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getFabricante",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboFabricanteReg01").html(result);  
                        $('#cboFabricanteReg01').val($idequipofabricante).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboEnvaseReg01").html(result);  
                        $('#cboEnvaseReg01').val($idenvase).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
            });
        });

    }else if(v_RegEstu == 3){   
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').show();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp').hide();
        $('#divphpf').hide();
        $('#divparticula').hide();
        $('#divliquido').hide();    
        
        var parametros = { 
            "idptregproducto":idptregproducto 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregproducequi",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {  
                var $idtipoproducto = this.id_tipoproducto;
                var $idsiparticula = this.id_siparticula;
                var $idsiparticulaliquido = this.id_siparticula_liquido;
                var $idenvase = this.id_envase;
                var $idtipoequipo = this.id_tipoequipo;
                var $idmediocalienta = this.id_mediocalienta;
                var $idequipofabricante = this.id_equipofabricante;

                $('#txtNombprodReg03').val(this.nombre_producto);                
                $('#txtPHmatprimaReg03').val(this.ph_materia_prima);
                $('#txtPHprodfinReg03').val(this.ph_producto_final);
                $('#txtProcalReg03').val(this.nroprocal);
                $('#txtDiamReg03').val(this.diametro);
                $('#txtAltuReg03').val(this.altura);
                $('#txtGrosReg03').val(this.grosor);
                $('#txtDescriequipoReg02').val(this.descripcion_equipo);
                $('#txtIdenequipoReg02').val(this.identificacion);                

                $('#cbollevapartReg03').val(this.particulas).trigger("change");  
                $('#cboDimenReg03').val(this.dimension).trigger("change");

                var params = { 
                    "idptregestudio":v_RegEstu 
                };

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoproducto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboTipoprodReg03").html(result);  
                        $('#cboTipoprodReg03').val($idtipoproducto).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboParticulasReg03").html(result);
                        $('#cboParticulasReg03').val($idsiparticula).trigger("change");  
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getLiquidogob",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#txtLiqgobReg03").html(result);  
                        $('#txtLiqgobReg03').val($idsiparticulaliquido).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboEnvaseReg03").html(result);  
                        $('#cboEnvaseReg03').val($idenvase).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });

                var v_RegEstuEquipo = 2;
                var paramsEquipo = { 
                    "idptregestudio":v_RegEstuEquipo 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoequipo",
                    dataType: "JSON",
                    async: true,
                    data: paramsEquipo,
                    success:function(result){
                        $("#cboTipoequipoReg02").html(result);  
                        $('#cboTipoequipoReg02').val($idtipoequipo);
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getMediocalen",
                    dataType: "JSON",
                    async: true,
                    data: paramsEquipo,
                    success:function(result){
                        $("#cboMediocalientaReg02").html(result);
                        $('#cboMediocalientaReg02').val($idmediocalienta);  
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getFabricante",
                    dataType: "JSON",
                    async: true,
                    data: paramsEquipo,
                    success:function(result){
                        $("#cboFabricanteReg02").html(result);
                        $('#cboFabricanteReg02').val($idequipofabricante);  
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
            });
        });
        //recuperaListReg03equipo(idptregproducto);
    }else if(v_RegEstu == 6){

        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').show();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp06').hide();
        $('#divphpf06').hide();
        $('#divparticula06').hide();

        $('#CreaReg04').hide();
        $('#CreaReg05').hide();

        var parametros = { 
            "idptregproducto":idptregproducto 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtipoproducto = this.id_tipoproducto;  
                var $idsiparticula = this.id_siparticula;  

                $('#txtNombprodReg06').val(this.nombre_producto);
                $('#txtPHmatprimaReg06').val(this.ph_materia_prima);
                $('#txtPHprodfinReg06').val(this.ph_producto_final);

                $('#cbollevapartReg06').val(this.particulas).trigger("change");
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
        
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoproducto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboTipoprodReg06").html(result);
                        $('#cboTipoprodReg06').val($idtipoproducto).trigger("change");  
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboParticulasReg06").html(result); 
                        $('#cboParticulasReg06').val($idsiparticula).trigger("change"); 
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                })
            });
        });
        recuperaListReg06equipo(idptregproducto);
    }else if(v_RegEstu == 8){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').show();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        $('#divphmp08').hide();
        $('#divphpf08').hide();
        $('#divparticula08').hide();
        
        $('#CreaReg07').hide();

        var parametros = { 
            "idptregproducto":idptregproducto 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtipoproducto = this.id_tipoproducto;  
                var $idsiparticula = this.id_siparticula; 
                var $idenvase = this.id_envase; 

                $('#txtNombprodReg08').val(this.nombre_producto);
                $('#txtPHmatprimaReg08').val(this.ph_materia_prima);
                $('#txtPHprodfinReg08').val(this.ph_producto_final);
                $('#txtDiamReg08').val(this.diametro);
                $('#txtAltuReg08').val(this.altura);
                $('#txtGrosReg08').val(this.grosor);

                $('#cbollevapartReg08').val(this.particulas).trigger("change");
                $('#cboDimenReg08').val(this.dimension).trigger("change");
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoproducto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboTipoprodReg08").html(result); 
                        $('#cboTipoprodReg08').val($idtipoproducto).trigger("change"); 
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboParticulasReg08").html(result);
                        $('#cboParticulasReg08').val($idsiparticula).trigger("change");   
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboEnvaseReg08").html(result);  
                        $('#cboEnvaseReg08').val($idenvase).trigger("change");   
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
            });
        });
        recuperaListReg08equipo(idptregproducto);
    }else if(v_RegEstu == 9){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').show();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var parametros = { 
            "idptregrecinto":idptregrecinto 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregrecinto",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtiporecinto = this.id_tiporecinto;

                $('#txtnrorecintosReg09').val(this.nro_recintos);
                $('#txtareaevalReg09').val(this.area_evaluada);
                $('#txtNroposReg09').val(this.nro_posiciones);
                $('#txtNrovolalmaReg09').val(this.vol_almacen);
                
                $('#cboevaluacionReg09').val(this.eval_recinto).trigger("change");
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTiporecinto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboTiporecintoReg09").html(result);
                        $('#cboTiporecintoReg09').val($idtiporecinto).trigger("change");   
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });                
            });
        });
    }else if(v_RegEstu == 10){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').show();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var parametros = { 
            "idptregequipo":idptregequipo 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregequiproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idsiparticula = this.id_siparticula; 
                var $idenvase = this.id_envase; 

                $('#txtnrorecintosReg10').val(this.nro_equipos);
                $('#txtareaevalReg10').val(this.area_evaluada);
                $('#txtNroposReg10').val(this.nro_posiciones);
                $('#txtNrovolalmaReg10').val(this.vol_almacen);
                $('#txtNombprodReg10').val(this.nombre_producto);                
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboFormaprodReg10").html(result);  
                        $('#cboFormaprodReg10').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de forma de producto');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboEnvaseReg10").html(result);  
                        $('#cboEnvaseReg10').val($idenvase).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de envases');
                    }
                });
            });
        });
    }else if(v_RegEstu == 11){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').show();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();
        

        var parametros = { 
            "idptregprocestudio":idptregprocestudio 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregestuproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $tipo_equirecinto = this.tipo_equirecinto;
                var $idsiparticula = this.id_siparticula; 
                var $idenvase = this.id_envase; 

                $('#txtIdenequipoReg11').val(this.identificacion);
                $('#txtNombprodReg11').val(this.nombre_producto);

                $('#cboRecintoReg11').val($tipo_equirecinto).trigger("change");                
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboFormaprodReg11").html(result);  
                        $('#cboFormaprodReg11').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de forma de producto');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboEnvaseReg11").html(result);  
                        $('#cboEnvaseReg11').val($idenvase).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de envases');
                    }
                });
            });
        });
    }else if(v_RegEstu == 12){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').show();
        $('#13Registro').hide();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var parametros = { 
            "idptregrecinto":idptregrecinto 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregrecintoproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtiporecinto = this.id_tiporecinto;
                var $idmediocalienta = this.id_mediocalienta; 
                var $idsiparticula = this.id_siparticula; 

                $('#txtnrorecintosReg12').val(this.nro_recintos);
                $('#txtareaevalReg12').val(this.area_evaluada);
                $('#txtnrocochesReg12').val(this.nro_coches);
                $('#txtIdenrecintoReg12').val(this.identificacion);
                $('#txtnombproductoReg12').val(this.nombre_producto);
                
                $('#cboevaluacionReg12').val(this.eval_recinto).trigger("change");
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTiporecinto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboRecintoReg12").html(result);
                        $('#cboRecintoReg12').val($idtiporecinto).trigger("change");   
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de Tipo Recinto');
                    }
                });                
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getMediocalen",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboMediocalReg12").html(result);  
                        $('#cboMediocalReg12').val($idmediocalienta).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de Medio Calentamiento');
                    }
                });      
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboPresentaReg12").html(result);  
                        $('#cboPresentaReg12').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de Presentacion');
                    }
                });              
            });
        });

    }else if(v_RegEstu == 13){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').show();
        $('#14Registro').hide();
        $('#15Registro').hide();

        var parametros = { 
            "idptregequipo":idptregequipo 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregequiproduc",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtipoequipo = this.id_tipoequipo; 
                var $idequipofabricante = this.id_equipofabricante; 
                var $idmediocalienta = this.id_mediocalienta; 
                var $idsiparticula = this.id_siparticula; 

                $('#txtCapacidadReg13').val(this.capacidad);
                $('#txtnrorecintosReg13').val(this.nro_equipos);
                $('#txtnrocochesReg13').val(this.nro_canastillas);
                $('#txtIdenequipoReg13').val(this.identificacion);
                $('#txtnombproductReg13').val(this.nombre_producto);                
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoequipo",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        console.log($idtipoequipo);
                        $("#cboTipoequipoReg13").html(result);  
                        $('#cboTipoequipoReg13').val($idtipoequipo).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getFabricante",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboFabricanteReg13").html(result);  
                        $('#cboFabricanteReg13').val($idequipofabricante).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboFormaprodReg10").html(result);  
                        $('#cboFormaprodReg10').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de forma de producto');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getMediocalen",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboMediocalReg13").html(result);  
                        $('#cboMediocalReg13').val($idmediocalienta).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboPresentaReg13").html(result);  
                        $('#cboPresentaReg13').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de Presentacion');
                    }
                }); 
            });
        });

    }else if(v_RegEstu == 14){
        $('#01Registro').hide();
        $('#02Registro').hide();
        $('#03Registro').hide();
        $('#04Registro').hide();
        $('#05Registro').hide();
        $('#06Registro').hide();
        $('#07Registro').hide();
        $('#08Registro').hide();
        $('#09Registro').hide();
        $('#10Registro').hide();
        $('#11Registro').hide();
        $('#12Registro').hide();
        $('#13Registro').hide();
        $('#14Registro').show();
        $('#15Registro').hide();
        

        var parametros = { 
            "idptregprocestudio":idptregprocestudio 
        };
        var request = $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"pt/cinforme/getrecuperaregestuproducequi",
            dataType: "JSON",
            async: true,
            data: parametros,
            error: function(){
                alert('Error, no se puede cargar la lista desplegable de establecimiento');
            }
        });      
        request.done(function( respuesta ) {            
            $.each(respuesta, function() {
                var $idtipoproducto = this.id_tipoproducto;
                var $idsiparticula = this.id_siparticula; 
                var $idsiparticulaliquido = this.id_siparticula_liquido; 
                var $idenvase = this.id_envase; 
                var $idtipoequipo = this.id_tipoequipo; 
                var $idmediocalienta = this.id_mediocalienta; 
                var $idequipofabricante = this.id_equipofabricante;

                $('#txtDescriocurridoReg14').val(this.descripcion_estudio);
                $('#txtComentocurridoReg14').val(this.comentarios);
                $('#txtNombprodReg14').val(this.nombre_producto);
                $('#txtLotesReg14').val(this.lotes);
                $('#txtPHmatprimaReg14').val(this.ph_materia_prima);
                $('#txtPHprodfinReg14').val(this.ph_producto_final);
                $('#txtDiamReg14').val(this.diametrop);
                $('#txtAltuReg14').val(this.alturap);
                $('#txtGrosReg14').val(this.grosorp);
                $('#txtDevcalReg14').val(this.nroprocal);
                $('#txtDescriequipoReg14').val(this.descripcion_equipo);
                $('#txtIdenequipoReg14').val(this.identificacion);

                
                var $tipo_conclusion = this.tipo_conclusion;
                var $particulas = this.particulas;
                var $dimension = this.dimensionp;

                $('#cboTipoconcluReg14').val($tipo_conclusion).trigger("change"); 
                $('#cbollevapartReg14').val($particulas).trigger("change");
                $('#cboDimenReg14').val($dimension).trigger("change");
                
                var params = { 
                    "idptregestudio":v_RegEstu 
                };

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoproducto",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboTipoprodReg14").html(result);  
                        $('#cboTipoprodReg14').val($idtipoproducto).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getParticulas",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboParticulasReg14").html(result);  
                        $('#cboParticulasReg14').val($idsiparticula).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de forma de producto');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getLiquidogob",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#txtLiqgobReg14").html(result);  
                        $('#txtLiqgobReg14').val($idsiparticulaliquido).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getEnvases",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result)
                    {
                        $("#cboEnvaseReg14").html(result);  
                        $('#cboEnvaseReg14').val($idenvase).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de envases');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getTipoequipo",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        console.log($idtipoequipo);
                        $("#cboTipoequipoReg14").html(result);  
                        $('#cboTipoequipoReg14').val($idtipoequipo).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getMediocalen",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboMediocalientaReg14").html(result);  
                        $('#cboMediocalientaReg14').val($idmediocalienta).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: baseurl+"pt/cinforme/getFabricante",
                    dataType: "JSON",
                    async: true,
                    data: params,
                    success:function(result){
                        $("#cboFabricanteReg14").html(result);  
                        $('#cboFabricanteReg14').val($idequipofabricante).trigger("change");
                    },
                    error: function(){
                        alert('Error, no se puede cargar la lista desplegable de establecimiento');
                    }
                });
            });
        });

    }else if(v_RegEstu == 15){
            $('#01Registro').hide();
            $('#02Registro').hide();
            $('#03Registro').hide();
            $('#04Registro').hide();
            $('#05Registro').hide();
            $('#06Registro').hide();
            $('#07Registro').hide();
            $('#08Registro').hide();
            $('#09Registro').hide();
            $('#10Registro').hide();
            $('#11Registro').hide();
            $('#12Registro').hide();
            $('#13Registro').hide();
            $('#14Registro').hide();
            $('#15Registro').show();

            var parametros = { 
                "idptregprocestudio":idptregprocestudio 
            };
            var request = $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"pt/cinforme/getrecuperaregestu",
                dataType: "JSON",
                async: true,
                data: parametros,
                error: function(){
                    alert('Error, no se puede cargar la lista desplegable de establecimiento');
                }
            });      
            request.done(function( respuesta ) {            
                $.each(respuesta, function() {
                    var $idservicio = this.idservicio;
    
                    $('#txtEquiposReg15').val(this.descripcion_equipo);
                    $('#txtProdLineaReg15').val(this.nombre_producto);
                    
                    var params = { 
                        "idptregestudio":v_RegEstu 
                    };
                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: baseurl+"pt/cinforme/getServicioAudi",
                        dataType: "JSON",
                        async: true,
                        data: params,
                        success:function(result){
                            $("#cboserviciosReg15").html(result);
                            $('#cboserviciosReg15').val($idservicio).trigger("change");   
                        },
                        error: function(){
                            alert('Error, no se puede cargar la lista desplegable de establecimiento');
                        }
                    });
                });
            });
    }
}

$('#btnNuevoReg').click(function(){   
    var v_idptservicio = $('#hdnIdregservi').val(); 
    var v_idptinforme = $('#hdnIdreginfor').val();    
    var v_descripcion_serv = $('#txtregservi').val();

    $('#frmMantRegistro').trigger("reset");

    var params = { 
        "cservicio":v_idptservicio 
    };

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/getEstudio",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
          $("#cboRegEstudio").html(result);  
          $('#cboRegEstudio').val('').trigger("change");
        },
        error: function(){
          alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });

    $('#hdnAccionptreg').val('N'); 
    $('#hdnIdregservi').val(v_idptservicio); 
    $('#hdnIdreginfor').val(v_idptinforme); 
    $('#txtregservi').val(v_descripcion_serv);    

    $('#btnNuevoReg').hide();
    $('#txtRegEstudio').hide();
    $('#divRegEstudio').show();
});

$('#btnRetornarEval').click(function(){
    $('#frmMantRegistro').trigger("reset");
    $('#tabinforme a[href="#tabinforme-eval"]').tab('show');
    var $idptinforme = $('#hdnIdreginfor').val();
    var $nro_informe = $('#hdnnroinforme').val();
    recuperaListregistro($idptinforme,$nro_informe);
});



listcboFabricante = function(v_RegEstu,vidfabricante){    
    var params = { 
        "idptregestudio":v_RegEstu 
    };    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/getFabricante",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            if(v_RegEstu == '1'){
                $("#cboFabricanteReg01").html(result);  
                $('#cboFabricanteReg01').val(vidfabricante).trigger("change"); 
            }
        },
        error: function(){
            alert('Error, no se puede cargar la lista desplegable de fabricante');
        }
    });
};
$("#mbtnnewfabricante").click(function (){
    $('#frmMantfabricante').trigger("reset");

    $("#modalMantfabricante").modal('show');

    $('#mhdnAccionfabricante').val('N');
    $('#mhdnidptregserv').val($('#cboRegEstudio').val());
});
$('#modalMantfabricante').on('show.bs.modal', function (e) {
    $('#frmMantfabricante').validate({        
        rules: {
            txtdescripcion: {
              required: true,
            },
        },
        messages: {
            txtdescripcion: {
              required: "Por Favor ingrese Nombre del fabricante"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },        
        submitHandler: function (form) {
            const botonEvaluar = $('#mbtnGMantfabricante');
            var request = $.ajax({
                url:$('#frmMantfabricante').attr("action"),
                type:$('#frmMantfabricante').attr("method"),
                data:$('#frmMantfabricante').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                    objPrincipal.liberarBoton(botonEvaluar);
                },
                beforeSend: function() {
                    objPrincipal.botonCargando(botonEvaluar);
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    Vtitle = 'Se Grabo Correctamente!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                      
                    var vRegEstu = $('#mhdnidptregserv').val();
                    var vidfabricante = this.id
                    listcboFabricante(vRegEstu,vidfabricante);

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCMantfabricante').click();    
                });
            });
            return false;
        }
    });
});

