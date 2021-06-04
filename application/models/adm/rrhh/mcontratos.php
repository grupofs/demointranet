<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontratos extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }

   /** CONTRATOS **/
    public function getbuscarcontratos($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_adm_rrhh_getbuscarcontratos(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }	
	public function setregempleado($parametros) { // Registrar Vacaciones		
        $this->db->trans_begin();
    
        $procedure = "call usp_adm_rrhh_setregempleado(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros); 
           
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            if ($query->num_rows() > 0) {
                return $query->result();
            }{
                return False;
            }	
        }   
    }
    public function getcbopensionentidad($idpension) { // Visualizar 	
        
        $sql = "select idpensionentidad, despensionentidad from adm_pensionentidad where idpension = ".$idpension." order by despensionentidad;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->idpensionentidad.'">'.$row->despensionentidad.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
	public function setentidadpension($parametros) { // Registrar Vacaciones		
        $this->db->trans_begin();
    
        $procedure = "call usp_adm_rrhh_setentidadpension(?,?,?,?)";
        $query = $this->db-> query($procedure,$parametros); 
           
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            if ($query->num_rows() > 0) {
                return $query->result();
            }{
                return False;
            }	
        }   
    }
    public function getcbobanco() { // Visualizar 	
        
        $sql = "select idbanco,nombanco from adm_banco order by nombanco;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->idbanco.'">'.$row->nombanco.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
	public function setbanco($parametros) { // Registrar Vacaciones		
        $this->db->trans_begin();
    
        $procedure = "call usp_adm_rrhh_setbanco(?,?,?)";
        $query = $this->db-> query($procedure,$parametros); 
           
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            if ($query->num_rows() > 0) {
                return $query->result();
            }{
                return False;
            }	
        }   
    }
    public function getcboprofesion() { // Visualizar 	
        
        $sql = "select idprofesion,desprofesion from adm_profesion order by desprofesion;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->idprofesion.'">'.$row->desprofesion.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
	public function setprofesion($parametros) { // Registrar Vacaciones		
        $this->db->trans_begin();
    
        $procedure = "call usp_adm_rrhh_setprofesion(?,?,?)";
        $query = $this->db-> query($procedure,$parametros); 
           
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            if ($query->num_rows() > 0) {
                return $query->result();
            }{
                return False;
            }	
        }   
    }
    public function getcboarea($ccia) { // Visualizar 	
        
        $sql = "select carea, darea from adm_area where ccompania = '".$ccia."' order by darea;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->carea.'">'.$row->darea.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbosubarea($ccia,$carea) { // Visualizar 	
        
        $sql = "select csubarea, dsubarea from adm_subarea where ccompania = '".$ccia."' and carea = '".$carea."' order by dsubarea;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->csubarea.'">'.$row->dsubarea.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbocargo() { // Visualizar 	
        
        $sql = "select idcargo, nomcargo from adm_cargo order by nomcargo;";
		$query  = $this->db->query($sql);

        $listas = '<option value="0" selected="selected">::Elegir</option>';
        
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->idcargo.'">'.$row->nomcargo.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
	public function setcargo($parametros) { // Registrar Vacaciones		
        $this->db->trans_begin();
    
        $procedure = "call usp_adm_rrhh_setcargo(?,?,?)";
        $query = $this->db-> query($procedure,$parametros); 
           
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            if ($query->num_rows() > 0) {
                return $query->result();
            }{
                return False;
            }	
        }   
    }
}
?>