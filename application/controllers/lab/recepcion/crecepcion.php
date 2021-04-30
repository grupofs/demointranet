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

class Crecepcion extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('lab/recepcion/mrecepcion');
		$this->load->model('lab/coti/mcotizacion');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** COTIZACION **/

    public function getbuscarrecepcion() { // Buscar Cotizacion
		$varnull = '';

		$ccliente   = $this->input->post('ccliente');
		$fini       = $this->input->post('fini');
		$ffin       = $this->input->post('ffin');
		$descr      = $this->input->post('descr');
		$estado      = $this->input->post('estado');
		$tieneot      = $this->input->post('tieneot');
        
        $parametros = array(
			'@CCIA'         => '2',
			'@CCLIENTE'     => ($this->input->post('ccliente') == '') ? '0' : $ccliente,
			'@FINI'         => ($this->input->post('fini') == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
			'@FFIN'         => ($this->input->post('ffin') == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@DESCR'		=> ($this->input->post('descr') == '') ? '%' : '%'.$descr.'%',
			'@ESTADO'		=> ($this->input->post('estado') == '%') ? '%' : $estado,
			'@TIENEOT'		=> ($this->input->post('tieneot') == '%') ? '%' : $tieneot,
        );
        $retorna = $this->mrecepcion->getbuscarrecepcion($parametros);
        echo json_encode($retorna);		
    }

    public function setrecepcionmuestra() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('mhdnidcotizacion');
		$nversioncotizacion 	= $this->input->post('mhdnnroversion');
		$nordenproducto 	    = $this->input->post('mhdnnordenproducto');
        
		$cmuestra 			    = $this->input->post('mtxtmcodigo');
		$frecepcionmuestra 		= $this->input->post('mtxtFrecepcion');
		$drealproducto 		    = $this->input->post('mtxtmproductoreal');
		$dpresentacion 		    = $this->input->post('mtxtmpresentacion');
		$dtemperatura 		    = $this->input->post('mtxttemprecep');
		$dcantidad 		        = $this->input->post('mtxtcantmuestra');
		$dproveedorproducto 	= $this->input->post('mtxtproveedor');
		$dlote 	                = $this->input->post('mtxtnrolote');
		$fenvase 	            = $this->input->post('mtxtFenvase');
		$fmuestra 	            = $this->input->post('mtxtFmuestra');
		$hmuestra 	            = $this->input->post('mtxthmuestra');
		$stottus 		        = $this->input->post('mcbotottus');
		$ntrimestre 		    = $this->input->post('mcbomonitoreo');
		$zctipomotivo 	        = $this->input->post('mcbomotivo');
		$careacliente 	        = $this->input->post('mcboarea');
		$zctipoitem 	        = $this->input->post('mcboitem');
		$dubicacion 	        = $this->input->post('mtxtubicacion');
		$dcondicion 	        = $this->input->post('mtxtestado');
		$dobservacion 	        = $this->input->post('mtxtObserva');
		$dotraobservacion 	    = $this->input->post('mtxtObsotros');

		$accion 			    = $this->input->post('mhdnAccionRecepcion');
        
        $parametros = array(
            '@cinternocotizacion'   	=>  $cinternocotizacion,
            '@nversioncotizacion'   	=>  $nversioncotizacion,
            '@nordenproducto'      		=>  $nordenproducto,
            '@cmuestra'    		        =>  $cmuestra,
			'@frecepcionmuestra'        =>  substr($frecepcionmuestra, 6, 4).'-'.substr($frecepcionmuestra,3 , 2).'-'.substr($frecepcionmuestra, 0, 2),
			'@drealproducto'    	    =>  $drealproducto,
			'@dpresentacion'    		=>  $dpresentacion,
			'@dtemperatura'    		    =>  $dtemperatura,
			'@dcantidad'   	            =>  $dcantidad,
			'@dproveedorproducto'       =>  $dproveedorproducto,
			'@dlote'    	            =>  $dlote,
			'@fenvase'                  =>  ($this->input->post('mtxtFenvase') == $varnull) ? NULL : substr($fenvase, 6, 4).'-'.substr($fenvase,3 , 2).'-'.substr($fenvase, 0, 2),
			'@fmuestra'                 =>  ($this->input->post('mtxtFmuestra') == $varnull) ? NULL : substr($fmuestra, 6, 4).'-'.substr($fmuestra,3 , 2).'-'.substr($fmuestra, 0, 2),
			'@hmuestra'    		        =>  ($this->input->post('mtxthmuestra') == $varnull) ? NULL : $hmuestra,
            '@stottus'      	        =>  $stottus,
            '@ntrimestre'               =>  $ntrimestre,
            '@zctipomotivo'             =>  $zctipomotivo,
            '@careacliente'             =>  $careacliente,
            '@zctipoitem'               =>  $zctipoitem,
            '@dubicacion'               =>  $dubicacion,
            '@dcondicion'               =>  $dcondicion,
            '@dobservacion'             =>  $dobservacion,
            '@dotraobservacion'         =>  $dotraobservacion,
            '@accion'           	    =>  $accion
        );
        $retorna = $this->mrecepcion->setrecepcionmuestra($parametros);
        echo json_encode($retorna);		
	}
    
    public function getrecepcionmuestra() {	// Visualizar Servicios en CBO	
             
		$cinternocotizacion 	= $this->input->post('idcoti');
        $nversioncotizacion 	= $this->input->post('nversion');
        
        $parametros = array(
            '@cinternocotizacion'   	=>  $cinternocotizacion,
            '@nversioncotizacion'   	=>  $nversioncotizacion
        );
        $resultado = $this->mrecepcion->getrecepcionmuestra($parametros);
        echo json_encode($resultado);
    } 
    

	public function pdfOrderServ($cinternoordenservicio) { // recupera los cPTIZACION
        $this->load->library('pdfgenerator');

        $date = getdate();
        $fechaactual = date("d") . "/" . date("m") . "/" . date("Y");

        $html = '<html>
                <head>
                    <title>Orden de Trabajo</title>
                    <style>
                        @page {
                             margin: 0.3in 0.3in 0.3in 0.3in;
                        }
                        .teacherPage {
                            page: teacher;
                            page-break-after: always;
                        }
                        body{
                            font-family: Arial, Helvetica, sans-serif;
                            font-size: 9pt;
                            margin-top: 2cm;
                            margin-left: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                        }  
                        header {
                            position: fixed;
                            top: 0cm;
                            left: 0cm;
                            right: 0cm;
                            height: 3cm;
                        }
                        .cuerpo {
                            text-align: justify;
                        }
                        img.izquierda {
                            float: left;
                        }
                        img.derecha {
                            float: right;
                        }
                        div.page_break {
                            page-break-before: always;
                        }
                        .page-number {
                          text-align: right;
                        }                        
                        .page-number:before {
                          content: counter(page);
                        }
                        th { 
                            text-align: center; 
                            border: 1px solid black;
                        }
                    </style>
                </head>
                <body>
                
                <header>
                    <table  width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;">
                        <tr>
                            <td width="20%" rowspan="4">
                                <img src="'.public_url_ftp().'Imagenes/formatos/2/logoFSC.jpg" width="100" height="60" />    
                            </td>
                            <td width="60%" align="center" rowspan="4">
                                <h2>ORDEN DE TRABAJO</h2>
                            </td>
                            <td width="20%" align="center" colspan="2">
                                FSC-F-LAB-09
                            </td>
                        </tr>
                        <tr>
                            <td>Versión</td>
                            <td align="right">01</td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td align="right">05/11/2012</td>
                        </tr>
                        <tr>
                            <td>Página</td>
                            <td align="right"><div class="page-number"></div></td>
                        </tr>
                    </table>
                </header>';

        			
        $res = $this->mrecepcion->getpdfdatosot($cinternoordenservicio);
        if ($res){
            foreach($res as $row){
				$nordentrabajo      = $row->nordentrabajo;
				$fordentrabajo      = $row->fordentrabajo;
				$cinternocotizacion = $row->cinternocotizacion;
                $nversioncotizacion = $row->nversioncotizacion;
                $OBSERVACION        = $row->OBSERVACION;
			}
		}
                
        $html .= '
            <main>
                <table width="700px" align="center" cellspacing="0" cellpadding="2" >
                    <tr>
                        <td colspan="3" style="height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%">&nbsp;</td>
                        <td width="25%" align="right">N° '.$nordentrabajo.'</td>
                        <td width="25%" align="right">Fecha '.$fordentrabajo.'</td>
                    </tr>
                    <tr>
                        <td colspan="3" ><b>I AREA</b></td>
                    </tr>
                    <tr>
                        <td>MICROBIOLOGÍA</td>
                        <td>FISICOQUÍMICA</td>
                        <td>SENSORIAL</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:10px;">&nbsp;</td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="0" cellpadding="2">
                    <tr>
                        <td><b>II PRODUCTOS / PRESENTACIÓN / CANTIDAD</b></td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="1" cellpadding="0" FRAME="void" RULES="rows">
                    <tr>
                        <th width="10%" align="center">CÓDIGO DE MUESTRA</th>
                        <th width="35%" align="center">PRODUCTO</th>
                        <th width="35%" align="center">PRESENTACIÓN / CANTIDAD</th>
                        <th width="20%" align="center">CONDICIONES (*)</th>
                    </tr>';
                    $resprod = $this->mrecepcion->getpdfdatosotprod($cinternoordenservicio);
                    if ($resprod){
                        foreach($resprod as $rowprod){
                            $cmuestra       = $rowprod->cmuestra;
                            $drealproducto  = $rowprod->drealproducto;
                            $DPRESENTACION  = $rowprod->DPRESENTACION;
                            $dtemperatura = $rowprod->dtemperatura;
                            $html .= '<tr>
                                <td width="12%">&nbsp;'.$cmuestra.'</td>
                                <td width="40%">&nbsp;'.$drealproducto.'</td>
                                <td width="30%">&nbsp;'.$DPRESENTACION.'</td>
                                <td width="18%">&nbsp;'.$dtemperatura.'</td>
                            </tr>';
                        }
                    }        
                $html .= '</table>
                <table width="700px" align="center" cellspacing="0" cellpadding="2">
                    <tr>
                        <td style="height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>III SOLICITUD DE ENSAYO</b></td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="1" cellpadding="0" FRAME="void" RULES="rows">
                    <tr>
                        <th width="12%" align="center">PRODUCTO(S)</th>
                        <th width="8%" align="center">Código Metodo</th>
                        <th width="30%" align="center">METODO DE ENSAYO</th>
                        <th width="37%" align="center">NORMA / REFERENCIA</th>
                        <th width="5%" align="center">Vías</th>
                        <th width="5%" align="center">AC/ NOAC</th>
                    </tr>';
                    $resensayo = $this->mrecepcion->getpdfdatosotensayo($cinternoordenservicio);
                    if ($resensayo){
                        foreach($resensayo as $rowensayo){
                            $CMUESTRA   = $rowensayo->CMUESTRA;
                            $CENSAYOFS  = $rowensayo->CENSAYOFS;
                            $DENSAYO    = $rowensayo->DENSAYO;
                            $DNORMA     = $rowensayo->DNORMA;
                            $SACNOAC    = $rowensayo->SACNOAC;
                            $CANTIDAD   = $rowensayo->CANTIDAD;
                            $html .= '<tr>
                                <td width="12%">&nbsp;'.$CMUESTRA.'</td>
                                <td width="8%">&nbsp;'.$CENSAYOFS.'</td>
                                <td width="30%">&nbsp;'.$DENSAYO.'</td>
                                <td width="37%">&nbsp;'.$DNORMA.'</td>
                                <td width="5%">&nbsp;'.$CANTIDAD.'</td>
                                <td width="5%">&nbsp;'.$SACNOAC.'</td>
                            </tr>';
                        }
                    } 
                    
                           
                $html .= '<tr>
                        <td colspan="6" style="height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">Observaciones:</td>
                        <td colspan="4">'.$OBSERVACION.'</td>
                    </tr>
                </table>
                
                <table width="700px" align="center" cellspacing="0" cellpadding="2">
                    <tr>
                        <td colspan="3" style="height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <th width="15%" align="center">BK</th>
                        <th width="30%" align="center" style="border: black 1px solid;">LOTE</th>
                        <th width="55%" align="center" style="border: white 1px solid;">&nbsp;</th>
                    </tr>';
                    $resensayo = $this->mrecepcion->getpdfdatosotblancov($cinternocotizacion);
                    if ($resensayo){
                        foreach($resensayo as $rowensayo){
                            $bk     = $rowensayo->bk;
                            $lote   = $rowensayo->lote;
                            $html .= '<tr>
                                <td width="15%">&nbsp;'.$bk.'</td>
                                <td width="30%">&nbsp;'.$lote.'</td>
                                <td width="55%">&nbsp;</td>
                            </tr>';
                        }
                    } 
                $html .= '/table>
            </main>';

        $html .= '</body></html>';
		$filename = 'OrdenTrabajo-';//.$namefile;
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');
        //echo $html;
    }
    
    public function setordentrabajo() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('cinternocotizacion');
		$nversioncotizacion 	= $this->input->post('nversioncotizacion');
        $cusuario 	            = $this->input->post('cusuario');

        $parametros = array(
            '@cinternocotizacion'   	=>  $cinternocotizacion,
            '@nversioncotizacion'   	=>  $nversioncotizacion,
            '@cusuario'    		        =>  $cusuario,
        );
        $retorna = $this->mrecepcion->setordentrabajo($parametros);
        echo json_encode($retorna);	
    }
    
    public function setordentrabajoresult() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('cinternocotizacion');
		$nversioncotizacion 	= $this->input->post('nversioncotizacion');
		$nordenproducto 	    = $this->input->post('nordenproducto');
        $cmuestra 	            = $this->input->post('cmuestra');
        $cusuario 	            = $this->input->post('cusuario');

        $parametros = array(
            '@cinternocotizacion'   	=>  $cinternocotizacion,
            '@nversioncotizacion'   	=>  $nversioncotizacion,
            '@nordenproducto'      		=>  $nordenproducto,
            '@cmuestra'    		        =>  $cmuestra,
            '@cusuario'    		        =>  $cusuario,
        );
        $retorna = $this->mrecepcion->setordentrabajoresult($parametros);
        echo json_encode($retorna);	
    }

    public function setupdateFechaOT() { // Registrar informe PT
        $varnull = '';
        $fechaot = $this->input->post('txtForden');
        
		$mhdncinternoordenservicio 	= $this->input->post('mhdncinternoordenservicio');
		$fordentrabajo 	=  ($this->input->post('txtForden') == $varnull) ? NULL : substr($fechaot, 6, 4).'-'.substr($fechaot,3 , 2).'-'.substr($fechaot, 0, 2);
		$nordentrabajo 	= $this->input->post('mhdnnroordenservicio');
        
        $retorna = $this->mrecepcion->setupdateFechaOT($mhdncinternoordenservicio,$fordentrabajo,$nordentrabajo);
        echo json_encode($retorna);		
	}
    
    public function getlistdetrecepcion() {	// Visualizar
        $cinternocotizacion   = $this->input->post('cinternocotizacion');
        $nversioncotizacion   = $this->input->post('nversioncotizacion');
        $resultado = $this->mrecepcion->getlistdetrecepcion($cinternocotizacion, $nversioncotizacion);
        echo json_encode($resultado);
    }

    public function exportexcellistcoti(){
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

		$ccliente   = $this->input->post('cboclieserv');
		$chkFreg       = $this->input->post('chkFreg');
		$fini       = $this->input->post('txtFIni');
		$ffin       = $this->input->post('txtFFin');
		$descr      = $this->input->post('txtdescri');
		$estado      = $this->input->post('cboestado');
		$tieneot      = $this->input->post('cbotieneot');
        
        $parametros = array(
			'@CCIA'         => '2',
			'@CCLIENTE'     => ($this->input->post('cboclieserv') == '') ? '0' : $ccliente,
			'@FINI'         => ($this->input->post('chkFreg') == NULL) ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
			'@FFIN'         => ($this->input->post('chkFreg') == NULL) ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@DESCR'		=> ($this->input->post('txtdescri') == '') ? '%' : '%'.$descr.'%',
			'@ESTADO'		=> ($this->input->post('cboestado') == '%') ? '%' : $estado,
			'@TIENEOT'		=> ($this->input->post('cbotieneot') == '%') ? '%' : $tieneot,
			'@ACTIVO'       => 'A',
        );

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
        
        $sheet->setCellValue('A1', 'LISTADO DE COTIZACIONES')
			->mergeCells('A1:S1')
			->setCellValue('A3', 'Fecha Cotización')
			->setCellValue('B3', 'Nro Cotización')
			->setCellValue('C3', 'Estado Coti.')
			->setCellValue('D3', 'Cliente')
			->setCellValue('E3', 'Proveedor')
			->setCellValue('F3', 'Contacto')
			->setCellValue('G3', 'Elaborado por')
			->setCellValue('H3', 'Tipo de Pago')
			->setCellValue('I3', 'Moneda')
			->setCellValue('J3', 'Muestreo')
			->setCellValue('K3', 'Sub Total')
			->setCellValue('L3', 'Descuento %')
			->setCellValue('M3', 'Descuento')
			->setCellValue('N3', 'Monto sin IGV')
			->setCellValue('O3', 'IGV')
			->setCellValue('P3', 'Monto Total')
			->setCellValue('Q3', 'Nro OT')
			->setCellValue('R3', 'Fecha OT')
			->setCellValue('S3', 'Observación');

        $sheet->getStyle('A1:S1')->applyFromArray($titulo);
        $sheet->getStyle('A3:S3')->applyFromArray($cabecera);
		
		$sheet->getColumnDimension('A')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('B')->setAutoSize(false)->setWidth(19.10);
		$sheet->getColumnDimension('C')->setAutoSize(false)->setWidth(10.10);
		$sheet->getColumnDimension('D')->setAutoSize(false)->setWidth(54.10);
		$sheet->getColumnDimension('E')->setAutoSize(false)->setWidth(54.10);
		$sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(35.10);
		$sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(35.10);
		$sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(17.10);
		$sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(9.10);
		$sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(10.10);
		$sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(11.10);
		$sheet->getColumnDimension('M')->setAutoSize(false)->setWidth(11.10);
		$sheet->getColumnDimension('N')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('O')->setAutoSize(false)->setWidth(11.10);
		$sheet->getColumnDimension('P')->setAutoSize(false)->setWidth(12.10);
		$sheet->getColumnDimension('Q')->setAutoSize(false)->setWidth(19.10);
		$sheet->getColumnDimension('R')->setAutoSize(false)->setWidth(12.10);
        $sheet->getColumnDimension('S')->setAutoSize(false)->setWidth(72.10);
        
        $sheet->getStyle('Q')->getAlignment()->setWrapText(true);
        $sheet->getStyle('S')->getAlignment()->setWrapText(true);

		$rpt = $this->mcotizacion->getexcellistcoti($parametros);
		$irow = 4;
        if ($rpt){
        	foreach($rpt as $row){
                $DFECHA     = $row->DFECHA;
                $NROCOTI = $row->NROCOTI;
                $DESTADO = $row->DESTADO;
                $DCLIENTE = $row->DCLIENTE;
                $CPROVEEDOR = $row->CPROVEEDOR;
                $CONTACTO = $row->CONTACTO;
                $ELABORADO = $row->ELABORADO;
                $TIPOPAGO = $row->TIPOPAGO;
                $MONEDA = $row->MONEDA;
                $IMUESTREO = $row->IMUESTREO;
                $ISUBTOTAL = $row->ISUBTOTAL;
                $PDESCUENTO = $row->PDESCUENTO;
                $DDESCUENTO = $row->DDESCUENTO;
                $MONTOSINIGV = $row->MONTOSINIGV;
                $DIGV = $row->DIGV;
                $ITOTAL = $row->ITOTAL;
                $NROOT = $row->NROOT;
                $FOT = $row->FOT;
                $OBSERVA = $row->OBSERVA;

                $sheet->setCellValue('A'.$irow,$DFECHA);
                $sheet->setCellValue('B'.$irow,$NROCOTI);
                $sheet->setCellValue('C'.$irow,$DESTADO);
                $sheet->setCellValue('D'.$irow,$DCLIENTE);
                $sheet->setCellValue('E'.$irow,$CPROVEEDOR);
                $sheet->setCellValue('F'.$irow,$CONTACTO);
                $sheet->setCellValue('G'.$irow,$ELABORADO);
                $sheet->setCellValue('H'.$irow,$TIPOPAGO);
                $sheet->setCellValue('I'.$irow,$MONEDA);
                $sheet->setCellValue('J'.$irow,$IMUESTREO);
                $sheet->setCellValue('K'.$irow,$ISUBTOTAL);
                $sheet->setCellValue('L'.$irow,$PDESCUENTO);
                $sheet->setCellValue('M'.$irow,$DDESCUENTO);
                $sheet->setCellValue('N'.$irow,$MONTOSINIGV);
                $sheet->setCellValue('O'.$irow,$DIGV);
                $sheet->setCellValue('P'.$irow,$ITOTAL);
                $sheet->setCellValue('Q'.$irow,$NROOT);
                $sheet->setCellValue('R'.$irow,$FOT);
                $sheet->setCellValue('S'.$irow,$OBSERVA);

				$irow++;
			}
        }
        $posfin = $irow - 1;

        $sheet->getStyle('A4:S'.$posfin)->applyFromArray($celdastexto);
        $sheet->getStyle('A4:A'.$posfin)->applyFromArray($celdastextocentro);
        $sheet->getStyle('J4:K'.$posfin)->applyFromArray($celdasnumerodec);
        $sheet->getStyle('L4:L'.$posfin)->applyFromArray($celdasnumero);
        $sheet->getStyle('M4:P'.$posfin)->applyFromArray($celdasnumerodec);
        $sheet->getStyle('I4:I'.$posfin)->applyFromArray($celdastextocentro);
        
		$sheet->setTitle('Listado - Cotización');            
		$writer = new Xlsx($spreadsheet);
		$filename = 'listCotizacion-'.time();
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }
}
?>