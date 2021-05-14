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
        <h1 class="m-0 text-dark">Consulta de Licencias de Funcionamiento</h1>
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
                <h3 class="card-title">BUSQUEDA</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>   

            <form class="form-horizontal" id="frmconslicenciaprov" name="frmconslicenciaprov" action="<?= base_url('at/ctrlprovclie/cctrlprovclieExport/excelconslicprov')?>" method="POST" enctype="multipart/form-data" role="form">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusu ?>">
                    <input type="hidden" class="form-control" id="hdnCUsuario" name="hdnCUsuario" value="<?php echo $cusu ?>">
                    <input type="hidden" class="form-control" id="hdnCCliente" name="hdnCCliente" value="<?php echo $cclie ?>">
                </div>
                                        
                <div class="row">      
                    <div class="col-md-3">
                        <label>&nbsp;&nbsp;</label> 
                        <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="rdPeriodo" name="rFbuscar" checked>
                            <label for="rdPeriodo">
                                Por Periodo
                            </label>
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="rdFechas" name="rFbuscar" >
                            <label for="rdFechas">
                                Entre Fechas
                            </label>
                        </div>
                        </div>
                        <input type="hidden" class="form-control" id="hrdbuscar" name="hrdbuscar" value="P">
                    </div>   
                    <div class="col-md-2">
                        <div class="form-group" id="divAnio"> 
                            <label>Año</label>
                            <select class="form-control" id="cboAnio" name="cboAnio" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                        <div class="form-group" id="divDesde">    
                            <label>Desde</label>                      
                            <div class="input-group date" id="txtFDesde" data-target-input="nearest">
                                <input type="text" id="txtFIni" name="txtFIni" class="form-control datetimepicker-input" data-target="#txtFDesde" />
                                <div class="input-group-append" data-target="#txtFDesde" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" id="divMes">
                            <label>Mes</label>
                            <select class="form-control" id="cboMes" name="cboMes" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                        <div class="form-group" id="divHasta">       
                            <label>Hasta</label>                      
                            <div class="input-group date" id="txtFHasta" data-target-input="nearest">
                                <input type="text" id="txtFFin" name="txtFFin" class="form-control datetimepicker-input" data-target="#txtFHasta"/>
                                <div class="input-group-append" data-target="#txtFHasta" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>   
            </div>
            <div class="card-footer justify-content-between" style="background-color: #E0F4ED;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>
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
                        <h3 class="card-title"><b>LISTADO LICENCIA DE FUNCIONAMIENTO</b></h3>
                    </div>                                       
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="tblconslicfunciona" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Licencia de Funcionamiento</th>
                                <th>Nro. de Inspecciones</th>
                                <th>% de Inspecciones</th>
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


<!-- /.Modal-Listado-Proveedores --> 
<div class="modal fade" id="modalDet" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg fullModal">
    <div class="modal-content" id="contenedorListdet">      

        <div class="modal-header text-center bg-lightblue">
            <h4 class="modal-title w-100 font-weight-bold">Detalle</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form class="form-horizontal" id="frmconsdetlicenciaprov" name="frmconsdetlicenciaprov" action="<?= base_url('at/ctrlprovclie/cctrlprovclieExport/excelconsdetlicprov')?>" method="POST" enctype="multipart/form-data" role="form">
        <div class="modal-body">
            <input type="hidden" class="form-control" id="hddnmdetccliente" name="hddnmdetccliente">
            <input type="hidden" class="form-control" id="hddnmdetanio" name="hddnmdetanio">
            <input type="hidden" class="form-control" id="hddnmdetmes" name="hddnmdetmes">
            <input type="hidden" class="form-control" id="hddnmdetfini" name="hddnmdetfini"> 
            <input type="hidden" class="form-control" id="hddnmdetffin" name="hddnmdetffin"> 
            <input type="hidden" class="form-control" id="hddnmdetestado" name="hddnmdetestado">       
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <button type="reset" class="btn btn-secondary" id="btnRetornarLista" data-dismiss="modal"><i class="fas fa-undo-alt"></i> Retornar</button>
                        <button type="submit" class="btn btn-info" id="btnexcelDet" disabled="true"><i class="fa fw fa-file-excel-o"></i> Exportar Excel</button>  
                    </div>
                </div>
            </div>        
            <div class="row"> 
                <div class="col-12" style="overflow-x: scroll;">
                    <table id="tbllistlicprovdet" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Proveedor - (Establecimiento/Maquilador)</th>
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
        </form>

        <div class="modal-footer">  

        </div>
                
    </div>
  </div>
</div> 
<!-- /.Modal-->
