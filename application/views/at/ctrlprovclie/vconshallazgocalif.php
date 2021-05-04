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
        <h1 class="m-0 text-dark">Consolidado Hallazgos según Calificación</h1>
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
<section class="content" style="background-color: #E0F4ED;">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">            
                        <ul class="nav nav-tabs" id="tabhallazgocalif" style="background-color: #28a745;" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #000000;" id="tabhallazgocalif-list-tab" data-toggle="pill" href="#tabhallazgocalif-list" role="tab" aria-controls="tabhallazgocalif-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #000000;" id="tabhallazgocalif-det-tab" data-toggle="pill" href="#tabhallazgocalif-det" role="tab" aria-controls="tabhallazgocalif-det" aria-selected="false">DETALLE</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabhallazgocalif-tabContent">
                            <div class="tab-pane fade show active" id="tabhallazgocalif-list" role="tabpanel" aria-labelledby="tabhallazgocalif-list-tab">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">BUSQUEDA</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>                        
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
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Proveedor</label>
                                                    <select class="form-control select2bs4" id="cboProveedor" name="cboProveedor" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>               
                                        </div>                 
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Área del Cliente</label>
                                                    <select class="form-control select2bs4" id="cboareaclie" name="cboareaclie" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Calificación</label>
                                                    <select class="form-control select2bs4" id="cbocalificacion" name="cbocalificacion" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
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
                                </div> 
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Listado de Hallazgos por Calificación</h3>
                                            </div>                                       
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tblconshallazgocalif" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Calificación</th>
                                                        <th>Categoria</th>
                                                        <th>1. No conformidad (NC)</th>
                                                        <th>2. No conformidad reiterativa (NCR)</th>
                                                        <th>3. Observacion (OB)</th>
                                                        <th>4. Observacion reiterativa (OBR)</th>
                                                        <th>5. Oportunidades de mejora (OM)</th>
                                                        <th>6. Observacion levantada (OL)</th>
                                                        <th>7. No conformidad levantada (NCL)</th>
                                                        <th>8. Observacion parc. Levantada (OPL)</th>
                                                        <th>9. No conform. Parc. Levantada (NCPL)</th>
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
                            <div class="tab-pane fade" id="tabhallazgocalif-det" role="tabpanel" aria-labelledby="tabhallazgocalif-det-tab">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">BUSQUEDA</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>                        
                                    <div class="card-body">                                        
                                        <div class="row">                    
                                        </div>   
                                    </div>
                                    <div class="card-footer justify-content-between" style="background-color: #E0F4ED;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
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
                                                <h3 class="card-title">Detalle de Hallazgos por calificación</h3>
                                            </div>                                       
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tbldetseguiaacc" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Proveedor</th>
                                                        <th>Establecimiento / Maquilador</th>
                                                        <th>Linea de Proceso</th>
                                                        <th>Nro. de Informe</th>
                                                        <th>Fecha Servicio</th>
                                                        <th>No conformidad (NC)</th>
                                                        <th>No conformidad reiterativa (NCR)</th>
                                                        <th>Observacion (OB)</th>
                                                        <th>Observacion reiterativa (OBR)</th>
                                                        <th>Oportunidades de mejora (OM)</th>
                                                        <th>Observacion levantada (OL)</th>
                                                        <th>No conformidad levantada (NCL)</th>
                                                        <th>Observacion parc. Levantada (OPL)</th>
                                                        <th>No conform. Parc. Levantada (NCPL)</th>
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
                        </div>
                    </div>                
                </div>
            </div>
        </div>     
    </div>
</section>
<!-- /.Main content -->

