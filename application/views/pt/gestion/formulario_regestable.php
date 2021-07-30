<style>
</style>
 
 <div class="card card-success card-outline"> 
    <div class="card-header">    
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">            
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border text-primary">ESTABLECIMIENTOS</legend>
                    <input type="hidden" id="mhdnestCcliente" name="mhdnestCcliente">
                    <input type="hidden" id="mhdnestDcliente" name="mhdnestDcliente">
                    <input type="hidden" id="mhdnestDdireccion" name="mhdnestDdireccion">
                    <input type="hidden" id="mhdnestDzid" name="mhdnestDzid">
                    <input type="hidden" id="mhdnestCpais" name="mhdnestCpais">
                    <input type="hidden" id="mhdnestDciudad" name="mhdnestDciudad">
                    <input type="hidden" id="mhdnestDestado" name="mhdnestDestado">
                    <input type="hidden" id="mhdnestCubigeo" name="mhdnestCubigeo">
                    <input type="hidden" id="mhdnestDubigeo" name="mhdnestDubigeo">
                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-md-2">
                                <h6><label>CLIENTE :</label></h6>
                            </div>
                            <div class="col-md-10">
                                <h6 id="lblCliente"></h6>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-2">
                                <h6><label>DIRECCIÓN :</label></h6>
                            </div>
                            <div class="col-md-10">
                                <h6 id="lblDirclie"></h6>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div> 
    <div class="card-footer justify-content-between"> 
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <button type="button" class="btn btn-secondary" id="btnRetornarLista"><i class="fas fa-undo-alt"></i> Retornar</button>
                    <button type="button" class="btn btn-outline-info" id="btnEstableNuevo"><i class="fas fa-plus"></i> Crear Nuevo</button>
                </div>
            </div>
        </div>
    </div> 
</div>

