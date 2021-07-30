
var oTableCliente, tblEstablecimiento;
var folderimage;

const objFormulario = {
};
$(function() {    
    /**
     * Muestra la lista ocultando el formulario
     */
    objFormulario.mostrarBusqueda = function () {
        const boton = $('#btnAccionContenedorLista');
        const icon = boton.find('i');
        if (icon.hasClass('fa-minus')) icon.removeClass('fa-minus');
        icon.addClass('fa-plus');
        boton.click();
        $('#contenedorRegestable').hide();
        $('#contenedorBusqueda').show();
        //objFiltro.buscar()
    };

    /**
     * Muestra el formulario ocultando la lista
     */
    objFormulario.mostrarRegEstable = function (ccliente,razonsocial,direccioncliente,dzip, cpais,dciudad,destado,cubigeo,dubigeo) {
        const boton = $('#btnAccionContenedorLista');
        const icon = boton.find('i');
        if (icon.hasClass('fa-plus')) icon.removeClass('fa-plus');
        icon.addClass('fa-minus');
        boton.click();

        $('#cardRegestable').hide();
        $('#cardListestable').show();
        
        document.querySelector('#lblCliente').innerText = razonsocial;
        document.querySelector('#lblDirclie').innerText = direccioncliente;

        $('#mhdnIdClie').val(ccliente);

        $('#mhdnestCcliente').val(ccliente);
        $('#mhdnestDcliente').val(razonsocial);
        $('#mhdnestDdireccion').val(direccioncliente);
        $('#mhdnestDzid').val(dzip);
        $('#mhdnestCpais').val(cpais);
        $('#mhdnestDciudad').val(dciudad);
        $('#mhdnestDestado').val(destado);
        $('#mhdnestCubigeo').val(cubigeo);
        $('#mhdnestDubigeo').val(dubigeo); 
                  
        listEstable(ccliente);

/*
        $('#hdnIdaudi').val(cauditoriainspeccion);
        $('#hdnFaudi').val(fservicio);
        $('#hdnChecklist').val(cchecklist);
        
        //listarChecklist();
        var params = { "cestablecimiento":cestablecimiento};
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/auditoria/cregauditoria/getcboregAreazona",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result){
                $('#cboregAreazona').html(result);
            },
            error: function(){
                alert('Error, No se puede autenticar por error');
            }
        });
*/
        $('#contenedorRegestable').show();
        $('#contenedorBusqueda').hide();
    };
});

listEstable = function(ccliente){

  tblEstablecimiento = $('#tblListEstablecimiento').DataTable({
    "processing"  	: true,
    "bDestroy"    	: true,
    "stateSave"     : true,
    "bJQueryUI"     : true,
    'bStateSave'    : true,
    "scrollY"     	: "400px",
    "scrollX"     	: true,
    'scrollCollapse': true, 
    'AutoWidth'     : true,
    "paging"      	: false,
    "info"        	: true,
    "filter"      	: true, 
    "ordering"		  : false,
    "responsive"    : false,
    "select"        : true, 
    //'fixedColumns':{
    //  'leftColumns': false,// Fijo primera columna
    //  'rightColumns':1
    //},
    //'lengthMenu'  : [[10, 20, 30, -1], [10, 20, 30, "Todo"]], 
    'ajax'        : {
                      "url"   : baseurl+"pt/cptcliente/getbuscarestablecimiento",
                      "type"  : "POST", 
                      "data": function ( d ) {
                          d.IDCLIENTE = ccliente

                      },     
                      dataSrc : ''        
                    },
    'columns'     : [
        
                      {data: 'SPACE', "class": "col-xxs"},
                      {data: 'DESCRIPESTABLE', "class": "col-lm"},
                      {data: 'DIRECCION', "class": "col-lm"},
                    ], 
  });
  // Enumeracion 
  tblEstablecimiento.on( 'order.dt search.dt', function () { 
    tblEstablecimiento.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
        } );
  }).draw(); 
};

