<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconsresulgral extends CI_Model {
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
    public function getcbocalifiusuario() { // Listar Ensayos	
        $sql = "select A.CCRITERIORESULTADO, A.CDETALLECRITERIORESULTADO, A.DDETALLECRITERIORESULTADO 
                from MDETALLECRITERIORESULTADO A join MUSUARIO B on A.CCRITERIORESULTADO = B.CCRITERIORESULTADO where B.CUSUARIO = 'CL000001' and B.SREGISTRO = 'A';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->CDETALLECRITERIORESULTADO.'">'.$row->DDETALLECRITERIORESULTADO.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getconsresulgral($parametros)
    {
        $procedure = "call usp_at_ctrlprov_consresulgral(?,?,?,?,?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		   
    }
    public function getleyendachecklist($cchecklist) { // Listar Ensayos	
        $sql = "select dordenlista+' - '+drequisito as 'REQUISITO' 
                from MREQUISITOCHECKLIST where cchecklist = '".$cchecklist."' and SREQUISITO = 'P' and  LENGTH(DORDENLISTA) = 2 and DORDENLISTA <> '00';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<br>';
            
            foreach ($query->result() as $row)
            {
                $listas .= $row->REQUISITO.'<br>';  
            }
               return $listas;
        }{
            return false;
        }		
    }

}
?>