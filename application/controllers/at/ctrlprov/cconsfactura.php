<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cconsfactura extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('at/ctrlprov/mconsfactura');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONS. FACTURACIONES **/
    public function getbuscarfactura() {	// Busqueda	
		$varnull    =   '';
		$celestado  = 	'';

        $ccliente       = $this->input->post('ccliente');
        $cproveedor     = $this->input->post('cproveedor');
        $anio           = $this->input->post('anio');
        $mes            = $this->input->post('mes');
        $cestado        = $this->input->post('estado');
        $monto          = $this->input->post('monto');
	
        if(isset($cestado)){
            foreach($cestado as $dest){
                $celestado = $dest.','.$celestado;
            }
            $countest =strlen($celestado) ;
            $celestado = substr($celestado,0,$countest-1);
        }
        
        $parametros = array(
			'@ccliente'		=> $ccliente,
			'@cproveedor'	=> ($this->input->post('cproveedor') == $varnull) ? '%' : $cproveedor,
			'@anio'		    => $anio,
			'@mes'		    => ($this->input->post('mes') == $varnull) ? 0 : $mes,
			'@estado'		=> ($celestado == $varnull) ? '029,031,032,515' :$celestado,
			'@monto'		=> ($this->input->post('monto') == $varnull) ? -1000 : $monto,
        );
        
        $resultado = $this->mconsfactura->getbuscarfactura($parametros);
        echo json_encode($resultado);
    } 
}
?>