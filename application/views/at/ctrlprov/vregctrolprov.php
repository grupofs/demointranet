<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>

    tab {
        display: inline-block; 
        margin-left: 100px; 
    }
    tr.subgroup,
    tr.subgroup:hover {
        background-color: #F2F2F2 !important;
        /* color: blue; */
        font-weight: bold;
    }
    .group{
        background-color: #CDD1DB !important;
            font-size:15px;
            color:#000000 !important;
            opacity:0.7;
    }
    .subgroup{
        cursor: pointer;
    }
    td.subgroup {
        border-top: double !important;
    }
    td.expand {
        border-bottom: double !important;
    }
    .modal-lg{
        max-width: 1000px !important;
    }

    .dataTables_scrollBody thead{
        visibility:hidden;
    }
    .hidden {
        display: none;
    }
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">CTRL. PROVEEDORES</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>cprincipal/principal">Home</a></li>
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
                        <ul class="nav nav-tabs" id="tabctrlprov" style="background-color: #28a745;" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #000000;" id="tabctrlprov-list-tab" data-toggle="pill" href="#tabctrlprov-list" role="tab" aria-controls="tabctrlprov-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #000000;" id="tabctrlprov-det-tab" data-toggle="pill" href="#tabctrlprov-det" role="tab" aria-controls="tabctrlprov-det" aria-selected="false">PROGRAMACION</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabctrlprov-tabContent">
                            <div class="tab-pane fade show active" id="tabctrlprov-list" role="tabpanel" aria-labelledby="tabctrlprov-list-tab">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">BUSQUEDA</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>                        
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Clientes</label>
                                                    <select class="form-control select2bs4" id="cboclieserv" name="cboclieserv" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">    
                                                <div class="checkbox"><label>
                                                    <input type="checkbox" id="chkFreg" /> <b>Fecha Registro :: Del</b>
                                                </label></div>                        
                                                <div class="input-group date" id="txtFDesde" data-target-input="nearest" >
                                                    <input type="text" id="txtFIni" name="txtFIni" class="form-control datetimepicker-input" data-target="#txtFDesde" disabled/>
                                                    <div class="input-group-append" data-target="#txtFDesde" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">      
                                                <label>Hasta</label>                      
                                                <div class="input-group date" id="txtFHasta" data-target-input="nearest">
                                                    <input type="text" id="txtFFin" name="txtFFin" class="form-control datetimepicker-input" data-target="#txtFHasta" disabled/>
                                                    <div class="input-group-append" data-target="#txtFHasta" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Proveedor</label>
                                                    <select class="form-control select2bs4" id="cboprovxclie" name="cboprovxclie" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Maquilador</label>
                                                    <select class="form-control select2bs4" id="cbomaqxprov" name="cbomaqxprov" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Inspector</label>
                                                    <select class="form-control select2bs4" id="cboinspector" name="cboinspector"style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select class="form-control select2bs4" id="cboestado" name="cboestado" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer justify-content-between" style="background-color: #E0F4ED;"> 
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="text-left"> 
                                                    <button type="button" class="btn btn-outline-info" id="btnNuevo"><i class="fas fa-plus"></i> Crear Nuevo</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <div class="row">
                                                <div class="col-md-8">
                                                    <h3 class="card-title">Listado de Inspecciones - <label id="lblCliente"></label></h3>
                                                </div>                                                 
                                                <div class="col-md-4 text-right">
                                                    <button id="btn-show-all-children" type="button">Expandir</button>
                                                    <button id="btn-hide-all-children" type="button">Contraer</button>
                                                </div> 
                                                </div>
                                            </div>                                       
                                            <div class="card-body">
                                                <div class="row">
                                                <div class="col-md-12">
                                                <table id="tblListctrlprov" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="12">[Codigo] :: Proveedor - (Maquilador) - Establecimiento</th>
                                                    </tr>
                                                    <tr>
                                                        <th>desc_gral</th>
                                                        <th>Area Cliente</th>
                                                        <th>Linea Proceso</th>
                                                        <th></th>
                                                        <th>Periodo</th>
                                                        <th>Estado</th>
                                                        <th>Fecha</th>
                                                        <th>Inspector</th>
                                                        <th>Informe</th>
                                                        <th>Resultado</th>
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
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="tabctrlprov-det" role="tabpanel" aria-labelledby="tabctrlprov-det-tab">
                                <fieldset class="scheduler-border" id="datoInspeccion">
                                    <legend class="scheduler-border text-primary">Datos de Inspección</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-info">Codigo :: Proveedor (Maquilador) - Establecimiento </div>
                                            <div class="form-group">   
                                                <textarea class="form-control" cols="20" id="mtxtinspdatos" name="mtxtinspdatos" rows="2" disabled = true></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">   
                                                <textarea class="form-control" cols="20" name="mtxtinsparea"id="mtxtinsparea" rows="1" disabled = true></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">   
                                                <textarea class="form-control" cols="20" name="mtxtinsplinea"id="mtxtinsplinea" rows="1" disabled = true></textarea> 
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="scheduler-border" id="regInspeccion">
                                    <legend class="scheduler-border text-primary">Programación de Inspección</legend>
                                    <form class="form-horizontal" id="frmRegInsp" action="<?= base_url('at/ctrlprov/cregctrolprov/setreginspeccion')?>" method="POST" enctype="multipart/form-data" role="form">
                                        <input type="hidden" name="mfechainsp" id="mfechainsp">
                                        <input type="hidden" name="mhdnzctipoestado" id="mhdnzctipoestado">
                                        <input type="hidden" name="mhdnccliente" id="mhdnccliente">
                                        <input type="hidden" name="mhdnAccioninsp" id="mhdnAccioninsp"> 
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="text-info">Código</div>
                                                    <div> 
                                                        <input type="text" name="mtxtidinsp" id="mtxtidinsp" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-info">Periodo</div>
                                                    <div> 
                                                        <input type="month" name="cboinspperiodo" id="cboinspperiodo" class="form-control" pattern="[0-9]{4}-[0-9]{2}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-info">Estado Inspección</div>
                                                    <div>
                                                        <input type="text" name="txtinspestado" id="txtinspestado" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"> 
                                                    <div class="text-info">Fecha Inspeccion</div>                     
                                                    <div class="input-group date" id="txtFInspeccion" data-target-input="nearest">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><a style="cursor:pointer;" onClick="javascript:quitarFecha()"><i class="far fa-calendar-times"></i></a></div>
                                                        </div>
                                                        <input type="text" id="txtFInsp" name="txtFInsp" class="form-control datetimepicker-input" data-target="#txtFInspeccion"/>
                                                        <div class="input-group-append" data-target="#txtFInspeccion" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-info">Inspector</div>
                                                    <div>   
                                                        <select class="form-control select2bs4" id="cboinspinspector" name="cboinspinspector" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" style="text-align: center;">
                                                    <div class="text-info">AACC</div>
                                                    <div>   
                                                        <input type="checkbox" name="swaacc" id="swaacc" data-toggle="toggle" checked data-bootstrap-switch data-on-text="SI" data-off-text="NO" data-size="lg">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-info">Incluye Plan Inspección</div>
                                                    <div class="input-group">
                                                        <input type="checkbox" name="swplaninsp" id="swplaninsp" data-toggle="toggle" checked data-bootstrap-switch data-on-text="SI" data-off-text="NO">                                                        
                                                        <div class="input-group-addon input-group-button" id="Btnplan">
                                                            <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewentidadpension" data-toggle="modal" data-target="#modalMantentidadpension" ><i class="far fa-file-alt"></i> Generar Plan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="text-info">Sistema</div>
                                                    <div>
                                                        <select class="form-control select2bs4" id="cboinspsistema" name="cboinspsistema" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-info">Rubro</div>
                                                    <div>                                                  
                                                        <select class="form-control select2bs4" id="cboinsprubro" name="cboinsprubro" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="text-info">Check List</div>
                                                    <div>   
                                                        <select class="form-control select2bs4" id="cboinspcchecklist" name="cboinspcchecklist" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-info">Modelo Informe</div>
                                                    <div>                                                  
                                                        <select class="form-control select2bs4" id="cboinspmodeloinfo" name="cboinspmodeloinfo" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="text-info">Valor No Conformidad</div>
                                                    <div>                                                     
                                                        <select class="form-control select2bs4" id="cboinspvalconf" name="cboinspvalconf" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-info">Formula Evaluacion</div>
                                                    <div>                                                 
                                                        <select class="form-control select2bs4" id="cboinspformula" name="cboinspformula" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-info">Criterio Resultado</div>
                                                    <div>                                                     
                                                        <select class="form-control select2bs4" id="cboinspcritresul" name="cboinspcritresul" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="text-info">Contactos</div>
                                                    <div>  
                                                        <textarea class="form-control" cols="20" id="mtxtinspcoment" name="mtxtinspcoment" rows="2" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right"> 
                                                    <button type="submit" class="btn btn-success" id="btnGrabar"><i class="fas fa-save"></i> Grabar</button> 
                                                    <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>     
    </div>
