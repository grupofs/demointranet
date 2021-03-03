<?php
    $idusuario = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>
    .fullModal {
        margin: 0 !important;
        margin-right: auto !important;
        margin-left: auto !important;
        width: 100% !important;
      }
      @media (min-width: 576px) {
        .fullModal {
            width: 700px !important;
            max-width: 700px !important;
        }
      }
      @media (min-width: 768px) {
        .fullModal {
            width: 800px !important;
            max-width: 800px !important;
        }
      }
      @media (min-width: 992px) {
        .fullModal {
            width: 1070px !important;
            max-width: 1070px !important;
        }
      }
      @media (min-width: 1200px) {
        .fullModal {
            width: 1300px !important;
            max-width: 1300px !important;
        }
      }
      @media (min-width: 1500px) {
        .fullModal {
            width: 1500px !important;
            max-width: 1500px !important;
        }
    
    }
      
    
    [data-title]:hover:after {
        opacity: 1;
        transition: all 0.1s ease 0.5s;
        visibility: visible;
    }

    [data-title]:after {
        content: attr(data-title);
        background-color: #333;
        color: #fff;
        font-size: 14px;
        font-family: Raleway;
        position: absolute;
        padding: 3px 10px;
        bottom: -1.6em;
        left: -50%;
        right: -50%;
        /*white-space: nowrap;*/
        box-shadow: 1px 1px 3px #222222;
        opacity: 0;
        border: 1px solid #111111;
        z-index: 99999;
        visibility: hidden;
        border-radius: 6px;
        
    }
    [data-title] {
        position: relative;
    }
    .col_ellipsis[data-title][data-title-position="bottom"]:before {
        bottom: auto;
        margin-top: .5rem;
        top: 100%;
    }
    .col_ellipsis[data-title][data-title-position="bottom"]:after {
        bottom: auto;
        /*top: 100%;*/
        width: 300px;
    }
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">COTIZACIÓN</h1>
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
<section class="content" id="contenedorCotizacion">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-12">
                <div class="card card-lightblue card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">            
                        <ul class="nav nav-tabs tabfsc" id="tablab" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" id="tablab-list-tab" data-toggle="pill" href="#tablab-list" role="tab" aria-controls="tablab-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tablab-reg-tab" data-toggle="pill" href="#tablab-reg" role="tab" aria-controls="tablab-reg" aria-selected="false">REGISTRO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tablab-tabContent">
                            <div class="tab-pane fade show active" id="tablab-list" role="tabpanel" aria-labelledby="tablab-list-tab">                                
                                <div class="card card-lightblue">
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
                                                    <input type="text" id="txtdescri" name="txtdescri" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>                
                                                
                                    <div class="card-footer justify-content-between"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button> 
                                                    <button type="button" class="btn btn-outline-info" id="btnNuevo" ><i class="fas fa-plus"></i> Nuevo Cotización</button>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-lightblue">
                                            <div class="card-header">
                                                <h3 class="card-title">Listado de Cotizaciones</h3>
                                            </div>                                        
                                            <div class="card-body">
                                                <table id="tblListCotizacion" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Cliente</th>
                                                        <th>Cotizacion</th>
                                                        <th>Fecha</th>
                                                        <th>Precio Total</th>
                                                        <th>Elaborado por</th>
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
                            <div class="tab-pane fade" id="tablab-reg" role="tabpanel" aria-labelledby="tablab-reg-tab">
                                <fieldset class="scheduler-border-fsc" id="regCoti">
                                    <legend class="scheduler-border-fsc text-primary">REG. COTIZACION / PROPUESTA</legend>
                                    <form class="form-horizontal" id="frmRegCoti" action="<?= base_url('lab/coti/ccotizacion/setcotizacion')?>" method="POST" enctype="multipart/form-data" role="form">
                                        <input type="hidden" name="mtxtidcotizacion" id="mtxtidcotizacion" class="form-control">
                                        <input type="hidden" name="mtxtnroversion" id="mtxtnroversion" class="form-control" value='0'>
                                        <input type="hidden" name="hdnAccionregcoti" id="hdnAccionregcoti" class="form-control">

                                        <input type="hidden" name="mtxtidusuario" class="form-control" id="mtxtidusuario" value="<?php echo $idusuario ?>">
                                        <input type="hidden" name="mtxtcusuario" class="form-control" id="mtxtcusuario" value="<?php echo $cusuario ?>">
                                        <div class="row">                 
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="text-info">Fecha Cotización/Propuesta </div>
                                                    <div class="input-group date" id="mtxtFCoti" data-target-input="nearest">
                                                        <input type="text" id="mtxtFcotizacion" name="mtxtFcotizacion" class="form-control datetimepicker-input" data-target="#mtxtFCoti"/>
                                                        <div class="input-group-append" data-target="#mtxtFCoti" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>                        
                                                </div> 
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">    
                                                    <div class="text-info">Nro Cotización/Propuesta </div>
                                                    <input type="text" name="mtxtregnumcoti"id="mtxtregnumcoti" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">    
                                                    <div class="text-info">Estado </div>
                                                    <input type="text" id="mtxtregestado" name="mtxtregestado" class="form-control">
                                                    <input type="hidden" name="hdnregestado" id="hdnregestado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="text-info">Vigencia </div>
                                                    <input type="number" name="mtxtregvigen" id="mtxtregvigen" class="form-control" value="30" min="0" pattern="^[0-9]+">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="text-info">Servicio <span class="text-requerido">*</span></div>
                                                    <select class="form-control select2bs4" id="cboregserv" name="cboregserv" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="text-info">Cliente <span class="text-requerido">*</span></div>
                                                    <select class="form-control select2bs4" id="cboregclie" name="cboregclie" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="text-info">Proveedor del Cliente </div>
                                                    <select class="form-control select2bs4" id="cboregprov" name="cboregprov" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="text-info">Contacto del Cliente </div>
                                                    <select class="form-control select2bs4" id="cboregcontacto" name="cboregcontacto" style="width: 100%;">
                                                        <option value="" selected="selected">Cargando...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">   
                                            <div class="col-md-2">
                                                <div class="form-group">                                                    
                                                    <div class="text-info">Contra Muestra </div>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="mtxtcontramuestra"id="mtxtcontramuestra" class="form-control" value="0" min="0" pattern="^[0-9]+">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <span id="btntipocontramuestra">NA</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onClick="javascript:na()">NA</a>
                                                                <a class="dropdown-item" onClick="javascript:dias()">Días</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="mtxtregpermane"id="mtxtregpermane">
                                                </div>
                                            </div>  
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="text-info">Tiempo Entrega Inf. </div>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="mtxtregentregainf"id="mtxtregentregainf" class="form-control" min="0" pattern="^[0-9]+">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <span id="btntipodias">Días Calendario</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onClick="javascript:calen()">Días Calendario</a>
                                                                <a class="dropdown-item" onClick="javascript:util()">Días Útiles</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="txtregtipodias" id="txtregtipodias">
                                                </div>
                                            </div> 
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <div class="text-info">Observaciones </div>
                                                    <input type="text" name="mtxtobserv"id="mtxtobserv" class="form-control" >
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="text-info">Forma de Pago </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <span id="btnformapagos">Contado</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onClick="javascript:conta()">Contado</a>
                                                                <a class="dropdown-item" onClick="javascript:credi()">Crédito</a>
                                                                <a class="dropdown-item" onClick="javascript:otro()">Otros</a>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="mtxtregpagotro"id="mtxtregpagotro" class="form-control" >
                                                    </div>
                                                    <input type="hidden" name="txtregformapagos" id="txtregformapagos">
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="text-info">Moneda </div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                            <span id="btntipopagos">S/.</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onClick="javascript:soles()">S/.</a>
                                                                <a class="dropdown-item" onClick="javascript:dolares()">$</a>
                                                            </div>
                                                        </div>
                                                        <input type="number" name="mtxtregtipocambio"id="mtxtregtipocambio" class="form-control" placeholder="0.00" min="0.00">
                                                    </div>
                                                    <input type="hidden" name="mtxtregtipopagos" id="mtxtregtipopagos">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-2">
                                                <div class="form-group">                                                    
                                                    <div class="checkbox"><div class="text-info">
                                                    <input type="checkbox" id="chksmuestreo" name="chksmuestreo" />&nbsp;Muestreo </div> </div>   
                                                    <input type="number" name="txtmontmuestreo"id="txtmontmuestreo" class="form-control" placeholder="0.00" min="0.00">
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="text-info">Sub Total </div>
                                                    <input type="number" name="txtmontsubtotal"id="txtmontsubtotal" class="form-control" placeholder="0.00" min="0.00">
                                                </div>
                                            </div>   
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="text-info">Dscto. (%) </div>
                                                    <input type="number" name="txtporcdescuento"id="txtporcdescuento" class="form-control" placeholder="0" min="0">
                                                </div>
                                            </div>  
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="text-info">IGV. (%) </div>
                                                    <input type="number" name="txtporctigv"id="txtporctigv" class="form-control" placeholder="0" min="0">
                                                </div>
                                            </div>   
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="text-info">Total </div>
                                                    <input type="number" name="txtmonttotal"id="txtmonttotal" class="form-control" placeholder="0.00" min="0.00">
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5 text-left"> 
                                                <div class="form-group">
                                                    <div class="col-md-5">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="chkregverpago" name="chkregverpago" />
                                                            <label for="chkregverpago" class="custom-control-label">Ver Precios</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7 text-right"> 
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success" id="btnRegistrar"><i class="fas fa-save"></i> Registrar</button>   
                                                    <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="regProductos" style="border-top: 1px solid #ccc; padding-top: 10px;">
                                        <div class="row">
                                            <div class="col-6">
                                                <h4>
                                                    <i class="fas fa-weight"></i> PRODUCTOS
                                                    <small> - Ensayos :: </small>
                                                </h4>
                                            </div> 
                                        </div> 
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="card card-outline card-lightblue">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Listado de Productos</h3>
                                                    </div>                                        
                                                    <div class="card-body">
                                                        <table id="tblListProductos" class="table table-striped table-bordered" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th>Local</th>
                                                                <th>Productos</th>
                                                                <th>Condicion</th>
                                                                <th>N° Muestras</th>
                                                                <th>Importe S/.</th>
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

