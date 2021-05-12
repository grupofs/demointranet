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
		$sheet->setTitle('Seguimiento-AccCorr');

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
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(7.10);
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
}
?>