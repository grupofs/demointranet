<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cconsresulgral extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('at/ctrlprovclie/mconsresulgral');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    public function getcboprovxclie() {	// Visualizar Proveedor por cliente en CBO	
        
        $parametros = array(
            '@ccliente'   => $this->input->post('ccliente')
        );
		$resultado = $this->mconsresulgral->getcboprovxclie($parametros);
		echo json_encode($resultado);
	}
    public function getcboareaclie() {	// Visualizar Proveedor por cliente en CBO	
        
        $ccliente   = $this->input->post('ccliente');
		$resultado 	= $this->mconsresulgral->getcboareaclie($ccliente);
		echo json_encode($resultado);
	}
    public function getcbocalifiusuario() {	// Visualizar Proveedor por cliente en CBO	
        
		$resultado 	= $this->mconsresulgral->getcbocalifiusuario();
		echo json_encode($resultado);
	}    
    public function getconsresulgral() {	// Busqueda	
		$varnull    =   '';

        $ccliente       = $this->input->post('ccliente');
        $anio           = $this->input->post('anio');
        $mes            = $this->input->post('mes');
		$fini           = $this->input->post('fini');
		$ffin           = $this->input->post('ffin');
        $cclienteprov   = $this->input->post('cclienteprov');
        $area           = $this->input->post('area');
        $dcalificacion  = $this->input->post('dcalificacion');
        
        $parametros = array(
			'@CCLIENTE'		=>  $ccliente,
			'@ANIO'		    =>  $anio,
			'@MES'		    =>  ($this->input->post('mes') == $varnull) ? 0 : $mes,
			'@FINI' 		=>  ($this->input->post('fini') == '%') ? NULL : substr($fini, 6, 4).'-'.substr($fini,3 , 2).'-'.substr($fini, 0, 2), 
			'@FFIN' 		=>  ($this->input->post('ffin') == '%') ? NULL : substr($ffin, 6, 4).'-'.substr($ffin,3 , 2).'-'.substr($ffin, 0, 2),
			'@CCLIENTEPROV'	=>  ($this->input->post('cclienteprov') == $varnull) ? '%' : $cclienteprov, 
			'@AREA'		    =>  ($this->input->post('area') == $varnull) ? '%' : $area,
			'@DCALIFICACION'=>  ($this->input->post('dcalificacion') == '::Elegir') ? '%' : $dcalificacion,
        );
        
        $resultado = $this->mconsresulgral->getconsresulgral($parametros);
        echo json_encode($resultado);
    } 
    public function getleyendachecklist() {	// Visualizar 	
        $cchecklist = $this->input->post('cchecklist');
		$resultado 	= $this->mconsresulgral->getleyendachecklist($cchecklist);
		echo json_encode($resultado);
	}
}
?>