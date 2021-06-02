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

            </div>                
                        
            <div class="card-footer justify-content-between"> 
                <div class="row">
                    <!--<div class="col-md-2"> 
                        <div id="console-event"></div>                   
                        <input type="checkbox" name="swVigencia" id="swVigencia" data-toggle="toggle" checked data-bootstrap-switch  data-on-text="Activos" data-off-text="Inactivos">
                    </div>-->
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button>    
                            <button type="button" class="btn btn-outline-info" id="btnNuevo" data-toggle="modal" data-target="#modalMantemple"><i class="fas fa-plus"></i> Crear Nuevo</button>
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
<div class="modal fade" id="modalMantemple" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <form class="form-horizontal" id="frmMantemple" name="frmMantemple" action="<?= base_url('adm/rrhh/ccontratos/setregempleado')?>" method="POST" enctype="multipart/form-data" role="form"> 
        <div class="modal-header text-center bg-info">
            <h4 class="modal-title w-100 font-weight-bold">Mantenimiento Empleado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
            <input type="hidden" id="mhdnidempleado" name="mhdnidempleado">
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
                    <div class="col-6 text-right">                          
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
                    <div class="col-sm-3">
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
                    <div class="col-sm-3">
                        <div class="text-info">Fecha Nacimiento <span class="text-requerido">*</span></div>                    
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
                    <div class="col-md-2"> 
                        <div class="text-info">Hijos</div>
                        <div>    
                            <input type="text" name="mtxtnrohijos"id="mtxtnrohijos" class="form-control"  placeholder="0" min="0"><!-- disable -->
                        </div>
                    </div>   
                    <div class="col-md-3"> 
                        <div class="text-info">Profesión</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcboprofesion" name="mcboprofesion" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                                <option value="ABOGADO" >DERECHO</option>
                                <option value="ADMINISTRADOR" >ADMINISTRACION</option>
                                <option value="ADUANERO" >ADUANERO</option>
                                <option value="AGENTE DE SERVICIO" >AGENTE DE SERVICIO</option>
                                <option value="AGENTE DE VENTAS" >AGENTE DE VENTAS</option>
                                <option value="AGRONOMO" >AGRONOMO</option>
                                <option value="ALMACENERO" >ALMACENERO</option>
                                <option value="ANALISTA, SISTEMAS INFORMATICOS" >ANALISTA, SISTEMAS INFORMATICOS</option>
                                <option value="ARQUITECTO" >ARQUITECTO</option>
                                <option value="ASESOR CONTABLE" >ASESOR CONTABLE</option>
                                <option value="ASISTENTE SOCIAL" >ASISTENTE SOCIAL</option>
                                <option value="AUDITOR" >AUDITOR</option>
                                <option value="AUXILIAR FARMACEUTICO" >AUXILIAR FARMACEUTICO</option>
                                <option value="BIOLOGO" >BIOLOGO</option>
                                <option value="BIOQUIMICO" >BIOQUIMICO</option>
                                <option value="BOTANICO" >BOTANICO</option>
                                <option value="CONSERJE" >CONSERJE</option>
                                <option value="CONTADOR" >CONTADOR</option>
                                <option value="DISEÑADOR, GRAFICO" >DISEÑADOR, GRAFICO</option>
                                <option value="ESTADISTICO" >ESTADISTICO</option>
                                <option value="FARMACEUTICO" >FARMACEUTICO</option>
                                <option value="FARMACEUTICO" >HOTOLERIA Y TURISMO</option>
                                <option value="INGENIERO AGROINDUSTRIAL" >INGENIERO AGROINDUSTRIAL</option>
                                <option value="INGENIERO AGRONOMO" >INGENIERO AGRONOMO</option>
                                <option value="INGENIERO AGRONOMO" >INGENIERO ALIMENTOS</option>
                                <option value="INGENIERO BIOQUIMICO INDUSTRIAL" >INGENIERO BIOQUIMICO INDUSTRIAL</option>
                                <option value="INGENIERO CIVIL" >INGENIERO CIVIL</option>
                                <option value="INGENIERO DE MINAS" >INGENIERO DE MINAS</option>
                                <option value="INGENIERO FORESTAL" >INGENIERO FORESTAL</option>
                                <option value="INGENIERO INDUSTRIAL" >INGENIERO INDUSTRIAL</option>
                                <option value="INGENIERO INDUSTRIAL" >INGENIERO DE INDUSTRIAS ALIMENTARIAS</option>
                                <option value="INGENIERO MECANICO" >INGENIERO MECANICO</option>
                                <option value="INGENIERO METALURGICO" >INGENIERO METALURGICO</option>
                                <option value="INGENIERO PESQUERO" >INGENIERO PESQUERO</option>
                                <option value="INGENIERO QUIMICO" >INGENIERO QUIMICO</option>
                                <option value="INGENIERO, SISTEMAS INFORMATICOS" >INGENIERO EN SISTEMAS E INFORMATICA</option>
                                <option value="INGENIERO QUIMICO" >INGENIERO ZOOTECNISTA</option>
                                <option value="INSPECTOR, CONTROL DE CALIDAD" >INSPECTOR EN CONTROL DE CALIDAD</option>
                                <option value="INSTRUMENTISTA" >INSTRUMENTISTA</option>
                                <option value="INTERPRETE" >INTERPRETE</option>
                                <option value="INTERPRETE" >NEGOCIOS INTERNACIONALES</option>
                                <option value="INTERPRETE" >NUTRICION Y DIETETICA</option>
                                <option value="OPERADOR, COMPUTADORA" >OPERADOR DE COMPUTADORA</option>
                                <option value="PRACTICANTE" >PRACTICANTE</option>
                                <option value="PROGRAMADOR, INFORMATICA/ANALISIS DE BASE DE DATOS" >PROGRAMADOR, INFORMATICA/ANALISIS DE BASE DE DATOS</option>
                                <option value="PSICOLOGO" >PSICOLOGO</option>
                                <option value="QUIMICO" >QUIMICO</option>
                                <option value="QUIMICO, FARMACIA" >QUIMICO FARMACEUTICO</option>
                                <option value="RECEPCIONISTA" >RECEPCIONISTA</option>
                                <option value="SECRETARIA" >SECRETARIADO</option>
                                <option value="TECNICO AGRONOMO" >TECNICO AGRONOMO</option>
                                <option value="TECNICO CONTABLE EMPRESARIAL" >TECNICO CONTABLE EMPRESARIAL</option>
                                <option value="TECNICO EN LABORATORIO CLINICO" >TECNICO EN LABORATORIO CLINICO</option>
                                <option value="TECNICO, ALIMENTOS" >TECNICO EN ALIMENTOS</option>
                                <option value="TECNICO, ANALISIS INFORMATICO" >TECNICO EN COMPUTACION</option>
                                <option value="TECNICO, ANALISTA QUIMICO" >TECNICO EN ANALISTA QUIMICO</option>
                                <option value="ABOGADO" >TRADUCTOR</option>
                                <option value="OCUPACIÓN NO ESPECIFICADA" >OCUPACIÓN NO ESPECIFICADA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"> 
                        <div class="text-info">Nro Colegiatura</div>
                        <div>    
                            <input type="text" name="mtxtnrocoleg"id="mtxtnrocoleg" class="form-control" ><!-- disable -->
                        </div>
                    </div> 
                </div>                 
                <div class="row">
                    <div class="col-md-1"> 
                        <div class="text-info">EPS</div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcboeps" name="mcboeps" style="width: 100%;">
                                <option value="N" selected="selected">NO</option>
                                <option value="S" >SI</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-2"> 
                        <div class="text-info">Pension</div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcbopension" name="mcbopension" style="width: 100%;">
                                <option value="AFP" selected="selected">AFP</option>
                                <option value="SNP" >SNP</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="text-info">Entidad Pension</div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcboentidadpension" name="mcboentidadpension" style="width: 100%;">
                                <option value="" selected="selected">Seleccionar...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="text-info">Banco </div>
                        <div>                            
                            <select class="form-control select2bs4" id="mcbobanco" name="mcbobanco" style="width: 100%;">
                                <option value="" selected="selected">Seleccionar...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5"> 
                        <div class="text-info">Nro Cta Sueldo</div>                        
                        <div>    
                            <input type="text" name="mtxtnroctasueldo"id="mtxtnroctasueldo" class="form-control" ><!-- disable -->
                        </div>
                    </div>
                </div> 
            </div>         
            </div>
            
            <div style="border-top: 1px solid #ccc; padding-top: 10px;">     
            <div class="form-group">  
                <div class="row">
                    <div class="col-6">
                        <h4><i class="fas fa-file-signature"></i> Contrato <small> inicial </small></h4>                        
                    </div>
                </div>                 
                <div class="row">  
                    <div class="col-sm-3">
                        <div class="text-info">Fecha Inicio <span class="text-requerido">*</span></div>                    
                        <div class="input-group date" id="txtFInicio" data-target-input="nearest">
                            <input type="text" id="txtFIni" name="txtFIni" class="form-control datetimepicker-input" data-target="#txtFInicio" />
                            <div class="input-group-append" data-target="#txtFInicio" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div>   
                    <div class="col-sm-3">
                        <div class="text-info">Fecha Termino <span class="text-requerido">*</span></div>                    
                        <div class="input-group date" id="txtFTermino" data-target-input="nearest">
                            <input type="text" id="txtFTerm" name="txtFTerm" class="form-control datetimepicker-input" data-target="#txtFTermino" />
                            <div class="input-group-append" data-target="#txtFTermino" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Area</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcboarea" name="mcboarea" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Sub Area</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcbosubarea" name="mcbosubarea" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
                        </div>
                    </div> 
                </div>    
                <div class="row"> 
                    <div class="col-md-3"> 
                        <div class="text-info">Modalidad</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcbomodalidad" name="mcbomodalidad" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                                <option value="S" >SOLTERO</option>
                                <option value="C" >CASADO</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-3"> 
                        <div class="text-info">Cargo</div>                        
                        <div>                            
                            <select class="form-control select2bs4" id="mcbocargo" name="mcbocargo" style="width: 100%;">
                                <option value="" selected="selected">Ninguno</option>
                            </select>
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
        </div>
        <div class="modal-footer justify-content-between" style="background-color: #D4EAFC;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="reset" class="btn btn-default" id="mbtnCManteemp" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info" id="mbtnGManteemp">Grabar</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
  </div>
</div> 
<!-- /.modal-->