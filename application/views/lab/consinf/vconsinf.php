<?php
    $idusu = $this -> session -> userdata('s_idusuario');
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">CONSULTA LABORATORIO</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Laboratorio</li>
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
        <form class="form-horizontal" id="frmbuscahomo" name="frmbuscahomo" action="<?= base_url('pt/cpropuesta/excelpropu')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <div class="card-header">
                <h3 class="card-title">BUSQUEDA</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
          
            <div class="card-body">
                <input type="hidden" name="mtxtidusupropu" class="form-control" id="mtxtidusupropu" value="<?php echo $idusu ?>"></div>                
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <div class="col-md-2"> 
                        <div id="console-event"></div>                   
                        <input type="checkbox" name="swVigencia" id="swVigencia" data-toggle="toggle" checked data-bootstrap-switch  data-on-text="Activos" data-off-text="Inactivos">
                    </div>
                    <div class="col-md-10">
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
                        <h3 class="card-title">Listado de Propuestas</h3>
                    </div>
                
                    <div class="card-body">
                        <table id="tblListPropuesta" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>N° Propuesta</th>
                                <th>Cliente</th>
                                <th>Detalle Propuesta</th>
                                <th>Costo</th>
                                <th>Fecha</th>
                                <th>Establecimiento</th>
                                <th></th>
                                <th></th>
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