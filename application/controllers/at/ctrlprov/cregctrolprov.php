<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cregctrolprov extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('at/ctrlprov/mregctrolprov');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    public function getcboclieserv() {	// Visualizar Clientes del servicio en CBO	
        
		$resultado = $this->mregctrolprov->getcboclieserv();
		echo json_encode($resultado);
	}
    public function getcboprovxclie() {	// Visualizar Proveedor por cliente en CBO	
        
        $parametros = array(
            '@ccliente'   => $this->input->post('ccliente')
        );
		$resultado = $this->mregctrolprov->getcboprovxclie($parametros);
		echo json_encode($resultado);
	}
    public function getcbomaqxprov() {	// Visualizar Maquilador por proveedor en CBO	
        
        $parametros = array(
            '@cproveedor'   => $this->input->post('cproveedor')
        );
		$resultado = $this->mregctrolprov->getcbomaqxprov($parametros);
		echo json_encode($resultado);
	}
    public function getcboinspector() {	// Visualizar Inspectores en CBO	
        
        $parametros = array(
            '@sregistro'   => $this->input->post('sregistro')
        );
		$resultado = $this->mregctrolprov->getcboinspector($parametros);
		echo json_encode($resultado);
	}
    public function getcboestado() {	// Visualizar Estado en CBO	
        
		$resultado = $this->mregctrolprov->getcboestado();
		echo json_encode($resultado);
	}
    public function getcbocalif() {	// Visualizar Calificacion en CBO	
        
		$resultado = $this->mregctrolprov->getcbocalif();
		echo json_encode($resultado);
	}
    public function getbuscarctrlprov() {	// Busca Control de Proveedores	
        
		$varnull = 	'';

		$ccia 			= '1';
		$carea 			= '01';
		$cservicio 		= '02';
		$fini       	= $this->input->post('fdesde');
		$ffin       	= $this->input->post('fhasta');
		$ccliente   	= $this->input->post('ccliente');
		$dclienteprovmaq   = $this->input->post('dclienteprovmaq');
		$inspector    	= $this->input->post('inspector');
            
        $parametros = array(
			'@ccia'     	=> $ccia,
			'@carea'     	=> $carea,
			'@cservicio'    => $cservicio,
			'@fini'         => ($this->input->post('fdesde') == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2),
			'@ffin'         => ($this->input->post('fhasta') == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@ccliente'     => $ccliente,
			'@dclienteprovmaq' => ($this->input->post('dclienteprovmaq') == '') ? '%' : '%'.$dclienteprovmaq.'%', 
			'@inspector'	=> ($this->input->post('inspector') == '') ? '%' : $inspector,
		);		
		$resultado = $this->mregctrolprov->getbuscarctrlprov($parametros);
		echo json_encode($resultado);
	}
    public function getrecuperainsp() {	// Visualizar Maquilador por proveedor en CBO	
        
        $parametros = array(
            '@idinspeccion'   => $this->input->post('idinspeccion')
        );
		$resultado = $this->mregctrolprov->getrecuperainsp($parametros);
		echo json_encode($resultado);
	}
    public function getcboregestable() {	// Visualizar Maquilador por proveedor en CBO	
        
        $parametros = array(
            '@ccliente'   	=> $this->input->post('ccliente'),
            '@cproveedor'   => $this->input->post('cproveedor'),
            '@cmaquilador'  => $this->input->post('cmaquilador'),
            '@tipo'   		=> $this->input->post('tipo')
        );
		$resultado = $this->mregctrolprov->getcboregestable($parametros);
		echo json_encode($resultado);
	}
    public function getdirestable() {	// Visualizar Proveedor por cliente en CBO	
        
        $cestable   = $this->input->post('cestablecimiento');
		$resultado 	= $this->mregctrolprov->getdirestable($cestable);
		echo json_encode($resultado);
	}
    public function getcboareaclie() {	// Visualizar Proveedor por cliente en CBO	
        
        $ccliente   = $this->input->post('ccliente');
		$resultado 	= $this->mregctrolprov->getcboareaclie($ccliente);
		echo json_encode($resultado);
	}
    public function getcbolineaproc() {	// Visualizar Proveedor por cliente en CBO	
        
        $cestablecimiento   = $this->input->post('cestablecimiento');
		$resultado 	= $this->mregctrolprov->getcbolineaproc($cestablecimiento);
		echo json_encode($resultado);
	}
    public function getcbocontacprinc() {	// Visualizar Proveedor por cliente en CBO	
        
        $cproveedor   = $this->input->post('cproveedor');
		$resultado 	= $this->mregctrolprov->getcbocontacprinc($cproveedor);
		echo json_encode($resultado);
	}
    public function getcbotipoestable() {	// Visualizar Proveedor por cliente en CBO	
        
		$resultado 	= $this->mregctrolprov->getcbotipoestable();
		echo json_encode($resultado);
	}
    public function getmontotipoestable() {	// Visualizar Proveedor por cliente en CBO	
        
        $ctipoestable   = $this->input->post('ctipoestable');
		$resultado 	= $this->mregctrolprov->getmontotipoestable($ctipoestable);
		echo json_encode($resultado);
	}
    public function setregctrlprov() { // Registrar inspeccion
		$varnull = '';
		
		$cauditoriainspeccion 	= $this->input->post('mhdnregIdinsp');
		$ccliente 				= $this->input->post('cboregClie');
		$cproveedor 			= $this->input->post('cboregprovclie');
		$cmaquilador 			= $this->input->post('cboregmaquiprov');
		$cestablecimiento 		= $this->input->post('cboregestable');
		$clineaprocesocliente 	= $this->input->post('cboreglineaproc');
		$careacliente 			= $this->input->post('cboregareaclie');
		$ccontacto 				= $this->input->post('cbocontacprinc');
		$ctipoestablecimiento	= $this->input->post('cbotipoestable');
		$icostobase 			= $this->input->post('txtcostoestable');
		$dperiodo 				= $this->input->post('mtxtregPeriodo');
		$accion 				= $this->input->post('mhdnAccionctrlprov');
        
        $parametros = array(
            '@cauditoriainspeccion'   	=>  $cauditoriainspeccion,
            '@ccliente'   				=>  $ccliente,
            '@cproveedor'   			=>  $cproveedor,
            '@cmaquilador'   			=>  $cmaquilador,
            '@cestablecimiento'   		=>  $cestablecimiento,
            '@clineaprocesocliente'   	=>  $clineaprocesocliente,
            '@careacliente'  		 	=>  $careacliente,
            '@ccontacto'   				=>  $ccontacto,
            '@ctipoestablecimiento'   	=>  $ctipoestablecimiento,
            '@icostobase'   			=>  $icostobase,
            '@dperiodo'   				=>  $dperiodo,
            '@accion'   				=>  $accion,
        );
        $resultado = $this->mregctrolprov->setregctrlprov($parametros);
        echo json_encode($resultado);		
	}
    public function getcbosistemaip() {	// Visualizar Calificacion en CBO	
        
		$resultado = $this->mregctrolprov->getcbosistemaip();
		echo json_encode($resultado);
	}
    public function getcborubroip() {	// Visualizar Inspectores en CBO	
        
        $parametros = array(
            '@idnorma'   => $this->input->post('cnorma')
        );
		$resultado = $this->mregctrolprov->getcborubroip($parametros);
		echo json_encode($resultado);
	}
    public function getcbochecklist() {	// Visualizar Inspectores en CBO	
        
        $parametros = array(
            '@idnorma'   => $this->input->post('cnorma'),
            '@idsubnorma'   => $this->input->post('csubnorma'),
            '@ccliente'   => $this->input->post('ccliente')
        );
		$resultado = $this->mregctrolprov->getcbochecklist($parametros);
		echo json_encode($resultado);
	}
    public function getcbomodinforme() {	// Visualizar Calificacion en CBO	
        
		$resultado = $this->mregctrolprov->getcbomodinforme();
		echo json_encode($resultado);
	}
    public function getcboinspvalconf() {	// Visualizar Calificacion en CBO	
        
		$resultado = $this->mregctrolprov->getcboinspvalconf();
		echo json_encode($resultado);
	}
    public function getcboinspformula() {	// Visualizar Proveedor por cliente en CBO	
        
        $cchecklist   = $this->input->post('cchecklist');
		$resultado 	= $this->mregctrolprov->getcboinspformula($cchecklist);
		echo json_encode($resultado);
	}
    public function getcboinspcritresul() {	// Visualizar Calificacion en CBO	
        
		$resultado = $this->mregctrolprov->getcboinspcritresul();
		echo json_encode($resultado);
	}
    public function setreginspeccion() {	// Visualizar Inspectores en CBO
		$varnull = '';
		
		$cauditoriainspeccion 	= $this->input->post('mtxtidinsp');	
		$fservicio 				= $this->input->post('mfechainsp');
		$fechaservicio 			= $this->input->post('txtFInsp');	
		$cusuarioconsultor 		= $this->input->post('cboinspinspector');	
		$cnorma 				= $this->input->post('cboinspsistema');	
		$csubnorma 				= $this->input->post('cboinsprubro');	
		$cchecklist 			= $this->input->post('cboinspcchecklist');	
		$cvalornoconformidad 	= $this->input->post('cboinspvalconf');	
		$cformulaevaluacion 	= $this->input->post('cboinspformula');	
		$dcometario 			= $this->input->post('mtxtinspcoment');
		$ccriterioresultado 	= $this->input->post('cboinspcritresul');	
		$cmodeloinforme 		= $this->input->post('cboinspmodeloinfo');		
		$periodo 				= $this->input->post('cboinspperiodo');			
		$zctipoestado			= $this->input->post('mhdnzctipoestado');	
		$accion 				= $this->input->post('mhdnAccioninsp');	
        
        $parametros = array(
            '@cauditoriainspeccion' => $cauditoriainspeccion,
            '@fservicio' 			=> ($this->input->post('mfechainsp') == '') ? '1900-01-01' : substr($fservicio, 6, 4).'-'.substr($fservicio,3 , 2).'-'.substr($fservicio, 0, 2),
            '@fechaservicio'   		=> ($this->input->post('txtFInsp') == 'Sin Fecha') ? '1900-01-01' : substr($fechaservicio, 6, 4).'-'.substr($fechaservicio,3 , 2).'-'.substr($fechaservicio, 0, 2),
            '@cusuarioconsultor'   	=> ($this->input->post('cboinspinspector') == $varnull) ? null : $cusuarioconsultor,
            '@cnorma'   			=> ($this->input->post('cboinspsistema') == $varnull) ? null : $cnorma,
            '@csubnorma'   			=> ($this->input->post('cboinsprubro') == $varnull) ? null : $csubnorma,
            '@cchecklist'   		=> ($this->input->post('cboinspcchecklist') == $varnull) ? null : $cchecklist,
            '@cvalornoconformidad'  => ($this->input->post('cboinspvalconf') == $varnull) ? null : $cvalornoconformidad,
            '@cformulaevaluacion'   => ($this->input->post('cboinspformula') == $varnull) ? null : $cformulaevaluacion,
            '@dcometario'   		=> $dcometario,
            '@ccriterioresultado'   => ($this->input->post('cboinspcritresul') == $varnull) ? null : $ccriterioresultado,
            '@cmodeloinforme'   	=> ($this->input->post('cboinspmodeloinfo') == $varnull) ? null : $cmodeloinforme,
            '@periodo'   			=> $periodo,
            '@zctipoestado'   		=> $zctipoestado,
            '@accion'   			=> $accion 
        );
		$resultado = $this->mregctrolprov->setreginspeccion($parametros);
		echo json_encode($resultado);
	}
    public function getcbocierreTipo() {	// Visualizar Proveedor por cliente en CBO	
        
        $resultado 	= $this->mregctrolprov->getcbocierreTipo();
		echo json_encode($resultado);
	}
    public function setcierreespecial() {	// Visualizar Inspectores en CBO
		$varnull = '';
		
		$cauditoriainspeccion 	= $this->input->post('txtcierreidinsp');	
		$fservicio 				= $this->input->post('mhdncierrefservicio');
		$fechacierre 			= $this->input->post('txtcierrefservicio');	
		$zctipoestadoservicio	= $this->input->post('cbocierreTipo');
		$valorestado			= $this->input->post('mhdnfprog');
		$fechaprogramada		= $this->input->post('txtcierreFProg');		
		$itrunco 				= $this->input->post('txtcierremonto');	
		$ngastogeneral 			= $this->input->post('txtcierreviatico');	
		$dcomentario 			= $this->input->post('mtxtcierrecomentario');
		$cusuario 				= $this->input->post('hdncusuario');	
		$accion 				= $this->input->post('mhdnAccioncierre');	
        
        $parametros = array(
            '@cauditoriainspeccion' => $cauditoriainspeccion,
            '@fservicio' 			=> ($this->input->post('mhdncierrefservicio') == '') ? '1900-01-01' : substr($fservicio, 6, 4).'-'.substr($fservicio,3 , 2).'-'.substr($fservicio, 0, 2),
            '@fechacierre'   		=> ($this->input->post('txtcierrefservicio') == '') ? '1900-01-01' : substr($fechacierre, 6, 4).'-'.substr($fechacierre,3 , 2).'-'.substr($fechacierre, 0, 2),
			'@zctipoestadoservicio' => $zctipoestadoservicio,
			'@valorestado' 			=> $valorestado,
            '@fechaprogramada'   	=> ($this->input->post('txtcierreFProg') == '') ? '1900-01-01' : substr($fechaprogramada, 6, 4).'-'.substr($fechaprogramada,3 , 2).'-'.substr($fechaprogramada, 0, 2),
            '@itrunco'   			=> $itrunco,
            '@ngastogeneral'   		=> $ngastogeneral,
            '@dcomentario'  		=> $dcomentario,
            '@cusuario'  			=> $cusuario,
            '@accion'   			=> $accion 
        );
		$resultado = $this->mregctrolprov->setcierreespecial($parametros);
		echo json_encode($resultado);
	}
    public function setreaperturar() {	// Visualizar Inspectores en CBO
		$varnull = '';
		
		$cauditoriainspeccion 	= $this->input->post('cauditoriainspeccion');	
		$fservicio 				= $this->input->post('fservicio');	
		$cusuario 				= $this->input->post('cusuario');
        
        $parametros = array(
            '@cauditoriainspeccion' => $cauditoriainspeccion,
            '@fservicio' 			=> ($this->input->post('fservicio') == '') ? '1900-01-01' : substr($fservicio, 6, 4).'-'.substr($fservicio,3 , 2).'-'.substr($fservicio, 0, 2),
            '@cusuario' 			=> $cusuario,
        );
		$resultado = $this->mregctrolprov->setreaperturar($parametros);
		echo json_encode($resultado);
	}
    public function getcbocertificadora() {	// Visualizar Proveedor por cliente en CBO	
        
        $resultado 	= $this->mregctrolprov->getcbocertificadora();
		echo json_encode($resultado);
	}
	
    
}
?>