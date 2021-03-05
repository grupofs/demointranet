<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontratos extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }

   /** CONTRATOS **/
    public function getbuscarcontratos($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_adm_rrhh_getbuscarcontratos(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }	
}
?>