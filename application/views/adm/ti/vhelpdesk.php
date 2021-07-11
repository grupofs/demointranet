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
        <h1 class="m-0 text-dark"><i class="fas fa-ticket-alt"></i> TICKETS</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Helpdesk Sistemas</li>
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
                        <ul class="nav nav-tabs tabfsc" id="tabsis" role="tablist">                    
                            <li class="nav-item">
                                <a class="nav-link active" id="tabsis-list-tab" data-toggle="pill" href="#tabsis-list" role="tab" aria-controls="tabsis-list" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tabsis-reg-tab" data-toggle="pill" href="#tabsis-reg" role="tab" aria-controls="tabsis-reg" aria-selected="false">REGISTRO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabsis-tabContent">
                            <div class="tab-pane fade show active" id="tabsis-list" role="tabpanel" aria-labelledby="tabsis-list-tab">                                
                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title">BUSQUEDA</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div> 
                                    
                                    <div class="card-body">
                                    </div>                
                                                
                                    <div class="card-footer justify-content-between"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-primary" id="btnBuscar"><i class="fas fa-search"></i> Buscar</button> 
                                                    <button type="button" class="btn btn-outline-info" id="btnNuevo" ><i class="fas fa-plus"></i> Nuevo Ticket</button>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-lightblue">
                                            <div class="card-header">
                                                <h3 class="card-title">Listado de Tickets</h3>
                                            </div>                                        
                                            <div class="card-body" style="overflow-x: scroll;">
                                                <table id="tblListTicket" class="table table-striped table-bordered compact" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th></th>
                                                        <th>Cotizacion</th>
                                                        <th>Fecha</th>
                                                        <th>Orden Trabajo</th>
                                                        <th>Monto sin IGV</th>
                                                        <th>Monto Total</th>
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
                            <div class="tab-pane fade" id="tabsis-reg" role="tabpanel" aria-labelledby="tabsis-reg-tab">
                                <fieldset class="scheduler-border-fsc" id="regTicket">
                                    <legend class="scheduler-border-fsc text-primary">REG. TICKET</legend>
                                    <div class="card card-outline card-lightblue"> 
                                        <div class="card-header">
                                            <h3 id="nroticket" class="card-title">Nro Ticket ::</h3>
                                        </div>         

                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="row" id="datoempleado">
                                                    <div class="col-md-4">
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="text-info">Empleado <span class="text-requerido">*</span></div>
                                                        <select class="form-control select2bs4" id="cboempleado" name="cboempleado" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="text-info">Equipo <span class="text-requerido">*</span></div>
                                                        <select class="form-control select2bs4" id="cboequipo" name="cboequipo" style="width: 100%;">
                                                            <option value="" selected="selected">Cargando...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">  
                                                        <div class="text-info">Fecha Registro </div>
                                                        <input type="text" name="mtxtfregistro"id="mtxtfregistro">
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="text-info">Via de contacto</div>
                                                        <div>
                                                            <select class="form-control" id="cboviacom" name="cboviacom">
                                                                <option value="" selected="selected">::Elegir</option>
                                                                <option value="T">TELEFONO</option>
                                                                <option value="W">WHATSAPP</option>
                                                                <option value="E">EMAIL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">                                                        
                                                        <div class="text-info">Tipo Incidente</div>
                                                        <div>
                                                            <select class="form-control" id="cbotipoincidente" name="cbotipoincidente">
                                                                <option value="" selected="selected">::Elegir</option>
                                                                <option value="ST">SOPORTE TECNICO</option>
                                                                <option value="PD">PLATAFORMA DESARROLLO</option>
                                                                <option value="PR">PLATAFORMA REQUERIMIENTO</option>
                                                                <option value="OF">OFFICE 365</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">                                                        
                                                        <div class="text-info">Prioridad</div>
                                                        <div>
                                                            <select class="form-control" id="cboprioridad" name="cboprioridad">
                                                                <option value="" selected="selected">::Elegir</option>
                                                                <option value="U">URGENTE</option>
                                                                <option value="A">ALTO</option>
                                                                <option value="M">MEDIO</option>
                                                                <option value="B">BAJO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="text-info">Estado</div>
                                                        <div>
                                                            <select class="form-control" id="cboestado" name="cboestado">
                                                                <option value="" selected="selected">::Elegir</option>
                                                                <option value="N">NUEVO</option>
                                                                <option value="A">ABIERTO</option>
                                                                <option value="C">CONCLUIDO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>     
                                                <div class="row">
                                                    <div class="col-md-12">  
                                                        <div class="text-info">Asunto </div>
                                                        <input type="text" name="mtxtasunto"id="mtxtasunto" class="form-control">
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-12">  
                                                        <div class="text-info">Detalle </div>
                                                        <textarea type="text" name="mtxtdetalle"id="mtxtdetalle" class="form-control summernotebasic"> </textarea>
                                                    </div>
                                                </div>  
                                            </div> 
                                        </div>          
                                                    
                                        <div class="card-footer justify-content-between"> 
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12 text-right"> 
                                                        <button type="submit" class="btn btn-success" id="btnRegistrar"><i class="fas fa-save"></i> Grabar</button> 
                                                        <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button> 
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