<div class="card card-success" id="cardListestable">
    <div class="card-header">
        <h3 class="card-title"><b>LISTADO</b></h3>
     </div>
                
    <div class="card-body">
        <div class="form-group">
            <div class="row"> 
                <div class="col-md-12">
                    <table id="tblListEstablecimiento" class="table table-striped table-bordered compact" style="width:100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Establecimiento</th>
                                <th>Dirección</th>
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
<div class="card card-success" id="cardRegestable">
    <div class="card-header">
        <h3 class="card-title"><b>REGISTRO</b></h3>
     </div>
                
    <div class="card-body">
        <form class="form-horizontal" id="frmMantEstablecimiento" name="frmMantEstablecimiento" action="<?= base_url('pt/cptcliente/mantgral_establecimiento')?>" method="POST" enctype="multipart/form-data" role="form"> 
            <input type="hidden" id="mhdnIdEstable" name="mhdnIdEstable"> 
            <input type="hidden" id="mhdnIdClie" name="mhdnIdClie">
            <input type="hidden" id="mhdnAccionEstable" name="mhdnAccionEstable" value="">
            <div class="form-group">
                <div class="row"> 
                    <div class="col-sm-9">
                        <div class="text-info">Establecimiento</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableCI" id="txtestableCI">
                        </div>
                    </div>   
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="text-info">Pais</div>
                        <div>
                            <select class="form-control" id="cboPaisEstable" name="cboPaisEstable" data-validation="required">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div> 
                    <div class="col-sm-3" id="boxCiudadEstable">
                        <div class="text-info">Ciudad</div>
                        <div>
                            <input type="text" class="form-control" name="txtCiudadEstable" id="txtCiudadEstable">
                        </div>
                    </div> 
                    <div class="col-sm-3" id="boxEstadoEstable">
                        <div class="text-info">Estado / Region / Provincia</div>
                        <div>
                            <input type="text" class="form-control" name="txtEstadoEstable" id="txtEstadoEstable">
                        </div>
                    </div> 
                    <div class="col-md-6" id="boxUbigeoEstable">
                        <div class="text-info">Departamento / Distrito / Provincia</div>
                        <div class="input-group mb-3">
                            <input type="text" id="mtxtUbigeoEstable" name="mtxtUbigeoEstable" class="form-control">
                            <span class="input-group-append">
                                <button type="button" id="btnBuscarUbigeoEstable" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <input type="hidden" id="hdnidubigeoEstable" name="hdnidubigeoEstable">
                    </div>
                    <div class="col-sm-3">
                        <div class="text-info">Codigo Postal / ZIP</div>
                        <div>
                            <input type="text" class="form-control" name="txtestablezip" id="txtestablezip">
                        </div>
                    </div> 
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">  
                    <div class="col-sm-9">
                        <div class="text-info">Dirección Planta</div>
                        <div>
                            <input type="text" class="form-control" name="txtestabledireccion" id="txtestabledireccion">
                        </div>
                    </div>   
                </div>                
            </div>
            <div class="form-group">
                <div class="row"> 
                    <div class="col-sm-4">
                        <div class="text-info">FCE(Establecimiento de conservas de alimentos)</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableFce" id="txtestableFce">
                        </div>
                    </div>   
                    <div class="col-sm-4">
                        <div class="text-info">ECP(Persona de contacto del establecimiento)</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableEcp" id="txtestableEcp">
                        </div>
                    </div>  
                    <div class="col-sm-4">
                        <div class="text-info">FFRN(Número de registro de instalación de alimentos)</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableFfrn" id="txtestableFfrn">
                        </div>
                    </div>  
                </div>                
            </div>
            <div class="form-group">
                <div class="row"> 
                    <div class="col-sm-4">
                        <div class="text-info">Responsable del proceso/calidad</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableresproceso" id="txtestableresproceso">
                        </div>
                    </div>   
                    <div class="col-sm-4">
                        <div class="text-info">Cargo Responsable</div>
                        <div>
                            <input type="text" class="form-control" name="txtestablecargo" id="txtestablecargo">
                        </div>
                    </div>  
                    <div class="col-sm-4">
                        <div class="text-info">Email</div>
                        <div>
                            <input type="text" class="form-control" name="txtestableEmail" id="txtestableEmail">
                        </div>
                    </div>  
                </div>                
            </div>
            <div class="form-group">
                <div class="row"> 
                    <div class="col-sm-4">
                        <div class="text-info">Telefono/Celular  Responsable</div>
                        <div>
                            <input type="text" class="form-control" name="txtestablecelu" id="txtestablecelu">
                        </div>
                    </div>   
                    <div class="col-sm-4">
                        <div class="text-info">Estado</div>                                        
                        <div>                            
                            <select class="form-control" id="cboestableEstado" name="cboestableEstado" data-validation="required">
                                <option value = "A" selected="selected">Activo</option>
                                <option value = "I">Inactivo</option>
                            </select>
                        </div>
                    </div>  
                </div>                
            </div>
            <div class="form-group">
                <div class="row">                                     
                    <div class="col-sm-12 text-right"> 
                        <button type="submit" class="btn btn-success" id="btnguardarestable"><i class="fa fa-fw fa-check"></i>Grabar</button> 
                        <button type="button" class="btn btn-secondary" id="btnCerrarEstable"><i class="fas fa-window-close"></i> Cerrar</button>
                    </div> 
                </div>                
            </div>                        
        </form>
    </div>
</div>


<!-- /.modal-ubigeo --> 
<div class="modal fade" id="modalUbigeoest" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="frmUbigeo" name="frmUbigeo" action="" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Seleccionar Ubigeo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">                                  
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-info">Departamento</div>
                        <div>                            
                            <select class="form-control select2bs4" id="cboDepaEsta" name="cboDepaEsta" style="width: 100%;">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>  
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Provincia</div>
                        <div>
                            <select class="form-control select2bs4" id="cboProvEsta" name="cboProvEsta">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>   
                </div>                
            </div>
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Distrito</div>
                        <div>
                            <select class="form-control select2bs4" id="cboDistEsta" name="cboDistEsta">
                                <option value="">Cargando...</option>
                            </select>
                        </div>
                    </div>   
                </div>                
            </div>             
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button id="btnSelUbigeoEsta" type="button" class="btn btn-success"><i class="fa fa-save"></i> Seleccionar</button>
            <button id="btncerrarUbigeoEsta" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div> 
<!-- /.modal-->
