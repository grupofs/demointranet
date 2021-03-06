<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define("DOMPDF_ENABLE_REMOTE", true);

/**
 * Class ccons_insp
 * @property mcons_insp mcons_insp
 */
class ccons_insp extends FS_Controller
{
	/**
	 * CODIGO CIA
	 */
	const CIA = '1';

	/**
	 * CODIGO DE AREA
	 */
	const AREA = '01';

	/**
	 * CODIGO DE SERVICIO
	 */
	const SERVICIO = '02';

	/**
	 * ccons_insp constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('consinsp');
		$this->load->model('at/ctrlprov/mcons_insp', 'mcons_insp');
	}

	/**
	 * Busqueda de areas del cliente
	 */
	public function get_areas()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$ccliente = $this->input->post('ccliente');
		$items = $this->mcons_insp->getAreaCliente([
			'@AS_CCLIENTE' => $ccliente,
		]);
		echo json_encode(['items' => $items]);
	}

	/**
	 * Devuelve las inspecciones
	 */
	public function search()
	{
		$ccia = $this->input->post('ccia');
		$afecha = (int)$this->input->post('afecha');
		$fini = $this->input->post('fini');
		$ffin = $this->input->post('ffin');
		$ccliente = $this->input->post('filtro_cliente');
		$cclienteprov = $this->input->post('filtro_proveedor');
		$cclientemaquila = $this->input->post('filtro_maquilador');
		$careacliente = $this->input->post('filtro_cliente_area');
		$tipoestado = $this->input->post('filtro_tipo_estado');
		$peligro = $this->input->post('filtro_peligro');
		$sevalprod = $this->input->post('sevalprod');
		$filtro_calificacion = $this->input->post('filtro_calificacion');
		$establecimientoMaqui = $this->input->post('filtro_establecimiento_maqui');
		$dirEstablecimientoMaqui = $this->input->post('filtro_dir_establecimiento_maqui');
		$nroInforme = $this->input->post('filtro_nro_informe');

		$inspecciones = '';
		if (!empty($ccliente)) {
			$area = self::AREA;
			$cservicio = self::SERVICIO;
			$cclienteprov = (empty($cclienteprov)) ? '%' : $cclienteprov;
			$cclientemaquila = (empty($cclientemaquila)) ? '%' : $cclientemaquila;
			$careacliente = (empty($careacliente)) ? [] : $careacliente;
			$establecimientoMaqui = is_null($establecimientoMaqui) ? '%' : "%{$establecimientoMaqui}%";
			$dirEstablecimientoMaqui = is_null($dirEstablecimientoMaqui) ? '%' : "%{$dirEstablecimientoMaqui}%";
			$nroInforme = is_null($nroInforme) ? '%' : "%{$nroInforme}%";
			$tipoestado = (empty($tipoestado)) ? [] : $tipoestado;
			$peligro = empty($peligro) ? '%' : $peligro;
			$sevalprod = is_null($sevalprod) ? '0' : $sevalprod;
			$filtro_calificacion = is_null($filtro_calificacion) ? [] : $filtro_calificacion;

			// Se verifica si filtrara con fecha o no
			$now = \Carbon\Carbon::now('America/Lima')->format('Y-m-d');
			if (!$afecha) {
				$fini = null;
				$ffin = null;
			} else {
				// En caso sea un formato invalido se tomara la fecha de hoy
				$fini = (validateDate($fini, 'd/m/Y'))
					? \Carbon\Carbon::createFromFormat('d/m/Y', $fini, 'America/Lima')->format('Y-m-d')
					: $now;
				$ffin = (validateDate($ffin, 'd/m/Y'))
					? \Carbon\Carbon::createFromFormat('d/m/Y', $ffin, 'America/Lima')->format('Y-m-d')
					: $now;
			}

			$calificacion = clearLabel($filtro_calificacion, false);
			$tipoestado = clearLabel($tipoestado, false);
			$careacliente = clearLabel($careacliente, false);

			$inspecciones = $this->mcons_insp->buscarInspecciones(
				$ccia,
				$area,
				$cservicio,
				$ccliente,
				$cclienteprov,
				$cclientemaquila,
				$careacliente,
				$establecimientoMaqui,
				$dirEstablecimientoMaqui,
				$nroInforme,
				$tipoestado,
				$fini,
				$ffin,
				$peligro,
				$sevalprod,
				$calificacion
			);
		}
		echo json_encode(['items' => $inspecciones]);
	}

	/**
	 * Impresión del PDF de la inspección tecnica
	 */
	public function pdf()
	{
		try {
			$codigo = $this->input->get('codigo');
			$fecha = $this->input->get('fecha');
			$html2pdf = $this->_pdf($codigo, $fecha);
//			$dompdf->stream("ficha_tenica.pdf", array("Attachment" => 0));
			$html2pdf->output('file.pdf', 'I');
		} catch (Exception $ex) {
			show_error($ex->getMessage(), 500, 'Error al realizar la carga de PDF');
		}
	}

	/**
	 * Recurso para obtener el PDF
	 * @param string $codigo
	 * @param string $pdf
	 */
	private function _pdf($codigo, $fecha)
	{
		$data = [
			'@CAUDI' => $codigo, // '00000303',
			'@FSERV' => $fecha, // '2020-10-09',
		];
		$caratula = $this->mcons_insp->pdfCaratula($data);
		if (empty($caratula)) {
			throw new Exception('El control de proveedor no pudo ser encontrado.');
		}
		$parrafo1Pt1 = $this->mcons_insp->pdfParrafo1Parte1($data);
		$parrafo1Pt2 = $this->mcons_insp->pdfParrafo1Parte2($data);
		$cuadro1 = $this->mcons_insp->pdfCuadro1($data);
		$parrafo2 = $this->mcons_insp->pdfParrafo2($data);
		$grafico1 = $this->mcons_insp->pdfGrafico1($data);
		$cuadro2 = $this->mcons_insp->pdfCuadro2($data);
		$grafico2 = $this->mcons_insp->pdfGrafico2($data);
		$imgGrafico1 = '';
		$unicaInspeccion = true;
		if (!empty($grafico1)) {
			$arrayLabel = [];
			$arrayData = [];
			$arrayColor = [];
			if (!empty($grafico1->TF1)) {
				$arrayLabel[] = date('d/m/Y', strtotime($grafico1->TF1)) . " " . $grafico1->CERT1;
				$arrayData[] = $grafico1->TR1;
				$arrayColor[] = getColorRgba($grafico1->TR1);
			} else {
				$arrayLabel[] = '';
				$arrayData[] = -1; // $grafico1->TR2;
				$arrayColor[] = "'rgba(255,255,255,1)'";
			}
			if (!empty($grafico1->TF2)) {
				$unicaInspeccion = false;
				$arrayLabel[] = date('d/m/Y', strtotime($grafico1->TF2)) . " " . $grafico1->CERT2;
				$arrayData[] = $grafico1->TR2;
				$arrayColor[] = getColorRgba($grafico1->TR2);
			} else {
				$arrayLabel[] = '';
				$arrayData[] = -1; // $grafico1->TR2;
				$arrayColor[] = "'rgba(255,255,255,1)'";
			}
			if (!empty($grafico1->TF3)) {
				$unicaInspeccion = false;
				$arrayLabel[] = date('d/m/Y', strtotime($grafico1->TF3)) . " " . $grafico1->CERT3;
				$arrayData[] = $grafico1->TR3;
				$arrayColor[] = getColorRgba($grafico1->TR3);
			} else {
				$arrayLabel[] = '';
				$arrayData[] = -1; // $grafico1->TR2;
				$arrayColor[] = "'rgba(255,255,255,1)'";
			}
			if (!empty($grafico1->TF4)) {
				$unicaInspeccion = false;
				$arrayLabel[] = date('d/m/Y', strtotime($grafico1->TF4)) . " " . $grafico1->CERT4;
				$arrayData[] = $grafico1->TR4;
				$arrayColor[] = getColorRgba($grafico1->TR4);
			} else {
				$arrayLabel[] = '';
				$arrayData[] = -1; // $grafico1->TR2;
				$arrayColor[] = "'rgba(255,255,255,1)'";
			}
			if (!empty($grafico1->TF5)) {
				$unicaInspeccion = false;
				$arrayLabel[] = date('d/m/Y', strtotime($grafico1->TF5)) . " " . $grafico1->CERT5;
				$arrayData[] = $grafico1->TR5;
				$arrayColor[] = getColorRgba($grafico1->TR5);
			} else {
				$arrayLabel[] = '';
				$arrayData[] = -1; // $grafico1->TR2;
				$arrayColor[] = "'rgba(255,255,255,1)'";
			}
			$imgGrafico1 = getLinkFormChartBar(
				$arrayLabel,
				$arrayData,
				$arrayColor
			);
		}
		$parrafoPrimeraInsp = '';
		if ($unicaInspeccion) {
			$parrafoPrimeraInsp = $this->mcons_insp->pdfPrimeraInsp($data);
		}
		$imgGrafico2 = '';
		if (!empty($grafico2)) {
			$lenRows = count($grafico2);
			$totalRows = ($lenRows / 2);
			$labels = [];
			$maxValue = 0;
			foreach ($grafico2 as $key => $value) {
				if (!in_array($value->dnumerador, $labels)) {
					$labels[] = $value->dnumerador;
				}
				if ($value->mayor_val > $maxValue) {
					$maxValue = $value->mayor_val;
				}
			}
			$maxValue += 30; // Se aumenta 10 para poder mostrar el texto hacia arriba
			$dataMaximo = implode(',', getValueGraphic2($grafico2, 'maximo'));
			$dataObtenido = implode(',', getValueGraphic2($grafico2, 'obtenido'));
			$backgroundColorMaximo = "'rgba(255,0,0,1)'";
			$backgroundColorObtenido = "'rgba(0,128,0,1)'";
			if ($lenRows == 4) {
				$backgroundColorMaximo = "'rgba(255,0,0,1)','rgba(255,0,0,1)'";
				$backgroundColorObtenido = "'rgba(0,128,0,1)','rgba(0,128,0,1)'";
			}
			if ($lenRows > 4) {
				$backgroundColorMaximo = "'rgba(255,0,0,1)','rgba(255,0,0,1)','rgba(255,0,0,1)'";
				$backgroundColorObtenido = "'rgba(0,128,0,1)','rgba(0,128,0,1)','rgba(0,128,0,1)'";
			}
			$datasets = "{label:'Maximo',data:[{$dataMaximo}],backgroundColor:[{$backgroundColorMaximo}]}";
			$datasets .= ",{label:'Obtenido',data:[{$dataObtenido}],backgroundColor:[{$backgroundColorObtenido}]}";
			$imgGrafico2 = getLinkFormChartBar2($labels, $datasets, $maxValue);
		}
		$cuadro3 = $this->mcons_insp->pdfCuadro3($data);
		$cuadro4 = $this->mcons_insp->pdfCuadro4($data);
		$criterioInspeccion = $this->mcons_insp->pdfCriteriosInspeccion($data);
		$criterioEvaluacion = $this->mcons_insp->pdfCriteriosEvaluacion($data);
		$conclucionesGenerales = $this->mcons_insp->pdfConclucionesGeneral($data);
		$conclucionesEspecificas = $this->mcons_insp->pdfConclucionesEspecificas($data);
		$keyConclucionesEspecificasConformidades = array_search('Conformidades', array_column($conclucionesEspecificas, 'dregistro'));
		$conclucionesEspecificasConformidades = ($keyConclucionesEspecificasConformidades !== false) ? $conclucionesEspecificas[$keyConclucionesEspecificasConformidades] : null;
		$keyConclucionesEspecificasObservaciones = array_search('Observaciones', array_column($conclucionesEspecificas, 'dregistro'));
		$conclucionesEspecificasObservaciones = ($keyConclucionesEspecificasObservaciones !== false) ? $conclucionesEspecificas[$keyConclucionesEspecificasObservaciones] : null;
		$planAccionParrafo1 = $this->mcons_insp->pdfPlanAccionParrafo1($data);
		$planAccionParrafo2 = $this->mcons_insp->pdfPlanAccionParrafo2($data);
		$planAccionParrafo3 = $this->mcons_insp->pdfPlanAccionParrafo3($data);
		$escalaValoracion = $this->mcons_insp->pdfEscalaValoracion($data);
		$parrafoExcluyentes = $this->mcons_insp->pdfParrafoRequisitos($data);
		$requisitosExcluyentes = $this->mcons_insp->pdfRequisitoExcluyentes($data);
		$inspector = $this->mcons_insp->getDatosInspector($data);
		$peligros = $this->mcons_insp->pdfPeligros($data);
		$excluyentes = $this->mcons_insp->pdfExcluyentes($data);
		$rutafirma = null;
		if (!empty($inspector)) {
			$rutafirma = 'http://plataforma.grupofs.com:82/demointranet/FTPfileserver/Imagenes/internos/firmas/' . $inspector->rutafirma;
			if (file_exists($rutafirma)) {
				$rutafirma = base64ResourceConvert($rutafirma);
			}
		}
		// Contenedor de la ficha tecnica
		$content = $this->load->view('at/ctrlprov/vcons_insp_pdf', [
			'caratula' => $caratula,
			'parrafo1Pt1' => $parrafo1Pt1,
			'parrafo1Pt2' => $parrafo1Pt2,
			'parrafoPrimeraInsp' => $parrafoPrimeraInsp,
			'cuadro1' => $cuadro1,
			'parrafo2' => $parrafo2,
			'imgGrafico1' => $imgGrafico1,
			'cuadro2' => $cuadro2,
			'imgGrafico2' => $imgGrafico2,
			'cuadro3' => $cuadro3,
			'cuadro4' => $cuadro4,
			'criterioInspeccion' => $criterioInspeccion,
			'criterioEvaluacion' => $criterioEvaluacion,
			'conclucionesGenerales' => $conclucionesGenerales,
			'conclucionesEspecificasConformidades' => $conclucionesEspecificasConformidades,
			'conclucionesEspecificasObservaciones' => $conclucionesEspecificasObservaciones,
			'planAccionParrafo1' => $planAccionParrafo1,
			'planAccionParrafo2' => $planAccionParrafo2,
			'planAccionParrafo3' => $planAccionParrafo3,
			'escalaValoracion' => $escalaValoracion,
			'parrafoExcluyentes' => $parrafoExcluyentes,
			'requisitosExcluyentes' => $requisitosExcluyentes,
			'peligros' => $peligros,
			'rutafirma' => $rutafirma,
			'inspector' => $inspector,
			'excluyentes' => $excluyentes,
			'unicaInspeccion' => $unicaInspeccion,
		], TRUE);
		$html2pdf = new \Spipu\Html2Pdf\Html2Pdf();
//		$html2pdf->setDefaultFont('arial');
		$html2pdf->writeHTML($content);
		return $html2pdf;
	}

	/**
	 * Cierre de la inspeccion tecnica
	 */
	public function close_download()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		try {
			$codigo = $this->input->post('codigo');
			$fecha = $this->input->post('fecha');
			$inspecciondet = $this->mcons_insp->buscarInspccion($codigo, $fecha);
			if (empty($inspecciondet)) {
				throw new Exception('La inspección no pudo ser encontrada.');
			}
			$inspeccioncab = $this->mcons_insp->buscarInspccionCab($codigo);
			if (empty($inspeccioncab)) {
				throw new Exception('La inspección cabecera no pudo ser encontrada.');
			}

			$caratula = $this->mcons_insp->pdfCaratula([
				'@CAUDI' => $codigo, // '00000303',
				'@FSERV' => $fecha, // '2020-10-09',
			]);

			$informe = $caratula->dinforme;
			$dinforme = explode('/',$informe);

			// codigo | fecha .pdf
			$fileName = date('dmY', strtotime($fecha)) . '-' . $dinforme[0] . '.pdf';
			$dompdf = $this->_pdf($codigo, $fecha);

			// Separado por Archivos / cia|area|servicio / ccliente / caudi
			$rutaCarpeta = '1' . self::AREA.self::SERVICIO . '/' . $inspeccioncab->CCLIENTE . '/' .  $inspeccioncab->CAUDITORIAINSPECCION;
			if (!file_exists(RUTA_ARCHIVOS. $rutaCarpeta)) {
				mkdir(RUTA_ARCHIVOS . $rutaCarpeta, '0777', true);
			}
			$filePath = $rutaCarpeta . '/' . $fileName;
			$dompdf->output(RUTA_ARCHIVOS . $filePath, 'F');

			$validate = $this->db->update('PDAUDITORIAINSPECCION',
				[
					'DUBICACIONFILESERVERPDF' => $filePath,
				],
				[
					'CAUDITORIAINSPECCION' => $inspecciondet->CAUDITORIAINSPECCION,
					'FSERVICIO' => $inspecciondet->FSERVICIO,
				]
			);
			if (!$validate) {
				throw new Exception('La inspección no pudo ser actualizada correctamente.');
			}
			$inspecciondet->DUBICACIONFILESERVERPDF = $filePath;

			$this->result['status'] = 200;
			$this->result['message'] = 'Descarga del archivo correctamente.';
			$this->result['data'] = $inspecciondet;
		} catch (Exception $ex) {
			$this->result['message'] = $ex->getMessage();
		}
		responseResult($this->result);
	}

	/**
	 * Realiza la descarga del archivo
	 */
	public function download()
	{
		$fileName = $this->input->get('filename');
		$this->load->helper('download');
		$pathFile = RUTA_ARCHIVOS . $fileName;
		if (!file_exists($pathFile)) {
			show_404();
		}
		force_download($pathFile, null, false);
	}

	/**
	 * Busqueda de las acciones correctiva
	 */
	public function get_accion_correctiva()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$codigo = $this->input->post('codigo');
		$fecha = $this->input->post('fecha');
		$items = $this->mcons_insp->getAccionesCorrectiva([
			'@CAUDI' => $codigo,
			'@FSERV' => $fecha,
		]);
		echo json_encode(['items' => $items]);
	}

	/**
	 * Busqueda de las acciones correctiva
	 */
	public function get_proveedor()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$caudi = $this->input->post('caudi');
		$id_proveedor = $this->input->post('proveedor');
		$proveedor = $this->mcons_insp->getProveedor([
			'@AS_CCLIENTE' => $id_proveedor,
		]);
		$establecimiento = $this->mcons_insp->getProveedorEstablecimiento([
			'@AS_CAUDITORIAINSPECCION' => $caudi,
		]);
		$linea = $this->mcons_insp->getProveedorLinea([
			'@AS_CCLIENTE' => $id_proveedor,
			'@AS_CCIA' => 1,
		]);
		$contactos = $this->mcons_insp->getProveedorContactos([
			'@AS_CCLIENTE' => $id_proveedor,
			'@AS_CESTABLECIMIENTO' => (!empty($establecimiento)) ? $establecimiento->cestablecimientoprov : '',
		]);
		echo json_encode([
			'proveedor' => $proveedor,
			'establecimiento' => (!empty($establecimiento)) ? $establecimiento->ESTABLECIMIENTO : '',
			'linea' => $linea,
			'contactos' => $contactos,
		]);
	}

}
