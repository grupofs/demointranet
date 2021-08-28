<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Malerta extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
    public function getlistalertainf($parametros) {         
		$procedure = "call usp_pt_gest_getlistalertainf(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
    public function getlistalertaest($parametros) {         
		$procedure = "call usp_pt_gest_getlistalertaest(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
    public function getlistalertareg($parametros) {         
		$procedure = "call usp_pt_gest_getlistalertareg(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
}