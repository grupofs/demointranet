<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cconsregporvencer extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('ar/tramites/mconsregporvencer');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** REGISTROS POR VENCER **/
    public function getbuscarregporvencer() {	// Busqueda de Registros por Vencer 	
		$varnull = '';

        $ccliente       = $this->input->post('ccliente');
        $descripcion    = $this->input->post('descripcion');
        $porvencer    = $this->input->post('porvencer');
        
        $parametros = array(
			'@ccliente'		=> $ccliente,
			'@descripcion'		=> ($this->input->post('descripcion') == '') ? '%' : '%'.$descripcion.'%',
			'@porvencer'		=> $porvencer,
        );
        
        $resultado = $this->mconsregporvencer->getbuscarregporvencer($parametros);
        echo json_encode($resultado);
    } 
}
?>