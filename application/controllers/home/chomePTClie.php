<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChomePTClie extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('home/mhomePTClie');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
    public function getserviciosclie() {	// Visualizar Servicios a evaluar en CBO	
		
        $ccliente = $this->input->post("ccliente");
		$resultado = $this->mhomePTClie->getserviciosclie($ccliente);
		echo json_encode($resultado);
	}
}
?>