$('#tblListEstablecimiento tbody').on('dblclick', 'td', function () {
  var tr = $(this).parents('tr');
  var row = tblEstablecimiento.row(tr);
  var rowData = row.data();

  editarEstablecimiento(rowData.COD_ESTABLE,rowData.COD_CLIENTE,rowData.DESCRIPESTABLE,rowData.DIRECCION,rowData.DZIP,rowData.FCE,rowData.ECP,rowData.FFRN,rowData.RESPONCALIDAD,rowData.CARGOCALIDAD,rowData.EMAILCALIDAD,rowData.ESTADO,rowData.TELEFONOCALIDAD,rowData.PAIS,rowData.CIUDAD,rowData.ESTESTABLE,rowData.UBIGEO,rowData.DUBIGEO);
  $('#cardRegestable').show();
  $('#cardListestable').hide();
});

$('#btnCerrarEstable').click(function(){
  $('#cardRegestable').hide();
  $('#cardListestable').show();
});


editarEstablecimiento = function(cestablecimiento,ccliente,destablecimiento,direccion,dzip,fce,ecp,ffrn,responcalidad,cargocalidad,emailcalidad,estado,telefonocalidad,pais,ciudad,estestable,ubigeo,dubigeo){
  
  $('#mhdnIdEstable').val(cestablecimiento);    
  $('#mhdnIdClie').val(ccliente);    
  $('#txtestableCI').val(destablecimiento);    
  $('#cboPaisEstable').val(pais).trigger("change"); 
  $('#txtCiudadEstable').val(ciudad).trigger("change");    
  $('#txtEstadoEstable').val(estestable).trigger("change");     
  $('#hdnidubigeoEstable').val(ubigeo); 
  $('#mtxtUbigeoEstable').val(dubigeo);     
  $('#txtestablezip').val(dzip);    
  $('#txtestabledireccion').val(direccion);    
  $('#txtestableFce').val(fce);    
  $('#txtestableEcp').val(ecp);      
  $('#txtestableFfrn').val(ffrn);    
  $('#txtestableresproceso').val(responcalidad); 
  $('#txtestablecargo').val(cargocalidad); 
  $('#txtestableEmail').val(emailcalidad);   
  $('#txtestablecelu').val(telefonocalidad);  
  $('#cboestableEstado').val(estado).trigger("change");  
  $('#mhdnAccionEstable').val('A'); 
};


$('#btnEstableNuevo').click(function(){    
  $('#cardRegestable').show();
  $('#cardListestable').hide();

  limpiarFormEstable();    

  $('#mhdnIdClie').val($('#mhdnestCcliente').val());
  $('#txtestableCI').val($('#mhdnestDcliente').val());
  $('#txtestabledireccion').val($('#mhdnestDdireccion').val());
  $('#txtestablezip').val($('#mhdnestDzid').val());
  $('#cboPaisEstable').val($('#mhdnestCpais').val()).trigger("change"); 
  $('#txtCiudadEstable').val($('#mhdnestDciudad').val());
  $('#txtEstadoEstable').val($('#mhdnestDestado').val());
  $('#hdnidubigeoEstable').val($('#mhdnestCubigeo').val());
  $('#mtxtUbigeoEstable').val($('#mhdnestDubigeo').val()); 

  $('#mhdnAccionEstable').val('N'); 
});

$(document).ready(function() {
    $('#tabptcliente a[href="#tabptcliente-list-tab"]').attr('class', 'disabled');
    $('#tabptcliente a[href="#tabptcliente-reg-tab"]').attr('class', 'disabled active');

    $('#tabptcliente a[href="#tabptcliente-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tabptcliente a[href="#tabptcliente-list"]').attr('class', 'active');
        $('#tabptcliente a[href="#tabptcliente-reg"]').attr('class', '');
        return true;
    });
    $('#tabptcliente a[href="#tabptcliente-reg-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabptcliente a[href="#tabptcliente-reg"]').attr('class' ,'active');
        $('#tabptcliente a[href="#tabptcliente-eval"]').attr('class', '');
        return true;
    });
    
    $('#tabptcliente a[href="#tabptcliente-list"]').click(function(event){return false;});
    $('#tabptcliente a[href="#tabptcliente-reg"]').click(function(event){return false;});
    
    $("#boxDeparEstable").hide();
    $("#boxProvEstable").hide();
    $("#boxDistEstable").hide();
    $("#boxUbigeo").hide(); 

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"cglobales/getpaises",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboPais,#cboPaisEstable').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });
    $.ajax({
      type: 'ajax',
      method: 'post',
      url: baseurl+"cglobales/getdepartamentos",
      dataType: "JSON",
      async: true,
      success:function(result)
      {
          $('#cboDepa,#cboDepaEsta').html(result);
      },
      error: function(){
        alert('Error, No se puede autenticar por error');
      }
    });

    var btnCust = '';
  
    $("#file-input").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="fas fa-file-image"></i>',
      removeIcon: '<i class="fas fa-times-circle"></i>',
      removeTitle: 'Cancelar o remover',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
      allowedFileExtensions: ["jpeg", "jpg", "png", "gif"]
    });
});

