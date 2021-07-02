<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Cconsulhomo extends CI_Controller { 
    function __construct() {
		parent:: __construct();	
		$this->load->model('oi/homologacionesclie/mconsulhomo');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library(array('form_validation','session','encryption'));
    }

    /** RECUPERAR TABLAS - HOMOLOGACIONES **/ 
		// Lista de homologaciones
		public function getbuscarhomologaciones(){	
			$varnull 			= 	'';
			$celestado			= 	'';

			$estado = $this->input->post('estado');

			foreach($estado as $destado)
			{
				$celestado = $destado.','.$celestado;
			}
			$countestado =strlen($celestado) ;
			$celestado = substr($celestado,0,$countestado-1);

			$fregini = $this->input->post('fregini');
			$fregfin = $this->input->post('fregfin');
			$finiini = $this->input->post('finiini');
			$finifin = $this->input->post('finifin');
			$ftermini = $this->input->post('ftermini');
			$ftermfin = $this->input->post('ftermfin');

			$parametros = array(
				'@CCIA' 	        =>	$this->input->post('ccia'),
				'@CLIENTE' 	        =>	$this->input->post('ccliente'),
				'@PROVEEDOR' 	    =>	$this->input->post('proveedor'),
				'@ESTADOEVAL' 		=>  $celestado, 
				'@TIPOPROVEEDOR' 	=>  $this->input->post('tipoproveedor'),
				'@PRODUCTO' 		=>  ($this->input->post('producto') == $varnull) ? '%' : '%'.$this->input->post('producto').'%', 
				'@MARCA' 			=>  ($this->input->post('marca') == $varnull) ? '%' : '%'.$this->input->post('marca').'%', 
				'@FREGINI' 		    =>  ($this->input->post('fregini') == '%') ? NULL : substr($fregini, 6, 4).'-'.substr($fregini,3 , 2).'-'.substr($fregini, 0, 2), 
				'@FREGFIN' 		    =>  ($this->input->post('fregfin') == '%') ? NULL : substr($fregfin, 6, 4).'-'.substr($fregfin,3 , 2).'-'.substr($fregfin, 0, 2),  
				'@FINIINI' 			=>  ($this->input->post('finiini') == '%') ? NULL : substr($finiini, 6, 4).'-'.substr($finiini,3 , 2).'-'.substr($finiini, 0, 2),
				'@FINIFIN' 			=>  ($this->input->post('finifin') == '%') ? NULL : substr($finifin, 6, 4).'-'.substr($finifin,3 , 2).'-'.substr($finifin, 0, 2),
				'@FTERMINI' 		=>  ($this->input->post('ftermini') == '%') ? NULL : substr($ftermini, 6, 4).'-'.substr($ftermini,3 , 2).'-'.substr($ftermini, 0, 2),			
				'@FTERMFIN' 	    =>	($this->input->post('ftermfin') == '%') ? NULL : substr($ftermfin, 6, 4).'-'.substr($ftermfin,3 , 2).'-'.substr($ftermfin, 0, 2),
			);
			$resultado = $this->mconsulhomo->getbuscarhomologaciones($parametros);
			echo json_encode($resultado);
		}			
		// Recupera lista del detalle
		public function getlistarrequisitos(){	
			$parametros = array(
				'@CEVAL' 	        =>	$this->input->post('ceval'),
				'@CPRODUCTO' 	    =>	$this->input->post('cproducto'),
			);
			$resultado = $this->mconsulhomo->getlistarrequisitos($parametros);
			echo json_encode($resultado);
		}
		// Excel de homologaciones
		public function getexcelhomologaciones(){
			/*Estilos */
			   $titulo = [
				   'font'	=> [
					   'name' => 'Arial',
					   'size' =>12,
					   'color' => array('rgb' => 'FFFFFF'),
					   'bold' => true,
				   ], 
				   'fill'	=>[
					   'fillType' => Fill::FILL_SOLID,
					   'startColor' => [
						   'rgb' => '29B037'
					   ]
				   ],
				   'borders'	=>[
					   'allBorders' => [
						   'borderStyle' => Border::BORDER_THIN,
						   'color' => [ 
							   'rgb' => '000000'
						   ]
					   ]
				   ],
				   'alignment' => [
					   'horizontal' => Alignment::HORIZONTAL_CENTER,
					   'vertical' => Alignment::VERTICAL_CENTER,
					   'wrapText' => true,
				   ],
			   ];
			   $cabecera = [
				   'font'	=> [
					   'name' => 'Arial',
					   'size' =>10,
					   'color' => array('rgb' => 'FFFFFF'),
					   'bold' => true,
				   ], 
				   'fill'	=>[
					   'fillType' => Fill::FILL_SOLID,
					   'startColor' => [
						   'rgb' => '29B037'
					   ]
				   ],
				   'borders'	=>[
					   'allBorders' => [
						   'borderStyle' => Border::BORDER_THIN,
						   'color' => [ 
							   'rgb' => '000000'
						   ]
					   ]
				   ],
				   'alignment' => [
					   'horizontal' => Alignment::HORIZONTAL_CENTER,
					   'vertical' => Alignment::VERTICAL_CENTER,
					   'wrapText' => true,
				   ],
			   ];
			   $celdastexto = [
				   'borders'	=>[
					   'allBorders' => [
						   'borderStyle' => Border::BORDER_THIN,
						   'color' => [ 
							   'rgb' => '000000'
						   ]
					   ]
				   ],
				   'alignment' => [
					   'horizontal' => Alignment::HORIZONTAL_LEFT,
					   'vertical' => Alignment::VERTICAL_CENTER,
					   'wrapText' => true,
				   ],
			   ];
			/*Estilos */			
			
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setTitle('Listado - Tramites');

			$spreadsheet->getDefaultStyle()
				->getFont()
				->setName('Arial')
				->setSize(9);
			
			$sheet->setCellValue('A1', 'LISTADO DE HOMOLOGACIONES')
				->mergeCells('A1:H1')
				->setCellValue('A2', 'CLIENTE:')
				->mergeCells('B2:D2')
				->setCellValue('A4', 'Fecha de Registro')
				->setCellValue('B4', 'Fecha de Inicio')
				->setCellValue('C4', 'Fecha de termino')
				->setCellValue('D4', 'Estado')
				->setCellValue('E4', 'Categoria / Tipo de Proveedor')
				->setCellValue('F4', 'Proveedor')
				->setCellValue('G4', 'Producto')
				->setCellValue('H4', 'Marca')
				->setCellValue('I4', 'Envase Primario')
				->setCellValue('J4', 'Envase secundario')
				->setCellValue('K4', 'Vida Util')
				->setCellValue('L4', 'Condiciones de Almacenamiento')
				->setCellValue('M4', 'Fabricante Direccion')
				->setCellValue('N4', 'Almacen Direccion')
				->setCellValue('O4', 'Contacto')
				->setCellValue('P4', 'Cargo')
				->setCellValue('Q4', 'Telefono')
				->setCellValue('R4', 'Email')
				->setCellValue('S4', 'Registro Sanitario')
				->setCellValue('T4', 'Código de Registro Sanitario')
				->setCellValue('U4', 'Fecha de Emisión')
				->setCellValue('V4', 'Vencimiento del Registro Sanitario')
				->setCellValue('W4', 'Resultado microbiológico y/o fisicoquímico')
				->setCellValue('X4', 'Laboratorio')
				->setCellValue('Y4', 'Nº Informe de Ensayo')
				->setCellValue('Z4', 'Fecha de Análisis')
				->setCellValue('AA4', 'Vencimiento del Informe de Ensayo')
				->setCellValue('AB4', 'Ficha Técnica')
				->setCellValue('AC4', 'Rotulado')
				->setCellValue('AD4', 'Presentación - Foto')
				->setCellValue('AE4', 'Política de Retiro del Mercado')
				->setCellValue('AF4', 'Análisis de verificación de peligros')
				->setCellValue('AG4', 'Programa de verificación')
				->setCellValue('AH4', 'Laboratorio')
				->setCellValue('AI4', 'Nº Informe de Ensayo')
				->setCellValue('AJ4', 'Fecha de Análisis')
				->setCellValue('AK4', 'Vencimiento del Informe de Ensayo/ Seguimiento')
				->setCellValue('AL4', 'Carta de compromiso de actualización de documentos')
				->setCellValue('AM4', 'Nº de Versión o Revisión')
				->setCellValue('AN4', 'Certificado HACCP, ISO 22000, IHS u otro de Planta')
				->setCellValue('AO4', 'Empresa')
				->setCellValue('AP4', 'Nº de Informe o Certificado')
				->setCellValue('AQ4', 'Fecha de Inspección o Certificación')
				->setCellValue('AR4', '% Cumplimiento Total')
				->setCellValue('AS4', '% Cumplimiento HACCP')
				->setCellValue('AT4', 'Calificación cualitativa')
				->setCellValue('AU4', 'Fecha de seguimiento IHS')
				->setCellValue('AV4', 'Plan de Acciones Correctivas');

			$sheet->getStyle('A1:H1')->applyFromArray($titulo);
			$sheet->getStyle('A4:H4')->applyFromArray($cabecera);
		
			$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
			$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(12.10);
			$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(12.10);
			$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(25.10);
			$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(35.10);
			$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(45.10);
			$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(58.10);
			$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(32.10);

			$varnull 			= 	'';
			$celestado			= 	'';

			$cestado = $this->input->post('cboEstado');			
			if(isset($cestado)){
				foreach($cestado as $dest){
					$celestado = $dest.','.$celestado;
				}
				$countest =strlen($celestado) ;
				$celestado = substr($celestado,0,$countest-1);
			}

			$fregini = $this->input->post('txtFregIni');
			$fregfin = $this->input->post('txtFregFin');
			$finiini = $this->input->post('txtFiniIni');
			$finifin = $this->input->post('txtFiniFin');
			$ftermini = $this->input->post('txtFterIni');
			$ftermfin = $this->input->post('txtFterFin');

			$parametros = array(
				'@CCIA' 	        =>	'2',
				'@CLIENTE' 	        =>	$this->input->post('hdnCCliente'),
				'@PROVEEDOR' 	    =>	$this->input->post('cboProveedor'),
				'@ESTADOEVAL' 		=>  $celestado, 
				'@TIPOPROVEEDOR' 	=>  $this->input->post('cboTiporoveedor'),
				'@PRODUCTO' 		=>  ($this->input->post('txtProducto') == $varnull) ? '%' : '%'.$this->input->post('txtProducto').'%', 
				'@MARCA' 			=>  ($this->input->post('txtMarca') == $varnull) ? '%' : '%'.$this->input->post('txtMarca').'%', 
				'@FREGINI' 		    =>  ($this->input->post('txtFregIni') == '') ? NULL : substr($fregini, 6, 4).'-'.substr($fregini,3 , 2).'-'.substr($fregini, 0, 2), 
				'@FREGFIN' 		    =>  ($this->input->post('txtFregFin') == '') ? NULL : substr($fregfin, 6, 4).'-'.substr($fregfin,3 , 2).'-'.substr($fregfin, 0, 2),  
				'@FINIINI' 			=>  ($this->input->post('txtFiniIni') == '') ? NULL : substr($finiini, 6, 4).'-'.substr($finiini,3 , 2).'-'.substr($finiini, 0, 2),
				'@FINIFIN' 			=>  ($this->input->post('txtFiniFin') == '') ? NULL : substr($finifin, 6, 4).'-'.substr($finifin,3 , 2).'-'.substr($finifin, 0, 2),
				'@FTERMINI' 		=>  ($this->input->post('txtFterIni') == '') ? NULL : substr($ftermini, 6, 4).'-'.substr($ftermini,3 , 2).'-'.substr($ftermini, 0, 2),			
				'@FTERMFIN' 	    =>	($this->input->post('txtFterFin') == '') ? NULL : substr($ftermfin, 6, 4).'-'.substr($ftermfin,3 , 2).'-'.substr($ftermfin, 0, 2),
			);

			$rpt = $this->mconsulhomo->getexcelhomologaciones($parametros);
			$irow = 5;
			if ($rpt){
				foreach($rpt as $row){	
	
					$CLIENTE = $row->CLIENTE;
					$FECHA = $row->FECHA;
					$FECHAEVALUA = $row->FECHAEVALUA;
					$FECHAESTADOEVALUACION = $row->FECHAESTADOEVALUACION;
					$ESTADOEVALUACION = $row->ESTADOEVALUACION;
					$TIPOPRODUCTOEVALUAR = $row->TIPOPRODUCTOEVALUAR;
					$PROVEEDOR = $row->PROVEEDOR;
					$PRODUCTO = $row->PRODUCTO;
					$MARCA = $row->MARCA;
					
					$sheet->setCellValue('A'.$irow,$FECHA);
					$sheet->setCellValue('B'.$irow,$FECHAEVALUA);
					$sheet->setCellValue('C'.$irow,$FECHAESTADOEVALUACION);
					$sheet->setCellValue('D'.$irow,$ESTADOEVALUACION);
					$sheet->setCellValue('E'.$irow,$TIPOPRODUCTOEVALUAR);
					$sheet->setCellValue('F'.$irow,$PROVEEDOR);
					$sheet->setCellValue('G'.$irow,$PRODUCTO);
					$sheet->setCellValue('H'.$irow,$MARCA);
	
					$irow++;
				}
			}
			$sheet->setCellValue('B2',$CLIENTE);
			$pos = $irow - 1;
	
			$sheet->getStyle('A5:H'.$pos)->applyFromArray($celdastexto);
	
			$sheet->setAutoFilter('A4:H'.$pos);
	
			$writer = new Xlsx($spreadsheet);
			$filename = 'listaHomologaciones-'.time().'.xlsx"';
			ob_end_clean();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename);
			header('Cache-Control: max-age=0');
	
			$writer->save('php://output');
		}	

	/** LLENAR LISTAS - HOMOLOGACIONES **/ 
		// Lista de proveedores
		public function getproveedoreshomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->getproveedoreshomo($ccliente);
			echo json_encode($resultado);
		}
		// Lista de estados
		public function getestadoshomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->getestadoshomo($ccliente);
			echo json_encode($resultado);
		}	
		// Lista de tipo de proveedores
		public function gettipoprovedorhomo(){		
			$ccliente = $this->input->post('ccliente');		
			$resultado = $this->mconsulhomo->gettipoprovedorhomo($ccliente);
			echo json_encode($resultado);
		}	

	/** LLENAR LISTAS - PRODUCTO A VENCER **/ 	
		// Lista de alertas por fecha
		public function getalertasfecha(){	
			$fvence = $this->input->post('vence');

			$parametros = array(
				'@CCIA' 	        =>	$this->input->post('ccia'),
				'@CLIENTE' 	        =>	$this->input->post('ccliente'),
				'@PROVEEDOR' 	    =>	$this->input->post('proveedor'),			
				'@FVENCE' 	    	=>	substr($fvence, 6, 4).'-'.substr($fvence,3 , 2).'-'.substr($fvence, 0, 2),
			);
			$resultado = $this->mconsulhomo->getalertasfecha($parametros);
			echo json_encode($resultado);
        }
		
}