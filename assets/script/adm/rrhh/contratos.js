
var otblListContratos, otblContratos;

$(document).ready(function() {

});

$('#swCesados').on('switchChange.bootstrapSwitch',function (event, state) {
    if($('#swCesados').prop('checked')){
        $('#hdnestadocontrato').val('A'); 
    }else{
        $('#hdnestadocontrato').val('F'); 
    }
      
    $('#btnBuscar').click();
});

$("#btnBuscar").click(function (){    
    parametros = paramListarBusqueda();
    getListarBusqueda(parametros);    
});

paramListarBusqueda = function (){    
       
    var param = {
        "descripcion"     : '%',//
        "estadocontrato"  : $('#hdnestadocontrato').val(),
    }; 

    return param;    
};

getListarBusqueda = function(param){
    
    var groupColumn = 0;   

    otblListContratos = $('#tblListContratos').DataTable({
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
        'ajax'	: {
            "url"   : baseurl+"adm/rrhh/ccontratos/getbuscarcontratos/",
            "type"  : "POST", 
            "data"  : param,      
            dataSrc : ''        
        },
        'columns'	: [
            {data: 'AREA'},
            {data: null, "class": "col-xxs"},
            {"orderable": false, "class": "col-xxs", 
              render:function(data, type, row){
                return  '<div class="dropdown" style="text-align: center;">'+
                            '<a  data-toggle="dropdown" href="#"><span class="fas fa-bars"></span></a>'+
                            '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
                                '<li><a data-toggle="modal" title="Contratos" data-target="#modalMantcontratos" onclick="javascript:selContratos(\''+row.id_empleado+'\',\''+row.EMPLEADO+'\',\''+row.id_contrato+'\',\''+row.ccompania+'\',\''+row.FINICIO+'\',\''+row.FFIN+'\',\''+row.carea+'\',\''+row.csubarea+'\',\''+row.modalidad_contrato+'\',\''+row.SUELDO+'\',\''+row.id_cargo+'\');"><span class="fas fa-file-signature" aria-hidden="true">&nbsp;</span>&nbsp;Contratos</a></li>'+
                                '<li><a id="aCesecontrato" href="'+row.id_contrato+'" title="Cese"><span class="far fa-window-close" aria-hidden="true">&nbsp;</span>&nbsp;Cese de Contrato</a></li>'+
                            '</ul>'+
                        '</div>'
                
              }
            },
            {data: 'ANIO', "class": "col-xxs"},
            {data: 'MES', "class": "col-s"},
            {"orderable": false, "class": "col-lm",
                render:function(data, type, row){
                if(row.RUTAFOTO == ''){
                    return '<div class="user-block" style="float: none;">' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/user/unknown.png"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                    '<span class="username"  style="vertical-align: middle; margin-top: -25px;">'+row.EMPLEADO+'</span><span class="description"><h6>'+row.NRODOC+'</h6></span>'+
                    '</div>' ; 
                }else{
                    return '<div class="user-block" style="float: none;">' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/user/'+row.RUTAFOTO+'"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                    '<span class="username" style="vertical-align: middle; margin-top: -25px;">'+row.EMPLEADO+'</span><span class="description"><h6>'+row.NRODOC+'</h6></span>'+
                    '</div>' ; 
                }
                }
            },
            {data: 'FINICIO', "class": "col-s"},
            {data: 'FFIN', "class": "col-s"},
            {data: 'CARGO', "class": "col-s"},
            {data: 'SUELDO', "class": "dt-body-right col-xs"},
        ],  
        "rowCallback":function(row,data){            
            if(data.estado_contrato == "F"){
                $(row).css("color","red");
            }
        },
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([0], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(0).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="10"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
            
        }
    }); 
    otblListContratos.column(0).visible( false );      
    // Enumeracion 
    otblListContratos.on( 'order.dt search.dt', function () { 
        otblListContratos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
     
    $("#btnexcel").prop("disabled",false);  
};

$('#tblListContratos tbody').on('dblclick', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblListContratos.row(tr);
    var rowData = row.data();
    
    $("#modalMantemple").modal('show');

    $('#frmMantemple').trigger("reset");
    $('#divcia').hide();
    $('#divcontrato').hide();

    $('#mhdnAccionempleado').val('A'); 
    $('#mhdnidempleado').val(rowData.id_empleado);
    $('#mhdnidadministrado').val(rowData.id_administrado);
    $('#mhdntipodoc').val(rowData.id_tipodoc);
    $('#mtxtnrodoc').val(rowData.NRODOC);
    $('#mcbosexo').val(rowData.sexo).trigger("change"); 
    $('#mtxtapepat').val(rowData.ape_paterno);
    $('#mtxtapemat').val(rowData.ape_materno);
    $('#mtxtnombres').val(rowData.nombres);
    $('#mtxtemail').val(rowData.email);
    $('#mtxtcelular').val(rowData.fono_celular);
    $('#mtxttelefono').val(rowData.fono_fijo);
    $('#mtxtdireccion').val(rowData.direccion);
    $('#txtFIngre').val(rowData.f_inicio_laboral);
    $('#mtxtanexo').val(rowData.anexo);
    $('#mtxtemailempre').val(rowData.emailempresa);
    $('#mtxtcelularempre').val(rowData.cel_empresa);
    $('#txtFNace').val(rowData.fecha_nace);
    $('#mcboestadocivil').val(rowData.estado_civil).trigger("change"); 
    $('#mtxtnrohijos').val(rowData.hijos);
    $('#mcbopension').val(rowData.idpension).trigger("change", [rowData.idpensionentidad] ); 
    //$('#mcbopension').val(rowData.idpension).change(rowData.idpensionentidad);
    $('#mcboentidadpension').val(rowData.idpensionentidad);
    //listcboEntidadpension(rowData.idpension,rowData.idpensionentidad);
    //$('#mcbobanco').val(rowData.idbanco).trigger("change");     
    listcboBanco(rowData.idbanco);
    $('#mtxtnroctasueldo').val(rowData.nroctacte);
    $('#mtxtccictasueldo').val(rowData.ccictacte);
    $('#mcboeps').val(rowData.eps).trigger("change");
    //$('#mcboprofesion').val(rowData.idprofesion).trigger("change");
    listcboProfesion(rowData.idprofesion); 
    $('#mtxtnrocoleg').val(rowData.nrocolegio_prof);

});

$("#btnNuevo").click(function (){
    $('#frmMantemple').trigger("reset");

    $("#modalMantemple").modal('show');
 
    $('#divcia').show();

    $('#mhdnAccionempleado').val('N');

    $('#mhdntipodoc').val(1);
    $('#mcbosexo').val('').trigger("change"); 
    $('#mcboestadocivil').val('').trigger("change"); 
    $('#mcbopension').val(0).trigger("change"); 
    $('#mcboeps').val('N').trigger("change"); 
    listcboBanco(0);
    listcboProfesion(0);
    
});
    
$("body").on("click","#aCesecontrato",function(event){
    event.preventDefault();
    vidcontrato = $(this).attr("href");
    
    $.post(baseurl+"adm/rrhh/ccontratos/setcesarcontrato", 
    {
        idcontrato   : vidcontrato,
    },      
    function(data){           
        Vtitle = 'Se Ceso Correctamente!!!';
        Vtype = 'success';
        sweetalert(Vtitle,Vtype); 

        otblListContratos.ajax.reload(null,false); 	
    });
}); 

DNI=function(){
    $('#btntipodoc').html("DNI");
    $('#mhdntipodoc').val(1);
};

EXT=function(){
    $('#btntipodoc').html("CExt");
    $('#mhdntipodoc').val(4);
};

$('input[type=radio][name=rCia]').change(function() {
    if($('#rdFS').prop('checked')){        
        $('#hrdcia').val('1'); 
        listcboArea('1');
    }else if ($('#rdFSC').prop('checked')){  
        $('#hrdcia').val('2');
        listcboArea('2'); 
    } 
});

$('#modalMantemple').on('show.bs.modal', function (e) {

    $('#txtFIngreso,#txtFInicio,#txtFTermino').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });	
    $('#txtFNacimiento').datetimepicker({
        format: 'DD/MM/YYYY',
        locale:'es'
    });	    
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
    $('#txtFIngreso').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFInicio').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

    $('#hrdcia').val('1'); 

    var vccia = $('#hrdcia').val();
    listcboArea(vccia);
    listcboCargo();

    $('#frmMantemple').validate({
        rules: {
        },
        messages: {
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
            const botonEvaluar = $('#mbtnGManteemp');
            var request = $.ajax({
                url:$('#frmMantemple').attr("action"),
                type:$('#frmMantemple').attr("method"),
                data:$('#frmMantemple').serialize(),
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
                      
                    parametros = paramListarBusqueda();
                    getListarBusqueda(parametros); 

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCManteemp').click();    
                });
            });
            return false;
        }
    });
});

