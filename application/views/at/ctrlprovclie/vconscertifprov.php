<?php
    $idusu  = $this -> session -> userdata('s_idusuario');
    $cusu   = $this -> session -> userdata('s_cusuario');
    $cclie  = $this -> session -> userdata('s_ccliente');  
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Consulta Proveedores con Certificaciones</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>cpanel"> <i class="fas fa-tachometer-alt"></i>Home</a></li>
          <li class="breadcrumb-item active">Ctrl. Prov.</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">  
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><b>BUSQUEDA</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
          
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusu ?>">
                <input type="hidden" class="form-control" id="hdnCUsuario" name="hdnCUsuario" value="<?php echo $cusu ?>">
                <input type="hidden" class="form-control" id="hdnCCliente" name="hdnCCliente" value="<?php echo $cclie ?>">

                <div class="row">   
                    <div class="col-md-2">
                        <div class="form-group"> 
                            <label>Año</label>
                            <select class="form-control" id="cboAnio" name="cboAnio" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Mes</label>
                            <select class="form-control" id="cboMes" name="cboMes" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>              
                </div>      
            </div>             
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
                            <button type="submit" class="btn btn-info" id="btnexcel" disabled="true"><i class="fa fw fa-file-excel-o"></i> Exportar Excel</button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO PROVEEDORES CON CERTIFICACIONES</b></h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="tblconscertifprov" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Certificadora</th>
                                <th>Certificación</th>
                                <th>No Aplica</th>
                                <th>No Tiene</th>
                                <th>Si Tiene</th>
                                <th>Convalidado</th>
                                <th>Total</th>
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

<!-- /.Modal-Listado-AACC --> 
<div class="modal fade" id="modalDet" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg fullModal">
    <div class="modal-content" id="contenedorListdet">      

        <div class="modal-header text-center bg-lightblue">
            <h4 class="modal-title w-100 font-weight-bold">Detalle</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">         
            <div class="row"> 
                <div class="col-12" style="overflow-x: scroll;">
                    <table id="tbllistcertidet" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Proveedor</th>
                            <th>Maquilador</th>
                            <th>Establecimiento</th>
                            <th>Linea de Proceso</th>
                            <th>Dir. Establecimiento</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">  

        </div>
                
    </div>
  </div>
</div> 
<!-- /.Modal-->