</section>
<!-- /.Main content -->


<!-- /.modal-crear-inspeccion --> 
<div class="modal fade" id="modalCreactrlprov" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" id="frmCreactrlprov" name="frmCreactrlprov" action="<?= base_url('at/ctrlprov/cregctrolprov/setregctrlprov')?>" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registro de Control de Proveedores</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">          
            <input type="hidden" id="mhdnAccionctrlprov" name="mhdnAccionctrlprov">                          
            <div class="form-group">  
                <div class="row">
                    <div class="col-md-2"> 
                        <div class="text-info">Codigo</div>
                        <div>    
                            <input type="text" name="mhdnregIdinsp"id="mhdnregIdinsp" class="form-control"><!-- ID -->
                        </div>
                    </div>
                    <div class="col-md-10"> 
                        <div class="text-info">Clientes <span class="text-requerido">*</span></div>
                        <div>
                            <select class="form-control select2bs4" id="cboregClie" name="cboregClie" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">                        
                        <div class="text-info">Proveedor <span class="text-requerido">*</span></div>
                        <div>
                            <select class="form-control select2bs4" id="cboregprovclie" name="cboregprovclie" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">    
                        <div class="text-info">Maquilador</div>
                        <div>
                            <select class="form-control select2bs4" id="cboregmaquiprov" name="cboregmaquiprov" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-info">Establecimiento <span class="text-requerido">*</span></div>
                        <div>
                            <select class="form-control select2bs4" id="cboregestable" name="cboregestable" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="text-info">Dir. Inspeccion</div>
                        <div>
                            <input type="text" name="mtxtregdirestable"id="mtxtregdirestable" class="form-control" disable>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-info">Area del Cliente <span class="text-requerido">*</span></div>
                        <div>
                            <select class="form-control select2bs4" id="cboregareaclie" name="cboregareaclie" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="text-info">Linea de Proceso </div>
                        <div>
                            <select class="form-control select2bs4" id="cboreglineaproc" name="cboreglineaproc" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-info">Contacto Principal</div>
                        <div>
                            <select class="form-control select2bs4" id="cbocontacprinc" name="cbocontacprinc" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-info">Tipo de establecimiento</div>
                        <div>
                            <select class="form-control select2bs4" id="cbotipoestable" name="cbotipoestable" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-info">Costo</div>
                        <div>
                            <input type="number" name="txtcostoestable"id="txtcostoestable" class="form-control" placeholder="0.00" min="0.00">
                        </div>
                    </div>
                </div>
                <br>
                <div id="regInspeccion" style="border-top: 1px solid #ccc; padding-top: 10px;">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-list-alt"></i> INSPECCION
                            </h4>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-3">
                            <div class="text-info">Periodo</div>
                            <input type="month" name="mtxtregPeriodo" id="mtxtregPeriodo" class="form-control" pattern="[0-9]{4}-[0-9]{2}">
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCreactrl" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info" id="mbtnGCreactrl">Grabar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-cierre especial --> 
<div class="modal fade" id="modalCierreespecial" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">      

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Cierre Especial</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">  
        <form class="form-horizontal" id="frmCierreespecial" name="frmCierreespecial" action="<?= base_url('at/ctrlprov/cregctrolprov/setcierreespecial')?>" method="POST" enctype="multipart/form-data" role="form">         
            <input type="hidden" id="mhdncierrefservicio" name="mhdncierrefservicio">   
            <input type="hidden" id="mhdnAccioncierre" name="mhdnAccioncierre">
            <input type="hidden" id="hdncusuario" name="hdncusuario" value="<?php echo $cusuario ?>">                       
            <div class="form-group">  
                <div class="row">
                    <div class="col-md-3"> 
                        <div class="text-info">Codigo</div>
                        <div>    
                            <input type="text" name="txtcierreidinsp"id="txtcierreidinsp" class="form-control"><!-- ID -->
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Fecha Cierre</div>
                        <div>    
                            <input type="text" name="txtcierrefservicio"id="txtcierrefservicio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask><!-- ID -->
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="text-info">Tipo de Cierre </div>
                        <div>
                            <select class="form-control select2bs4" id="cbocierreTipo" name="cbocierreTipo" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div>   
                <div class="row" id="cierreprograma">
                    <div class="col-md-3"> 
                        <div class="text-info">F. Programado</div>                     
                        <div class="input-group date" id="txtcierreFProgramado" data-target-input="nearest">
                            <input type="text" id="txtcierreFProg" name="txtcierreFProg" class="form-control datetimepicker-input" data-target="#txtcierreFProgramado"/>
                            <div class="input-group-append" data-target="#txtcierreFProgramado" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                             </div>
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Monto</div>
                        <div>    
                            <input type="number" name="txtcierremonto"id="txtcierremonto" class="form-control" min="0.00" value="0.00"><!-- ID -->
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Viatico</div>
                        <div>    
                            <input type="number" name="txtcierreviatico"id="txtcierreviatico" class="form-control" min="0.00" value="0.00"><!-- ID -->
                        </div>
                    </div> 
                </div>   
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-info">Comentario</div>
                        <div>  
                            <textarea class="form-control" cols="20" id="mtxtcierrecomentario" name="mtxtcierrecomentario" rows="2" ></textarea>
                        </div>
                    </div>
                </div>             
            </div> 
        </form>  
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCierreesp" data-dismiss="modal">Cancelar</button>
            <button type="submit" form="frmCierreespecial" class="btn btn-info" id="mbtnGCierreesp">Grabar</button>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-convalidacion --> 
<div class="modal fade" id="modalConvalidacion" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="frmConvalidacion" name="frmConvalidacion" action="<?= base_url('at/ctrlprov/cregctrolprov/setconvalidacion')?>" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Convalidacion</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">          
            <input type="hidden" id="mhdnAccionconvali" name="mhdnAccionconvali">                          
            <div class="form-group">  
                <div class="row">
                    <div class="col-md-3"> 
                        <div class="text-info">Codigo</div>
                        <div>    
                            <input type="text" name="txtcierreidinsp"id="txtcierreidinsp" class="form-control"><!-- ID -->
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Fecha</div>
                        <div>    
                            <input type="text" name="txtcierrefservicio"id="txtcierrefservicio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask><!-- ID -->
                        </div>
                    </div> 
                </div> 
            </div>                         
            <div class="form-group">  
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-info">Tipo de Cierre </div>
                        <div>
                            <select class="form-control select2bs4" id="cbocierreTipo" name="cbocierreTipo" style="width: 100%;">
                                <option value="" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCreactrl" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info" id="mbtnGCreactrl">Grabar</button>
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