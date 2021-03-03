<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msistemas extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** SISTEMAS **/
    public function getlistarmodulos() { // Visualizar listado de modulos
        $procedure = "call usp_segu_sistema_getlistamodulos();";
		$query = $this->db-> query($procedure);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }          
    public function setmodulo($parametros) { // Guardar modulo
        $this->db->trans_begin();

        $procedure = "call usp_segu_sistema_guardarmodulo(?,?,?,?,?,?,?,?);";
        $this->db-> query($procedure,$parametros);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
            return 'Guardo Correctamente';
        }   
    }    
          
    public function getmodulo($parametros) { // Muestra los modulos del sistema
        $procedure = "call usp_segu_sistema_getmodulo(?);";
        $query = $this->db-> query($procedure,$parametros);

        if ($query->num_rows() > 0) { 
            return $query->result();
        }{
            return False;
        }		
    }
    public function getlistaropciones() { // Visualizar listado de opciones
        $procedure = "call usp_segu_sistema_getlistaopciones();";
		$query = $this->db-> query($procedure);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function setopcion($parametros) { // Registra el opcion del menu
		$this->db->trans_begin();

		$procedure = "call usp_segu_sistema_guardaropcion(?,?,?,?,?,?);";
		$this->db-> query($procedure,$parametros);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			return 'Guardo Correctamente';
		}   
	}   
    public function getmoduloxcia($parametros) { // Recuperar opciones por compañia
        $procedure = "call usp_segu_sistema_getmoduloxcia(?);";
        $query = $this->db-> query($procedure,$parametros);
            
        if ($query->num_rows() > 0) {
            $listas = '<option value="">::Elejir</option>';            
            foreach ($query->result() as $row) {
                $listas .= '<option value="'.$row->id_modulo.'">'.$row->desc_modulo.'</option>';  
            }
            return $listas;
        }{
            return false;
        }	
    }
    public function getlistarroles() { // Visualizar listado de roles
        $procedure = "call usp_segu_sistema_getlistaroles();";
		$query = $this->db-> query($procedure);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function setrol($parametros) { // Registra el opcion del menu
		$this->db->trans_begin();

		$procedure = "call usp_segu_sistema_guardarrol(?,?,?,?,?,?);";
		$this->db-> query($procedure,$parametros);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			return 'Guardo Correctamente';
		}   
	}  
    public function getrolxcia($parametros) { // Recuperar opciones por compañia
        $procedure = "call usp_segu_sistema_getrolxcia(?);";
        $query = $this->db-> query($procedure,$parametros);
            
        if ($query->num_rows() > 0) {
            $listas = '<option value="">::Elejir</option>';            
            foreach ($query->result() as $row) {
                $listas .= '<option value="'.$row->id_rol.'">'.$row->desc_rol.'</option>';  
            }
            return $listas;
        }{
            return false;
        }	
    }

    public function getlistarperm($parametros) { // Visualizar listado de permisos
        $procedure = "call usp_segu_sistema_getlistapermisos(?);";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getcborol() { // Visualizar cbo de roles
        $procedure = "call usp_segu_sistema_getlistaroles();";
		$query = $this->db-> query($procedure);
            
        if ($query->num_rows() > 0) {
            $listas = '<option value="">::Elejir</option>';            
            foreach ($query->result() as $row) {
                $listas .= '<option value="'.$row->id_rol.'">'.$row->CIA.' = '.$row->desc_rol.'</option>';  
            }
            return $listas;
        }{
            return false;
        }			
    }  
    public function getrolpermisos($parametros) { // Recuperar opciones por compañia
        $procedure = "call usp_segu_sistema_getrolpermisos(?,?,?);";
        $query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
    public function setasignarperm($parametros) { // Registra el opcion del menu
		$this->db->trans_begin();

		$procedure = "call usp_segu_sistema_setasignarperm(?,?,?,?);";
		$this->db-> query($procedure,$parametros);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			return 'Guardo Correctamente';
		}   
	}   
    public function gethomexcia($parametros) { // Recuperar opciones por compañia
        $procedure = "call usp_segu_sistema_gethomexcia(?);";
        $query = $this->db-> query($procedure,$parametros);
            
        if ($query->num_rows() > 0) {
            $listas = '<option value="">::Elejir</option>';            
            foreach ($query->result() as $row) {
                $listas .= '<option value="'.$row->id_opcion.'">'.$row->desc_opcion.'</option>';  
            }
            return $listas;
        }{
            return false;
        }
    }
}
?>