$('#mcbopension').change(function( event, videnti ){ 
    var v_cpension = $( "#mcbopension option:selected").attr("value");
    var v_cidentidad = videnti || 0;
    listcboEntidadpension(v_cpension,v_cidentidad);
});

listcboEntidadpension = function(v_cpension,videntidadpension){    
    var params = { 
        "idpension" : v_cpension
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbopensionentidad",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboentidadpension').html(result);
            $('#mcboentidadpension').val(videntidadpension).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcboentidadpension');
        }
    });
};

$("#mbtnnewentidadpension").click(function (){
    $('#frmMantentidadpension').trigger("reset");

    $("#modalMantentidadpension").modal('show');

    $('#mhdnAccionentidadpension').val('N');
});

$('#modalMantentidadpension').on('show.bs.modal', function (e) {
    $('#frmMantentidadpension').validate({        
        rules: {
            txtdescripcion: {
              required: true,
            },
        },
        messages: {
            txtdescripcion: {
              required: "Por Favor ingrese Nombre de la entidad"
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
            const botonEvaluar = $('#mbtnGMantentidadpension');
            var request = $.ajax({
                url:$('#frmMantentidadpension').attr("action"),
                type:$('#frmMantentidadpension').attr("method"),
                data:$('#frmMantentidadpension').serialize(),
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
                      
                    var vidpension = $('#mcbopension').val();
                    listcboEntidadpension(vidpension,0);

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCMantentidadpension').click();    
                });
            });
            return false;
        }
    });
});

