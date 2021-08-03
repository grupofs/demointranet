<?php
    $idusuario = $this-> session-> userdata('s_idusuario');
    $cusuario = $this-> session-> userdata('s_cusuario');
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    MANTENIMIENTO
                    <small>Servicios</small>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
                    <li class="breadcrumb-item">PT</li>
                    <li class="breadcrumb-item active">Listar servicios</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="tabptcliente" style="background-color: #28a745;" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #000000;" id="tabReg1-tab"
                                   data-toggle="pill" href="#tabReg1" role="tab"
                                   aria-controls="tabReg1" aria-selected="true">LISTADO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #000000;" id="tabReg2-tab" data-toggle="pill"
                                   href="#tabReg2" role="tab" aria-controls="tabReg2"
                                   aria-selected="false">REGISTRO</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" >
                            <div class="tab-pane fade show active" id="tabReg1" role="tabpanel" >
                                <!--Contenedor de consulta-->
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Buscar Servicios</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="form-horizontal" id="frmBuscarTramite">
                                            <input name="idusuario" type="hidden" id="idusuario"
                                                   value="<?php echo $idusuario ?>">
                                            <input name="cusuario" type="hidden" id="cusuario"
                                                   value="<?php echo $cusuario ?>">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <label for="txtNombre" >Nombre :</label>
                                                    <input type="text" name="txtNombre" id="txtNombre"
                                                           class="form-control" value="">
                                                </div>
                                            </div>
                                            <br>
                                        </form>
                                    </div>
                                    <!--Contenedor de botones-->
                                    <div class="card-footer">
                                        <div class="col-12 text-right">
                                            <button type="button" class="btn btn-primary" id="btnBuscar"> <i class="fa fa-fw fa-search"></i> Buscar</button>
                                            <button type="button" class="btn btn-outline-info" id="btnNuevoArea"> <i class="fa fa-fw fa-plus"></i> Nuevo Servicio </button>
                                        </div>
                                    </div>
                                </div>
                                <!--FIN Contenedor de consulta-->
                                <!--Contenedor del DataTable-->
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Listado</h3>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <table id="tblLista" class="table table-striped table-bordered compact" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Servicio</th>
                                                    <th>Estado</th>
                                                    <th>Abreviatura</th>
                                                    <th>Tipo Servicio</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabReg2" role="tabpanel" >
                                <?php $this->load->view('ar/evalprod/area/varea_formulario'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>