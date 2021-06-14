<?php
    $idusuario = $this -> session -> userdata('s_idusuario');
    $cusuario = $this -> session -> userdata('s_cusuario');
?>

<style>
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
        background: red !important;
        color: white !important;
    }
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-address-book"></i> CONTRATOS</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Recursos Humanos</li>
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
                <h3 class="card-title"><b>BUSCAR CONTRATOS</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
          
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusuario ?>">
                <input type="hidden" class="form-control" id="hdnestadocontrato" name="hdnestadocontrato" value="A">
            </div>                
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <div class="col-md-6">                  
                        <input type="checkbox" name="swCesados" id="swCesados" data-toggle="toggle" checked data-bootstrap-switch  data-on-text="Vigentes" data-off-text="Cesados">
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                            <button type="button" role="button" class="btn btn-outline-info" id="btnNuevo" data-toggle="modal" data-target="#modalMantemple"><i class="fas fa-plus"></i> Crear Nuevo</button>
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
                        <h3 class="card-title"><b>LISTADO DE CONTRATOS</b></h3>
                    </div>
                
                    <div class="card-body">
                        <table id="tblListContratos" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th>Area</th>
                                <th></th>
                                <th></th>
                                <th>Año</th>
                                <th>Mes</th>
                                <th>Empleado</th>
                                <th>Fecha Inicio Contrato</th>
                                <th>Fecha Fin Contrato</th>
                                <th>Cargo</th>
                                <th>Sueldo</th>
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


