<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cconscertifprov extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('at/ctrlprovclie/mconscertifprov');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONTROL DE PROVEEDORES **/  
    public function getconscertifprov() {	// Busqueda	
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
        );
        
        $resultado = $this->mconscertifprov->getconscertifprov($parametros);
        echo json_encode($resultado);
    } 
    public function getleyendachecklist() {	// Visualizar 	
        $cchecklist = $this->input->post('cchecklist');
		$resultado 	= $this->mconsresulgral->getleyendachecklist($cchecklist);
		echo json_encode($resultado);
	}
}
?>