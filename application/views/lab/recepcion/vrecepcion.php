<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>
    tab {
        display: inline-block; 
        margin-left: 30px; 
    }
    tr.subgroup,
    tr.subgroup:hover {
        background-color: #F2F2F2 !important;
        /* color: blue; */
        font-weight: bold;
    }
    .group{
            background-color:#D5D8DC !important;
            font-size:15px;
            color:#000000!important;
            opacity:0.7;
    }
    .subgroup{
        cursor: pointer;
    }

    .btn-circle {
        width: 45px;
        height: 45px;
        line-height: 45px;
        text-align: center;
        padding: 0;
        border-radius: 50%;
    }
    
    .btn-circle i {
        position: relative;
        top: -1px;
    }

    .btn-circle-sm {
        width: 35px;
        height: 35px;
        line-height: 35px;
        font-size: 0.9rem;
    }

    .btn-circle-lg {
        width: 55px;
        height: 55px;
        line-height: 55px;
        font-size: 1.1rem;
    }

    .btn-circle-xl {
        width: 70px;
        height: 70px;
        line-height: 70px;
        font-size: 1.3rem;
    }

    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 0px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    
    .dropdown-item:hover{
        border-color: #0067ab;
        background-color: #e83e8c !important;
    }

    td.details-control {
        background: url('<?php echo public_base_url(); ?>assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.details td.details-control {
        background: url('<?php echo public_base_url(); ?>assets/images/details_close.png') no-repeat center center;
    }

    .tabledit-edit-button{
        color: #fff;
        background-color: #138496 ;
        border-color: #138496 ;
        box-shadow: none;
        content: "Reference: ";
    }
    .tabledit-edit-button::before{
        font-weight: negrita;
        color: navy;
        content: "Editar";
    }
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">RECEPCION DE MUESTRAS</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>cprincipal/principal">Home</a></li>
          <li class="breadcrumb-item active">Laboratorio</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content" id="contenedorCotizacion" style="background-color: #E0F4ED;">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">            
                        <ul class="nav nav-tabs" id="tablab" style="background-color: #2875A7;" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #000000;" id="tablab-list-tab" data-toggle="pill" href="#tablab-list" role="tab" aria-controls="tablab-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #000000;" id="tablab-reg-tab" data-toggle="pill" href="#tablab-reg" role="tab" aria-controls="tablab-reg" aria-selected="false">REGISTRO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tablab-tabContent">
                            <div class="tab-pane fade show active" id="tablab-list" role="tabpanel" aria-labelledby="tablab-list-tab">                                
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">BUSQUEDA</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>   
                                    <form class="form-horizontal" id="frmbuscarcoti" name="frmbuscarcoti" action="<?= base_url('lab/recepcion/crecepcion/exportexcellistcoti')?>" method="POST" enctype="multipart/form-data" role="form">
                                    <div class="card-body">
                                        <input type="hidden" name="mtxtidcotizacion" class="form-control" id="mtxtidcotizacion" >
                                        <input type="hidden" name="mtxtnroversion" class="form-control" id="mtxtnroversion" >
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Clientes</label>
                                                    <select class="form-control select2bs4" id="cboclieserv" name="cboclieserv" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Estado</label>
                                                <div>
                                                    <select class="form-control" id="cboestado" name="cboestado">
                                                        <option value="%" selected="selected">TODOS</option>
                                                        <option value="N">ABIERTO</option>
                                                        <option value="S">CERRADO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">    
                                                <div class="checkbox"><label>
                                                    <input type="checkbox" id="chkFreg" /> <b>Fecha Cotizacion :: Del</b>
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
                                            <div class="col-md-4"> 
                                                <label>Nro. Cotizacion/ Producto</label> 
                                                <div>
                                                    <input type="text" id="txtdescri" name="txtdescri" class="form-control"  onkeypress="pulsarListarCoti(event)"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Ver OT</label>
                                                <div>
                                                    <select class="form-control" id="cbotieneot" name="cbotieneot">
                                                        <option value="%" selected="selected">TODOS</option>
                                                        <option value="N">Sin OT</option>
                                                        <option value="S">Con OT</option>
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
                                                    <button type="submit" class="btn btn-success" id="btnexcel" disabled="true"><i class="far fa-file-excel"></i> Exportar Excel</button>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Listado de Cotizaciones</h3>
                                            </div>                                        
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tblListRecepcion" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Cotizacion</th>
                                                        <th>Fecha</th>
                                                        <th>Entrega</th>
                                                        <th>Monto sin IGV</th>
                                                        <th>Monto Total</th>
                                                        <th>Elaborado por</th>
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
                            <div class="tab-pane fade" id="tablab-reg" role="tabpanel" aria-labelledby="tablab-reg-tab">
                                <fieldset class="scheduler-border-fsc" id="regCoti">
                                    <legend class="scheduler-border-fsc text-primary">RECEPCION DE MUESTRA</legend>
                                    <div id="regProductos" style="border-top: 1px solid #ccc; padding-top: 10px;">
                                        <div class="row">
                                            <div class="col-6">
                                                <h4>
                                                    <i class="fas fa-weight"></i> <label id="lblclie"></label>
                                                    <small id="lblcoti"> </small>
                                                </h4>
                                            </div> 
                                        </div> 
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="card card-outline card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Listado de Recepcion</h3>
                                                    </div>                                        
                                                    <div class="card-body">
                                                    <input type="hidden" name="mtxtcusuario" class="form-control" id="mtxtcusuario" value="<?php echo $cusuario ?>">
                                                        <div class="row" style="background-color: #dff0d8;">                                                         
                                                            <div class="col-6 text-left">
                                                                <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
                                                            </div>                                                          
                                                            <div class="col-6 text-right">
                                                                <button type="button" class="btn btn-success" id="btngenerarOT"><i class="fas fa-clipboard-list"></i> Generar OT</button>
                                                            </div>    
                                                        </div>
                                                        <br>
                                                        <div class="row">                                                         
                                                            <div class="col-12"> 
                                                            <table id="tblListProductos" class="table table-striped table-bordered compact" style="width:100%">
                                                                <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th>N°</th>
                                                                    <th>F. Recepcion</th>
                                                                    <th>Codigo</th>
                                                                    <th>Producto Real</th>
                                                                    <th>Presentacion</th>
                                                                    <th>Temp. Recep.</th>
                                                                    <th>Cant. Muestra</th>
                                                                    <th>Proveedor</th>
                                                                    <th>N° Lote</th>
                                                                    <th>F. Envase</th>
                                                                    <th>F. Muestreo</th>
                                                                    <th>Hora Muestreo</th>
                                                                    <th>Observacion para Informe</th>
                                                                    <th>Observacion Otros</th>
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

<!-- /.modal-crear-recepcion --> 
<div class="modal fade" id="modalRecepcion" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" id="frmRecepcion" name="frmRecepcion" action="<?= base_url('lab/recepcion/crecepcion/setrecepcionmuestra')?>" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registro de Recepcion</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">          
            <input type="hidden" name="mhdnidcotizacion" id="mhdnidcotizacion" class="form-control">
            <input type="hidden" name="mhdnnroversion" id="mhdnnroversion" class="form-control">
            <input type="hidden" name="mhdnnordenproducto" id="mhdnnordenproducto" class="form-control">
            <input type="hidden" id="mhdnAccionRecepcion" name="mhdnAccionRecepcion" value="">
                        
            <div class="form-group">
                <div class="row">  
                    <div class="col-md-2">
                        <div class="text-info">Codigo</div>
                        <div>  
                            <input type="text" name="mtxtmcodigo" class="form-control" id="mtxtmcodigo"/>  
                        </div>
                    </div>                 
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="text-info">F. Recepcion <span class="text-requerido">*</span></div>
                            <div class="input-group date" id="mtxtFRecep" data-target-input="nearest">
                                <input type="text" id="mtxtFrecepcion" name="mtxtFrecepcion" class="form-control datetimepicker-input" data-target="#mtxtFRecep" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask />
                                <div class="input-group-append" data-target="#mtxtFRecep" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>                        
                        </div> 
                    </div>             
                    <div class="col-md-7">
                        <div class="text-info">Producto Real</div>
                        <div>
                            <input type="text" name="mtxtmproductoreal" class="form-control" id="mtxtmproductoreal"/>
                        </div>
                    </div> 
                </div>                
            </div>      
            <div class="form-group">
                <div class="row">                   
                    <div class="col-md-12">
                        <div class="text-info">Presentacion<span class="text-requerido">*</span></div>
                        <div>  
                            <textarea class="form-control" cols="20" data-val="true" data-val-length="No debe superar los 500 caracteres." data-val-length-max="500" name="mtxtmpresentacion" id="mtxtmpresentacion" rows="2" data-val-maxlength-max="500" data-validation="required"/> </textarea> 
                        </div>
                    </div> 
                </div>                
            </div>         
            <div class="form-group">
                <div class="row">    
                    <div class="col-md-4">
                        <div class="text-info">Temp. Recepcion</div>
                        <div>  
                            <input type="text" name="mtxttemprecep" class="form-control" id="mtxttemprecep"/>  
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="text-info">Cantidad Muestra</div>
                        <div>  
                            <input type="text" name="mtxtcantmuestra" class="form-control" id="mtxtcantmuestra"/>  
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="text-info">Precinto</div>
                        <div>  
                            <input type="text" name="mtxtprecinto" class="form-control" id="mtxtprecinto"/>  
                        </div>
                    </div>    
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="text-info">F. Muestreo</div>
                            <div class="input-group date" id="mtxtFMues" data-target-input="nearest">
                                <input type="text" id="mtxtFmuestra" name="mtxtFmuestra" class="form-control datetimepicker-input" data-target="#mtxtFMues"/>
                                <div class="input-group-append" data-target="#mtxtFMues" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>                        
                        </div>                       
                    </div>   
                    <div class="col-md-3">
                        <div class="text-info">Hora Muestreo</div>
                        <div>  
                            <input type="text" name="mtxthmuestra" class="form-control" id="mtxthmuestra"/>  
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="text-info">Proveedor</div>
                        <div>  
                            <input type="text" name="mtxtproveedor" class="form-control" id="mtxtproveedor"/>  
                        </div>
                    </div>  
                </div>                
            </div> 
            <div class="form-group" id="divExtra">
                <div class="row">    
                    <div class="col-sm-2">
                        <div class="text-info">Tottus</div>
                        <div>
                            <select class="form-control select2bs4" id="mcbotottus" name="mcbotottus">
                            <option value="" selected="selected">Elegir...</option>
                            <option value="M">Marca Propia</option>
                            <option value="T">Tienda</option>
                            <option value="N">No aplica</option>
                            </select>
                        </div>
                    </div>        
                    <div class="col-sm-2">
                        <div class="text-info">Monitoreo</div>
                        <div>
                            <select class="form-control select2bs4" id="mcbomonitoreo" name="mcbomonitoreo">
                            <option value="" selected="selected">Elegir...</option>
                            <option value="1">PRIMERO</option>
                            <option value="2">SEGUNDO</option>
                            <option value="3">TERCERO</option>
                            <option value="4">CUARTO</option>
                            </select>
                        </div>
                    </div>               
                    <div class="col-sm-3">
                        <div class="text-info">Motivo</div>
                        <div>
                            <select class="form-control select2bs4" id="mcbomotivo" name="mcbomotivo">
                            <option value="" selected="selected">Elegir...</option>
                            <option value="524">Monitoreo</option>
                            <option value="525">Remuestreo</option>
                            <option value="526">Validación CP</option>
                            <option value="527">Validación tienda</option>
                            <option value="528">Validación otros</option>
                            </select>
                        </div>
                    </div>               
                    <div class="col-sm-3">
                        <div class="text-info">Area</div>
                        <div>
                            <select class="form-control select2bs4" id="mcboarea" name="mcboarea">
                            <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>                
                    <div class="col-sm-2">
                        <div class="text-info">Item</div>
                        <div>
                            <select class="form-control select2bs4" id="mcboitem" name="mcboitem">
                            <option value="" selected="selected">Elegir...</option>
                            <option value="530">Ambiente</option>
                            <option value="531">Alimento</option>
                            <option value="532">Superficie</option>
                            <option value="533">Manipulador</option>
                            <option value="534">Agua</option>
                            <option value="535">Hielo</option>
                            <option value="917">Validación</option>
                            </select>
                        </div>
                    </div>                    
                </div>                
                <div class="row"> 
                    <div class="col-sm-6">
                        <div class="text-info">Ubicacion</div>
                        <div>  
                            <input type="text" name="mtxtubicacion" class="form-control" id="mtxtubicacion"/>  
                        </div>
                    </div>      
                    <div class="col-sm-6">
                        <div class="text-info">Estado</div>
                        <div>  
                            <input type="text" name="mtxtestado" class="form-control" id="mtxtestado"/>  
                        </div>
                    </div>  
                </div>                
            </div>
            <div class="form-group">
                <div class="row">                
                    <div class="col-md-12">
                        <div class="text-info">Observación para Constancia</div>
                        <div>   
                            <textarea class="form-control" cols="20" data-val="true" data-val-length="No debe superar los 500 caracteres." data-val-length-max="500" id="mtxtObservaconst" name="mtxtObservaconst" rows="2" data-val-maxlength-max="500" data-validation="required"></textarea>
                            <span class="help-inline" style="padding-left:0px; color:#999; font-size:0.9em;">Caracteres: 0 / 500</span>     
                        </div> 
                    </div> 
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">                
                    <div class="col-md-12">
                        <div class="text-info">Observacion para Informe</div>
                        <div>   
                            <textarea class="form-control" cols="20" data-val="true" data-val-length="No debe superar los 500 caracteres." data-val-length-max="500" id="mtxtObserva" name="mtxtObserva" rows="2" data-val-maxlength-max="500" data-validation="required"></textarea>
                            <span class="help-inline" style="padding-left:0px; color:#999; font-size:0.9em;">Caracteres: 0 / 500</span>     
                        </div> 
                    </div> 
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">                            
                    <div class="col-md-12">
                        <div class="text-info">Observación Otros</div>
                        <div>   
                            <textarea class="form-control" cols="20" data-val="true" data-val-length="No debe superar los 500 caracteres." data-val-length-max="500" id="mtxtObsotros" name="mtxtObsotros" rows="2" data-val-maxlength-max="500" data-validation="required"></textarea>
                            <span class="help-inline" style="padding-left:0px; color:#999; font-size:0.9em;">Caracteres: 0 / 500</span>     
                        </div> 
                    </div> 
                </div>                
            </div>         
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCreaProduc" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info" id="mbtnGCreaProduc">Grabar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-FechaOT --> 
<div class="modal fade" id="modalFechaOT" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Orden de Trabajo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
        <form class="form-horizontal" id="frmFechaOT" name="frmFechaOT" action="<?= base_url('lab/recepcion/crecepcion/setupdateFechaOT')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdncinternoordenservicio" name="mhdncinternoordenservicio">  
            <input type="hidden" id="mhdnnroordenservicio" name="mhdnnroordenservicio">                       
            <div class="form-group"> 
                <div class="row">
                    <div class="col-md-5 text-center">            
                        <div class="input-group date" id="txtFOT" data-target-input="nearest">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-check-circle">Fecha OT</i></div>
                            </div>
                            <input type="text" id="txtForden" name="txtForden" class="form-control datetimepicker-input" data-target="#txtFOT"/>
                            <div class="input-group-append" data-target="#txtFOT" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 text-left"> 
                        <button type="submit" form="frmFechaOT" class="btn btn-info" id="mbtnGFechaOT">Actualizar</button>
                    </div>  
                </div>
            </div>
        </form>  

        <form class="form-horizontal" id="frmGenConst" name="frmGenConst" action="<?= base_url('lab/recepcion/crecepcion/setgenerarconst')?>" method="POST" enctype="multipart/form-data" role="form">       
            <input type="hidden" id="mhdnidotconst" name="mhdnidotconst"> <!-- ID -->
            <input type="hidden" id="mhdncordenservicioconst" name="mhdncordenservicioconst">
            <input type="hidden" id="mhdnAccionConst" name="mhdnAccionConst" >

            <div class="form-group">
                <fieldset class="scheduler-border-fsc" id="regConst">
                    <legend class="scheduler-border-fsc text-primary">Constancia de recepcion de muestras</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-info">Nro Constancia <span class="text-requerido">*</span></div>
                            <div>  
                                <input type="text" id="txtnroconst" name="txtnroconst" class="form-control" disabled/>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="text-info">Fecha Ingreso</div>
                            <div class="input-group date" id="txtFConstancia" data-target-input="nearest">
                                <input type="text" id="txtFConst" name="txtFConst" class="form-control datetimepicker-input" data-target="#txtFConstancia"/>
                                <div class="input-group-append" data-target="#txtFConstancia" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>  
                        </div>  
                        <div class="col-md-3">
                            <div class="text-info">Hora Ingreso</div>
                            <div class="input-group date" id="txtHConstancia" data-target-input="nearest">
                                <input type="text" id="txtHConst" name="txtHConst" class="form-control datetimepicker-input" data-target="#txtHConstancia"/>
                                <div class="input-group-append" data-target="#txtHConstancia" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-left">
                            <div class="text-info">&nbsp;</div> 
                            <button type="submit" form="frmGenConst" class="btn btn-info" id="mbtnGGenConst">Generar Constancia</button>
                        </div>     
                    </div>     
                </fieldset> 
            </div>
        </form>

        <!--<form class="form-horizontal" id="frmBlancovia" name="frmBlancovia" action="<?= base_url('lab/recepcion/crecepcion/setblancoviajero')?>" method="POST" enctype="multipart/form-data" role="form">       -->
            
            <div class="form-group">
                <fieldset class="scheduler-border-fsc" id="regConst">
                    <legend class="scheduler-border-fsc text-primary">Blanco Viajero</legend>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                            <div class="card-header">
                            </div> 
                            <div class="card-body">
                            <div class="table-responsive">
                            <table class="table m-0" id="tblBlancoviajero">
                            <thead>
                            <tr>
                                <th>BK</th>
                                <th>LOTE</th>
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
                        <div class="col-md-4">  
                            <div class="card card-primary">  
                            <div class="card-header">
                            <h4 class="card-title">
                                :: Registro
                            </h4>
                            </div>               
                            <form class="form-horizontal" id="frmBlancovia" name="frmBlancovia" action="<?= base_url('lab/recepcion/crecepcion/setblancoviajero')?>" method="POST" enctype="multipart/form-data" role="form">              
                            <div class="card-body">                    
                                <input type="hidden" id="mhdnidblancoviajero" name="mhdnidblancoviajero"> <!-- ID -->
                                <input type="hidden" id="mhdncordenservicioblancovia" name="mhdncordenservicioblancovia">
                                <input type="hidden" id="mhdnAccionblancovia" name="mhdnAccionblancovia" >                                  
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="text-light-blue">BK</div>                
                                            <select id="cbobk" name="cbobk" class="form-control" style="width: 100%;">
                                                <option value="0" selected="selected">:: Elegir</option>
                                                <option value="PBS">PBS</option>
                                                <option value="BPW">BPW</option> 
                                                <option value="D/E">D/E</option>
                                                <option value="APC">APC</option>
                                                <option value="OGYE">OGYE</option>
                                                <option value="OXFORD">OXFORD</option>
                                                <option value="MYP">MYP</option>
                                                <option value="VRBA">VRBA</option>
                                                <option value="XLD">XLD</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                        </div>
                                    </div>      
                                    <div class="form-group">
                                        <div class="col-sm-12"> 
                                            <div class="text-light-blue">LOTE</div> 
                                            <input class="form-control" id="mtxtlote" name="mtxtlote" type="text" value="" />                                
                                        </div>
                                    </div>       
                            </div>                    
                            <div class="card-footer">
                                <div class="text-right">
                                <button type="button" id="btnNuevobv" class="btn btn-primary">Nuevo</button>
                                <button type="submit" id="btnGrabarbv" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                            </form>
                            </div> 
                        </div>   
                    </div>     
                </fieldset> 
            </div>
        <!--</form>-->
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCFechaOT" data-dismiss="modal">Cancelar</button>            
        </div>
      
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Etiqueta --> 
<div class="modal fade" id="modalEtiqueta" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Etiquetas para Muestras</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" id="mhdncinternoordenservicio" name="mhdncinternoordenservicio">
            <div class="row">
                <div class="col-md-6"> 
                    <div class="text-info">Tipo de Etiqueta</div>
                    <input type="checkbox" name="swCasos" id="swCasos" checked data-bootstrap-switch  data-on-text="General" data-off-text="Lote">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card card-outline card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Muestras</h3>
                        </div>                                        
                        <div class="card-body" style="overflow-x: scroll;">
                            <table id="tblListEtiquetasmuestras" class="table table-striped table-bordered compact" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Nro Muestra</th>
                                    <th>Seleccion</th>
                                    <th>Nro Copias</th>
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

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCancelar" data-dismiss="modal">Cancelar</button>   
            <button type="submit" class="btn btn-info" id="mbtnPrint">Vista Previa</button>           
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->