listarcliente = function(){
    oTableCliente = $('#tblListPtcliente').DataTable({
      "processing"  	: true,
      "bDestroy"    	: true,
      "stateSave"     : true,
      "bJQueryUI"     : true,
      "scrollY"     	: "500px",
      "scrollX"     	: true, 
      'AutoWidth'     : true,
      "paging"      	: false,
      "info"        	: true,
      "filter"      	: true, 
      "ordering"		  : false,
      "responsive"    : false,
      "select"        : true, 
      'ajax'        : {
        "url"   : baseurl+"pt/cptcliente/getbuscarclientes",
        "type"  : "POST", 
        "data": function ( d ) {
          d.cliente = $('#txtCliente').val();   
        },     
        dataSrc : ''        
      },
      'columns'     : [
          {data: 'SPACE', "class": "col-xxs"},
          {"orderable": false, "class": "col-xxs", 
            render:function(data, type, row){
              return  '<div class="dropdown" style="text-align: center;">'+
                          '<a  data-toggle="dropdown" href="#"><span class="fas fa-bars"></span></a>'+
                          '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
                              '<li><a title="Establecimientos" style="cursor:pointer; color:blue;" onClick="objFormulario.mostrarRegEstable(\''+row.CCLIENTE+'\',\''+row.DRAZONSOCIAL+'\',\''+row.DDIRECCIONCLIENTE+'\',\''+row.dzip+'\',\''+row.cpais+'\',\''+row.dciudad+'\',\''+row.destado+'\',\''+row.CUBIGEO+'\',\''+row.DUBIGEO+'\');"><span class="fas fa-map-marked-alt" aria-hidden="true">&nbsp;</span>&nbsp;Establecimientos</a></li>'+
                              //'<li><a id="aCesecontrato" href="'+row.id_contrato+'" title="Cese"><span class="far fa-window-close" aria-hidden="true">&nbsp;</span>&nbsp;Cese de Contrato</a></li>'+
                          '</ul>'+
                      '</div>'
              
            }
          },
          {"orderable": false, "class": "col-l",
              render:function(data, type, row){
              if(row.DRUTA == ''){
                  return '<div class="user-block" style="float: none;">' +
                  '<img src="'+baseurl+'FTPfileserver/Imagenes/clientes/unknown.png"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                  '<span class="username"  style="vertical-align: middle; margin-top: -25px;">'+row.DRAZONSOCIAL+'</span><span class="description"><h6>'+row.NRUC+'</h6></span>'+
                  '</div>' ; 
              }else{
                  return '<div class="user-block" style="float: none;">' +
                  '<img src="'+baseurl+'FTPfileserver/Imagenes/clientes/'+row.DRUTA+'"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                  '<span class="username" style="vertical-align: middle; margin-top: -25px;">'+row.DRAZONSOCIAL+'</span><span class="description"><h6>'+row.NRUC+'</h6></span>'+
                  '</div>' ; 
              }
              }
          },
          {"orderable": false, "class": "col-lm",
              render:function(data, type, row){
              if(row.DRUTA == ''){
                  return '<div>' +
                  '<span class="username"  style="vertical-align: middle;">'+row.DDIRECCIONCLIENTE+'</span><br><span class="description"><small>'+row.DUBIGEO+'</small></span>'+
                  '</div>' ; 
              }else{
                  return '<div>' +
                  '<span class="username" style="vertical-align: middle;">'+row.DDIRECCIONCLIENTE+'</span><br><span class="description"><small>'+row.DUBIGEO+'</small></span>'+
                  '</div>' ; 
              }
              }
          },
          {data: 'DTELEFONO', "class": "col-sm"},
          {data: 'DREPRESENTANTE', "class": "col-m"}
      ], 
    });    
    // Enumeracion 
    oTableCliente.on( 'order.dt search.dt', function () { 
      oTableCliente.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();     
};

$('#tblListPtcliente tbody').on('dblclick', 'td', function () {
  var tr = $(this).parents('tr');
  var row = oTableCliente.row(tr);
  var rowData = row.data();

  editarCliente(rowData.CCLIENTE,rowData.NRUC,rowData.DRAZONSOCIAL,rowData.cpais,rowData.dciudad,rowData.destado,rowData.dzip,rowData.CUBIGEO,rowData.DDIRECCIONCLIENTE,rowData.DTELEFONO,rowData.DFAX,rowData.dweb,rowData.ZCTIPOTAMANOEMPRESA,rowData.NTRABAJADOR,rowData.DREPRESENTANTE,rowData.DCARGOREPRESENTANTE,rowData.DEMAILREPRESENTANTE,rowData.DRUTA,rowData.TIPODOC,rowData.DUBIGEO);
});

$('#btnBuscar').click(function(){
  listarcliente();
});

$('#btnNuevo').click(function(){    
    $('#tabptcliente a[href="#tabptcliente-reg"]').tab('show'); 
    limpiarForm(); 
    $('#divlogo').hide();
    $('#btnGrabar').show(); 
    $('#hdnAccionptclie').val('N'); 
});

$('#btnRetornar').click(function(){
    $('#tabptcliente a[href="#tabptcliente-list"]').tab('show');  
});

$('#cboPais').change(function(){
  var v_cpais = $( "#cboPais option:selected").attr("value");
  $('#mtxtUbigeo').val('');
  $('#hdnidubigeo').val('');
  if(v_cpais == '290'){
    $("#boxCiudad").hide();
    $("#boxEstado").hide();
    $("#boxUbigeo").show();      
  } else {
    $("#boxCiudad").show();
    $("#boxEstado").show();
    $("#boxUbigeo").hide(); 
  }
});

$('#btnBuscarUbigeo').click(function() {
  $("#modalUbigeo").modal();	
});

$('#cboDepa').change(function(){
  var v_cdepa = $( "#cboDepa option:selected").attr("value");
  var params = { "cdepa" : v_cdepa};  
  $.ajax({
    type: 'ajax',
    method: 'post',
    url: baseurl+"cglobales/getprovincias",
    dataType: "JSON",
    async: true,
    data: params,
    success:function(result){
        $('#cboProv').html(result);
    },
    error: function(){
      alert('Error, No se puede autenticar por error');
    }
  });
});

$('#cboProv').change(function(){
  var v_cdepa = $( "#cboDepa option:selected").attr("value");
  var v_cprov = $( "#cboProv option:selected").attr("value");
  var params = { 
    "cdepa" : v_cdepa,
    "cprov" : v_cprov
  };  
  $.ajax({
    type: 'ajax',
    method: 'post',
    url: baseurl+"cglobales/getdistritos",
    dataType: "JSON",
    async: true,
    data: params,
    success:function(result){
        $('#cboDist').html(result);
    },
    error: function(){
      alert('Error, No se puede autenticar por error');
    }
  });
});

$('#btnSelUbigeo').click(function(){
  var v_cubigeo = $( "#cboDist option:selected").attr("value");
  var v_depa = $("#cboDepa").find('option:selected').text();
  var v_prov = $("#cboProv").find('option:selected').text();
  var v_dist = $("#cboDist").find('option:selected').text();
  $('#mtxtUbigeo').val(v_depa+' - '+v_prov+' - '+v_dist);
  $('#hdnidubigeo').val(v_cubigeo);
  $("#btncerrarUbigeo").click(); 

});

registrar_imagen = function(){
  var archivoInput = document.getElementById('file-input').files[0].name;
  var archivoRuta = archivoInput;
  var extPermitidas = /(.gif|.jpg|.png|.jpeg)$/i;

  if(!extPermitidas.exec(archivoRuta)){
    alert('Asegurese de haber seleccionado un GIF, JPG, PNG, JPEG');
    archivoInput.value = '';
    return false;
  }
  else
  {
    var parametrotxt = new FormData($("#frmFileinputLogoclie")[0]);
      $.ajax({
        data: parametrotxt,
        method: 'post',
        url: baseurl+"pt/cptcliente/upload_image",
        dataType: "JSON",
        async: true,
        contentType: false,
        processData: false,
        success: function(response){  
          $('#divlogo').show();
          folderimage = response.nombreArch;
          $('#utxtlogo').val(folderimage);        
        },
        error: function(){
          alert('Error, no se cargó el archivo');
        }

      });
  }
}

editarCliente = function(ccliente,nruc,drazonsocial,cpais,dciudad,destado,dzip,cubigeo,ddireccioncliente,dtelefono,
                        dfax,dweb,zctipotamanoempresa,ntrabajador,drepresentante,dcargorepresentante,demailrepresentante,
                        druta,tipodoc,dubigeo){
  var ruta_imagen;
  ruta_imagen = baseurl+'FTPfileserver/Imagenes/clientes/'+druta;

  $('#hdnIdptclie').val(ccliente);    
  $('#txtnrodoc').val(nruc);    
  $('#txtrazonsocial').val(drazonsocial);    
  $('#cboPais').val(cpais).trigger("change"); 
  $('#txtCiudad').val(dciudad);    
  $('#txtEstado').val(destado);    
  $('#hdnidubigeo').val(cubigeo); 
  $('#mtxtUbigeo').val(dubigeo);     
  $('#txtCodigopostal').val(dzip);    
  $('#txtDireccion').val(ddireccioncliente);    
  $('#txtTelefono').val(dtelefono);    
  $('#txtFax').val(dfax);      
  $('#txtWeb').val(dweb);    
  $('#txtTipoempresa').val(zctipotamanoempresa);  
  $('#txtNroTrab').val(ntrabajador); 
  $('#txtRepresentante').val(drepresentante); 
  $('#txtCargorep').val(dcargorepresentante); 
  $('#txtEmailrep').val(demailrepresentante);   
  $('#hdnAccionptclie').val('E'); 
  $('#utxtlogo').val(druta);  
  $('#cboTipoDoc').val(tipodoc);  
  document.getElementById("image_previa").src = ruta_imagen; 
  $('#tabptcliente a[href="#tabptcliente-reg"]').tab('show'); 
  $('#divlogo').hide();
  $("#mbtnsavecliente").prop('disabled',false);
  $('#hdnCCliente').val(ccliente);
};

limpiarForm = function(){    
  $('#frmMantptClie').trigger("reset");
  $('#hdnIdptclie').val('');
  $('#cboPais').val('').trigger("change"); 
  $('#cboUbigeo').val('').trigger("change");
}

$('#frmMantptClie').submit(function(event){
    event.preventDefault();
    
    var request = $.ajax({
        url:$('#frmMantptClie').attr("action"),
        type:$('#frmMantptClie').attr("method"),
        data:$('#frmMantptClie').serialize(),
        error: function(){
          alert('Error, No se puede autenticar por error');
        }
    });
    request.done(function( respuesta ) {
        
            Vtitle = 'Datos Guardados correctamente';
            Vtype = 'success';
            sweetalert(Vtitle,Vtype);
            limpiarForm();    
            listarcliente();
            $('#tabptcliente a[href="#tabptcliente-list"]').tab('show'); 
    });
});

$('#btnRetornarLista').click(function(){
    objFormulario.mostrarBusqueda();
});

$('#cboPaisEstable').change(function(){
    var v_cpais = $( "#cboPaisEstable option:selected").attr("value");
    
  $('#mtxtUbigeoEstable').val('');
  $('#hdnidubigeoEstable').val('');

    if(v_cpais == '290'){
      $("#boxCiudadEstable").hide();
      $("#boxEstadoEstable").hide();
      $("#boxUbigeoEstable").show(); 
    } else {
      $("#boxCiudadEstable").show();
      $("#boxEstadoEstable").show(); 
      $("#boxUbigeoEstable").hide(); 
    }
});

$('#btnBuscarUbigeoEstable').click(function() {
  $("#modalUbigeoest").modal();	
});

$('#cboDepaEsta').change(function(){
  var v_cdepa = $( "#cboDepaEsta option:selected").attr("value");
  var params = { "cdepa" : v_cdepa};  
  $.ajax({
    type: 'ajax',
    method: 'post',
    url: baseurl+"cglobales/getprovincias",
    dataType: "JSON",
    async: true,
    data: params,
    success:function(result){
        $('#cboProvEsta').html(result);
    },
    error: function(){
      alert('Error, No se puede autenticar por error');
    }
  });
});

$('#cboProvEsta').change(function(){
  var v_cdepa = $( "#cboDepaEsta option:selected").attr("value");
  var v_cprov = $( "#cboProvEsta option:selected").attr("value");
  var params = { 
    "cdepa" : v_cdepa,
    "cprov" : v_cprov
  };  
  $.ajax({
    type: 'ajax',
    method: 'post',
    url: baseurl+"cglobales/getdistritos",
    dataType: "JSON",
    async: true,
    data: params,
    success:function(result){
        $('#cboDistEsta').html(result);
    },
    error: function(){
      alert('Error, No se puede autenticar por error');
    }
  });
});

$('#cboDistEsta').change(function(){
  var v_cubigeo = $( "#cboDistEsta option:selected").attr("value");
  $('#hdnidubigeoEstable').val(v_cubigeo);
});

$('#btnSelUbigeoEsta').click(function(){
  var v_cubigeo = $( "#cboDistEsta option:selected").attr("value");
  var v_depa = $("#cboDepaEsta").find('option:selected').text();
  var v_prov = $("#cboProvEsta").find('option:selected').text();
  var v_dist = $("#cboDistEsta").find('option:selected').text();
  $('#mtxtUbigeoEstable').val(v_depa+' - '+v_prov+' - '+v_dist);
  $('#hdnidubigeoEstable').val(v_cubigeo);
  $("#btncerrarUbigeoEsta").click(); 

});

limpiarFormEstable = function(){    
  $('#frmMantEstablecimiento').trigger("reset");
  $('#mhdnIdEstable').val('');
  $('#cboPaisEstable').val('').trigger("change"); 
  $('#mtxtUbigeoEstable').val('').trigger("change");
}

$('#frmMantEstablecimiento').submit(function(event){

  event.preventDefault();
  
  var request = $.ajax({
      url:$('#frmMantEstablecimiento').attr("action"),
      type:$('#frmMantEstablecimiento').attr("method"),
      data:$('#frmMantEstablecimiento').serialize(),
      error: function(){
        alert('Error, No se puede autenticar por error');
      }
  });
  request.done(function( respuesta ) {
      
          Vtitle = 'Datos Guardados correctamente';
          Vtype = 'success';
          sweetalert(Vtitle,Vtype);
          limpiarFormEstable(); 
          var v_ccliente = $('#mhdnIdClie').val();
          listEstable(v_ccliente);   
          
          $('#cardRegestable').hide();
          $('#cardListestable').show();
  });
});

/**/
  (function($, window) {
    'use strict';

    var MultiModal = function(element) {
        this.$element = $(element);
        this.modalCount = 0;
    };

    MultiModal.BASE_ZINDEX = 1040;

    MultiModal.prototype.show = function(target) {
        var that = this;
        var $target = $(target);
        var modalIndex = that.modalCount++;

        $target.css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20) + 10);

        window.setTimeout(function() {
            if(modalIndex > 0)
                $('.modal-backdrop').not(':first').addClass('hidden');

            that.adjustBackdrop();
        });
    };

    MultiModal.prototype.hidden = function(target) {
        this.modalCount--;

        if(this.modalCount) {
          this.adjustBackdrop();
            $('body').addClass('modal-open');
        }
    };

    MultiModal.prototype.adjustBackdrop = function() {
        var modalIndex = this.modalCount - 1;
        $('.modal-backdrop:first').css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20));
    };

    function Plugin(method, target) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('multi-modal-plugin');

            if(!data)
                $this.data('multi-modal-plugin', (data = new MultiModal(this)));

            if(method)
                data[method](target);
        });
    }

    $.fn.multiModal = Plugin;
    $.fn.multiModal.Constructor = MultiModal;

    $(document).on('show.bs.modal', function(e) {
        $(document).multiModal('show', e.target);
    });

    $(document).on('hidden.bs.modal', function(e) {
        $(document).multiModal('hidden', e.target);
    });
  }(jQuery, window));
