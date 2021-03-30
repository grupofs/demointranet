<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconsregporvencer extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }

   /** REGISTROS POR VENCER **/
    public function getbuscarregporvencer($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_ar_tramite_getbuscarregporvencer(?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }	
}
?>