<!-- Reg. Productos Ensayos-->
<section class="content" id="contenedorRegensayo" style="display: none" >
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            
                                <fieldset class="scheduler-border-fsc" id="regProd">
                                    <legend class="scheduler-border-fsc text-primary">Registro de Producto</legend> 
                                    <div class="card card-lightblue">
                                    <form class="form-horizontal" id="frmCreaProduc" name="frmCreaProduc" action="<?= base_url('lab/coti/ccotizacion/setproductoxcotizacion')?>" method="POST" enctype="multipart/form-data" role="form"> 
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-archive"></i>&nbsp;<b>Producto :: NRO Cotización - </b> <label id="lblNrocoti"></label></h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>                                
                                        <div class="card-body">
                                            <input type="hidden" id="mhdnIdProduc" name="mhdnIdProduc" class="form-control"> <!-- ID -->
                                            <input type="hidden" id="mhdnidcotizacion" name="mhdnidcotizacion" class="form-control">
                                            <input type="hidden" id="mhdnnroversion" name="mhdnnroversion" class="form-control">
                                            <input type="hidden" id="mhdnAccionProduc" name="mhdnAccionProduc" class="form-control">
                                            <input type="hidden" id="mhdncusuario" name="mhdncusuario" class="form-control">
                        
                                                        
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="text-info">Local del Cliente <span class="text-requerido">*</span></div>
                                                        <div>                            
                                                            <select class="form-control select2bs4" id="mcboregLocalclie" name="mcboregLocalclie" style="width: 100%;">
                                                                <option value="" selected="selected">Cargando...</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="col-sm-6">
                                                        <div class="text-info">Nombre del Producto <span class="text-requerido">*</span></div>
                                                        <div>  
                                                            <input type="text" name="mtxtregProducto" class="form-control" id="mtxtregProducto"/>  
                                                        </div>
                                                    </div>  
                                                </div>                
                                            </div> 
                                            <div class="form-group">
                                                <div class="row">                
                                                    <div class="col-sm-3">
                                                        <div class="text-info">Condicion</div>
                                                        <div>
                                                            <select class="form-control select2bs4" id="mcboregcondicion" name="mcboregcondicion">
                                                            <option value="">Cargando...</option>
                                                            </select>
                                                        </div>
                                                    </div>                
                                                    <div class="col-sm-2">
                                                        <div class="text-info">Muestras <span class="text-requerido">*</span></div>
                                                        <div>   
                                                            <input type="number" name="mtxtregmuestra"id="mtxtregmuestra" class="form-control" value="0" min="0" pattern="^[0-9]+">
                                                        </div>
                                                    </div>               
                                                    <div class="col-sm-4">
                                                        <div class="text-info">Procedencia de muestra</div>
                                                        <div>
                                                            <select class="form-control select2bs4" id="mcboregprocedencia" name="mcboregprocedencia">
                                                            <option value="">Cargando...</option>
                                                            </select>
                                                        </div>
                                                    </div>                
                                                    <div class="col-sm-3">
                                                        <div class="text-info">Cantidad de muestra minima</div>
                                                        <div>  
                                                            <input type="text" name="mtxtregcantimin" class="form-control" id="mtxtregcantimin"/>  
                                                        </div>
                                                    </div> 
                                                </div>                
                                            </div> 
                                            <div class="form-group">
                                                <div class="row">                   
                                                    <div class="col-sm-2">
                                                        <div class="text-info">Monto S/.</div>
                                                        <div>  
                                                            <input type="number" name="mtxtmIMonto"id="mtxtmIMonto" class="form-control" placeholder="0.00" min="0.00" disabled> 
                                                        </div>
                                                    </div>               
                                                    <div class="col-sm-3">
                                                        <div class="text-info"></div>
                                                        <div>  
                                                            
                                                        </div>
                                                    </div>            
                                                    <div class="col-sm-2">
                                                        <div class="text-info"><b>Octogono</b></div>
                                                        <div>
                                                            <select class="form-control" id="mcboregoctogono" name="mcboregoctogono">
                                                                <option value="1">SI</option>
                                                                <option value="0" selected="selected">NO</option>
                                                            </select>
                                                        </div>
                                                    </div>                
                                                    <div class="col-sm-2">
                                                        <div class="text-info"><b>Etiquetado Nutricional</b></div>
                                                        <div>
                                                            <select class="form-control" id="mcboregetiquetado" name="mcboregetiquetado">
                                                                <option value="1">SI</option>
                                                                <option value="0" selected="selected">NO</option>
                                                            </select>
                                                        </div>
                                                    </div>                 
                                                    <div class="col-sm-2">
                                                        <div class="text-info">Tamaño de Porcion</div>
                                                        <div>  
                                                            <input type="text" name="mtxtregtamporci" class="form-control" id="mtxtregtamporci"/>  
                                                        </div>
                                                    </div>                
                                                    <div class="col-sm-1">
                                                        <div class="text-info">UM</div>
                                                        <div>
                                                            <select class="form-control" id="mcboregumeti" name="mcboregumeti">
                                                                <option value="" selected="selected"></option>
                                                                <option value="ml">ml</option>
                                                                <option value="g">g</option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>                
                                            </div>
                                        </div>                
                                                                            
                                        <div class="card-footer justify-content-between">                     
                                            <div class="form-group">                
                                                <div class="row">
                                                    <div class="col-md-6 text-left">  
                                                        <button type="reset" class="btn btn-secondary" id="mbtnCCreaProduc" data-dismiss="modal"><i class="fas fa-door-open"></i>Regresar</button> 
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <button type="submit" class="btn btn-success" id="mbtnGCreaProduc"><i class="fas fa-save"></i>Grabar</button>              
                                                    </div> 
                                                </div>  
                                            </div>  
                                        </div>
                                    </from>  
                                    </div>          
                                </fieldset>  

                                <fieldset class="scheduler-border-fsc">
                                    <legend class="scheduler-border-fsc text-primary">Registro de Ensayos</legend>
                                    <div class="box-body">                
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="card card-lightblue">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fas fa-microscope"></i>&nbsp;<b>Ensayos ::</b></h3>
                                                    </div>                                        
                                                    <div class="card-body" style="overflow-x: scroll;">
                                                        <table id="tblListEnsayos" class="table table-striped table-bordered" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>N°</th>
                                                                <th>Codigo</th>
                                                                <th>Ensayo</th>
                                                                <th>Año</th>
                                                                <th>Norma</th>
                                                                <th>Precio S/.</th>
                                                                <th>Vias</th>
                                                                <th>Cant.</th>
                                                                <th>Costo S/.</th>
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
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
<!-- /.Reg. Ensayos -->

