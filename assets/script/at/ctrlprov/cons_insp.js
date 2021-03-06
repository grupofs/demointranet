/*!
 *
 * @version 1.0.0
 */

const objInsp = {};

$(function () {

	/**
	 * Verifica si la carga esta activa o no
	 * @type {boolean}
	 */
	objInsp.loading = false;

	/**
	 * ID de la inspección abierta para realizar su descarga
	 * @type {integer|null}
	 */
	objInsp.pdf = {
		codigo: '',
		fecha: ''
	};

	/**
	 * Activa la carga de la busqueda
	 */
	objInsp.activeLoading = function () {
		objInsp.loading = true;
		objPrincipal.botonCargando($('#btnBuscar'));
	};

	/**
	 * Desactiva la carga de la busqueda
	 */
	objInsp.inactiveLoading = function () {
		objInsp.loading = false;
		objPrincipal.liberarBoton($('#btnBuscar'));
	};

	/**
	 * Realiza el filtro de las inspecciones
	 */
	objInsp.search = function () {
		if (objInsp.loading) {
			objPrincipal.alert('warning', 'Aún se encuentra activa la busqueda. Por favor espere!');
		} else {
			objInsp.activeLoading();
			let filtroPeligro = '';
			if ($('#filtro_peligro_1').is(':checked')) {
				filtroPeligro = 'S';
			}
			if ($('#filtro_peligro_2').is(':checked')) {
				filtroPeligro = 'N';
			}
			const oTableLista = $('#tblInspecciones').DataTable({
				'bJQueryUI': true,
				'scrollY': '650px',
				'scrollX': true,
				'processing': true,
				'bDestroy': true,
				'paging': true,
				'info': true,
				'filter': true,
				'ajax': {
					"url": BASE_URL + 'at/ctrlprov/ccons_insp/search',
					"type": "POST",
					"data": function (d) {
						d.afecha = ($('#activar_fecha').is(':checked')) ? 1 : 0;
						d.fini = $('#fini').val();
						d.ffin = $('#ffin').val();
						d.ccia = $('#idcia').val();
						d.filtro_cliente = $('#filtro_cliente').val();
						d.filtro_proveedor = $('#filtro_proveedor').val();
						d.filtro_maquilador = $('#filtro_maquilador').val();
						d.filtro_tipo_estado = $('#filtro_tipo_estado').val();
						d.filtro_cliente_area = $('#filtro_cliente_area').val();
						d.filtro_linea_proveedor = $('#filtro_linea_proveedor').val();
						d.filtro_calificacion = $('#filtro_calificacion').val();
						d.filtro_establecimiento_maqui = $('#filtro_establecimiento_maqui').val();
						d.filtro_dir_establecimiento_maqui = $('#filtro_dir_establecimiento_maqui').val();
						d.filtro_nro_informe = $('#filtro_nro_informe').val();
						d.filtro_peligro = filtroPeligro;
					},
					dataSrc: function (data) {
						objInsp.inactiveLoading();
						return data.items;
					},
					error: function () {
						objPrincipal.alert('warning', 'Error en el proceso de ejecución.', 'Vuelva a intentarlo más tarde.');
						objInsp.inactiveLoading();
					}
				},
				'columns': [
					{
						"orderable": false,
						render: function (data, type, row) {
							const rowId = 'dropdown-' + row.CODIGO + row.FECHAINSPECCION;
							let htmlRow = '<div class="dropdown">';
							htmlRow += '<button type="button" class="btn btn-secondary btn-sm dropdown-toggle" role="button" id="' + rowId + '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
							htmlRow += '<i class="fa fa-bars" ></i> Opciones';
							htmlRow += '</button>';
							htmlRow += '<div class="dropdown-menu" aria-labelledby="' + rowId + '">';
							let tipoEstado = String(row.TIPOESTADOSERVICIO).toLowerCase().trim();
							if (tipoEstado === 'concluido ok') {
								if (!row.DUBICACIONFILESERVERPDF) {
									htmlRow += '<button type="button" class="btn btn-sm dropdown-item open-pdf" data-codigo="' + row.CODIGO + '" data-fecha="' + row.FECHAINSPECCION + '" ><i class="fa fa-file-pdf" ></i> Ver Informe Técnico</button>';
								}
							}
							let DIRECCIONPROV = (row.DIRECCIONPROV) ? row.DIRECCIONPROV : '';
							let ESTABLECIMIENTOPROV = (row.ESTABLECIMIENTOPROV) ? row.ESTABLECIMIENTOPROV : '';
							let MAQUILADOR = (row.MAQUILADOR) ? row.MAQUILADOR : '';
							let dirProvMaqui = (DIRECCIONPROV) ? ESTABLECIMIENTOPROV : ESTABLECIMIENTOPROV + ' - ' + MAQUILADOR;
							htmlRow += '<button type="button" class="btn btn-sm dropdown-item ver-accion-correctiva" data-excel="' + row.DUBICACIONFILESERVERAC + '" data-codigo="' + row.CODIGO + '" data-fecha="' + row.FECHAINSPECCION + '" data-proveedor="' + row.PROVEEDOR + '" data-direccion="' + dirProvMaqui + '" ><i class="fa fa-th-list" ></i> Ver Acciones Correctivas</button>';
							htmlRow += '<button type="button" class="btn btn-sm dropdown-item ver-proveedor" data-codigo="' + row.CODIGO + '" data-proveedor="' + row.CPROVEEDOR + '" ><i class="fa fa-eye" ></i> Datos del Proveedor</button>';
							htmlRow += '</div>';
							htmlRow += '</div>';
							return htmlRow;
						}
					},
					{
						"orderable": false,
						render: function (data, type, row) {
							if (row.DUBICACIONFILESERVER) {
								return '<a href="' + baseurl + 'FTPfileserver/Archivos/' + row.DUBICACIONFILESERVER + '" target="_blank" class="btn btn-sm btn-success btn-block" ><i class="fa fa-folder" ></i> Ver Informe Convalidado</a>';
							} else {
								if (!row.DUBICACIONFILESERVERPDF) {
									let tipoEstado = String(row.TIPOESTADOSERVICIO).toLowerCase().trim();
									if (tipoEstado === 'concluido ok') {
										return '<button type="button" class="btn btn-danger btn-sm btn-block close-pdf" data-codigo="' + row.CODIGO + '" data-fecha="' + row.FECHAINSPECCION + '" ><i class="fa fa-save"></i> Cerrar Informe</button>';
									}
								} else {
									return '<a href="' + baseurl + 'FTPfileserver/Archivos/' + row.DUBICACIONFILESERVERPDF + '" target="_blank" class="btn btn-sm btn-success btn-block" ><i class="fa fa-file-pdf" ></i> Ver Informe Técnico</a>';
								}
							}
						}
					},
					{data: 'CODIGO', orderable: false, targets: 1},
					{
						"orderable": false,
						render: function (data, type, row) {
							return moment(row.FECHAINSPECCION, 'YYYY-MM-DD').format('DD/MM/YYYY');
						}
					},
					{
						"orderable": false,
						render: function (data, type, row) {
							return moment(row.FCREACION, 'YYYY-MM-DD').format('DD/MM/YYYY');
						}
					},
					{data: 'CLIENTE', orderable: false, targets: 4},
					{data: 'nruc', orderable: false, targets: 5},
					{data: 'PROVEEDOR', orderable: false, targets: 6},
					{
						"orderable": false,
						render: function (data, type, row) {
							let DIRECCIONPROV = (row.DIRECCIONPROV) ? row.DIRECCIONPROV : '';
							let ESTABLECIMIENTOPROV = (row.ESTABLECIMIENTOPROV) ? row.ESTABLECIMIENTOPROV : '';
							let MAQUILADOR = (row.MAQUILADOR) ? row.MAQUILADOR : '';
							if (DIRECCIONPROV) {
								return ESTABLECIMIENTOPROV;
							} else {
								return ESTABLECIMIENTOPROV + ' - ' + MAQUILADOR;
							}
						}
					},
					{
						"orderable": false,
						render: function (data, type, row) {
							let DIRECCIONMAQUILA = (row.DIRECCIONMAQUILA) ? row.DIRECCIONMAQUILA : '';
							let UBIGEOMAQUILA = (row.UBIGEOMAQUILA) ? row.UBIGEOMAQUILA : '';
							let DIRECCIONPROV = (row.DIRECCIONPROV) ? row.DIRECCIONPROV : '';
							let UBIGEOPROV = (row.UBIGEOPROV) ? row.UBIGEOPROV : '';
							if (DIRECCIONPROV) {
								return DIRECCIONPROV + ' ' + UBIGEOPROV;
							} else {
								return DIRECCIONMAQUILA + ' ' + UBIGEOMAQUILA;
							}
						}
					},
					{data: 'AREACLIENTE', orderable: false, targets: 6},
					{
						"orderable": false,
						render: function (data, type, row) {
							if (String(row.espeligro).toUpperCase() === 'S') {
								return '<span class="text-danger" >' + row.LINEA + '</span>';
							}
							return row.LINEA;
						}
					},
					// {data: 'LINEA', orderable: false, targets: 7},
					{data: 'TIPOESTADOSERVICIO', orderable: false, targets: 8},
					{data: 'COMENTARIO', orderable: false, targets: 9},
					{data: 'dinformefinal', orderable: false, targets: 10},
					{
						"orderable": false,
						render: function (data, type, row) {
							let RESULTADOCHECKLIST = (row.RESULTADOCHECKLIST) ? row.RESULTADOCHECKLIST + '%' : '';
							let RESULTADOTEXTO = (row.RESULTADOTEXTO) ? row.RESULTADOTEXTO : '';
							return RESULTADOCHECKLIST + '<br>' + RESULTADOTEXTO;
						}
					},
					{data: 'ACCIONCORRECTIVA', orderable: false, targets: 12},
					{data: 'CONSULTOR', orderable: false, targets: 13},
					{
						"orderable": false,
						render: function (data, type, row) {
							let CERTIFICADORA = (row.CERTIFICADORA) ? row.CERTIFICADORA : '';
							let CERTIFICACION = (row.CERTIFICACION) ? row.CERTIFICACION : '';
							if (CERTIFICADORA || CERTIFICACION) {
								return CERTIFICADORA + '<br>' + CERTIFICACION;
							}
							let tipoEstado = String(row.TIPOESTADOSERVICIO).toLowerCase().trim();
							let EMPRESAINSPECTORA = String(row.EMPRESAINSPECTORA).toLowerCase().trim();
							if (tipoEstado === 'convalidado' && (
								EMPRESAINSPECTORA === 'senasa' ||
								EMPRESAINSPECTORA === 'digesa' ||
								EMPRESAINSPECTORA === 'sanipes'
							)) {
								return row.EMPRESAINSPECTORACONV;
							}
						}
					},
					// {data: 'SCERTIFICACION', orderable: false, targets: 15},
					{
						"orderable": false,
						render: function (data, type, row) {
							let SCERTIFICACION = (row.SCERTIFICACION) ? row.SCERTIFICACION : '';
							let EMPRESAINSPECTORA = String(row.EMPRESAINSPECTORA).toLowerCase().trim();
							let tipoEstado = String(row.TIPOESTADOSERVICIO).toLowerCase().trim();
							if (tipoEstado === 'convalidado' && (
								EMPRESAINSPECTORA === 'senasa' ||
								EMPRESAINSPECTORA === 'digemid' ||
								EMPRESAINSPECTORA === 'digesa' ||
								EMPRESAINSPECTORA === 'sanipes'
							)) {
								return 'SI TIENE';
							} else {
								return SCERTIFICACION;
							}
						}
					},
					{
						"orderable": false,
						render: function (data, type, row) {
							let LICENCIADEFUNCIONAMIENTO = (row.LICENCIADEFUNCIONAMIENTO) ? row.LICENCIADEFUNCIONAMIENTO : '';
							let ESTADOLICENCIADEFUNCIONAMIENTO = (row.ESTADOLICENCIADEFUNCIONAMIENTO) ? row.ESTADOLICENCIADEFUNCIONAMIENTO : '';
							return ESTADOLICENCIADEFUNCIONAMIENTO + '<br>' + LICENCIADEFUNCIONAMIENTO;
						}
					},
					{data: 'EMPRESAINSPECTORA', orderable: false, targets: 17},
					{data: 'SEVALPROD', orderable: false, targets: 18},
					{data: 'espeligro', orderable: false, targets: 19},
					{data: 'CCHECKLIST', orderable: false, targets: 20},
					{data: 'CHECKLIST', orderable: false, targets: 21},
					{data: 'CERTIFICADORA', orderable: false, targets: 22},
					{data: 'DSISTEMA', orderable: false, targets: 23},
					{data: 'DSUBNORMA', orderable: false, targets: 24},
				],
				"columnDefs": [
					{
						"defaultContent": " ",
						"targets": "_all"
					}
				]
			});
			// oTableLista.on('order.dt search.dt', function () {
			// 	oTableLista.column(1, {
			// 		search: 'applied',
			// 		order: 'applied'
			// 	}).nodes().each(function (cell, i) {
			// 		cell.innerHTML = i + 1;
			// 	});
			// }).draw();
		}
	};

	/**
	 * Habre el modal para visualizar el informe tecnico
	 */
	objInsp.openPDF = function () {
		const button = $(this);
		// save ID
		objInsp.pdf.codigo = button.data('codigo');
		objInsp.pdf.fecha = button.data('fecha');
		const modalPDF = $('#modalPDF');
		modalPDF.modal('show');
		$('#framePDF').attr('src', objInsp.getLink());
	};

	/**
	 * Link del PDF
	 * @returns {string}
	 */
	objInsp.getLink = function () {
		return BASE_URL + 'at/ctrlprov/ccons_insp/pdf?codigo=' + objInsp.pdf.codigo + '&fecha=' + objInsp.pdf.fecha;
	};

	/**
	 * Cierra el PF
	 */
	objInsp.closePDF = function (btn) {
		if (objInsp.loading) {
			objPrincipal.alert('info', 'Existe una carga pendiente! Intentalo más tarde.');
		} else {
			objInsp.loading = true;
			$.ajax({
				url: BASE_URL + 'at/ctrlprov/ccons_insp/close_download',
				method: 'POST',
				data: objInsp.pdf,
				dataType: 'json',
				beforeSend: function () {
					objPrincipal.botonCargando(btn);
				}
			}).done(function (res) {
				objInsp.download(res.data.DUBICACIONFILESERVERPDF);
				$('#modalPDF').modal('hide');
				objInsp.loading = false;
				objInsp.search();
			}).fail(function () {
				objInsp.loading = false;
				objPrincipal.alert('error', 'Error en la descarga del archivo.', 'Vuelva a inentarlo más tarde.');
			}).always(function () {
				objPrincipal.liberarBoton(btn);
			});
		}
	};

	/**
	 * Descarga del link del PDF
	 */
	objInsp.downloadPDF = function () {
		const button = $(this);
		const link = button.data('link');
		objInsp.download(link);
	};

	/**
	 * Realiza la descarga del archivo
	 * @param linkPdf
	 */
	objInsp.download = function (linkPdf) {
		const url = BASE_URL + 'at/ctrlprov/ccons_insp/download?filename=' + linkPdf;
		const download = window.open(url, '_blank');
		if (!download) {
			objPrincipal.alert('warning', 'Habilite la ventana emergente de su navegador.');
		}
		download.focus();
	};

	/**
	 * Activa o desactiva las fechas
	 */
	objInsp.activeDate = function () {
		const chech = !$(this).is(':checked');
		$('#fini').prop('disabled', chech);
		$('#ffin').prop('disabled', chech);
	};

	/**
	 * Carga de clientes
	 */
	objInsp.cargaClientes = function () {
		/*LLENADO DE COMBOS*/
		$.ajax({
			type: 'ajax',
			method: 'post',
			url: baseurl + "at/ctrlprov/cregctrolprov/getcboclieserv",
			dataType: "JSON",
		}).done(function(res) {
			$('#filtro_cliente').html(res);
		}).fail(function() {
			objPrincipal.notify('warning', 'Hubo un error al carga los clientes.');
		});
	};

	/**
	 * @param idCliente
	 */
	objInsp.cargaArea = function(idCliente) {
		$.ajax({
			type: 'ajax',
			method: 'post',
			url: baseurl + "at/ctrlprov/ccons_insp/get_areas",
			data: {
				ccliente: idCliente,
			},
			dataType: "JSON",
		}).done(function(res) {
			const items = res.items;
			let options = '';
			if (items && Array.isArray(items)) {
				items.forEach(function(item) {
					options += '<option value="' + item.AREACLIENTE + '" >' + item.DAREACLIENTE + '</option>';
				});
			}
			$('#filtro_cliente_area').html(options);
		}).fail(function() {
			objPrincipal.notify('warning', 'Hubo un error al carga las areas.');
		});
	};

	/**
	 * Carga de proveedores
	 */
	objInsp.cargaProveedor = function (idCliente) {
		$.ajax({
			type: 'ajax',
			method: 'post',
			url: baseurl + "at/ctrlprov/cregctrolprov/getcboprovxclie",
			data: {
				ccliente: idCliente,
			},
			dataType: "JSON",
		}).done(function(res) {
			$('#filtro_proveedor').html(res);
		}).fail(function() {
			objPrincipal.notify('warning', 'Hubo un error al carga los proveedor.');
		});
	};

	/**
	 * Carga de proveedores
	 */
	objInsp.cargaEstados = function () {
		$.ajax({
			type: 'ajax',
			method: 'post',
			url: baseurl + "at/ctrlprov/cregctrolprov/getcboestado",
			data: {},
			dataType: "JSON",
		}).done(function(res) {
			$('#filtro_tipo_estado').html(res);
			$('#filtro_tipo_estado').val(0).trigger('change');
		}).fail(function() {
			objPrincipal.notify('warning', 'Hubo un error al carga los proveedor.');
		});
	};

	/**
	 * Carga de proveedores
	 */
	objInsp.cargaMaquilador = function (idProveedor) {
		$.ajax({
			type: 'ajax',
			method: 'post',
			url: baseurl + "at/ctrlprov/cregctrolprov/getcbomaqxprov",
			data: {
				cproveedor: idProveedor,
			},
			dataType: "JSON",
		}).done(function(res) {
			$('#filtro_maquilador').html(res);
		}).fail(function() {
			objPrincipal.notify('warning', 'Hubo un error al carga los maquilador.');
		});
	};

	/**
	 * Ver Acciones correctivas
	 */
	objInsp.verAccionCorrectiva = function() {
		const button = $(this);
		const codigo = button.data('codigo');
		const fecha = button.data('fecha');
		const proveedor = button.data('proveedor');
		const dirProvMaqui = button.data('direccion');
		const excel = button.data('excel');
		objPrincipal.botonCargando(button);
		const oTableLista = $('#tblAcciónCorrectiva').DataTable({
			"processing"  	: true,
			"bDestroy"    	: true,
			"stateSave"     : true,
			"bJQueryUI"     : true,
			"scrollY"     	: "540px",
			"scrollX"     	: true,
			'AutoWidth'     : true,
			"paging"      	: false,
			"info"        	: true,
			"filter"      	: true,
			"ordering"		: false,
			"responsive"    : false,
			"select"        : true,
			'ajax': {
				"url": baseurl + 'at/ctrlprov/ccons_insp/get_accion_correctiva',
				"type": "POST",
				"data": function (d) {
					d.codigo = codigo;
					d.fecha = fecha;
				},
				dataSrc: function (data) {
					objPrincipal.liberarBoton(button);
					return data.items;
				},
				error: function () {
					objPrincipal.alert('warning', 'Error en el proceso de ejecución.', 'Vuelva a intentarlo más tarde.');
					objPrincipal.liberarBoton(button);
				}
			},
			'columns': [
				{data: 'dnumerador', orderable: false, targets: 0, "class": "col-s"},
				{data: 'drequisito', orderable: false, targets: 1, "class": "col-1m"},
				{data: 'sexcluyente', orderable: false, targets: 2, "class": "col-xs"},
				{data: 'tipohallazgo', orderable: false, targets: 3, "class": "col-sm"},
				{data: 'dhallazgo', orderable: false, targets: 4, "class": "col-1m"},
				{data: 'daccioncorrectiva', orderable: false, targets: 5, "class": "col-1m"},
				{data: 'dresponsablecliente', orderable: false, targets: 6, "class": "col-sm"},
				{
					"orderable": false,
					render: function (data, type, row) {
						return moment(row.tcreacion).format('DD/MM/YYYY');
					}
				},
				{data: 'svalor', orderable: false, targets: 8, "class": "col-xs"},
				{data: 'dobservacion', orderable: false, targets: 9, "class": "col-xm"},
			],
			"columnDefs": [
				{
					"defaultContent": " ",
					"targets": "_all"
				}
			]
		});
		const elModal = $('#modalAccionCorrectiva');
		elModal.find('h5').html('Acción Correctiva (' + proveedor + ' - ' + dirProvMaqui + ' - ' + moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') + ')');
		if (excel) {
			$('#btnDownloadAccionCorrectiva').attr('href', baseurl + 'FTPfileserver/Archivos/' + excel);
			$('#download-excel').show();
		} else {
			$('#btnDownloadAccionCorrectiva').attr('href', '#');
			$('#download-excel').hide();
		}
		elModal.modal('show');
	};

	/**
	 * DAtos del proveedor
	 */
	objInsp.verProveedor = function() {
		const button = $(this);
		const caudi = button.data('codigo');
		const proveedor = button.data('proveedor');
		$.ajax({
			url: baseurl + 'at/ctrlprov/ccons_insp/get_proveedor',
			method: 'POST',
			data: {
				proveedor: proveedor,
				caudi: caudi,
			},
			dataType: 'json',
			beforeSend: function() {
				objPrincipal.botonCargando(button);
			},
		}).done(function(res) {
			console.log(res);
			objInsp.imprimirProveedor(res.proveedor);
			objInsp.imprimirProveedorEstablecimiento(res.establecimiento);
			objInsp.imprimirProveedorLinea(res.linea);
			objInsp.imprimirProveedorContactos(res.contactos);
			$('#modalProveedor').modal('show');
		}).fail(function() {
			objPrincipal.notify('warning', 'Error al cargar los datos del proveedor');
		}).always(function() {
			objPrincipal.liberarBoton(button);
		});
	};

	/**
	 * @param data
	 */
	objInsp.imprimirProveedor = function(data) {
		$('#proveedor_ruc').html(data.NRUC);
		$('#proveedor_razon_social').html(data.DRAZONSOCIAL);
		$('#proveedor_direccion').html(data.DDIRECCIONCLIENTE);
		$('#proveedor_ubigeo').html(data.UBIGEO);
		$('#proveedor_telefono').html(data.DTELEFONO);
		$('#proveedor_representante').html(data.DREPRESENTANTE);
		$('#proveedor_tipo_empresa').html(data.tipoempresa);
	};

	/**
	 * @param establecimiento
	 */
	objInsp.imprimirProveedorEstablecimiento = function(establecimiento) {
		$('#proveedor_inspeccionado').html(establecimiento);
	};

	/**
	 * @param linea
	 */
	objInsp.imprimirProveedorLinea = function(linea) {
		$('#proveedor_linea').html(linea);
	};

	/**
	 * @param datos
	 */
	objInsp.imprimirProveedorContactos = function(datos) {
		let rows = '';
		if (datos && Array.isArray(datos)) {
			datos.forEach(function(item, key) {
				rows += '<tr>';
				rows += '<td class="text-center" style="min-width: 50px" >' + (key + 1) + '</td>';
				rows += '<td class="text-left" style="min-width: 150px" >' + item.NOMBRES + '</td>';
				rows += '<td class="text-left" style="min-width: 150px" >' + item.DCARGOCONTACTO + '</td>';
				rows += '<td class="text-left" style="min-width: 150px" >' + item.DMAIL + '</td>';
				rows += '<td class="text-left" style="min-width: 150px" >' + item.DTELEFONO + '</td>';
				rows += '</tr>';
			});
		}
		$('#tblProveedorContactos tbody').html(rows);
	};

});

