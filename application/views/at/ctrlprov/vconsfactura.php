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
        <h1 class="m-0 text-dark"><i class="fas fa-address-book"></i> CUADRO DE FACTURACION</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Inspeccion Proveedores</li>
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
          
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusuario ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Clientes</label>
                            <select class="form-control select2bs4" id="cboclieserv" name="cboclieserv" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Proveedor</label>
                            <select class="form-control select2bs4" id="cboprovxclie" name="cboprovxclie" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>      
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Año</label>
                            <select class="form-control" id="mcboanio" name="mcboanio" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>         
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Mes</label>                           
                            <select class="form-control" id="mcbomes" name="mcbomes" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div> 
                </div>  
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control select2bs4" id="cboestado" name="cboestado" multiple="multiple" style="width: 100%;">                                
                                <option value="" selected="selected">Elejir</option>
                                <option value="032">CONCLUIDO</option>
                                <option value="031">EN PROCESO</option>
                                <option value="029">INSPECTOR ASIGNADO</option>
                                <option value="515">TRUNCO</option>
                            </select>
                        </div>
                    </div>   
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Monto</label>
                            <input type="text" class="form-control" id="txtmonto" name="txtmonto">                               
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
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE FACTURAS</b></h3>
                    </div>
                
                    <div class="card-body">
                        <table id="tblCdroFactura" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Cliente</th>
                                <th>Proveedor</th>
                                <th>N° RUC</th>
                                <th>Area Cliente</th>
                                <th>Importe S/. Total (sin IGV)</th>
                                <th>Mes Facturacion</th>
                                <th>Direccion de Planta</th>
                                <th>Linea Inspeccion</th>
                                <th>Fecha Inspeccion</th>
                                <th>N° Informe</th>
                                <th>Estado</th>
                                <th>Inspector</th>
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