<!-- /.Modal-Buscar-Ensayos --> 
<div class="modal fade" id="modaladdEnsayo" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg fullModal">
    <div class="modal-content" id="contenedorBuscarensayo">      

        <div class="modal-header text-center bg-lightblue">
            <h4 class="modal-title w-100 font-weight-bold">Seleccionar Ensayo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">          
            <input type="hidden" id="hdnbusIdcoti" name="hdnbusIdcoti" >
            <input type="hidden" id="hdnbusNvers" name="hdnbusNvers" >
            <input type="hidden" id="hdnbusIdprod" name="hdnbusIdprod" >
            <input type="hidden" id="hdnbusprod" name="hdnbusprod" >   

            <div class="row">
                <div class="col-sm-3">                                                 
                    <label>Tipo Ensayo</label>                        
                    <select class="form-control select2bs4" id="mcbobustipoensayo" name="mcbobustipoensayo">
                        <option value="" selected="Cargando..."></option>
                    </select>
                </div>
                <div class="col-sm-2">                                                 
                    <label>Estado Acreditado</label>                        
                    <select class="form-control" id="mcbobusacredensayo" name="mcbobusacredensayo">
                        <option value="" selected="selected"></option>
                        <option value="A">SI AC</option>
                        <option value="N">NO AC</option>
                    </select>
                </div>
                <div class="col-sm-4 text-left">                                                 
                    <label>Ensayo / Codigo / Laboratorio / Matriz</label>
                    <div class="input-group mb-3">
                      <input type="text" name="mtxtbusdescrensayo"id="mtxtbusdescrensayo" class="form-control rounded-0">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-primary"><a style="cursor:pointer;" id="btnBuscarEnsayo" ><i class="fas fa-search"></i></a></button>
                      </span>
                    </div>
                </div>
                <div class="col-sm-3 text-right">   
                    <button type="button" class="btn btn-outline-info" id="btnNuevoEnsayo"><i class="fas fa-plus"></i> Nuevo Ensayo</button>
                    <button type="reset" class="btn btn-secondary" id="btnRetornarEnsayo" data-dismiss="modal"><i class="fas fa-door-open"></i> Retornar</button>  
                </div>
            </div>
            <br>
            <div class="row"> 
                <div class="col-12">
                    <table id="tblbuscarEnsayos" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Ensayo</th>
                            <th>Codigo</th>
                            <th>Año</th>
                            <th>Acred.</th>
                            <th>Norma</th>
                            <th>Laboratorio</th>
                            <th>Costo</th>
                            <th>Tipo Ensayo</th>
                            <th>Matriz</th>
                            <th></th>
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
                
      </form>
    </div>
    <div class="modal-content" id="contenedorEditarensayo">
    </div>
  </div>
