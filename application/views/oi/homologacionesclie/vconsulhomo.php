<?php
    $idusu  = $this -> session -> userdata('s_idusuario');
    $cusu   = $this -> session -> userdata('s_cusuario');
    $cclie  = $this -> session -> userdata('s_ccliente'); 
?>
<style>
    table.dataTable tbody tr.selected{
        background-color: #ffffff !important;
    }
    table.dataTable tbody tr.details{
        background-color: #B0BED9 !important;
    }
    table.dataTable tbody tr:hover{
        background-color: #ffffff !important;
    }
    
    
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-6">
        <h1 class="m-0 text-dark">CONSULTA DE HOMOLOGACIONES</h1>
      </div>
      <div class="col-6">
        <ol class="breadcrumb float-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Homologación</li>
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
                <form class="form-horizontal" id="frmexcellisthomo" name="frmexcellisthomo" action="<?= base_url('oi/homologacionesclie/cconsulhomo/getexcelhomologaciones')?>" method="POST" enctype="multipart/form-data" role="form">  
                <input type="hidden" class="form-control" id="hdnCCliente" name="hdnCCliente" value="<?php echo $cclie ?>">
                <div class="row">  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Proveedor :</label>
                            <select class="form-control select2bs4" id="cboProveedor" name="cboProveedor" style="width: 100%;">
                                <option value="%" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>   
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado :</label>
                            <select class="select2bs4" id="cboEstado" name="cboEstado[]" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;">
                                <option value="%" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">    
                        <div class="checkbox"><label>
                            <input type="checkbox" id="chkFreg" /> <b>Fecha Registro :: Del</b>
                        </label></div>                        
                        <div class="input-group date" id="txtFregDesde" data-target-input="nearest" >
                            <input type="text" id="txtFregIni" name="txtFregIni" class="form-control datetimepicker-input" data-target="#txtFregDesde" disabled/>
                            <div class="input-group-append" data-target="#txtFregDesde" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">      
                        <label>Hasta</label>                      
                        <div class="input-group date" id="txtFregHasta" data-target-input="nearest">
                            <input type="text" id="txtFregFin" name="txtFregFin" class="form-control datetimepicker-input" data-target="#txtFregHasta" disabled/>
                            <div class="input-group-append" data-target="#txtFregHasta" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>                
                </div>                 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Categoria / Tipo Proveedor :</label>
                            <select class="form-control select2bs4" id="cboTiporoveedor" name="cboTiporoveedor" style="width: 100%;">
                                <option value="%" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Producto :</label>
                            <input type="text" class="form-control" id="txtProducto" name="txtProducto">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Marca :</label>
                            <input type="text" class="form-control" id="txtMarca" name="txtMarca">
                        </div>
                    </div>
                </div>
                <div class="row">  
                    <div class="col-md-3">    
                        <div class="checkbox"><label>
                            <input type="checkbox" id="chkFini" /> <b>Fecha Inicio :: Del</b>
                        </label></div>                        
                        <div class="input-group date" id="txtFiniDesde" data-target-input="nearest" >
                            <input type="text" id="txtFiniIni" name="txtFiniIni" class="form-control datetimepicker-input" data-target="#txtFiniDesde" disabled/>
                            <div class="input-group-append" data-target="#txtFiniDesde" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">      
                        <label>Hasta</label>                      
                        <div class="input-group date" id="txtFiniHasta" data-target-input="nearest">
                            <input type="text" id="txtFiniFin" name="txtFiniFin" class="form-control datetimepicker-input" data-target="#txtFiniHasta" disabled/>
                            <div class="input-group-append" data-target="#txtFiniHasta" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-3">    
                        <div class="checkbox"><label>
                            <input type="checkbox" id="chkFter" /> <b>Fecha Termino :: Del</b>
                        </label></div>                        
                        <div class="input-group date" id="txtFterDesde" data-target-input="nearest" >
                            <input type="text" id="txtFterIni" name="txtFterIni" class="form-control datetimepicker-input" data-target="#txtFterDesde" disabled/>
                            <div class="input-group-append" data-target="#txtFterDesde" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">      
                        <label>Hasta</label>                      
                        <div class="input-group date" id="txtFterHasta" data-target-input="nearest">
                            <input type="text" id="txtFterFin" name="txtFterFin" class="form-control datetimepicker-input" data-target="#txtFterHasta" disabled/>
                            <div class="input-group-append" data-target="#txtFterHasta" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>              
                </div>                
                </form>
            </div>             
                        
            <div class="card-footer justify-content-between" style="background-color: #D4EAFC;"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
                            <button type="submit" form="frmexcellisthomo" class="btn btn-info" id="btnexcel" disabled="true"><i class="far fa-file-excel"></i> Exportar Excel</button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE HOMOLOGACIONES</b></h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="tblhomologaciones" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Fecha de Registro</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de termino</th>
                                <th>Estado</th>
                                <th>Categoria / Tipo de Proveedor</th>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th>Marca</th>
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