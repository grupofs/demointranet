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

class CctrlprovclieExport extends CI_Controller {
	function __construct() {
		parent:: __construct();
		$this->load->model('at/ctrlprovclie/mconsseguiaacc');
		$this->load->model('at/ctrlprovclie/mconscertifprov');	
	}
	
	public function excelconsseguiaacc() {
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
           $celdastextocentro = [
               'font'	=> [
                   'name' => 'Arial',
                   'size' => 10,
                   'color' => array('rgb' => '000000'),
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
           $celdasnumero = [
               'alignment' => [
                   'horizontal' => Alignment::HORIZONTAL_RIGHT,
                   'vertical' => Alignment::VERTICAL_CENTER,
                   'wrapText' => true,
               ],
           ];			
           $formatonroundec = [
               'numberFormat' => [
                   'formatCode' => '#,##0.0',
               ],
           ];
		/*Estilos */	

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Seguimiento Acc. Corr.');

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
		
		$sheet->setCellValue('A1', 'LISTADO DE SEGUIMIENTO DE ACCIONES CORRECTIVAS')
			->mergeCells('A1:F1')
			->setCellValue('A2', 'CLIENTE:')
			->mergeCells('B2:D2')
			->setCellValue('A4', 'N°')
			->setCellValue('B4', 'Categoria')
			->setCellValue('C4', 'Nro. de Proveedores')
			->setCellValue('D4', 'Nro. de Inspecciones')
			->setCellValue('E4', 'Inspecciones con Acciones Correctivas Concluídas')
			->setCellValue('F4', '% de Inspecciones con Acciones Correctivas');

		$sheet->getStyle('A1:F1')->applyFromArray($titulo);
		$sheet->getStyle('A4:F4')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(9.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(45.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(25.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(25.10);

			$varnull = '';
            
            $ccliente       = $this->input->post('hdnCCliente');
            $anio           = $this->input->post('cboAnio');
            $mes            = $this->input->post('cboMes');
            $fini           = $this->input->post('txtFIni');
            $ffin           = $this->input->post('txtFFin');
            $area           = $this->input->post('cboareaclie');
            $periodo        = $this->input->post('hrdbuscar');

            if($periodo == 'P'){
                $fini = '%';
                $ffin = '%';
            }
        
            $parametros = array(
                '@CCLIENTE'		=>  $ccliente,
                '@ANIO'		    =>  $anio,
                '@MES'		    =>  ($mes == $varnull) ? 0 : $mes,
                '@FINI' 		=>  ($fini == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2), 
                '@FFIN' 		=>  ($ffin == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
                '@AREA'		    =>  ($area == $varnull) ? '%' : $area,
            );	

		$rpt = $this->mconsseguiaacc->getconsseguiaacc($parametros);
		$irow = 5;
		$ipos = 1;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$AREACLIENTE = $row->AREACLIENTE;
				$NROPROVEEDOR = $row->NROPROVEEDOR;
				$TOTALAC = $row->TOTALAC;
				$ACRECUPERADAS = $row->ACRECUPERADAS;
				$PTOTALACRE = $row->PTOTALACRE;

				$sheet->setCellValue('A'.$irow,$ipos);
				$sheet->setCellValue('B'.$irow,$AREACLIENTE);
				$sheet->setCellValue('C'.$irow,$NROPROVEEDOR);
				$sheet->setCellValue('D'.$irow,$TOTALAC);
				$sheet->setCellValue('E'.$irow,$ACRECUPERADAS);
				$sheet->setCellValue('F'.$irow,$PTOTALACRE);
				
				$ipos++;
				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A5:F'.$pos)->applyFromArray($celdastexto);
		$sheet->getStyle('C5:F'.$pos)->applyFromArray($celdasnumero);

		$sheet->setAutoFilter('A4:F'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'RepSeguiAACC-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function excelconsdetseguiaacc() {
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
           $celdastextocentro = [
               'font'	=> [
                   'name' => 'Arial',
                   'size' => 10,
                   'color' => array('rgb' => '000000'),
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
           $celdasnumero = [
               'alignment' => [
                   'horizontal' => Alignment::HORIZONTAL_RIGHT,
                   'vertical' => Alignment::VERTICAL_CENTER,
                   'wrapText' => true,
               ],
           ];			
           $formatonroundec = [
               'numberFormat' => [
                   'formatCode' => '#,##0.00',
               ],
           ];
		/*Estilos */	

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Detalle Seguimiento Acc. Corr.');

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
		
		$sheet->setCellValue('A1', 'LISTADO DETALLE DE SEGUIMIENTO DE AA. CC.')
			->mergeCells('A1:J1')
			->setCellValue('A2', 'CLIENTE:')
			->setCellValue('A3', 'AREA:')
			->mergeCells('B2:D2')
			->mergeCells('B3:D3')
			->setCellValue('A5', 'N°')
			->setCellValue('B5', 'Proveedor')
			->setCellValue('C5', 'Linea de Proceso')
			->setCellValue('D5', 'Nro. de Informe')
			->setCellValue('E5', 'Resultado (%)')
			->setCellValue('F5', 'Resultado (%)')
			->setCellValue('G5', 'Fecha Envio AA. CC.')
			->setCellValue('H5', 'AA. CC. Concluidas')
			->setCellValue('I5', 'AA. CC. por Realizar')
			->setCellValue('J5', 'Total AA. CC.');

		$sheet->getStyle('A1:J1')->applyFromArray($titulo);
		$sheet->getStyle('A5:J5')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(9.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(55.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(22.10);
		$sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(22.10);

			$varnull = '';
            
            $ccliente       = $this->input->post('hddnmdetccliente');
            $anio           = $this->input->post('hddnmdetanio');
            $mes            = $this->input->post('hddnmdetmes');
            $fini           = $this->input->post('hddnmdetfini');
            $ffin           = $this->input->post('hddnmdetffin');
            $area           = $this->input->post('hddnmdetarea');
        
            $parametros = array(
                '@CCLIENTE'		=>  $ccliente,
                '@ANIO'		    =>  $anio,
                '@MES'		    =>  ($mes == $varnull) ? 0 : $mes,
                '@FINI' 		=>  ($fini == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2), 
                '@FFIN' 		=>  ($ffin == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
                '@AREA'		    =>  $area,
            );	

		$rpt = $this->mconsseguiaacc->getdetseguiaacc($parametros);
		$irow = 6;
		$ipos = 1;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$AREACLIENTE = $row->AREACLIENTE;
				$PROVEEDOR = $row->PROVEEDOR;
				$LINEACLIENTE = $row->LINEACLIENTE;
				$NROINFORME = $row->NROINFORME;
				$RESULTADOCHECKLIST = $row->RESULTADOCHECKLIST;
				$descripcion_result = $row->descripcion_result;
				$FACEPTACORRECTIVA = $row->FACEPTACORRECTIVA;
				$ACRECUPERADAS = $row->ACRECUPERADAS;
				$ACPORREALIZAR = $row->ACPORREALIZAR;
				$TOTALAC = $row->TOTALAC;

				$sheet->setCellValue('A'.$irow,$ipos);
				$sheet->setCellValue('B'.$irow,$PROVEEDOR);
				$sheet->setCellValue('C'.$irow,$LINEACLIENTE);
				$sheet->setCellValue('D'.$irow,$NROINFORME);
				$sheet->setCellValue('E'.$irow,$RESULTADOCHECKLIST);
				$sheet->setCellValue('F'.$irow,$descripcion_result);
				$sheet->setCellValue('G'.$irow,$FACEPTACORRECTIVA);
				$sheet->setCellValue('H'.$irow,$ACRECUPERADAS);
				$sheet->setCellValue('I'.$irow,$ACPORREALIZAR);
				$sheet->setCellValue('J'.$irow,$TOTALAC);
				
				$ipos++;
				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$sheet->setCellValue('B3',$AREACLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A6:J'.$pos)->applyFromArray($celdastexto);
		$sheet->getStyle('D6:D'.$pos)->applyFromArray($celdastextocentro);
		$sheet->getStyle('F6:F'.$pos)->applyFromArray($celdastextocentro);
		$sheet->getStyle('E6:E'.$pos)->applyFromArray($celdasnumero);
		$sheet->getStyle('E6:E'.$pos)->applyFromArray($formatonroundec);
		$sheet->getStyle('G6:J'.$pos)->applyFromArray($celdasnumero);

		$sheet->setAutoFilter('A5:J'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'RepDetSeguiAACC-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function excelconscertifprov() {
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
           $celdastextocentro = [
               'font'	=> [
                   'name' => 'Arial',
                   'size' => 10,
                   'color' => array('rgb' => '000000'),
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
           $celdasnumero = [
               'alignment' => [
                   'horizontal' => Alignment::HORIZONTAL_RIGHT,
                   'vertical' => Alignment::VERTICAL_CENTER,
                   'wrapText' => true,
               ],
           ];			
           $formatonroundec = [
               'numberFormat' => [
                   'formatCode' => '#,##0.00',
               ],
           ];
		/*Estilos */	

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('List Provee. Certificaciones');

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
		
		$sheet->setCellValue('A1', 'LISTADO DE PROVEEDORES CON CERTIFICACIONES')
			->mergeCells('A1:J1')
			->setCellValue('A2', 'CLIENTE:')
			->mergeCells('B2:D2')
			->setCellValue('A4', 'Certificadora')
			->setCellValue('B4', 'Certificación')
			->setCellValue('C4', 'No Aplica')
			->setCellValue('D4', 'No Tiene')
			->setCellValue('E4', 'Si Tiene')
			->setCellValue('F4', 'Convalidado')
			->setCellValue('G4', 'Total');

		$sheet->getStyle('A1:G1')->applyFromArray($titulo);
		$sheet->getStyle('A4:G4')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(25.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(65.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(15.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(15.10);

			$varnull = '';
            
            $ccliente       = $this->input->post('hdnCCliente');
            $anio           = $this->input->post('cboAnio');
            $mes            = $this->input->post('cboMes');
        
            $parametros = array(
                '@CCLIENTE'		=>  $ccliente,
                '@ANIO'		    =>  $anio,
                '@MES'		    =>  ($mes == $varnull) ? 0 : $mes,
            );	

		$rpt = $this->mconscertifprov->getconscertifprov($parametros);
		$irow = 6;
		$ipos = 1;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$CERTIFICADORA = $row->CERTIFICADORA;
				$CERTIFICACION = $row->CERTIFICACION;
				$NOAPLICA = $row->NOAPLICA;
				$NOTIENE = $row->NOTIENE;
				$SITIENE = $row->SITIENE;
				$CONVALIDADO = $row->CONVALIDADO;
				$TOTAL = $row->TOTAL;

				$sheet->setCellValue('A'.$irow,$CERTIFICADORA);
				$sheet->setCellValue('B'.$irow,$CERTIFICACION);
				$sheet->setCellValue('C'.$irow,$NOAPLICA);
				$sheet->setCellValue('D'.$irow,$NOTIENE);
				$sheet->setCellValue('E'.$irow,$SITIENE);
				$sheet->setCellValue('F'.$irow,$CONVALIDADO);
				$sheet->setCellValue('G'.$irow,$TOTAL);
				
				$ipos++;
				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$pos = $irow - 1;

		$sheet->getStyle('A6:G'.$pos)->applyFromArray($celdastexto);
		$sheet->getStyle('D6:D'.$pos)->applyFromArray($celdastextocentro);
		$sheet->getStyle('F6:F'.$pos)->applyFromArray($celdastextocentro);
		$sheet->getStyle('E6:E'.$pos)->applyFromArray($celdasnumero);
		$sheet->getStyle('E6:E'.$pos)->applyFromArray($formatonroundec);
		$sheet->getStyle('G6:G'.$pos)->applyFromArray($celdasnumero);

		$sheet->setAutoFilter('A5:B'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'RepCertifProv-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
	
	public function excelconsdetcertifprov() {
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
           $celdastextocentro = [
               'font'	=> [
                   'name' => 'Arial',
                   'size' => 10,
                   'color' => array('rgb' => '000000'),
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
           $celdasnumero = [
               'alignment' => [
                   'horizontal' => Alignment::HORIZONTAL_RIGHT,
                   'vertical' => Alignment::VERTICAL_CENTER,
                   'wrapText' => true,
               ],
           ];			
           $formatonroundec = [
               'numberFormat' => [
                   'formatCode' => '#,##0.00',
               ],
           ];
		/*Estilos */	

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Detalle Provee. Certificaciones');

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
		
		$sheet->setCellValue('A1', 'LISTADO DETALLE DE PROVEEDORES CON CERTIFICACIONES')
			->mergeCells('A1:D1')
			->setCellValue('A2', 'CLIENTE:')
			->setCellValue('A3', 'CERTIFICADO:')
			->mergeCells('B3:C3')
			->setCellValue('A5', 'N°')
			->setCellValue('B5', 'Proveedor - (Establecimiento/Maquilador)')
			->setCellValue('C5', 'Linea de Proceso')
			->setCellValue('D5', 'Dir. Establecimiento');

		$sheet->getStyle('A1:D1')->applyFromArray($titulo);
		$sheet->getStyle('A5:D5')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(62.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(62.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(62.10);

			$varnull = '';
            
            $CCLIENTE       = $this->input->post('hddnmdetccliente');
            $ANIO           = $this->input->post('hddnmdetanio');
            $MES            = $this->input->post('hddnmdetmes');
            $CERTI           = $this->input->post('hddnmdetcerti');
            $ESTADO           = $this->input->post('hddnmdetestado');
        
            $parametros = array(
				'@CCLIENTE'		=>  $CCLIENTE,
				'@ANIO'		    =>  $ANIO,
				'@MES'		    =>  $MES,
				'@CERTI'		=>  ($this->input->post('hddnmdetcerti') == $varnull) ? NULL : $CERTI,
				'@ESTADO'	    =>  $ESTADO,
			);	

		$rpt = $this->mconscertifprov->getcertidet($parametros);
		$irow = 6;
		$ipos = 1;
        if ($rpt){
        	foreach($rpt as $row){	

				$CLIENTE = $row->CLIENTE;
				$CERTIFICACION = $row->CERTIFICACION;
				$PROVEEDOR = $row->PROVEEDOR;
				$LINEAPROCESO = $row->LINEAPROCESO;
				$DIRESTABLECIMIENTO = $row->DIRESTABLECIMIENTO;

				$sheet->setCellValue('A'.$irow,$ipos);
				$sheet->setCellValue('B'.$irow,$PROVEEDOR);
				$sheet->setCellValue('C'.$irow,$LINEAPROCESO);
				$sheet->setCellValue('D'.$irow,$DIRESTABLECIMIENTO);
				
				$ipos++;
				$irow++;
			}
		}
		$sheet->setCellValue('B2',$CLIENTE);
		$sheet->setCellValue('B3',$CERTIFICACION);
		$pos = $irow - 1;

		$sheet->getStyle('A6:D'.$pos)->applyFromArray($celdastexto);

		$sheet->setAutoFilter('A5:D'.$pos);

		$writer = new Xlsx($spreadsheet);
		$filename = 'RepDetCertifProv-'.time().'.xlsx"';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename);
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
?>