<!-- /.modal-Mante Empleado --> 
<div class="modal fade" id="modalMantemple" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Mantenimiento Empleado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
        <form class="form-horizontal" id="frmMantemple" name="frmMantemple" action="<?= base_url('adm/rrhh/ccontratos/setregempleado')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnidempleado" name="mhdnidempleado">
            <input type="hidden" id="mhdnidadministrado" name="mhdnidadministrado">
            <input type="hidden" id="mhdnAccionempleado" name="mhdnAccionempleado">  
            <div class="form-group">  
                <div class="row">
                    <div class="col-6">
                        <h4><i class="fas fa-user-tie"></i> Datos <small> Personales</small></h4>
                    </div> 
                </div> 
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="text-info">Nro Documento<span class="text-requerido">*</span></div>
                        <div>    
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span id="btntipodoc">DNI</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onClick="javascript:DNI()">DNI</a>
                                        <a class="dropdown-item" onClick="javascript:EXT()">CExt</a>
                                    </div>
                                    <input type="hidden" id="mhdntipodoc" name="mhdntipodoc">  
                                </div>
                                <input type="text" name="mtxtnrodoc"id="mtxtnrodoc" class="form-control" >
                                <!--/.span class="input-group-append">
                                    <button type="button" id="btnbusadmi" class="btn btn-info btn-flat"><i class="fas fa-external-link-square-alt"></i></button>
                                </span--> 
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="text-info">Sexo</div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcbosexo" name="mcbosexo" style="width: 100%;">
                                <option value="" selected="selected">Sin Especificar</option>
                                <option value="F" >FEMENINO</option>
                                <option value="M" >MASCULINO</option>
                            </select>
                        </div>
                    </div>  
                    <div class="col-md-3"> 
                        <div class="text-info">Apellido Paterno</div>
                        <div>    
                            <input type="text" name="mtxtapepat"id="mtxtapepat" class="form-control" ><!-- disable -->
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Apellido Materno</div>
                        <div>    
                            <input type="text" name="mtxtapemat"id="mtxtapemat" class="form-control" ><!-- disable -->
                        </div>
                    </div>         
                </div>  
                <div class="row">
                    <div class="col-md-3"> 
                        <div class="text-info">Nombres</div>
                        <div>    
                            <input type="text" name="mtxtnombres"id="mtxtnombres" class="form-control" ><!-- disable -->
                        </div>
                    </div> 
                    <div class="col-md-4"> 
                        <div class="text-info">Email</div>
                        <div>    
                            <input type="text" name="mtxtemail"id="mtxtemail" class="form-control" ><!-- disable -->
                        </div>
                    </div>  
                    <div class="col-md-3"> 
                        <div class="text-info">Celular</div>
                        <div>    
                            <input type="text" name="mtxtcelular"id="mtxtcelular" class="form-control" ><!-- disable -->
                        </div>
                    </div> 
                    <div class="col-md-2"> 
                        <div class="text-info">Telefono</div>
                        <div>    
                            <input type="text" name="mtxttelefono"id="mtxttelefono" class="form-control" ><!-- disable -->
                        </div>
                    </div> 
                </div>  
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info">Direccion</div>
                        <div>    
                            <textarea type="text" name="mtxtdireccion"id="mtxtdireccion" class="form-control" rows="2"></textarea><!-- disable -->
                        </div>
                    </div>          
                </div>                
            </div>    
            
            <div style="border-top: 1px solid #ccc; padding-top: 10px;">     
            <div class="form-group">  
                <div class="row">
                    <div class="col-6">
                        <h4><i class="far fa-id-card"></i> Informacion <small> del empleado </small></h4>                        
                    </div>
                    <div class="col-6 text-right" id="divcia">                          
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="rdFS" name="rCia" checked>
                                <label for="rdFS"> FS </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="rdFSC" name="rCia" >
                                <label for="rdFSC">FSC</label>
                            </div>
                        </div>
                        <input type="hidden" id="hrdcia" name="hrdcia">
                    </div>
                </div>                 
                <div class="row">  
                    <div class="col-md-3">
                        <div class="text-info">Fecha Ingreso <span class="text-requerido">*</span></div>                    
                        <div class="input-group date" id="txtFIngreso" data-target-input="nearest">
                            <input type="text" id="txtFIngre" name="txtFIngre" class="form-control datetimepicker-input" data-target="#txtFIngreso" />
                            <div class="input-group-append" data-target="#txtFIngreso" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="col-md-2"> 
                        <div class="text-info">Anexo</div>
                        <div>    
                            <input type="text" name="mtxtanexo"id="mtxtanexo" class="form-control" ><!-- disable -->
                        </div>
                    </div>  
                    <div class="col-md-4"> 
                        <div class="text-info">Email Empresa</div>
                        <div>    
                            <input type="text" name="mtxtemailempre"id="mtxtemailempre" class="form-control" ><!-- disable -->
                        </div>
                    </div>  
                    <div class="col-md-3"> 
                        <div class="text-info">Celular Empresa</div>
                        <div>    
                            <input type="text" name="mtxtcelularempre"id="mtxtcelularempre" class="form-control" ><!-- disable -->
                        </div>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-info">Fecha Nacimiento</div>                    
                        <div class="input-group date" id="txtFNacimiento" data-target-input="nearest">
                            <input type="text" id="txtFNace" name="txtFNace" class="form-control datetimepicker-input" data-target="#txtFNacimiento" />
                            <div class="input-group-append" data-target="#txtFNacimiento" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Estado Civil</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcboestadocivil" name="mcboestadocivil" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                                <option value="S" >SOLTERO</option>
                                <option value="C" >CASADO</option>
                                <option value="V" >VIUDO</option>
                                <option value="D" >DIVORCIADO</option>
                                <option value="X" >CONVIVIENTE</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-1"> 
                        <div class="text-info">Hijos</div>
                        <div>    
                            <input type="text" name="mtxtnrohijos"id="mtxtnrohijos" class="form-control"  placeholder="0" min="0"><!-- disable -->
                        </div>
                    </div>    
                    <div class="col-md-2"> 
                        <div class="text-info">Pension</div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcbopension" name="mcbopension" style="width: 100%;">
                                <option value="0" selected="selected">::Elegir</option>
                                <option value="1" >SNP</option>
                                <option value="2" >AFP</option>
                            </select>
                        </div>
                    </div>        
                    <div class="col-md-3">
                        <div class="text-info">Entidad Pension</div>
                        <div class="input-group input-group-select-button">
                            <select class="form-control select2bs4" id="mcboentidadpension" name="mcboentidadpension" style="width: 100%;">
                                <option value="" selected="selected">Seleccionar...</option>
                            </select>
                            <div class="input-group-addon input-group-button">
                                <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewentidadpension" data-toggle="modal" data-target="#modalMantentidadpension"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>                     
                </div>                 
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="text-info">Banco </div>
                        <div class="input-group input-group-select-button">                            
                            <select class="form-control select2bs4" id="mcbobanco" name="mcbobanco" style="width: 100%;">
                                <option value="" selected="selected">Seleccionar...</option>
                            </select>
                            <div class="input-group-addon input-group-button">
                                <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewbanco" data-toggle="modal" data-target="#modalMantbanco"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="text-info">Nro Cta Sueldo</div>                        
                        <div>    
                            <input type="text" name="mtxtnroctasueldo"id="mtxtnroctasueldo" class="form-control" ><!-- disable -->
                        </div>
                    </div>   
                    <div class="col-md-4"> 
                        <div class="text-info">CCI Cta Sueldo</div>                        
                        <div>    
                            <input type="text" name="mtxtccictasueldo"id="mtxtccictasueldo" class="form-control" ><!-- disable -->
                        </div>
                    </div>             
                </div>                 
                <div class="row"> 
                    <div class="col-md-2"> 
                        <div class="text-info">EPS</div>
                        <div>                           
                            <select class="form-control select2bs4" id="mcboeps" name="mcboeps" style="width: 100%;">
                                <option value="N" selected="selected">NO</option>
                                <option value="S" >SI</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-6"> 
                        <div class="text-info">Profesión</div> 
                        <div class="input-group input-group-select-button">                 
                            <select class="form-control select2bs4" id="mcboprofesion" name="mcboprofesion" style="width: 100%;">
                                <option value="" selected="selected">Seleccionar...</option>
                            </select>
                            <div class="input-group-addon input-group-button">
                                <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewprofesion" data-toggle="modal" data-target="#modalMantprofesion"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="text-info">Nro Colegiatura</div>
                        <div>    
                            <input type="text" name="mtxtnrocoleg"id="mtxtnrocoleg" class="form-control" ><!-- disable -->
                        </div>
                    </div>
                </div>
                
            </div>         
            </div>
            
            <div style="border-top: 1px solid #ccc; padding-top: 10px;" id="divcontrato">     
            <div class="form-group">  
                <div class="row">
                    <div class="col-6">
                        <h4><i class="fas fa-file-signature"></i> Contrato <small> inicial </small></h4>                        
                    </div>
                </div>                 
                <div class="row"> 
                    <div class="col-md-3"> 
                        <div class="text-info">Area</div>                        
                        <div class="input-group input-group-select-button">                            
                            <select class="form-control select2bs4" id="mcboarea" name="mcboarea" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-4"> 
                        <div class="text-info">Sub Area</div>                        
                        <div class="input-group input-group-select-button">                            
                            <select class="form-control select2bs4" id="mcbosubarea" name="mcbosubarea" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-5"> 
                        <div class="text-info">Cargo</div>                        
                        <div class="input-group input-group-select-button">                            
                            <select class="form-control select2bs4" id="mcbocargo" name="mcbocargo" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
                            <div class="input-group-addon input-group-button">
                                <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewcargo" data-toggle="modal" data-target="#modalMantcargo"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div> 
                </div>    
                <div class="row"> 
                    <div class="col-md-3"> 
                        <div class="text-info">Modalidad</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcbomodalidad" name="mcbomodalidad" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                                <option value="PLA" >PLANILLA</option>
                                <option value="RXH" >RECIBOS HONORARIOS</option>
                                <option value="INT" >INTERMITENTE</option>
                                <option value="PRA" >PRACTICAS</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="text-info">Fecha Inicio <span class="text-requerido">*</span></div>                    
                        <div class="input-group date" id="txtFInicio" data-target-input="nearest">
                            <input type="text" id="txtFIni" name="txtFIni" class="form-control datetimepicker-input" data-target="#txtFInicio" />
                            <div class="input-group-append" data-target="#txtFInicio" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div>   
                    <div class="col-md-3">
                        <div class="text-info">Fecha Termino <span class="text-requerido">*</span></div>                    
                        <div class="input-group date" id="txtFTermino" data-target-input="nearest">
                            <input type="text" id="txtFTerm" name="txtFTerm" class="form-control datetimepicker-input" data-target="#txtFTermino" />
                            <div class="input-group-append" data-target="#txtFTermino" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Sueldo</div>
                        <div>    
                            <input type="number" name="mtxtsueldo"id="mtxtsueldo" class="form-control" ><!-- disable -->
                        </div>
                    </div>
                </div>             
            </div>                     
            </div>
        </form>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCManteemp" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantemple" class="btn btn-info" id="mbtnGManteemp">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Mante Contratos --> 
