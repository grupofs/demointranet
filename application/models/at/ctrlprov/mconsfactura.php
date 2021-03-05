<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconsfactura extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }

   /** CONS. FACTURACIONES **/
    public function getbuscarfactura($parametros) { // Busqueda	
        $procedure = "call usp_at_ctrlprov_getbuscarfactura(?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }	
}
?>