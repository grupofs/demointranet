<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconssegiaacc extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    
    public function getcboprovxclie($parametros) { // Visualizar Proveedor por cliente en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboprovxclie(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDPROV.'">'.$row->DESCRIPPROV.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcboareaclie($ccliente) { // Listar Ensayos	
        $sql = "select careacliente, dareacliente from mareacliente where ccliente  = '".$ccliente."' and ccompania = '1';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->careacliente.'">'.$row->dareacliente.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getconsseguiaacc($parametros)
    {
        $procedure = "call usp_at_ctrlprov_consseguiaacc(?,?,?,?,?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		   
    }

}
?>