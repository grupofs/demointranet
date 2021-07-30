<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>
    .fa-file-image:before {
        content: "\f0c6";
    }   
    .img-perfil{
        width: 200px !important;
    }
    .btn-file{
        display: none;
    }
    #file-input{
        display: none;
    }
    .text-center img{     
        cursor: pointer; 
        text-align: center;       
    }
    .text-center:hover img{
        opacity: 0.6;        
        filter:brightness(0.4);
    }
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-city"></i> MANTENIMIENTO CLIENTES</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Gestion Procesos Termicos</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content" id="contenedorBusqueda">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">            
                        <ul class="nav nav-tabs" id="tabptcliente" style="background-color: #28a745;" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #000000;" id="tabptcliente-list-tab" data-toggle="pill" href="#tabptcliente-list" role="tab" aria-controls="tabptcliente-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #000000;" id="tabptcliente-reg-tab" data-toggle="pill" href="#tabptcliente-reg" role="tab" aria-controls="tabptcliente-reg" aria-selected="false">REGISTRO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabptcliente-tabContent">
                            <div class="tab-pane fade show active" id="tabptcliente-list" role="tabpanel" aria-labelledby="tabptcliente-list-tab">                            
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>BUSCAR CLIENTES - PT</b></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cliente - Nro Documento</label>
                                                    <input id="txtCliente" name="txtCliente" type="text" class="form-control" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>  
                                    </div>                
                                                
                                    <div class="card-footer justify-content-between"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                                                    <button type="button" class="btn btn-outline-info" id="btnNuevo"><i class="fas fa-plus"></i> Crear Nuevo</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <h3 class="card-title"><b>LISTADO DE CLIENTES - PT</b></h3>
                                            </div>
                                        
                                            <div class="card-body">
                                                <table id="tblListPtcliente" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Cliente</th>
                                                        <th>Dirección</th>
                                                        <th>Telefono</th>
                                                        <th>Representante Legal</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabptcliente-reg" role="tabpanel" aria-labelledby="tabptcliente-reg-tab">
                                
                                    <div class="row">
                                        <div class="col-12">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border text-primary">Datos Cliente</legend>
                                            <div class="card card-success">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                    <form class="form-horizontal" id="frmMantptClie" action="<?= base_url('pt/cptcliente/setptcliente')?>" method="POST" enctype="multipart/form-data" role="form">
                                                        
                                                        <input type="hidden" id="hdnIdptclie" name="hdnIdptclie"> <!-- ID -->
                                                        <input type="hidden" id="hdnAccionptclie" name="hdnAccionptclie">
                                                        <input type="hidden" class="form-control" name="utxtlogo" id="utxtlogo"> 
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="text-info">Tipo Doc.</div>
                                                                <div>  
                                                                    <select id="cboTipoDoc" name="cboTipoDoc" class="form-control" style="width: 100%;">
                                                                        <option value = "">Elige</option>
                                                                        <option value = "R">RUC</option>
                                                                        <option value = "O">OTROS</option>
                                                                    </select>
                                                                 </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="text-info">Nro documento</div>
                                                                <div>  
                                                                    <input type="text" class="form-control" name="txtnrodoc" id="txtnrodoc">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="text-info">Razón Social</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtrazonsocial" id="txtrazonsocial">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="text-info">Pais</div>
                                                                <div>
                                                                    <select id="cboPais" name="cboPais" class="form-control select2bs4" style="width: 100%;">
                                                                        <option value = "">Cargando...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3" id="boxCiudad">
                                                                <div class="text-info">Ciudad</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtCiudad" id="txtCiudad">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3" id="boxEstado">
                                                                <div class="text-info">Estado / Region / Provincia</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtEstado" id="txtEstado">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="boxUbigeo">
                                                                <div class="text-info">Departamento / Distrito / Provincia</div>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" id="mtxtUbigeo" name="mtxtUbigeo" class="form-control">
                                                                    <span class="input-group-append">
                                                                        <button type="button" id="btnBuscarUbigeo" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                                                                    </span>
                                                                </div>
                                                                <input type="hidden" id="hdnidubigeo" name="hdnidubigeo">
                                                            </div>
                                                            <div class="col-md-3" id="boxEstado">
                                                                <div class="text-info">Codigo Postal / ZIP</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtCodigopostal" id="txtCodigopostal">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="text-info">Dirección Domicilio Fiscal</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtDireccion" id="txtDireccion">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div style="border-top: 1px solid #ccc; padding-top: 10px;"> 
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <h4><i class="fas fa-user-tie"></i> Datos <small> Representante Legal</small></h4>
                                                            </div> 
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="text-info">Representante Legal</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtRepresentante" id="txtRepresentante">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="text-info">Cargo Rep.</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtCargorep" id="txtCargorep">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="text-info">Email Rep.</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtEmailrep" id="txtEmailrep">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="text-info">Telefono</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtTelefono" id="txtTelefono">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="text-info">Pagina Web</div>
                                                                <div>
                                                                    <input type="text" class="form-control" name="txtWeb" id="txtWeb">
                                                                </div>
                                                            </div>
                                                        </div>       
                                                        </div>
                                                    </form>
                                                    </div>
                                                        <br>
                                                        <div style="border-top: 1px solid #ccc; padding-top: 10px;"> 
                                                        <form id="frmFileinputLogoclie" name="frmFileinputLogoclie" method="post" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="text-info">Logo del Cliente</div>
                                                                <div class="text-center">
                                                                        <input type="hidden" id="hdnCCliente" name="hdnCCliente">  
                                                                        <label for="file-input"> 
                                                                            <img  id="image_previa" alt="Foto de Cliente" class="profile-user-img img-fluid img-circle img-perfil" style="border: 3px solid #adb5bd; padding: 3px;" title="Click para cambiar de foto ">
                                                                        </label>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-6" style="display: none;" id="divlogo">
                                                                <div class="text-info">Vista Previa de Logo</div>
                                                                <div class="text-center">
                                                                    <div class="kv-avatar">
                                                                        <div class="file-loading">
                                                                            <input id="file-input" name="file-input" type="file" onchange="registrar_imagen()" ref="image" style="display: none;"/> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        </form>  
                                                        <!--<div class="row">
                                                            <div class="col-md-6" style="display: none;" id="divlogo">
                                                                <div class="text-info"></div>
                                                                <div>
                                                                    <input type="hidden" class="form-control" name="utxtlogo" id="utxtlogo">
                                                                    <img id="image_previa" src="" width="150" height="100" class="img-circle">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="kv-avatar">
                                                                    <div class="file-loading">
                                                                        <input id="logo_image" name="logo_image" type="file" onchange="registrar_imagen()">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->       
                                                        </div>
                                                </div>
                                                <div class="card-footer"> 
                                                    <div class="row">
                                                        <div class="col-md-12 text-right"> 
                                                            <button type="submit" form="frmMantptClie" class="btn btn-success" id="btnGrabar"><i class="fas fa-save"></i> Grabar</button>    
                                                            <button type="button" class="btn btn-secondary" id="btnRetornar"><i class="fas fa-undo-alt"></i> Retornar</button>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </fieldset>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Main content -->

<!-- Reg. Establecimiento -->
<section class="content" id="contenedorRegestable" style="display: none" >
    <div class="container-fluid">
        <?php $this->load->view('pt/gestion/formulario_regestable'); ?>
    </div>
</section>
<!-- /.Reg. Establecimiento -->

<!-- /.modal-ubigeo --> 
<div class="modal fade" id="modalUbigeo" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="frmUbigeo" name="frmUbigeo" action="" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Seleccionar Ubigeo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">                                  
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-info">Departamento</div>
                        <div>                            
                            <select class="form-control select2bs4" id="cboDepa" name="cboDepa" style="width: 100%;">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>  
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Provincia</div>
                        <div>
                            <select class="form-control select2bs4" id="cboProv" name="cboProv">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>   
                </div>                
            </div>
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Distrito</div>
                        <div>
                            <select class="form-control select2bs4" id="cboDist" name="cboDist">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>   
                </div>                
            </div>             
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button id="btnSelUbigeo" type="button" class="btn btn-success"><i class="fa fa-save"></i> Seleccionar</button>
            <button id="btncerrarUbigeo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- Script Generales -->
<script type="text/javascript">
    var baseurl = "<?php echo base_url();?>"; 
</script>