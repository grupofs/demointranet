<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** COTIZACION **/ 
class Mrecepcion extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** LISTADO **/ 

    public function getbuscarrecepcion($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getbuscarrecepcion(?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
   /** REGISTRO **/ 

    public function getrecepcionmuestra($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getrecepcionmuestra(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }

    public function setrecepcionmuestra($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setrecepcionmuestra(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setordentrabajo($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setordentrabajo(?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setordentrabajoresult($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_lab_coti_setordentrabajoresult(?,?,?,?,?);";
        $query = $this->db->query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return $query->result(); 
        }   
    } 

    public function setupdateFechaOT($mhdncinternoordenservicio,$fordentrabajo,$nordentrabajo) { // Recuperar Password
		
        $data = array(
            "FORDENTRABAJO" => $fordentrabajo,
            "NORDENTRABAJO" => $nordentrabajo,
        );

        $this->db->where("cinternoordenservicio", $mhdncinternoordenservicio);
		if($this->db->update("pordenserviciotrabajo", $data)){
			return TRUE;
		}
	}
}
?>