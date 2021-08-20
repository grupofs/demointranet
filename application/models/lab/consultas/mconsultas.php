<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconsultas extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
    public function getbuscar($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getbuscar(?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getinfxmuestras_caratula($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getinfxmuestras_caratula(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getinfxmuestras_resmicro($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getinfxmuestras_resmicro(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getinfxmuestras_resfq($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getinfxmuestras_resfq(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getinfxmuestras_nota01($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getinfxmuestras_nota01(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getmetodosensayos($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getmetodosensayos(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getinfxmuestras_firmas($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consinf_getinfxmuestras_firmas(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
	}	
    
    public function infinacal($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_consulta_infinacal(?,?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
}
?>