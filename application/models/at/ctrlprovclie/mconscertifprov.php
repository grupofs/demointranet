<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconscertifprov extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    
    public function getconscertifprov($parametros)
    {
        $procedure = "call usp_at_ctrlprov_conscertifprov(?,?,?)";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		   
    }

}
?>