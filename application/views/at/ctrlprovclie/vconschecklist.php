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
        <h1 class="m-0 text-dark">Consulta Checklist</h1>
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
<section class="content">
    <div class="container-fluid">  
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><b>BUSQUEDA</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
          
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnIdUsuario" name="hdnIdUsuario" value="<?php echo $idusu ?>">
                <input type="hidden" class="form-control" id="hdnCUsuario" name="hdnCUsuario" value="<?php echo $cusu ?>">
                <input type="hidden" class="form-control" id="hdnCCliente" name="hdnCCliente" value="<?php echo $cclie ?>">
            </div>             
                        
            <div class="card-footer justify-content-between"> 
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
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE CHECKLIST</b></h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="tblconschecklist" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Check List Descripción</th>
                                <th>Servicio</th>
                                <th>Sistema</th>
                                <th>Organismo</th>
                                <th>Rubro</th>
                                <th>Uso</th>
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
</section>
<!-- /.Main content -->

<!-- /.modal-leyenda--> 
<div class="modal fade" id="modalLeyenda" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Leyenda</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body"> 
            <div class="form-group">  
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="text-info"> <label id="nameChkl"></label></div>
                        <div id="nameLeyenda"></div>
                    </div> 
                </div> 
            </div>           
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCreactrl" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div> 
<!-- /.modal-->