<div class="modal fade" id="modalMantcontratos" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registrar Contratos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
            <div class="row">
                <div class="col-md-6">
                    <table id="tblContratos" class="table table-striped table-bordered compact" style="width:50%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>FECHA INICIO</th>
                            <th>FECHA TERMINO</th>
                            <th>ESTADO</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>               
                    </table> 
                </div>
                <div class="col-md-6">
                <label id="nomempleado"></label>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border text-primary">Registro</legend>  
                    <form class="form-horizontal" id="frmMantcontratos" name="frmMantcontratos" action="<?= base_url('adm/rrhh/ccontratos/setcontratos')?>" method="POST" enctype="multipart/form-data" role="form"> 
                        <input type="hidden" id="mhdnidcontrato" name="mhdnidcontrato">
                        <input type="hidden" id="mhdnidempleado_cont" name="mhdnidempleado_cont">
                        <input type="hidden" id="hrdcia_cont" name="hrdcia_cont">
                        <input type="hidden" id="mhdnAccioncontrato" name="mhdnAccioncontrato">
                        <div class="form-group">        
                            <div class="row"> 
                                <div class="col-md-6">
                                    <div class="text-info">Fecha Inicio <span class="text-requerido">*</span></div>                    
                                    <div class="input-group date" id="txtFInicio_cont" data-target-input="nearest">
                                        <input type="text" id="txtFIni_cont" name="txtFIni_cont" class="form-control datetimepicker-input" data-target="#txtFInicio_cont" />
                                        <div class="input-group-append" data-target="#txtFInicio_cont" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> 
                                </div>   
                                <div class="col-md-6">
                                    <div class="text-info">Fecha Termino <span class="text-requerido">*</span></div>                    
                                    <div class="input-group date" id="txtFTermino_cont" data-target-input="nearest">
                                        <input type="text" id="txtFTerm_cont" name="txtFTerm_cont" class="form-control datetimepicker-input" data-target="#txtFTermino_cont" />
                                        <div class="input-group-append" data-target="#txtFTermino_cont" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> 
                                </div>  
                            </div>      
                            <div class="row"> 
                                <div class="col-md-6"> 
                                    <div class="text-info">Area</div>                        
                                    <div class="input-group input-group-select-button">                            
                                        <select class="form-control select2bs4" id="mcboarea_cont" name="mcboarea_cont" style="width: 100%;">
                                            <option value="" selected="selected">Ninguno</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="text-info">Sub Area</div>                        
                                    <div class="input-group input-group-select-button">                            
                                        <select class="form-control select2bs4" id="mcbosubarea_cont" name="mcbosubarea_cont" style="width: 100%;">
                                            <option value="" selected="selected">Ninguno</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>    
                            <div class="row">  
                                <div class="col-md-7"> 
                                    <div class="text-info">Modalidad</div>                        
                                    <div>                            
                                        <select class="form-control select2bs4" id="mcbomodalidad_cont" name="mcbomodalidad_cont" style="width: 100%;">
                                            <option value="" selected="selected">Ninguno</option>
                                            <option value="PLA" >PLANILLA</option>
                                            <option value="RXH" >RECIBOS HONORARIOS</option>
                                            <option value="INT" >INTERMITENTE</option>
                                            <option value="PRA" >PRACTICAS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5"> 
                                    <div class="text-info">Sueldo</div>
                                    <div>    
                                        <input type="number" name="mtxtsueldo_cont"id="mtxtsueldo_cont" class="form-control" ><!-- disable -->
                                    </div>
                                </div> 
                            </div>    
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="text-info">Cargo</div>                        
                                    <div class="input-group input-group-select-button">                            
                                        <select class="form-control select2bs4" id="mcbocargo_cont" name="mcbocargo_cont" style="width: 100%;">
                                            <option value="" selected="selected">Ninguno</option>
                                        </select>
                                        <div class="input-group-addon input-group-button">
                                            <button type="button" role="button" class="btn btn-outline-info" id="mbtnnewcargo_cont" data-toggle="modal" data-target="#modalMantcargo"><i class="fas fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </form>
                </fieldset>
                </div>
            </div>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCMantcontrato" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantcontratos" class="btn btn-info" id="mbtnGMantcontrato">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Mante EntidadPension --> 
