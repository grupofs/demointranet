<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $cusu = $this -> session -> userdata('s_cusuario');
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">INFORME INACAL</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main"><i class="fas fa-tachometer-alt"></i>Home</a></li>
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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">BUSQUEDA</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
          
            <div class="card-body">
            <form class="form-horizontal" id="frmconsseguiaacc" name="frmconsseguiaacc" action="<?= base_url('at/ctrlprovclie/cctrlprovclieExport/excelconsseguiaacc')?>" method="POST" enctype="multipart/form-data" role="form">
                <input type="hidden" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusu ?>">
                <input type="hidden" id="hdnCUsuario" name="hdnCUsuario" value="<?php echo $cusu ?>">
                <div class="row"> 
                    <div class="col-md-5">
                        <div class="form-group clearfix text-left">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="rdPeriodo" name="rFbuscar" checked>
                                <label for="rdPeriodo">Por Periodo</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="rdFechas" name="rFbuscar" >
                                <label for="rdFechas">Entre Fechas</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="rdSemestre" name="rFbuscar" >
                                <label for="rdSemestre">Semestre</label>
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
                        <div class="form-group" id="divSemestre"> 
                            <label>Semestre</label>
                            <select class="form-control" id="cboSem" name="cboSem" style="width: 100%;">
                                <option value = 0 selected="selected">Todos</option>
                                <option value = 1> 1er Semestre</option>
                                <option value = 2> 2do Semestre</option>
                            </select>
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
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group"> 
                            <div class="checkbox"><label>
                                <div class="d-inline">
                                    <input type="radio" id="rdBInf" value="%" name="rBDesc" checked/> <b>Nro. Informe</b>
                                </div>
                                &nbsp;&nbsp;
                                <div class="d-inline">
                                    <input type="radio" id="rdBOT" value="%" name="rBDesc"/> <b>Nro. OT</b>
                                </div>
                                &nbsp;&nbsp;
                                <div class="d-inline">
                                    <input type="radio" id="rdBCliente" value="%" name="rBDesc"/> <b>Cliente</b>
                                </div>
                            </label></div>
                            <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion">
                        </div>
                    </div>      
                </div>  
            </form>
            </div>                
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Listado </h3>
                    </div>
                
                    <div class="card-body">
                        <table id="tblListinfinacal" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Nro. Informe</th>
                                <th>Fecha de Emisión</th>
                                <th>Matriz, producto o material</th>
                                <th>Disciplina</th>
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