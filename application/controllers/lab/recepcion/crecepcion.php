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
    

	public function pdfOrderServ($idcoti,$nversion) { // recupera los cPTIZACION
        $this->load->library('pdfgenerator');

        $date = getdate();
        $fechaactual = date("d") . "/" . date("m") . "/" . date("Y");

        $html = '<html>
                <head>
                    <title>Cotizacion</title>
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
                    </style>
                </head>
                <body>';

        			
        $res = $this->mcotizacion->getpdfdatoscoti($idcoti,$nversion);
        if ($res){
            foreach($res as $row){
				$dcotizacion         = $row->dcotizacion;
				$drazonsocial         = $row->drazonsocial;
				$nruc         = $row->nruc;
				$ddireccioncliente         = $row->ddireccioncliente;
				$dtelefono         = $row->dtelefono;
				$dcontacto         = $row->dcontacto;
				$dmail         = $row->dmail;
                $fcotizacion         = $row->fcotizacion;
                $imuestreo         = $row->imuestreo;
                $isubtotal         = $row->isubtotal;
                $pigv         = $row->pigv;
                $pdescuento         = $row->pdescuento;
                $itotal         = $row->itotal;
				$cantprod         = $row->cantprod;
				$summuestra         = $row->summuestra;
				$cforma_pago         = $row->cforma_pago;
				$banco         = $row->banco;
				$detraccion         = $row->detraccion;
                $entrega         = $row->entrega;
                $dcantidadminima         = $row->dcantidadminima;
                $diaspermanecia         = $row->diaspermanecia;
                $diascoti         = $row->diascoti;
                $dobservacion         = $row->dobservacion;
                $usuariocrea         = $row->usuariocrea;
			}
		}
                
        $html .= '<div>
        <table width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;">
                    <tr>
                        <td width="80px" rowspan="4">
                            <img src="./FTPfileserver/Imagenes/formatos/2/logoFSC.jpg" width="100" height="60" />    
                        </td>
                        <td align="center" rowspan="4">
                            <h2>COTIZACION DE SERVICIO DE ENSAYO</h2>
                        </td>
                        <td width="130px" align="center" colspan="2">
                            FSC-F-LAB-07
                        </td>
                    </tr>
                    <tr>
                        <td>Versión</td>
                        <td align="right">02</td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td align="right">24/10/2013</td>
                    </tr>
                    <tr>
                        <td>Página</td>
                        <td align="right">2D</td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;">
                    <tr>
                        <td colspan="4"><b>N°'.$dcotizacion.'</b></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height:10px;"></td>
                    </tr>
                    <tr>
                        <td colspan="4" ><b>I CLIENTE</b></td>
                    </tr>
                    <tr>
                        <td width="80px">Razón Social:</td>
                        <td width="360px">'.$drazonsocial.'</td>
                        <td width="50px">RUC:</td>
                        <td width="190px">'.$nruc.'</td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td>'.$ddireccioncliente.'</td>
                        <td>Teléfono:</td>
                        <td>'.$dtelefono.'</td>
                    </tr>
                    <tr>
                        <td>Contacto:</td>
                        <td>'.$dcontacto.'</td>
                        <td>E-mail:</td>
                        <td>'.$dmail.'</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Fecha:</td>
                        <td>'.$fcotizacion.'</td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;">
                    <tr>
                        <td><b>II DETERMINACIONES</b></td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;" FRAME="void" RULES="cols">
                    <tr>
                        <td width="180px" align="center">LOCAL</td>
                        <td width="340px" align="center">PRODUCTO</td>
                        <td width="160px" align="center">CONDICIONES DE LA MUESTRA (*)</td>
                    </tr>
                </table>
                <table width="700px" align="center" cellspacing="0" cellpadding="3" FRAME="void" RULES="rows">';
                		
                	
        $resprod = $this->mcotizacion->getpdfdatosprod($idcoti,$nversion);
        if ($resprod){
            foreach($resprod as $rowprod){
				$destablecimiento = $rowprod->destablecimiento;
				$dproducto = $rowprod->dproducto;
				$condicion = $rowprod->condicion;
				$procedencia = $rowprod->procedencia;
                $html .= '<tr>
                    <td width="180px">'.$destablecimiento.' / '.$procedencia.'</td>
                    <td>'.$dproducto.'</td>
                    <td width="160px">'.$condicion.'</td>
                </tr>';
			}
		}        
        $html .= '</table>
        <table width="300px" style="margin-left: 15px; height:25px;">
            <tr>
                <td>Cantidad de Productos:</td>
                <td>'.$cantprod.'</td>
                <td>Suma de Muestras:</td>
                <td>'.$summuestra.'</td>
            </tr>
            <tr>
                <td colspan="4" style="height:30px;"></td>
            </tr>
        </table>
        <table width="700px" align="center" cellspacing="0" cellpadding="2" style="border: 1px solid black;"  FRAME="void" RULES="cols">
            <tr >
                <td width="40px" align="center">Codigo Metodo</td>
                <td width="120px" align="center">METODO DE ENSAYO</td>
                <td width="20px" align="center">AC / NOAC</td>
                <td width="160px" align="center">NORMA / REFERENCIA</td>
                <td width="20px" align="center">Cant.</td>
                <td width="40px" align="center">P.UNI S/.</td>
                <td width="40px" align="center">Precio Total S/.</td>
            </tr>';
        $resproddet = $this->mcotizacion->getpdfdatosprod($idcoti,$nversion);
        if ($resproddet){
            foreach($resproddet as $rowproddet){
                $dproductodet = strtoupper($rowproddet->dproducto);
                $idproduc = $rowproddet->nordenproducto;
                
                $html .= '<tr>
                    <td colspan="7"><h3>'.$dproductodet.'</h3>
                    </td>
                </tr>';
                    $resensadet = $this->mcotizacion->getlistarensayo($idcoti,$nversion,$idproduc);
                    if ($resensadet){
                        foreach($resensadet as $rowensadet){
                            $codigo = $rowensadet->CODIGO;
                            $densayo = $rowensadet->DENSAYO;
                            $acre = $rowensadet->ACRE;
                            $norma = $rowensadet->NORMA;
                            $cantidad = $rowensadet->CANTIDAD;
                            $costoensa = $rowensadet->CONSTOENSAYO;
                            $costo = $rowensadet->COSTO;
                            $html .= '<tr>
                            <td width="50px">
                            '.$codigo.'
                            </td>
                            <td width="160px">
                            '.$densayo.'
                            </td>
                            <td width="40px" align="center">
                            '.$acre.'
                            </td>
                            <td width="220px">
                            '.$norma.'
                            </td>
                            <td width="40px" align="center">
                            '.$cantidad.'
                            </td>
                            <td width="50px" align="right">
                            '.$costoensa.'
                            </td>
                            <td width="50px" align="right">
                            '.$costo.'
                            </td>
                            </tr>';
                        }
                    }
                    $html .= '';
			}
		}
        $html .= '</table>
        <table width="700px" align="center">
            <tr>
                <td width="500px">AC: Método Acreditado<br>NO AC: Método No Acreditado</td>
                <td width="80px"> Muestreo</td>
                <td width="80px" align="right">'.$imuestreo.'</td>
            </tr>
            <tr>
                <td></td>
                <td> SUBTOTAL</td>
                <td width="80px" align="right">'.$isubtotal.'</td>
            </tr>
            <tr>
                <td></td>
                <td> DESCUENTOS</td>
                <td width="80px" align="right">'.$pdescuento.'</td>
            </tr>
            <tr>                
                <td></td>
                <td> IGV 18%</td>
                <td width="80px" align="right">'.$pigv.'</td>
            </tr>
            <tr>                
                <td></td>
                <td> TOTAL</td>
                <td width="80px" align="right">'.$itotal.'</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;">
                </td>
            </tr>
        </table>';

        $html .= '<table width="700px" align="center">
            <tr>
                <td><b>III</b></td>
                <td><b>FORMA DE PAGO</b></td>
                <td align="left">'.$cforma_pago.'</td>
                <td>'.$banco.'</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>'.$detraccion.'</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>CCI: 00219400156160801692</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td><b>IV</b></td>
                <td colspan="2"><b>TIEMPO DE ENTREGA DEL INFORME</b></td>
                <td>'.$entrega.'</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td><b>V</b></td>
                <td colspan="2"><b>CANTIDAD DE MUESTRA MINIMA</b></td>
                <td>'.$dcantidadminima.'</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td>(*) </td>
                <td colspan="3">En caso el cliente incumpla estas condiciones la muestra se considerará muestra no idónea y sólo con su autorización será ensayada y reportará como Informe No Oficial.</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
        </table>';
        
        $html .= '<table width="700px" align="center">
            <tr>
                <td VALIGN=top><b>VI</b></td>
                <td colspan="2"><b>PERMANENCIA DE LA CONTRA MUESTRA EN EL LABORATORIO:</b>  En caso de que el servicio considere contramuestras, éstas se conservarán en el laboratorio por el período acordado con el cliente, 
                luego de lo cual serán eliminadas de acuerdo a nuestros procedimientos  internos. En caso el cliente requiera la devolución de la contramuestra, esta deberá ser solicitada antes de la finalización del Tiempo de Custodia(***)</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
            <tr>
                <td>(***)</td>
                <td colspan="2">'.$diaspermanecia.'</td>
            </tr>
            <tr>
                <td><b>VII</b></td>
                <td><b>VIGENCIA DE COTIZACION</b></td>
                <td align="left">'.$diascoti.'</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
        </table>';
        
        $html .= '<table width="700px" align="center">
            <tr>
                <td VALIGN=top><b>VIII</b></td>
                <td colspan="2"><b>ACEPTACION DE LA COTIZACION:</b></td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">En caso de Aceptar la Cotización, favor de enviarla firmada o declaranado su aceptación mediante un correo electronico. Cualquier cambio en la cotización enviada deberá solicitarse antes de iniciado el servicio.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">Al dar su visto bueno, el cliente acepta esta cotización con carácter de contrato.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">Toda la información derivada de las actividades del laboratorio obtenidas a través del servicio brindado se conservará de modo confidencial, excepto por la información que el cliente pone a disposición del público, o cuando lo acuerdan el laboratorio y el cliente.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">Cuando a FS Certificaciones se le solicite por ley o disposiciones contractuales divulgar información confidencial, notificará al cliente salvo que esté prohibido por ley.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">La información acerca del cliente, obtenida de fuentes diferentes del cliente se tratará como información confidencial.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">La emisión de los Informes de Ensayo se realizará en formato digital (PDF), los cuales serán enviados por correo electrónico al cliente. El envío de los informes físicos tiene un costo adicional que será informado al cliente.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2">Copias adicionales de los informes y las traducciones de los mismos tendrán un costo adicional.</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
            <tr>
                <td VALIGN=top><b>IX</b></td>
                <td><b>OBSERVACIONES:</b></td>
                <td>'.$dobservacion.'</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
        </table>';
        
        $html .= '<table width="700px" align="center">
            <tr>
                <td colspan="4" style="height:80px;"></td>
            </tr>
            <tr>
                <td></td>
                <td align="center">SOLICITANTE</td>
                <td></td>
                <td align="center">FSC LABORATORIO</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;"></td>
            </tr>
            <tr>
                <td colspan="4"><b>'.$usuariocrea.'</b></td>
            </tr>
        </table>';

        $html .= '</div></body></html>';
		$filename = 'coti';
		$this->pdfgenerator->generate($html, $filename);
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