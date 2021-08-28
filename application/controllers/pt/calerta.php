<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calerta extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('pt/malerta');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** INFORME **/	
    public function getlistalertainf() {	// Recupera Listado de Reg. informes        
        $varnull 			= 	'';
            
        $parametros = array(
            '@idempleado' => $this->input->post('idempleado')
        );		
        $resultado = $this->malerta->getlistalertainf($parametros);
        echo json_encode($resultado);
    }
    public function getlistalertaest() {	// Recupera Listado de Reg. informes        
        $varnull 			= 	'';
            
        $parametros = array(
            '@idempleado' => $this->input->post('idempleado')
        );		
        $resultado = $this->malerta->getlistalertaest($parametros);
        echo json_encode($resultado);
    }
    public function getlistalertareg() {	// Recupera Listado de Reg. informes        
        $varnull 			= 	'';
            
        $parametros = array(
            '@idempleado' => $this->input->post('idempleado')
        );		
        $resultado = $this->malerta->getlistalertareg($parametros);
        echo json_encode($resultado);
    }
}  