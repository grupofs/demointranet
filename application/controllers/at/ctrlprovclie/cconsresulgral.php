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
    
}
?>