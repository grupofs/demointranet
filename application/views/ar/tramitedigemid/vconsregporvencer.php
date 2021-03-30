<?php
    $idusuario = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-address-book"></i> Registros por Vencer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Asuntos Regulatorios</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">  
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><b>BUSQUEDA</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <form class="form-horizontal" id="frmexceltramar" name="frmexceltramar" action="<?= base_url('ar/tramites/cexcelExport/excelregporvencer')?>" method="POST" enctype="multipart/form-data" role="form">  
            
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusuario ?>">
                <div class="row">    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cliente a Ver Registros</label>
                            <select class="form-control select2bs4" id="cbocliente" name="cbocliente" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>  
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>NSO / Descripcion SAP / Nombre Producto / Codigo SAP</label>
                            <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder="...">
                        </div>
                    </div>  
                    <div class="col-sm-4">
                        <label>&nbsp;&nbsp;</label> 
                        <!-- radio -->
                        <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="rdPV180" value="180" name="rporvencer" checked>
                            <label for="rdPV180">
                                6 meses
                            </label>
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="rdPV360" value="360" name="rporvencer">
                            <label for="rdPV360">
                                1 año
                            </label>
                        </div>
                        </div>
                    </div>
                </div>
            </div>                
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <!--<div class="col-md-2"> 
                        <div id="console-event"></div>                   
                        <input type="checkbox" name="swVigencia" id="swVigencia" data-toggle="toggle" checked data-bootstrap-switch  data-on-text="Activos" data-off-text="Inactivos">
                    </div>-->
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                            <button type="button" class="btn btn-outline-info" id="btnNuevo" data-toggle="modal" data-target="#modalCreaPropu"><i class="fas fa-plus"></i> Crear Nuevo</button>
                            <button type="submit" class="btn btn-info" id="btnexcel" disabled="true"><i class="fa fw fa-file-excel-o"></i> Exportar Excel</button>  
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE REGISTROS POR VENCER</b></h3>
                    </div>
                
                    <div class="card-body">
                        <table id="tblListRegporvencer" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Código</th>
                                <th>Descripcion SAP</th>
                                <th>Nombre del Producto</th>
                                <th>Modelo / Tono / Variedades / Sub-Marca</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Fabricante(s)</th>
                                <th>País(es)</th>
                                <th>NSO</th>
                                <th>F. Vence</th>
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
</section>
<!-- /.Main content -->