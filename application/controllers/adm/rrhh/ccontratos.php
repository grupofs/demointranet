<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccontratos extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('adm/rrhh/mcontratos');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONTRATOS **/
    public function getbuscarcontratos() {	// Busqueda de Contratos 	
		$varnull = '';

        $descripcion   = $this->input->post('descripcion');
        
        $parametros = array(
			'@descripcion'		=> ($this->input->post('descripcion') == '') ? '%' : '%'.$descripcion.'%',
        );
        
        $resultado = $this->mcontratos->getbuscarcontratos($parametros);
        echo json_encode($resultado);
    } 
}
?>