listcboBanco = function(vidbanco){    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbobanco",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcbobanco').html(result);
            $('#mcbobanco').val(vidbanco).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcbobanco');
        }
    });
};

$("#mbtnnewbanco").click(function (){
    $('#frmMantbanco').trigger("reset");

    $("#modalMantbanco").modal('show');
    
    $('#mhdnAccionbanco').val('N');
});

$('#modalMantbanco').on('show.bs.modal', function (e) {
    $('#frmMantbanco').validate({        
        rules: {
            txtdesbanco: {
              required: true,
            },
        },
        messages: {
            txtdesbanco: {
              required: "Por Favor ingrese Nombre del Banco"
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
            const botonEvaluar = $('#mbtnGMantbanco');
            var request = $.ajax({
                url:$('#frmMantbanco').attr("action"),
                type:$('#frmMantbanco').attr("method"),
                data:$('#frmMantbanco').serialize(),
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
                      
                    listcboBanco();

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCMantbanco').click();    
                });
            });
            return false;
        }
    });
});

listcboProfesion = function(idprofesion){    
    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcboprofesion",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcboprofesion').html(result);
            $('#mcboprofesion').val(idprofesion).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcboprofesion');
        }
    });
};

$("#mbtnnewprofesion").click(function (){
    $('#frmMantprofesion').trigger("reset");

    $("#modalMantprofesion").modal('show');
    
    $('#mhdnAccionprofesion').val('N');
});

$('#modalMantprofesion').on('show.bs.modal', function (e) {
    $('#frmMantprofesion').validate({        
        rules: {
            txtdesprofesion: {
              required: true,
            },
        },
        messages: {
            txtdesprofesion: {
              required: "Por Favor ingrese Nombre de la Profesion"
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
            const botonEvaluar = $('#mbtnGMantprofesion');
            var request = $.ajax({
                url:$('#frmMantprofesion').attr("action"),
                type:$('#frmMantprofesion').attr("method"),
                data:$('#frmMantprofesion').serialize(),
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
                      
                    listcboProfesion();

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCMantprofesion').click();    
                });
            });
            return false;
        }
    });
});

