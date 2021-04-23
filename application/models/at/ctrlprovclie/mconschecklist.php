<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconschecklist extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    public function getconschecklist($parametros)
    {
        $procedure = "call usp_at_ctrlprov_conschecklist(?)";
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