$(document).ready(function () {

	objInsp.cargaClientes();

	objInsp.cargaEstados();

	$('#btnBuscar').click(objInsp.search);

	$('#chkBusavanzada').click(function() {
		$('#modalFiltro').modal('show');
	});

	$('#modalFiltro').on('hidden.bs.modal', function () {
		$('#chkBusavanzada').prop('checked', false);
	});

	$(document).on('click', '.open-pdf', objInsp.openPDF);

	$(document).on('click', '.close-pdf', function() {
		const btn = $(this);
		objInsp.pdf.codigo = btn.data('codigo');
		objInsp.pdf.fecha = btn.data('fecha');
		objInsp.closePDF(btn);
	});

	$(document).on('click', '.download-pdf', objInsp.downloadPDF);

	$('#closePDF').click(function() {
		const btn = $(this);
		objInsp.closePDF(btn);
	});

	$('#activar_fecha').change(objInsp.activeDate);

	$('#modalPDF').on('hidden.bs.modal', function () {
		$('#framePDF').attr('src','about:blank');
	});

	$(document).on('click', '.ver-accion-correctiva', objInsp.verAccionCorrectiva);

	$(document).on('click', '.ver-proveedor', objInsp.verProveedor);

	$('#filtro_cliente').change(function() {
		const value = $(this).val();
		objInsp.cargaArea(value);
		objInsp.cargaProveedor(value);
		$('#contenedorMaquilador').hide();
		$('#filtro_maquilador').html('').change();
		if (value) {
			$('#contenedorProveedor').show();
		} else {
			$('#contenedorProveedor').hide();
		}
	});

	$('#filtro_proveedor').change(function() {
		const value = $(this).val();
		objInsp.cargaMaquilador(value);
		if (value) {
			$('#contenedorMaquilador').show();
		} else {
			$('#contenedorMaquilador').hide();
		}
	});

	const initSelect2 = {
		minimumInputLength: 0,
		theme: 'bootstrap4',
		placeholder: "::Elegir::",
		allowClear: true,
		width: '100%'
	};
	$('#filtro_cliente').select2(initSelect2);
	$('#filtro_proveedor').select2(initSelect2);
	$('#filtro_maquilador').select2(initSelect2);
	// $('#filtro_tipo_estado').select2(initSelect2);
	// $('#filtro_cliente_area').select2(initSelect2);

});