listcboArea = function(v_ccia){    
    var params = { 
        "ccia" : v_ccia
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcboarea",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboarea').html(result);
        },
        error: function(){
            a
            lert('Error, No se puede autenticar por error = mcboarea');
        }
    });
};

$('#mcboarea').change(function(){    
    var vccia = $('#hrdcia').val();
    var vcarea = $('#mcboarea').val();
    listcboSubarea(vccia,vcarea);
});

listcboSubarea = function(v_ccia,v_carea){    
    var params = { 
        "ccia" : v_ccia,
        "carea" : v_carea
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbosubarea",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcbosubarea').html(result);
        },
        error: function(){
            a
            lert('Error, No se puede autenticar por error = mcbosubarea');
        }
    });
};

listcboCargo = function(tipocargo){
    vtipocargo = tipocargo;    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbocargo",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            if(vtipocargo == 'E'){
                $('#mcbocargo').html(result);
            }else{
                $('#mcbocargo_cont').html(result);
            }            
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcbocargo');
        }
    });
};

$("#mbtnnewcargo").click(function (){
    $('#frmMantcargo').trigger("reset");

    $("#modalMantcargo").modal('show');
    
    $('#mhdnAccioncargo').val('N');
    $('#mhdncargotipo').val('E');
});

$('#modalMantcargo').on('show.bs.modal', function (e) {
    var vtipocargo = $('#mhdncargotipo').val();
    $('#frmMantcargo').validate({        
        rules: {
            txtdescargo: {
              required: true,
            },
        },
        messages: {
            txtdescargo: {
              required: "Por Favor ingrese Nombre del Cargo"
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
            const botonEvaluar = $('#mbtnGMantcargo');
            var request = $.ajax({
                url:$('#frmMantcargo').attr("action"),
                type:$('#frmMantcargo').attr("method"),
                data:$('#frmMantcargo').serialize(),
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
                     
                    listcboCargo(vtipocargo);

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCMantcargo').click();    
                });
            });
            return false;
        }
    });
});

$('#txtFInicio').on('change.datetimepicker',function(e){	
    
    $('#txtFTermino').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	
    
    var faño = moment(e.date).add(1, 'years');

    $('#txtFTermino').datetimepicker('date',moment(faño).format('DD/MM/YYYY') );
    

});


$('#modalMantcontratos').on('show.bs.modal', function (e) {
    /*
    $('#txtFInicio_cont').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true
    });	
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
    $('#txtFInicio_cont').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );*/
   

    $('#frmMantcontratos').validate({
        rules: {
        },
        messages: {
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
            const botonEvaluar = $('#mbtnGMantcontrato');
            var request = $.ajax({
                url:$('#frmMantcontratos').attr("action"),
                type:$('#frmMantcontratos').attr("method"),
                data:$('#frmMantcontratos').serialize(),
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
                    
                    otblContratos.ajax.reload(null,false);  
                    //getlistContratos(); 

                    objPrincipal.liberarBoton(botonEvaluar);       
                });
            });
            return false;
        }
    });
});

selContratos = function(vidempleado,vempleado,vidcontrato,vccia,vfinicio,vffin,vcarea,vcsubarea,vmodalidad_contrato,vsueldo,vidcargo){
    
    $('#mhdnidempleado_cont').val(vidempleado);
    $('#mhdnAccioncontrato').val('A');
    document.querySelector('#nomempleado').innerText = vempleado;
    $('#txtFInicio_cont').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true
    });	
    getlistContratos();    
    getContratos(vidcontrato,vccia,vfinicio,vffin,vcarea,vcsubarea,vmodalidad_contrato,vsueldo,vidcargo);
};

$('#txtFInicio_cont').on('change.datetimepicker',function(e){	
    
    $('#txtFTermino_cont').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });	
    
    var faño = moment(e.date).add(1, 'years');
    $('#txtFTermino_cont').datetimepicker('date',moment(faño).format('DD/MM/YYYY') );    

});