<div class="modal fade" id="modalMantentidadpension" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registrar Entidad Pension</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
        <form class="form-horizontal" id="frmMantentidadpension" name="frmMantentidadpension" action="<?= base_url('adm/rrhh/ccontratos/setentidadpension')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnidpensionentidad" name="mhdnidpensionentidad">
            <input type="hidden" id="mhdnAccionentidadpension" name="mhdnAccionentidadpension">
            <div class="form-group">        
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info">Pension</div>
                        <div>                            
                            <select class="form-control select2bs4" id="cbotipopension" name="cbotipopension" style="width: 100%;">
                                <option value="2" selected="selected">AFP</option>
                                <option value="1" >SNP</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <div class="text-info">Descripcion <span class="text-requerido">*</span></div>
                        <div>    
                            <input type="text" name="txtdesentidadpension"id="txtdesentidadpension" class="form-control"><!-- disable -->
                        </div>
                    </div>   
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCMantentidadpension" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantentidadpension" class="btn btn-info" id="mbtnGMantentidadpension">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Mante Banco --> 
<div class="modal fade" id="modalMantbanco" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registrar Banco</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
        <form class="form-horizontal" id="frmMantbanco" name="frmMantbanco" action="<?= base_url('adm/rrhh/ccontratos/setbanco')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnidbanco" name="mhdnidbanco">
            <input type="hidden" id="mhdnAccionbanco" name="mhdnAccionbanco">
            <div class="form-group">        
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info">Descripcion <span class="text-requerido">*</span></div>
                        <div>    
                            <input type="text" name="txtdesbanco"id="txtdesbanco" class="form-control"><!-- disable -->
                        </div>
                    </div>   
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCMantbanco" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantbanco" class="btn btn-info" id="mbtnGMantbanco">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Mante Profesion --> 
<div class="modal fade" id="modalMantprofesion" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registrar Profesion</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
        <form class="form-horizontal" id="frmMantprofesion" name="frmMantprofesion" action="<?= base_url('adm/rrhh/ccontratos/setprofesion')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnidprofesion" name="mhdnidprofesion">
            <input type="hidden" id="mhdnAccionprofesion" name="mhdnAccionprofesion">
            <div class="form-group">        
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info">Profesion</div>
                        <div>               
                            <input type="text" name="txtdesprofesion"id="txtdesprofesion" class="form-control"><!-- disable -->
                        </div>
                    </div>   
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCMantprofesion" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantprofesion" class="btn btn-info" id="mbtnGMantprofesion">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->

<!-- /.modal-Mante Cargo --> 
<div class="modal fade" id="modalMantcargo" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registrar Cargo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
        <form class="form-horizontal" id="frmMantcargo" name="frmMantcargo" action="<?= base_url('adm/rrhh/ccontratos/setcargo')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnidcargo" name="mhdnidcargo">
            <input type="hidden" id="mhdnAccioncargo" name="mhdnAccioncargo">
            <input type="hidden" id="mhdncargotipo" name="mhdncargotipo">
            <div class="form-group">        
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info">Cargo</div>
                        <div>               
                            <input type="text" name="txtdescargo"id="txtdescargo" class="form-control"><!-- disable -->
                        </div>
                    </div>   
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer w-100 d-flex flex-row" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCMantcargo" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="frmMantcargo" class="btn btn-info" id="mbtnGMantcargo">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->