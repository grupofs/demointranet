<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

class CexcelExport extends CI_Controller {
	function __construct() {
		parent:: __construct();
		$this->load->model('ar/tramites/mconstramdigesa');	
		$this->load->model('ar/tramites/mconsregporvencer');	
		$this->load->model('ar/tramites/mbusctramdigemid', 'mconstramdigemid');
	}
	 
    public function viewtramite() { 		
		
		$this->layout->js(array(public_url('script/ar/tramitedigesa/constramdigesa.js')));

		$data['content_for_layout'] = 'ar/tramitedigesa/vconstramdigesa';
        $this->parser->parse('seguridad/vprincipalClie',$data);
    }   

	public function exceltramardigesa() {
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
		
		$sheet->setCellValue('A1', 'LISTADO DE TRAMITES AR')
			->mergeCells('A1:R1')
			->setCellValue('A2', 'CLIENTE:')
			->mergeCells('B2:D2')
			->setCellValue('A4', 'CÓDIGO')
			->setCellValue('B4', 'DESCRIPCIÓN SAP')
			->setCellValue('C4', 'NOMBRE DEL PRODUCTO')
			->setCellValue('D4', 'MARCA')
			->setCellValue('E4', 'CATEGORIA')
			->setCellValue('F4', 'PRESENTACIÓN')
			->setCellValue('G4', 'MODELO')
			->setCellValue('H4', 'FABRICANTE(S)')
			->setCellValue('I4', 'PAIS(ES)')
			->setCellValue('J4', 'FECHA INGRESO')
			->setCellValue('K4', 'TRÁMITE')
			->setCellValue('L4', 'ESTADO')
			->setCellValue('M4', 'N° EXPEDIENTE')
			->setCellValue('N4', 'RS')
			->setCellValue('O4', 'TIEMPO DE VIDA UTIL')
			->setCellValue('P4', 'NRO DR')
			->setCellValue('Q4', 'FECHA EMISIÓN')
			->setCellValue('R4', 'FECHA VENCIMIENTO')
			->setCellValue('S4', 'ACTIVO/ INACTIVO');

		$sheet->getStyle('A1:S1')->applyFromArray($titulo);
		$sheet->getStyle('A4:S4')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('M')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('N')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('O')->setAutoSize(false)->setWidth(18.10);
		$sheet->getColumnDimension('P')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('Q')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('R')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('S')->setAutoSize(false)->setWidth(12.10);

			$varnull = '';

			$codprod = 		($this->input->post('txtcodprodu') == $varnull) ? '%' : '%'.$this->input->post('txtcodprodu').'%';
			$nomprod = 		($this->input->post('txtdescprodu') == $varnull) ? '%' : '%'.$this->input->post('txtdescprodu').'%';
			$regsan = 		($this->input->post('txtnrors') == $varnull) ? '%' : '%'.$this->input->post('txtnrors').'%';
			$tono = 		($this->input->post('txtcaractprodu') == $varnull) ? '%' : '%'.$this->input->post('txtcaractprodu').'%';
			$estado = 		($this->input->post('cboesttramite') == $varnull) ? '%' : '%'.$this->input->post('cboesttramite').'%';
			$marca = 		($this->input->post('cbomarca') == $varnull) ? '%' : '%'.$this->input->post('cbomarca').'%';
			$allf = 		$this->input->post('chkFreg');
			$fini = 		$this->input->post('txtFIni');
			$ffin = 		$this->input->post('txtFFin');
			$ccliente = 	($this->input->post('hdnccliente') == $varnull) ? $this->input->post('cbocliente') : $this->input->post('hdnccliente');
			$numexpdiente = ($this->input->post('txtnroexpe') == $varnull) ? '%' : '%'.$this->input->post('txtnroexpe').'%';
			$ccategoria = 	'%';
			$est = 			($this->input->post('cboestproducto') == $varnull) ? '%' : '%'.$this->input->post('cboestproducto').'%';	
			$tipoest = 		$this->input->post('restado');	
			$tiporeporte = 	'E'; 
			$iln = 		    '%';
			
				
			if($allf == 'on'){
				$CFECHA = 'N';
			}else{
				$CFECHA = 'S';
			}
			

			$parametros = array(
				'@codprod' 		=>	$codprod,
				'@nomprod' 		=>  $nomprod,
				'@regsan' 		=>  $regsan,
				'@tono' 		=>  $tono,
				'@estado'		=>  $estado,
				'@marca' 		=>  $marca,
				'@tramite' 		=>  '%001%',
				'@allf' 		=>  $CFECHA,
				'@fi' 			=>  substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
				'@ff' 			=>  substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
				'@ccliente' 	=>  $ccliente,
				'@numexpdiente' =>  $numexpdiente,
				'@ccategoria' 	=>  $ccategoria,		
				'@est' 			=>  $est,
				'@tipoest' 		=>  $tipoest,
				'@TIPOREPORTE'	=>	$tiporeporte,
				'@iln'			=>	$iln
			);	

		$rpt = $this->mconstramdigesa->getconsulta_excel_tr($parametros);
		$irow = 5;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$CODIGOPROD = $row->CODIGOPROD;
				$DES_SAP = $row->DES_SAP;
				$NOMBREPROD = $row->NOMBREPROD;
				$MARCAPROD = $row->MARCAPROD;
				$DCATEGORIACLIENTE = $row->DCATEGORIACLIENTE;
				$DPRESENTACION = $row->DPRESENTACION;
				$TONOPROD = $row->TONOPROD;
				$FABRIPROD = $row->FABRIPROD;
				$PAISPROD = $row->PAISPROD;
				$tcreacion = $row->tcreacion;
				$TRAMITEPROD = $row->TRAMITEPROD;
				$ESTADO = $row->ESTADO;
				$NUMEXP = $row->NUMEXP;
				$REGSANIPROD = $row->REGSANIPROD;
				$VIDAUTIL = $row->VIDAUTIL;
				$DNUMERODR = $row->DNUMERODR;
				$FEMI = $row->FEMI;
				$FECHAVENCE = $row->FECHAVENCE;
				$SREGISTROPDTO = $row->SREGISTROPDTO;

				$sheet->setCellValue('A'.$irow,$CODIGOPROD);
				$sheet->setCellValue('B'.$irow,$DES_SAP);
				$sheet->setCellValue('C'.$irow,$NOMBREPROD);
				$sheet->setCellValue('D'.$irow,$MARCAPROD);
				$sheet->setCellValue('E'.$irow,$DCATEGORIACLIENTE);
				$sheet->setCellValue('F'.$irow,$DPRESENTACION);
				$sheet->setCellValue('G'.$irow,$TONOPROD);
				$sheet->setCellValue('H'.$irow,$FABRIPROD);
				$sheet->setCellValue('I'.$irow,$PAISPROD);
				$sheet->setCellValue('J'.$irow,$tcreacion);
				$sheet->setCellValue('K'.$irow,$TRAMITEPROD);
				$sheet->setCellValue('L'.$irow,$ESTADO);
				$sheet->setCellValue('M'.$irow,$NUMEXP);
				$sheet->setCellValue('N'.$irow,$REGSANIPROD);
				$sheet->setCellValue('O'.$irow,$VIDAUTIL);
				$sheet->setCellValue('P'.$irow,$DNUMERODR);
				$sheet->setCellValue('Q'.$irow,$FEMI);
				$sheet->setCellValue('R'.$irow,$FECHAVENCE);
				$sheet->setCellValue('S'.$irow,$SREGISTROPDTO);

				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A5:S'.$pos)->applyFromArray($celdastexto);

		$sheet->setAutoFilter('A4:S'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'ExpRegSanitario-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

	public function exceltramardigemid() {
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
		
		$sheet->setCellValue('A1', 'LISTADO DE TRAMITES AR')
			->mergeCells('A1:S1')
			->setCellValue('A2', 'CLIENTE:')
			->mergeCells('B2:D2')
			->setCellValue('A4', 'CÓDIGO')
			->setCellValue('B4', 'CÓDIGO FORMULA ILN')
			->setCellValue('C4', 'DESCRIPCIÓN SAP')
			->setCellValue('D4', 'NOMBRE DEL PRODUCTO')
			->setCellValue('E4', 'MARCA')
			->setCellValue('F4', 'CATEGORIA')
			->setCellValue('G4', 'PRESENTACIÓN')
			->setCellValue('H4', 'MODELO')
			->setCellValue('I4', 'FABRICANTE(S)')
			->setCellValue('J4', 'PAIS(ES)')
			->setCellValue('K4', 'FECHA INGRESO')
			->setCellValue('L4', 'TRÁMITE')
			->setCellValue('M4', 'ESTADO')
			->setCellValue('N4', 'N° EXPEDIENTE')
			->setCellValue('O4', 'NSO')
			->setCellValue('P4', 'NRO DR')
			->setCellValue('Q4', 'FECHA EMISIÓN')
			->setCellValue('R4', 'FECHA VENCIMIENTO')
			->setCellValue('S4', 'ACTIVO/ INACTIVO');

		$sheet->getStyle('A1:S1')->applyFromArray($titulo);
		$sheet->getStyle('A4:S4')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(45.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('M')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('N')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('O')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('P')->setAutoSize(false)->setWidth(18.10);
		$sheet->getColumnDimension('Q')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('R')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('S')->setAutoSize(false)->setWidth(12.10);

			$varnull = '';

			$codprod = 		($this->input->post('txtcodprodu') == $varnull) ? '%' : '%'.$this->input->post('txtcodprodu').'%';
			$nomprod = 		($this->input->post('txtdescprodu') == $varnull) ? '%' : '%'.$this->input->post('txtdescprodu').'%';
			$regsan = 		($this->input->post('txtnrors') == $varnull) ? '%' : '%'.$this->input->post('txtnrors').'%';
			$tono = 		($this->input->post('txtcaractprodu') == $varnull) ? '%' : '%'.$this->input->post('txtcaractprodu').'%';
			$estado = 		($this->input->post('cboesttramite') == $varnull) ? '%' : '%'.$this->input->post('cboesttramite').'%';
			$marca = 		($this->input->post('cbomarca') == $varnull) ? '%' : '%'.$this->input->post('cbomarca').'%';
			$allf = 		$this->input->post('chkFreg');
			$fini = 		$this->input->post('txtFIni');
			$ffin = 		$this->input->post('txtFFin');
			$ccliente = 	($this->input->post('hdnccliente') == $varnull) ? $this->input->post('cbocliente') : $this->input->post('hdnccliente');
			$numexpdiente = ($this->input->post('txtnroexpe') == $varnull) ? '%' : '%'.$this->input->post('txtnroexpe').'%';
			$ccategoria = 	'%';
			$est = 			($this->input->post('cboestproducto') == $varnull) ? '%' : '%'.$this->input->post('cboestproducto').'%';	
			$tipoest = 		$this->input->post('restado');	
			$tiporeporte = 	'E'; 
			$iln = 		    '%';
			
				
			if($allf == 'on'){
				$CFECHA = 'N';
			}else{
				$CFECHA = 'S';
			}
			

			$parametros = array(
				'@codprod' 		=>	$codprod,
				'@nomprod' 		=>  $nomprod,
				'@regsan' 		=>  $regsan,
				'@tono' 		=>  $tono,
				'@estado'		=>  $estado,
				'@marca' 		=>  $marca,
				'@tramite' 		=>  '%002%',
				'@allf' 		=>  $CFECHA,
				'@fi' 			=>  substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
				'@ff' 			=>  substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
				'@ccliente' 	=>  $ccliente,
				'@numexpdiente' =>  $numexpdiente,
				'@ccategoria' 	=>  $ccategoria,		
				'@est' 			=>  $est,
				'@tipoest' 		=>  $tipoest,
				'@TIPOREPORTE'	=>	$tiporeporte,
				'@iln'			=>	$iln
			);	

		$rpt = $this->mconstramdigemid->getconsulta_excel_tr($parametros);
		$irow = 5;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$CODIGOPROD = $row->CODIGOPROD;
				$dcodigoformula = $row->dcodigoformula;
				$DES_SAP = $row->DES_SAP;
				$NOMBREPROD = $row->NOMBREPROD;
				$MARCAPROD = $row->MARCAPROD;
				$DCATEGORIACLIENTE = $row->DCATEGORIACLIENTE;
				$DPRESENTACION = $row->DPRESENTACION;
				$TONOPROD = $row->TONOPROD;
				$FABRIPROD = $row->FABRIPROD;
				$PAISPROD = $row->PAISPROD;
				$tcreacion = $row->tcreacion;
				$TRAMITEPROD = $row->TRAMITEPROD;
				$ESTADO = $row->ESTADO;
				$NUMEXP = $row->NUMEXP;
				$REGSANIPROD = $row->REGSANIPROD;
				$DNUMERODR = $row->DNUMERODR;
				$FEMI = $row->FEMI;
				$FECHAVENCE = $row->FECHAVENCE;
				$SREGISTROPDTO = $row->SREGISTROPDTO;
				

				$sheet->setCellValue('A'.$irow,$CODIGOPROD);
				$sheet->setCellValue('B'.$irow,$dcodigoformula);
				$sheet->setCellValue('C'.$irow,$DES_SAP);
				$sheet->setCellValue('D'.$irow,$NOMBREPROD);
				$sheet->setCellValue('E'.$irow,$MARCAPROD);
				$sheet->setCellValue('F'.$irow,$DCATEGORIACLIENTE);
				$sheet->setCellValue('G'.$irow,$DPRESENTACION);
				$sheet->setCellValue('H'.$irow,$TONOPROD);
				$sheet->setCellValue('I'.$irow,$FABRIPROD);
				$sheet->setCellValue('J'.$irow,$PAISPROD);
				$sheet->setCellValue('K'.$irow,$tcreacion);
				$sheet->setCellValue('L'.$irow,$TRAMITEPROD);
				$sheet->setCellValue('M'.$irow,$ESTADO);
				$sheet->setCellValue('N'.$irow,$NUMEXP);
				$sheet->setCellValue('O'.$irow,$REGSANIPROD);
				$sheet->setCellValue('P'.$irow,$DNUMERODR);
				$sheet->setCellValue('Q'.$irow,$FEMI);
				$sheet->setCellValue('R'.$irow,$FECHAVENCE);
				$sheet->setCellValue('S'.$irow,$SREGISTROPDTO);

				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A5:S'.$pos)->applyFromArray($celdastexto);

		$sheet->setAutoFilter('A4:S'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'ExpTramitesAR-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function excelregporvencer() {
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
		$sheet->setTitle('Listado - Registros por Vencer');

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
		
		$sheet->setCellValue('A1', 'LISTADO DE REGISTROS POR VENCER')
			->mergeCells('A1:K1')
			->setCellValue('A2', 'CLIENTE:')
			->mergeCells('B2:D2')
			->setCellValue('A4', 'Nro')
			->setCellValue('B4', 'Código')
			->setCellValue('C4', 'Descripcion SAP')
			->setCellValue('D4', 'Nombre del Producto')
			->setCellValue('E4', 'Modelo / Tono / Variedades / Sub-Marca')
			->setCellValue('F4', 'Marca')
			->setCellValue('G4', 'Categoria')
			->setCellValue('H4', 'Fabricante(s)')
			->setCellValue('I4', 'País(es)')
			->setCellValue('J4', 'NSO')
			->setCellValue('K4', 'F. Vence');

		$sheet->getStyle('A1:K1')->applyFromArray($titulo);
		$sheet->getStyle('A4:K4')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(32.10);
		$sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(32.10);

			$varnull = '';

			$ccliente       = $this->input->post('cbocliente');
			$descripcion    = $this->input->post('txtdescripcion');
			$porvencer    = $this->input->post('rporvencer');
			
				
			if($porvencer == '180'){
				$varporvencer = 180;
			}else{
				$varporvencer = 360;
			};
			

			$parametros = array(
				'@ccliente' 		=>	$ccliente,
				'@descripcion' 		=>  ($this->input->post('txtdescripcion') == '') ? '%' : '%'.$descripcion.'%',
				'@porvencer'		=> $varporvencer,				
			);	

		$rpt = $this->mconsregporvencer->getbuscarregporvencer($parametros);
		$irow = 5;
		$ipos = 1;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->DRAZONSOCIAL;
				$CPRODUCTOCLIENTE = $row->CPRODUCTOCLIENTE;
				$DPRODUCTOCLIENTE = $row->DPRODUCTOCLIENTE;
				$DNOMBREPRODUCTO = $row->DNOMBREPRODUCTO;
				$DMODELOPRODUCTO = $row->DMODELOPRODUCTO;
				$DMARCA = $row->DMARCA;
				$DREGISTRO = $row->DREGISTRO;
				$FABRICANTES = $row->FABRICANTES;
				$PAISFABRICANTES = $row->PAISFABRICANTES;
				$DREGISTROSANITARIO = $row->DREGISTROSANITARIO;
				$FFINREGSANITARIO = $row->FFINREGSANITARIO;

				$sheet->setCellValue('A'.$irow,$ipos);
				$sheet->setCellValue('B'.$irow,$CPRODUCTOCLIENTE);
				$sheet->setCellValue('C'.$irow,$DPRODUCTOCLIENTE);
				$sheet->setCellValue('D'.$irow,$DNOMBREPRODUCTO);
				$sheet->setCellValue('E'.$irow,$DMODELOPRODUCTO);
				$sheet->setCellValue('F'.$irow,$DMARCA);
				$sheet->setCellValue('G'.$irow,$DREGISTRO);
				$sheet->setCellValue('H'.$irow,$FABRICANTES);
				$sheet->setCellValue('I'.$irow,$PAISFABRICANTES);
				$sheet->setCellValue('J'.$irow,$DREGISTROSANITARIO);
				$sheet->setCellValue('K'.$irow,$FFINREGSANITARIO);
				
				$ipos++;
				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A5:K'.$pos)->applyFromArray($celdastexto);

		$sheet->setAutoFilter('A4:K'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'RepTramVencidos-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

}
?>
