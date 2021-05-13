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
        
        $parametros = array(
			'@CCLIENTE'		=>  $ccliente,
			'@ANIO'		    =>  $anio,
			'@MES'		    =>  ($this->input->post('mes') == $varnull) ? 0 : $mes,
        );
        
        $resultado = $this->mconscertifprov->getconscertifprov($parametros);
        echo json_encode($resultado);
    } 
    public function getcertidet() {	// Visualizar 	
		$varnull    =   '';

        $CCLIENTE       = $this->input->post('CCLIENTE');
        $ANIO           = $this->input->post('ANIO');
        $MES            = $this->input->post('MES');
		$CERTI          = $this->input->post('CERTI');
		$ESTADO         = $this->input->post('ESTADO');
        
        $parametros = array(
			'@CCLIENTE'		=>  $CCLIENTE,
			'@ANIO'		    =>  $ANIO,
			'@MES'		    =>  $MES,
			'@CERTI'		=>  ($this->input->post('CERTI') == $varnull) ? NULL : $CERTI,//$CERTI,
			'@ESTADO'	    =>  $ESTADO,
        );
		$resultado 	= $this->mconscertifprov->getcertidet($parametros);
		echo json_encode($resultado);
	}
}
?>