</div> 
<!-- /.Modal-->


<!-- /.modal- Insertar EnsayosLab --> 
<div class="modal fade" id="modalselensayo" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="frmEnsayosLab" name="frmEnsayosLab" action="<?= base_url('lab/coti/ccotizacion/setregensayoxprod')?>" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-lightblue">
            <h4 class="modal-title w-100 font-weight-bold">Ensayos por Laboratorio</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" id="mhdnmcensayo" name="mhdnmcensayo"> 
            <input type="hidden" id="hdnmIdcoti" name="hdnmIdcoti" >
            <input type="hidden" id="hdnmNvers" name="hdnmNvers" >
            <input type="hidden" id="hdnmIdprod" name="hdnmIdprod" >
            
            <input type="hidden" id="mtxtmCLab" name="mtxtmCLab" >
            <input type="hidden" id="hdnmAccion" name="hdnmAccion" >
            <div class="form-group">
                <div class="row"> 
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-archive"></i> <label id="lblmProducto"></label>
                        </h4>
                    </div>
                </div>                
            </div> 
            <div class="form-group">
                <div class="row"> 
                    <div class="col-2">
                        <label>Ensayo :</label>
                    </div>
                    <div class="col-3">
                        <h5 id="lblmCodigo">  
                        </h5>
                    </div>
                    <div class="col-7">
                        <h5 id="lblmEnsayo">  
                        </h5>
                    </div>
                </div>                
            </div>                        
            <div class="form-group"> 
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="text-info">Costo</div>
                        <div>    
                            <input type="number" name="mtxtmCosto"id="mtxtmCosto" class="form-control" placeholder="0.00" min="0.00">
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="text-info">Vias</div>                        
                        <div>    
                            <input type="number" name="mtxtmvias" class="form-control" id="mtxtmvias"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCerrarEnsayo" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info" id="mbtnGabarEnsayo">Grabar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<!-- /.modal-->
