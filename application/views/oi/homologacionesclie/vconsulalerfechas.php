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
      <div class="col-6">
        <h1 class="m-0 text-dark">CONSULTA DE ALERTAS POR FECHAS</h1>
      </div>
      <div class="col-6">
        <ol class="breadcrumb float-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Homologación</li>
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
                <h3 class="card-title"><b>BUSQUEDA PRODUCTOS VENCIDOS</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
        
            <div class="card-body">
                <input type="hidden" class="form-control" id="hdnCCliente" name="hdnCCliente" value="<?php echo $cclie ?>">
                <div class="row">  
                    <div class="col-md-3">      
                        <label>Vencidos al :</label>                      
                        <div class="input-group date" id="txtFvencido" data-target-input="nearest">
                            <input type="text" id="txtFvence" name="txtFvence" class="form-control datetimepicker-input" data-target="#txtFvencido" />
                            <div class="input-group-append" data-target="#txtFvencido" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Proveedor :</label>
                            <select class="form-control select2bs4" id="cboProveedor" name="cboProveedor" style="width: 100%;">
                                <option value="%" selected="selected">Cargando...</option>
                            </select>
                        </div>
                    </div>             
                </div>
            </div>             
                        
            <div class="card-footer justify-content-between" style="background-color: #D4EAFC;"> 
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
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE PRODUCTOS VENCIDOS</b></h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="tblalertasfecha" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Presentación</th>
                                <th>Requisito</th>
                                <th>Fecha</th>
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

<!-- Script Generales -->
<script type="text/javascript">
    var  baseurl = "<?php echo base_url();?>";          
</script>