listcboArea_cont = function(v_ccia, v_carea, v_csubarea){    
    var params = { 
        "ccia" : v_ccia
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcboarea",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcboarea_cont').html(result);
            $('#mcboarea_cont').val(v_carea).trigger("change", [v_ccia,v_csubarea] ); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcboarea');
        }
    });
};

$('#mcboarea_cont').change(function( event, ccia, csubarea){ 
    var v_carea = $( "#mcboarea_cont option:selected").attr("value");
    listcboSubarea_cont(ccia,v_carea,csubarea);
});

listcboSubarea_cont = function(v_ccia,v_carea,v_subarea){    
    var params = { 
        "ccia" : v_ccia,
        "carea" : v_carea
    }; 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbosubarea",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#mcbosubarea_cont').html(result);
            $('#mcbosubarea_cont').val(v_subarea).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcbosubarea');
        }
    });
};

listcboCargo_cont = function(v_idcargo){    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"adm/rrhh/ccontratos/getcbocargo",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#mcbocargo_cont').html(result);
            $('#mcbocargo_cont').val(v_idcargo).trigger("change"); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = mcbocargo');
        }
    });
}

getlistContratos = function(){
    otblContratos = $('#tblContratos').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "320px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: false,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"adm/rrhh/ccontratos/getcontratosxempleado/",
            "type"  : "POST", 
            "data": function ( d ) { 
                d.id_empleado     = $('#mhdnidempleado_cont').val(); 
            },      
            dataSrc : ''        
        },
        'columns'	: [
            {data: null, "class": "col-xxs"},
            {data: 'FINICIO', "class": "col-sm"},
            {data: 'FTERMINO', "class": "col-sm"},
            {data: 'ESTADO', "class": "col-xs"},
            {"orderable": false, "class": "col-xxs",
                render:function(data, type, row){                
                        if ( row.ESTADO == 'A' ){
                            return '<div>' +
                            '<a id="aRenovar" href="'+row.id_contrato+'" title="Renovar" style="cursor:pointer; color:cray;"><span class="fas fa-marker" aria-hidden="true"> </span></a>'
                            '</div>' ;
                        }else{
                            return '<div>' +
                            '</div>' ;
                        }
                    
                } 
            }
        ]
    });      
    // Enumeracion 
    otblContratos.on( 'order.dt search.dt', function () { 
        otblContratos.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
};

getContratos = function(vidcontrato,vccia,vfinicio,vffin,vcarea,vcsubarea,vmodalidad_contrato,vsueldo,vidcargo){
    $('#mhdnidcontrato').val(vidcontrato);
    $('#hrdcia_cont').val(vccia);
    $('#txtFIni_cont').val(vfinicio);
    $('#txtFTerm_cont').val(vffin); 
    listcboArea_cont(vccia,vcarea,vcsubarea);
    $('#mcbomodalidad_cont').val(vmodalidad_contrato).trigger("change");
    $('#mtxtsueldo_cont').val(vsueldo);
    listcboCargo_cont(vidcargo);
};

$('#tblContratos tbody').on('click', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblContratos.row(tr);
    var rowData = row.data();

    $('#frmMantcontratos').trigger("reset");

    $('#mhdnAccioncontrato').val('A');
    getContratos(rowData.id_contrato,rowData.ccompania,rowData.FINICIO,rowData.FTERMINO,rowData.carea,rowData.csubarea,rowData.modalidad_contrato,rowData.sueldo,rowData.idcargo);
});

$("#mbtnnewcargo_cont").click(function (){
    $('#frmMantcargo').trigger("reset");

    $("#modalMantcargo").modal('show');
    
    $('#mhdnAccioncargo').val('N');
    $('#mhdncargotipo').val('C');
});
    
$("body").on("click","#aRenovar",function(event){
    event.preventDefault();
    vidcontrato = $(this).attr("href");
    
    $.post(baseurl+"adm/rrhh/ccontratos/setrenovarcontrato", 
    {
        idcontrato   : vidcontrato,
    },      
    function(data){           
        Vtitle = 'Se Renovo Correctamente!!!';
        Vtype = 'success';
        sweetalert(Vtitle,Vtype); 

        otblContratos.ajax.reload(null,false); 	
    });
}); 