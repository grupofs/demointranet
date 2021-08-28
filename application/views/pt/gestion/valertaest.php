<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $codusu = $this -> session -> userdata('s_cusuario');
    $infousuario = $this->session->userdata('s_infodato');
    $idempleado = $this->session->userdata('s_idempleado');
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-file-alt"></i> Estados Pendientes</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Gestion Procesos Termicos</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Informes con Estados Pendientes</h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">                        
                        <input type="hidden" id="hdidempleado" name="hdidempleado" value= <?php echo $idempleado; ?> >
                        <table id="tblListalertaest" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>N° Informe</th>
                                <th>Estado</th>
                                <th>Fecha Informe</th>
                                <th>N° Propuesta</th>
                                <th>Cliente</th>
                                <th>Detalle</th>
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


<script type="text/javascript">
    var baseurl = "<?php echo base_url();?>"; 
</script>