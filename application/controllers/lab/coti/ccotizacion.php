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

class Ccotizacion extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('lab/coti/mcotizacion');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** COTIZACION **/
    public function getcboclieserv() {	// Visualizar Clientes del servicio en CBO	
        $resultado = $this->mcotizacion->getcboclieserv();
        echo json_encode($resultado);
    } 

    public function getbuscarcotizacion() { // Buscar Cotizacion
		$varnull = '';

		$ccliente   = $this->input->post('ccliente');
		$fini       = $this->input->post('fini');
		$ffin       = $this->input->post('ffin');
		$descr      = $this->input->post('descr');
		$estado      = $this->input->post('estado');
		$tieneot      = $this->input->post('tieneot');
		$activo      = $this->input->post('activo');
        
        $parametros = array(
			'@CCIA'         => '2',
			'@CCLIENTE'     => ($this->input->post('ccliente') == '') ? '0' : $ccliente,
			'@FINI'         => ($this->input->post('fini') == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
			'@FFIN'         => ($this->input->post('ffin') == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@DESCR'		=> ($this->input->post('descr') == '') ? '%' : '%'.$descr.'%',
			'@ESTADO'		=> ($this->input->post('estado') == '%') ? '%' : $estado,
			'@TIENEOT'		=> ($this->input->post('tieneot') == '%') ? '%' : $tieneot,
			'@ACTIVO'       => $activo,
        );
        $retorna = $this->mcotizacion->getbuscarcotizacion($parametros);
        echo json_encode($retorna);		
    }
    
    public function getcboregserv() {	// Visualizar Servicios en CBO	
        $resultado = $this->mcotizacion->getcboregserv();
        echo json_encode($resultado);
    } 
    
    public function getcliente() {	// Visualizar Servicios en CBO	
        $resultado = $this->mcotizacion->getcliente();
        echo json_encode($resultado);
    } 
    
    public function getprovcliente() {	// Visualizar Servicios en CBO
        $ccliente   = $this->input->post('ccliente');
        $resultado = $this->mcotizacion->getprovcliente($ccliente);
        echo json_encode($resultado);
    } 
    
    public function getcontaccliente() {	// Visualizar Servicios en CBO
        $ccliente   = $this->input->post('ccliente');
        $resultado = $this->mcotizacion->getcontaccliente($ccliente);
        echo json_encode($resultado);
    } 

    public function setcotizacion() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('mtxtidcotizacion');
		$nversioncotizacion 	= $this->input->post('mtxtnroversion');
		$fcotizacion 			= $this->input->post('mtxtFcotizacion');
		$dcotizacion 			= $this->input->post('mtxtregnumcoti');
		$scotizacion 		    = $this->input->post('hdnregestado');
		$nvigencia 		        = $this->input->post('mtxtregvigen');
		$csubservicio 		    = $this->input->post('cboregserv');
		$ccliente 		        = $this->input->post('cboregclie');
		$cproveedorcliente 	    = ($this->input->post('cboregprov') == '%') ? '' : $this->input->post('cboregprov');
		$ccontacto 	            = ($this->input->post('cboregcontacto') == '%') ? '' : $this->input->post('cboregcontacto');
		$npermanenciamuestra 	= $this->input->post('mtxtcontramuestra');
		$ntiempoentregainforme 	= $this->input->post('mtxtregentregainf');
		$stiempoentregainforme 	= $this->input->post('txtregtipodias');
		$dobservacion 		    = $this->input->post('mtxtobserv');
		$zctipoformapago 		= $this->input->post('txtregformapagos');
		$dotraformapago 	    = $this->input->post('mtxtregpagotro');
		$ctipocambio 	        = $this->input->post('mtxtregtipopagos');
		$dtipocambio 	        = $this->input->post('mtxtregtipocambio');
		$smuestreo 	            = ($this->input->post('chksmuestreo') == '') ? 'N' : 'S';
		$imuestreo 	            = $this->input->post('txtmontmuestreo');
		$isubtotal 	            = $this->input->post('txtmontsubtotal');
		$pdescuento 	        = $this->input->post('txtporcdescuento');
		$pigv 	                = 18;
		$digv 	                = $this->input->post('txtporctigv');
		$itotal 	            = $this->input->post('txtmonttotal');
        $smostrarprecios 	    = ($this->input->post('chkregverpago') == '') ? 'N' : 'S';
		$cusuario 			    = $this->input->post('mtxtcusuario');
		$zpermanenciamuestra 	= $this->input->post('mtxtregpermane');
		$accion 			    = $this->input->post('hdnAccionregcoti');
        
        $parametros = array(
            '@cinternocotizacion'   	=>  $cinternocotizacion,
            '@nversioncotizacion'   	=>  $nversioncotizacion,
            '@fcotizacion'      		=>  substr($fcotizacion, 6, 4).'-'.substr($fcotizacion,3 , 2).'-'.substr($fcotizacion, 0, 2),
            '@dcotizacion'    		    =>  $dcotizacion,
			'@scotizacion'    		    =>  $scotizacion,
			'@nvigencia'    	        =>  $nvigencia,
			'@csubservicio'    		    =>  $csubservicio,
			'@ccliente'    		        =>  $ccliente,
			'@cproveedorcliente'   	    =>  $cproveedorcliente,
			'@ccontacto'                =>  $ccontacto,
			'@npermanenciamuestra'    	=>  $npermanenciamuestra,
			'@ntiempoentregainforme'    =>  $ntiempoentregainforme,
			'@stiempoentregainforme'    =>  $stiempoentregainforme,
			'@dobservacion'    		    =>  $dobservacion,
            '@zctipoformapago'      	=>  $zctipoformapago,
            '@dotraformapago'           =>  $dotraformapago,
            '@ctipocambio'              =>  $ctipocambio,
            '@dtipocambio'              =>  $dtipocambio,
            '@smuestreo'                =>  $smuestreo,
            '@imuestreo'                =>  $imuestreo,
            '@isubtotal'                =>  $isubtotal,
            '@pdescuento'               =>  $pdescuento,
            '@pigv'                     =>  $pigv,
            '@digv'                     =>  $digv,
            '@itotal'                   =>  $itotal,
            '@smostrarprecios'          =>  $smostrarprecios,
            '@cusuario'                 =>  $cusuario,
			'@zpermanenciamuestra'    	=>  $zpermanenciamuestra,
            '@accion'           	    =>  $accion
        );
        $retorna = $this->mcotizacion->setcotizacion($parametros);
        echo json_encode($retorna);		
	}
    
    public function getlistarproducto() {	// Visualizar Servicios en CBO	
        $idcoti     = $this->input->post('idcoti');
        $nversion   = $this->input->post('nversion');
        $resultado = $this->mcotizacion->getlistarproducto($idcoti,$nversion);
        echo json_encode($resultado);
    } 
    
    public function getcboregLocalclie() {	// Visualizar Servicios en CBO
        $ccliente   = $this->input->post('ccliente');
        $resultado = $this->mcotizacion->getcboregLocalclie($ccliente);
        echo json_encode($resultado);
    }
    
    public function getcboregcondi() {	// Visualizar Servicios en CBO
        $resultado = $this->mcotizacion->getcboregcondi();
        echo json_encode($resultado);
    }  
    
    public function getcboregprocede() {	// Visualizar Servicios en CBO
        $resultado = $this->mcotizacion->getcboregprocede();
        echo json_encode($resultado);
    }  

    public function setproductoxcotizacion() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('mhdnidcotizacion');
		$nversioncotizacion 	= $this->input->post('mhdnnroversion');
		$nordenproducto 		= $this->input->post('mhdnIdProduc');
		$clocalcliente 			= $this->input->post('mcboregLocalclie');
		$dproducto 		        = $this->input->post('mtxtregProducto');
		$zctipocondicionpdto 	= $this->input->post('mcboregcondicion');
		$nmuestra 		        = $this->input->post('mtxtregmuestra');
		$zctipoprocedencia 		= $this->input->post('mcboregprocedencia');
		$dcantidadminima 	    = $this->input->post('mtxtregcantimin');
		$ctipoproducto 	        = $this->input->post('mcboregoctogono');
		$setiquetanutri 	    = $this->input->post('mcboregetiquetado');
		$ntamanoporcion 	    = $this->input->post('mtxtregtamporci');
		$umporcion 	            = $this->input->post('mcboregumeti');
		$cusuario 			    = $this->input->post('mhdncusuario');
		$accion 			    = $this->input->post('mhdnAccionProduc');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto,
            '@clocalcliente'    	=>  $clocalcliente,
			'@dproducto'    		=>  $dproducto,
			'@zctipocondicionpdto'  =>  $zctipocondicionpdto,
			'@nmuestra'    		    =>  $nmuestra,
			'@zctipoprocedencia'    =>  $zctipoprocedencia,
			'@dcantidadminima'   	=>  $dcantidadminima,
			'@ctipoproducto'        =>  $ctipoproducto,
			'@setiquetanutri'    	=>  $setiquetanutri,
			'@ntamanoporcion'       =>  $ntamanoporcion,
			'@umporcion'            =>  $umporcion,
            '@cusuario'             =>  $cusuario,
            '@accion'           	=>  $accion
        );
        $retorna = $this->mcotizacion->setproductoxcotizacion($parametros);
        echo json_encode($retorna);		
	}
    
    public function getlistarensayo() {	// Visualizar Servicios en CBO	
        $idcoti     = $this->input->post('idcoti');
        $nversion   = $this->input->post('nversion');
        $idproduc   = $this->input->post('idproduc');
        $resultado = $this->mcotizacion->getlistarensayo($idcoti,$nversion,$idproduc);
        echo json_encode($resultado);
    } 

	public function pdfCoti($idcoti,$nversion) { // recupera los cPTIZACION
        $this->load->library('pdfgenerator');

        $date = getdate();
        $fechaactual = date("d") . "/" . date("m") . "/" . date("Y");

        $html = '<html>
                <head>
                    <title>Cotización</title>
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
                                <h2>COTIZACION DE SERVICIO DE ENSAYO</h2>
                            </td>
                            <td width="20%" align="center" colspan="2">
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
                            <td align="right"><div class="page-number"></div></td>
                        </tr>
                    </table>
                </header>';

        			
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
                $verprecios         = $row->verprecios;
                $digv         = $row->digv;
                $ddescuento         = $row->ddescuento;
                $condescuento         = $row->condescuento;
                $namefile         = $row->namefile;
                $ctipocambio         = $row->ctipocambio;
                $dtipocambio         = $row->dtipocambio;              
                
                
                if ($ctipocambio  == 'S') :
                    $var_moneda = 'S/.';
                else:
                    $var_moneda = '$';
                endif;
			}
		}
                
        $html .= '
            <main>
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
                <table width="700px" align="center" cellspacing="1" cellpadding="0" FRAME="void" RULES="rows">
                    <tr>
                        <th width="30%" align="center">LOCAL</th>
                        <th width="35%" align="center">PRODUCTO</th>
                        <th width="20%" align="center">CONDICIONES DE LA MUESTRA</th>
                        <th width="15%" align="center">CANTIDAD MUESTRA MINIMA</th>
                    </tr>';
                    //</table>
                    //<table width="700px" align="center" cellspacing="0" cellpadding="3" style="border: 1px solid black;" FRAME="void" RULES="rows">';  
                    $resprod = $this->mcotizacion->getpdfdatosprod($idcoti,$nversion);
                    if ($resprod){
                        foreach($resprod as $rowprod){
                            $destablecimiento = $rowprod->destablecimiento;
                            $dproducto = $rowprod->dproducto;
                            $condicion = $rowprod->condicion;
                            $procedencia = $rowprod->procedencia;
                            $dcantidadminima = $rowprod->dcantidadminima;
                            $html .= '<tr>
                                <td width="30%">&nbsp;'.$destablecimiento.' <br> &nbsp;'.$procedencia.'</td>
                                <td width="35%">&nbsp;'.$dproducto.'</td>
                                <td width="20%">&nbsp;'.$condicion.'</td>
                                <td width="15%">&nbsp;'.$dcantidadminima.'</td>
                            </tr>';
                        }
                    }        
                $html .= '</table>';
                //<table width="700px" align="center" cellspacing="1" cellpadding="0" style="border: 1px solid black;" FRAME="void" RULES="rows">
                $html .= '<table width="300px" style="margin-left: 15px; height:25px;">
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
                <table width="700px" align="center" cellspacing="1" cellpadding="0" FRAME="void" RULES="rows">
                    <tr >
                        <th width="10%" align="center">Codigo Metodo</th>
                        <th width="30%" align="center">METODO DE ENSAYO</th>
                        <th width="10%" align="center">AC / NOAC</th>
                        <th width="20%" align="center">NORMA / REFERENCIA</th>
                        <th width="10%" align="center">Cant.</th>
                        <th width="10%" align="center">P.UNI '.$var_moneda.'</th>
                        <th width="10%" align="center">Precio Total '.$var_moneda.'</th>
                    </tr>';
                    $resproddet = $this->mcotizacion->getpdfdatosprod($idcoti,$nversion);
                    if ($resproddet){
                        foreach($resproddet as $rowproddet){
                            $dproductodet = strtoupper($rowproddet->dproducto);
                            $idproduc = $rowproddet->nordenproducto;
                            $subtotal = $rowproddet->subtotal;
                            
                            if ($verprecios  == 'S') :
                                $var_subtotal = $subtotal;
                            else:
                                $var_subtotal = null;
                            endif;
                            
                            $html .= '<tr>
                                <td colspan="6" ><h3>'.$dproductodet.'</h3>
                                </td>
                                <td align="right"><h3>'.$var_subtotal.'</h3>
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
                                        
                                        if ($verprecios  == 'S') :
                                            $var_costoensa = $costoensa;
                                        else:
                                            $var_costoensa = null;
                                        endif;
                                        if ($verprecios  == 'S') :
                                            $var_costo = $costo;
                                        else:
                                            $var_costo = null;
                                        endif;

                                        $html .= '<tr>
                                        <td width="10%" align="center">
                                        '.$codigo.'
                                        </td>
                                        <td width="25%">
                                        '.$densayo.'
                                        </td>
                                        <td width="5%" align="center">
                                        '.$acre.'
                                        </td>
                                        <td width="35%">
                                        '.$norma.'
                                        </td>
                                        <td width="5%" align="center">
                                        '.$cantidad.'
                                        </td>
                                        <td width="10%" align="right">
                                        '.$var_costoensa.'
                                        </td>
                                        <td width="10%" align="right">
                                        '.$var_costo.'
                                        </td>
                                        </tr>';
                                    }
                                }
                                $html .= '';
                        }
                    }
                    //<table width="698px" align="center" cellspacing="1" cellpadding="0" style="border: 1px solid black;">';
                    $html .= '</table>                    
                    <table width="698px" align="center">';
                    
                if ($ctipocambio  == 'S') :
                    $html .= '<tr>
                            <td width="470px" >AC: Método Acreditado<br>NO AC: Método No Acreditado</td>
                            <td width="130px" > Muestreo</td>
                            <td width="80px" align="right">'.$imuestreo.'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> SUBTOTAL</td>
                            <td align="right">'.$isubtotal.'</td>
                        </tr>';
                    if($pdescuento > 0){
                    $html .= '<tr>
                                <td></td>
                                <td> DESCUENTOS '.$pdescuento.'% </td>
                                <td align="right">('.$ddescuento.')</td>
                            </tr>
                            <tr>                
                                <td></td>
                                <td> </td>
                                <td align="right">'.$condescuento.'</td>
                            </tr>';
                    }
                    $html .= '<tr>                
                            <td></td>
                            <td> IGV 18%</td>
                            <td align="right">'.$digv.'</td>
                        </tr>
                        <tr>                
                            <td></td>
                            <td> TOTAL</td>
                            <td align="right">'.$itotal.'</td>
                        </tr>
                        <tr>
                            <td style="height:10px;">
                            </td>
                        </tr>';
                else:
                    $html .= '<tr>
                        <td width="530px" >AC: Método Acreditado<br>NO AC: Método No Acreditado</td>
                        <td width="70px"> TOTAL $</td>
                        <td width="80px" align="right">'.$itotal.'</td>
                    </tr>
                    <tr>
                        <td style="height:10px;">
                        </td>
                    </tr>';
                endif;                    

                    $html .= '</table>';

        $html .= '<table width="700px" align="center">
            <tr>
                <td><b>III</b></td>
                <td><b>FORMA DE PAGO:</b></td>
                <td align="left">'.$cforma_pago.'</td>
                <td>'.$banco.'</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>CCI: 00219400156160801692</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>'.$detraccion.'</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td><b>IV</b></td>
                <td colspan="2"><b>TIEMPO DE ENTREGA DEL INFORME:</b></td>
                <td style="text-align: justify;">'.$entrega.'</td>
            </tr>
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td VALIGN=top><b>V</b></td>
                <td colspan="4" style="text-align: justify;"><b>CANTIDAD DE MUESTRA MINIMA:</b>  En caso el cliente incumpla estas condiciones la muestra se considerará muestra no idónea y sólo con su autorización será ensayada y reportará como Informe No Oficial.</td>
            </tr>            
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
            <tr>
                <td VALIGN=top><b>VI</b></td>
                <td colspan="4" style="text-align: justify;"><b>PERMANENCIA DE LA CONTRA MUESTRA EN EL LABORATORIO:</b>  En caso de que el servicio considere contramuestras, éstas se conservarán en el laboratorio por el período acordado con el cliente, 
                luego de lo cual serán eliminadas de acuerdo a nuestros procedimientos  internos. En caso el cliente requiera la devolución de la contramuestra, esta deberá ser solicitada antes de la finalización del Tiempo de Custodia ('.$diaspermanecia.')</td>
            </tr>            
            <tr>
                <td colspan="4" style="height:10px;">
                </td>
            </tr>
        </table>';
        
        $html .= '<table width="700px" align="center">
            <tr>
                <td VALIGN=top ><b>VII</b></td>
                <td ><b>VIGENCIA DE COTIZACION:</b></td>
                <td align="left">'.$diascoti.'</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
            <tr>
                <td VALIGN=top><b>VIII</b></td>
                <td colspan="2"><b>ACEPTACION DE LA COTIZACION:</b></td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">En caso de Aceptar la Cotización, favor de enviarla firmada o declaranado su aceptación mediante un correo electronico. Cualquier cambio en la cotización enviada deberá solicitarse antes de iniciado el servicio.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">Al dar su visto bueno, el cliente acepta esta cotización con carácter de contrato.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">Toda la información derivada de las actividades del laboratorio obtenidas a través del servicio brindado se conservará de modo confidencial, excepto por la información que el cliente pone a disposición del público, o cuando lo acuerdan el laboratorio y el cliente.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">Cuando a FS Certificaciones se le solicite por ley o disposiciones contractuales divulgar información confidencial, notificará al cliente salvo que esté prohibido por ley.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">La información acerca del cliente, obtenida de fuentes diferentes del cliente se tratará como información confidencial.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">La emisión de los Informes de Ensayo se realizará en formato digital (PDF), los cuales serán enviados por correo electrónico al cliente. El envío de los informes físicos tiene un costo adicional que será informado al cliente.</td>
            </tr>
            <tr>
                <td VALIGN=top>-</td>
                <td colspan="2" style="text-align: justify;">Copias adicionales de los informes y las traducciones de los mismos tendrán un costo adicional.</td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px;"></td>
            </tr>
            <tr>
                <td VALIGN=top width="10px"><b>IX</b></td>
                <td width="180px"><b>OBSERVACIONES:</b></td>
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
                <td align="center" style="border-top: 1px solid black;">CLIENTE</td>
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

        $html .= '</main></body></html>';
		$filename = 'Cotizacion-'.$namefile;
        $this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');
        
	}

    public function setduplicarprodxcoti() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
		$nordenproducto 		= $this->input->post('idcotiproducto');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto
        );
        $retorna = $this->mcotizacion->setduplicarprodxcoti($parametros);
        echo json_encode($retorna);		
	}

    public function precioxcoti() { // Registrar informe PT
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
		$smostrarprecios 	= $this->input->post('smostrarprecios');
        
        $retorna = $this->mcotizacion->precioxcoti($cinternocotizacion,$nversioncotizacion,$smostrarprecios);
        echo json_encode($retorna);		
	}

    public function deleteprodxcoti() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
		$nordenproducto 		= $this->input->post('idcotiproducto');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto
        );
        $retorna = $this->mcotizacion->deleteprodxcoti($parametros);
        echo json_encode($retorna);		
	}

    public function getbuscarensayos() { // Buscar Cotizacion
		$varnull = '';

		$descripcion   = $this->input->post('descripcion');
		$sacnoac       = $this->input->post('sacnoac');
		$tipoensayo       = $this->input->post('tipoensayo');
        
        $parametros = array(
			'@descripcion'		=> ($this->input->post('descripcion') == '') ? '%' : '%'.$descripcion.'%',
			'@sacnoac'          => ($this->input->post('sacnoac') == '') ? '%' : $sacnoac,
			'@tipoensayo'       => $tipoensayo,
        );
        $retorna = $this->mcotizacion->getbuscarensayos($parametros);
        echo json_encode($retorna);		
    }

    public function setregensayoxprod() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('hdnmIdcoti');
		$nversioncotizacion 	= $this->input->post('hdnmNvers');
		$nordenproducto 		= $this->input->post('hdnmIdprod');
		$censayo 		        = $this->input->post('mhdnmcensayo');
		$claboratorio 		    = $this->input->post('mtxtmCLab');
		$nvias 		            = $this->input->post('mtxtmvias');
		$icostoclienteparcial 	= $this->input->post('mtxtmCosto');
		$accion 		        = $this->input->post('hdnmAccion');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto,
            '@censayo'   	        =>  $censayo,
            '@claboratorio'   	    =>  $claboratorio,
            '@nvias'   	            =>  $nvias,
            '@icostoclienteparcial' =>  $icostoclienteparcial,
            '@accion'   	        =>  $accion
        );
        $retorna = $this->mcotizacion->setregensayoxprod($parametros);
        echo json_encode($retorna);		
	}

    public function seteditensayoxprod() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('ehdnmIdcoti');
		$nversioncotizacion 	= $this->input->post('ehdnmNvers');
		$nordenproducto 		= $this->input->post('ehdnmIdprod');
		$censayo 		        = $this->input->post('ehdnmcensayo');
		$claboratorio 		    = $this->input->post('etxtmCLab');
		$nvias 		            = $this->input->post('etxtmvias');
		$icostoclienteparcial 	= $this->input->post('etxtmCosto');
		$accion 		        = $this->input->post('ehdnmAccion');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto,
            '@censayo'   	        =>  $censayo,
            '@claboratorio'   	    =>  $claboratorio,
            '@nvias'   	            =>  $nvias,
            '@icostoclienteparcial' =>  $icostoclienteparcial,
            '@accion'   	        =>  $accion
        );
        $retorna = $this->mcotizacion->setregensayoxprod($parametros);
        echo json_encode($retorna);		
	}

    public function deleteensayoxprod() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
		$nordenproducto 		= $this->input->post('idcotiproducto');
		$censayo 		        = $this->input->post('censayo');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion,
            '@nordenproducto'   	=>  $nordenproducto,
            '@censayo'   	        =>  $censayo
        );
        $retorna = $this->mcotizacion->deleteensayoxprod($parametros);
        echo json_encode($retorna);		
	}

    public function cerrarcotizacion() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion
        );
        $retorna = $this->mcotizacion->cerrarcotizacion($parametros);
        echo json_encode($retorna);		
	}

    public function abrircotizacion() { // Registrar informe PT
		$varnull = '';
		
		$cinternocotizacion 	= $this->input->post('idcotizacion');
		$nversioncotizacion 	= $this->input->post('nversion');
        
        $parametros = array(
            '@cinternocotizacion'   =>  $cinternocotizacion,
            '@nversioncotizacion'   =>  $nversioncotizacion
        );
        $retorna = $this->mcotizacion->abrircotizacion($parametros);
        echo json_encode($retorna);		
	}
    
    public function getmcbobustipoensayo() {	// Visualizar Servicios en CBO
        $resultado = $this->mcotizacion->getmcbobustipoensayo();
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
		$activo      = $this->input->post('swVigencia');
        
        $parametros = array(
			'@CCIA'         => '2',
			'@CCLIENTE'     => ($this->input->post('cboclieserv') == '') ? '0' : $ccliente,
			'@FINI'         => ($this->input->post('chkFreg') == NULL) ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
			'@FFIN'         => ($this->input->post('chkFreg') == NULL) ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@DESCR'		=> ($this->input->post('txtdescri') == '') ? '%' : '%'.$descr.'%',
			'@ESTADO'		=> ($this->input->post('cboestado') == '%') ? '%' : $estado,
			'@TIENEOT'		=> ($this->input->post('cbotieneot') == '%') ? '%' : $tieneot,
			'@ACTIVO'       => ($this->input->post('swVigencia') == NULL) ? 'I' : 'A',
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