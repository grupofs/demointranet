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
                                    <form class="form-horizontal" id="frmexcelconshallazgocalif" name="frmexcelconshallazgocalif" action="<?= base_url('at/ctrlprovclie/cctrlprovclieExport/excelconshallazgocalif')?>" method="POST" enctype="multipart/form-data" role="form">
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
                                    </form>
                                </div> 
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <h3 class="card-title"><b>LISTADO DE HALLAZGOS POR CALIFICACIÓN</b></h3>
                                            </div>                                       
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tblconshallazgocalif" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Calificación</th>
                                                        <th>Categoria</th>
                                                        <th>Cant. Líneas</th>
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
                                    <form class="form-horizontal" id="frmexcelconsdethallazgocalif" name="frmexcelconsdethallazgocalif" action="<?= base_url('at/ctrlprovclie/cctrlprovclieExport/excelconsdethallazgocalif')?>" method="POST" enctype="multipart/form-data" role="form">
                                    <div class="card-body"> 
                                        <input type="hidden" class="form-control" id="hddnmdetccliente" name="hddnmdetccliente">
                                        <input type="hidden" class="form-control" id="hddnmdetanio" name="hddnmdetanio">
                                        <input type="hidden" class="form-control" id="hddnmdetmes" name="hddnmdetmes">  
                                        <input type="hidden" class="form-control" id="hddnmdetfini" name="hddnmdetfini"> 
                                        <input type="hidden" class="form-control" id="hddnmdetffin" name="hddnmdetffin">  
                                        <input type="hidden" class="form-control" id="hddnmdetcclienteprov" name="hddnmdetcclienteprov">
                                        <input type="hidden" class="form-control" id="hddnmdetarea" name="hddnmdetarea">
                                        <input type="hidden" class="form-control" id="hddnmdetdcalificacion" name="hddnmdetdcalificacion">                                      
                                        <div class="row">                    
                                        </div>   
                                    </div>
                                    <div class="card-footer justify-content-between" style="background-color: #E0F4ED;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
                                                    <button type="submit" class="btn btn-info" id="btnexcelDet" disabled="true"><i class="fa fw fa-file-excel-o"></i> Exportar Excel</button>  
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
                                                <h3 class="card-title">Detalle de Hallazgos por calificación</h3>
                                            </div>                                       
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tbldethallazgocalif" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
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


<!-- /.Modal-Listado-AACC --> 
<div class="modal fade" id="modalResumen" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg fullModal">
    <div class="modal-content" id="contenedorListaresumen">      

        <div class="modal-header text-center bg-lightblue">
            <h4 class="modal-title w-100 font-weight-bold">Resumen de Hallazgos Según fecha de Inspección</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">         
            <div class="row">
                <div class="col-md-6"> 
                    <div class="text-info">Empresa</div>
                    <div>    
                        <input type="text" name="mtxtempresa" id="mtxtempresa" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="text-info">Dir. Inspección</div>
                    <div>    
                        <input type="text" name="mtxtdirinspeccion" id="mtxtdirinspeccion" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="col-md-6"> 
                    <div class="text-info">Línea</div>
                    <div>    
                        <input type="text" name="mtxtlinea" id="mtxtlinea" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="text-info">Puntaje (%)</div>
                    <div>    
                        <input type="text" name="mtxtpuntaje" id="mtxtpuntaje" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="text-info">Calificación</div>
                    <div>    
                        <input type="text" name="mtxtcalificacion" id="mtxtcalificacion" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="text-info">Nro Informe</div>
                    <div>    
                        <input type="text" name="mtxtnroinforme" id="mtxtnroinforme" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-1"> 
                    <div class="text-info">Estado Lic. Funcionamiento</div>
                    <div>    
                        <input type="text" name="mtxtlicfunestado" id="mtxtlicfunestado" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="text-info">Nro. Lic. <br>Funcionamiento</div>
                    <div>    
                        <input type="text" name="mtxtlicfunnro" id="mtxtlicfunnro" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-3"> 
                    <div class="text-info">&nbsp;<br>Municipalidad</div>
                    <div>    
                        <input type="text" name="mtxtmunicipalidad" id="mtxtmunicipalidad" class="form-control" disabled><!-- ID -->
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="text-info">&nbsp;<br>Observación</div>
                    <div>    
                        <textarea name="mtxtobservacion" id="mtxtobservacion" class="form-control" rows="2" disabled></textarea><!-- ID -->
                    </div>
                </div>
            </div> 
            <br>
            <div class="row"> 
                <div class="col-6" style="overflow-x: scroll;">
                    <table id="tbldetresumen" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Detalle del Resumen de Inspección</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-6" style="overflow-x: scroll;">
                    <table id="tblreqexcluye" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Requisitos Excluyentes</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row"> 
                <div class="col-8" style="overflow-x: scroll;">
                    <table id="tblproducto" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Peligros Identificados por Tottus</th>
                            <th>Peligros Identificados por el Proveedor</th>
                            <th>Peligros Adicionales Identificados en la Inspección</th>
                            <th>Observación</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-4" style="overflow-x: scroll;">
                    <table id="tblcriterio" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Criterios</th>
                            <th>Nro de Hallazgos</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">  
            <button type="reset" class="btn btn-default" id="mbtnCerrar" data-dismiss="modal">Cerrar</button>
        </div>
                
    </div>
  </div>
</div> 
<!-- /.Modal-->

