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

class Cconsexcel extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('lab/consultas/mconsultas');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }

    public function excelinfinacal(){
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
					   'rgb' => '042C5C'
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
					   'rgb' => '042C5C'
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
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
           ];			
           $celdasnumerodec = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'numberFormat' => [
                    'formatCode' => '#,##0.0',
                ],
           ];		
           $celdasnumero = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'numberFormat' => [
                    'formatCode' => '#,##0',
                ],
           ];
        /*Estilos */	
        
        $varnull = '';

		$buscar      = $this->input->post('hrdbuscar');
		$anio   = $this->input->post('cboAnio');
		$mes       = $this->input->post('cboMes');
		$fini       = $this->input->post('txtFIni');
		$ffin       = $this->input->post('txtFFin');
		$sem      = $this->input->post('cboSem');
		$tipodes      = $this->input->post('hrdtipodes');
        $descr      = $this->input->post('txtdescripcion');
        
        if($buscar == 'P'){
            $fini = '%';
            $ffin = '%';
            $sem = 0;
        }else if($buscar == 'F'){
            $anio = 0;
            $mes = 0;
            $sem = 0;
        }else if($buscar == 'S'){
            $fini = '%';
            $ffin = '%';
            $mes = 0;
        }
                 
        $parametros = array(
			'@ANIO'         => $anio,
			'@MES'          => $mes,
			'@FINI'         => ($fini == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2), 
			'@FFIN'         => ($ffin == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@SEM'          => $sem,
			'@TIPODESC'		=> $tipodes,
			'@DESCRIPCION'  => ($this->input->post('txtdescripcion') == '') ? '%' : '%'.$descr.'%',
        );

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
        
        $sheet->setCellValue('A1', 'INFORME INACAL')
			->mergeCells('A1:E1')
			->setCellValue('A3', '')
			->setCellValue('B3', 'NRO. INFORME')
			->setCellValue('C3', 'FECHA DE EMISION')
			->setCellValue('D3', 'MATRIZ, PRODUCTO O MATERIAL')
			->setCellValue('E3', 'DISCIPLINA');

        $sheet->getStyle('A1:E1')->applyFromArray($titulo);
        $sheet->getStyle('A3:E3')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(7.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(20.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(25.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(70.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(30.10);
        
		$rpt = $this->mconsultas->infinacal($parametros);
        $irow = 4;
        $i = 0;
        if ($rpt){
        	foreach($rpt as $row){
                $NROINFORME     = $row->NROINFORME;
                $FEMISION = $row->FEMISION;
                $PRODUCTO = $row->PRODUCTO;
                $DISCIPLINA = $row->DISCIPLINA;
                $i++;

                $sheet->setCellValue('A'.$irow,$i);
                $sheet->setCellValue('B'.$irow,$NROINFORME);
                $sheet->setCellValue('C'.$irow,$FEMISION);
                $sheet->setCellValue('D'.$irow,$PRODUCTO);
                $sheet->setCellValue('E'.$irow,$DISCIPLINA);

				$irow++;
			}
        }
        $posfin = $irow - 1;

        $sheet->getStyle('A4:E'.$posfin)->applyFromArray($celdastexto);
        $sheet->getStyle('A4:A'.$posfin)->applyFromArray($celdastextocentro);
        $sheet->getStyle('C4:C'.$posfin)->applyFromArray($celdastextocentro);
        
		$sheet->setTitle('Listado - Informes');            
		$writer = new Xlsx($spreadsheet);
		$filename = 'listinformeinacal-'.time();
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }
}
?>