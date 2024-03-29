<?php
$codcliente = $this->session->userdata('s_ccliente');
$idusuario = $this->session->userdata('s_idusuario');
$idrol = $this->session->userdata('s_idrol');
$cia = $this->session->userdata('s_cia');
?>

<style>
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		color: #000;
	}
</style>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">
					CONSULTA DE INSPECCIÓN A PROVEEDORES
				</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>cprincipal/principal">Home</a>
					</li>
					<li class="breadcrumb-item active">Consulta de Inspecciones</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card card-info card-outline card-tabs">
					<div class="card-header p-0 pt-1 border-bottom-0">
						<ul class="nav nav-tabs" id="tabptcliente" style="background-color: #17a2b8;" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" style="color: #000000;" id="tabReg1-tab"
								   data-toggle="pill" href="#tabReg1" role="tab"
								   aria-controls="tabReg1" aria-selected="true">LISTADO</a>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane fade show active" id="tabReg1" role="tabpanel">
								<!--Contenedor de consulta-->
								<div class="card card-info">
									<div class="card-header">
										<h3 class="card-title">Busqueda</h3>

										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse"><i
														class="fas fa-minus"></i></button>
										</div>
									</div>
									<div class="card-body">
										<form class="form-horizontal" id="frmBuscarTramite">
											<input type="hidden" id="idcliente"
												   value="<?php echo $codcliente ?>">
											<input type="hidden" id="idusuario"
												   value="<?php echo $idusuario; ?>">
											<input type="hidden" id="idrol"
												   value="<?php echo $idrol; ?>">
											<input type="hidden" id="idcia" name="idcia"
												   value="<?php echo $cia ?>">
											<div class="row">
												<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12"
													 id="contenedorProveedor">
													<div class="form-group">
														<label for="filtro_proveedor">Proveedor</label>
														<div class="input-group">
															<select name="filtro_proveedor" id="filtro_proveedor"
																	class="custom-select"></select>
														</div>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12"
													 id="contenedorMaquilador"
													 style="display: none" >
													<div class="form-group">
														<label for="filtro_maquilador">Maquilador</label>
														<div class="input-group">
															<select name="filtro_maquilador" id="filtro_maquilador"
																	class="custom-select"></select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-3 col-lg-4 col-md-5 col-sm-4 col-12">
													<div class="form-group">
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input"
																   checked
																   id="activar_fecha">
															<label for="activar_fecha" class="custom-control-label">
																Fecha de Inspección
															</label>
														</div>
														<div class="input-group">
															<input type="text" class="form-control datepicker"
																   id="fini" name="fini" aria-label=""
																   value="<?php echo '01/01/' . date('Y'); ?>"/>
															<div class="input-group-prepend">
																<span class="input-group-text">hasta</span>
															</div>
															<input type="text" class="form-control datepicker"
																   id="ffin" name="ffin" aria-label=""
																   value="<?php echo date('d/m/Y'); ?>"/>
														</div>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-7 col-sm-4 col-12">
													<div class="form-group">
														<label for="filtro_tipo_estado">Tipo Estado</label>
														<select name="filtro_tipo_estado" style="width: 100% !important;"
																id="filtro_tipo_estado" multiple
																class="custom-select select2"></select>
													</div>
												</div>
												<div class="col-xl-2 col-lg-4 col-md-6 col-sm-4 col-12">
													<div class="form-group">
														<label for="filtro_calificacion">Calificación</label>
														<select name="filtro_calificacion" id="filtro_calificacion" multiple
																class="custom-select select2" style="width: 100% !important;" >
															<option value="muy bueno">Muy Bueno</option>
															<option value="bueno">Bueno</option>
															<option value="regular">Regular</option>
															<option value="deficiente">Deficiente</option>
														</select>
													</div>
												</div>
												<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
													<div class="form-group">
														<label for="" class="d-block">
															Peligro
														</label>
														<div class="custom-control custom-control-inline custom-radio">
															<input type="radio" id="filtro_peligro_1"
																   name="filtro_peligro"
																   class="custom-control-input" value="S">
															<label class="custom-control-label"
																   for="filtro_peligro_1">
																Si
															</label>
														</div>
														<div class="custom-control custom-control-inline custom-radio">
															<input type="radio" id="filtro_peligro_2"
																   name="filtro_peligro"
																   class="custom-control-input" value="N">
															<label class="custom-control-label"
																   for="filtro_peligro_2">
																No
															</label>
														</div>
														<div class="custom-control custom-control-inline custom-radio">
															<input type="radio" id="filtro_peligro_3"
																   name="filtro_peligro"
																   checked
																   class="custom-control-input" value="">
															<label class="custom-control-label"
																   for="filtro_peligro_3">
																Todos
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="row" >
												<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
													<div class="form-group">
														<div class="icheck-primary d-inline">
															<input type="checkbox" id="chkBusavanzada">
															<label for="chkBusavanzada">
																Búsqueda Avanzada
															</label>
														</div>
													</div>
												</div>
											</div>
											<?php $this->load->view('oi/ctrlprov/vcons_insp_filtro'); ?>
										</form>
									</div>
									<!--Contenedor de botones-->
									<div class="card-footer">
										<div class="d-flex flex-row justify-content-end">
											<div class="col-sm-6 col-12 text-left">
												<button type="button" class="btn btn-success" id="btnDescargar">
													<i class="fa fa-fw fa-download"></i> Descargar Resultado
												</button>
											</div>
											<div class="col-sm-6 col-12 text-right">
												<button type="button" class="btn btn-primary" id="btnBuscar">
													<i class="fa fa-fw fa-search"></i> Buscar
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="card card-info">
									<div class="card-header with-border">
										<h3 class="card-title">Listado</h3>
									</div>
									<div class="card-body">
										<div>
											<table id="tblInspecciones" class="table table-striped table-bordered"
												   style="width:100%">
												<thead>
												<tr>
													<th style="width: 100px; min-width: 100px"></th>
													<th style="width: 180px; min-width: 180px"></th>
													<th>Fecha Inspección</th>
													<th>RUC</th>
													<th>Proveedor</th>
													<th>Establecimiento / Maquilador</th>
													<th>Dirección Establecimiento / Maquilador</th>
													<th>Área Cliente</th>
													<th>Línea</th>
													<th>Tipo Estado Servicio</th>
													<th>Comentario</th>
													<th>Nro de Informe</th>
													<th>Calificación</th>
													<th>Acción Correctiva</th>
													<th>Consultor</th>
													<th>Certificación</th>
													<th>Estado Certificación</th>
													<th>Licencia de Funcionamiento</th>
													<th>Empresa Inspectora</th>
													<th>Eval. Prod.</th>
													<th>Es Peligro</th>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->load->view('oi/ctrlprov/vcons_insp_ctiva'); ?>

<?php $this->load->view('oi/ctrlprov/vcons_insp_prov'); ?>
