<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mregctrolprov extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** CONTROL DE PROVEEDORES **/ 
    public function getcboclieserv() { // Visualizar Clientes del servicio en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboclieserv()";
		$query = $this->db-> query($procedure);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDCLIE.'">'.$row->DESCRIPCLIE.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
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
    public function getcbomaqxprov($parametros) { // Visualizar Maquilador por proveedor en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcbomaqxprov(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDMAQ.'">'.$row->DESCRIPMAQ.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }	
    public function getcboinspector($parametros) { // Visualizar Clientes del servicio en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboinspector(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDINSP.'">'.$row->DESCRIPINSP.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }	
    public function getcboestado() {	// Visualizar Estado en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboestado()";
		$query = $this->db-> query($procedure);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDESTADO.'">'.$row->DESCRIPESTADO.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbocalif() { // // Visualizar Calificacion en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcbocalif()";
		$query = $this->db-> query($procedure);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDCALIF.'">'.$row->DESCRIPCALIF.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getbuscarctrlprov($parametros) { // Recupera Listado de Propuestas        
		$procedure = "call usp_at_ctrlprov_getbuscarctrlprov(?,?,?,?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
    public function getrecuperainsp($parametros) { // Recupera Listado de Propuestas        
		$procedure = "call usp_at_ctrlprov_getrecuperainsp(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }
    public function getcboregestable($parametros) { // Visualizar Proveedor por cliente en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboregestable(?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->CESTABLECIMIENTO.'">'.$row->DESTABLECIMIENTO.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getdirestable($cestable) { // Listar Ensayos	
        $sql = "select ((select x.DDEPARTAMENTO+' - '+x.DPROVINCIA+' - '+x.DDISTRITO from TUBIGEO x where x.cubigeo = z.cubigeo) +' - '+ z.DDIRECCION) as 'DIRESTABLE' from MESTABLECIMIENTOCLIENTE z where z.CESTABLECIMIENTO = '".$cestable."';";
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
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
    public function getcbolineaproc($ccliente) { // Listar Ensayos	
        $sql = "select clineaprocesocliente, dlineaclientee + (if speligro = 'S' then '  --> ( PELIGRO ) ' else '' end if) as 'dlineacliente'
                from mlineaprocesocliente  
                where cestablecimiento = '".$ccliente."' and  sregistro = 'A';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->clineaprocesocliente.'">'.$row->dlineacliente.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function setregctrlprov($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_at_ctrlprov_setpcauditoriainspeccion(?,?,?,?,?,?,?,?,?,?);";
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
    
    public function getcbosistemaip() { // Visualizar Sistema en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcbosistemaip()";
		$query = $this->db-> query($procedure);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDNORMA.'">'.$row->DESCSISTEMA.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcborubroip($parametros) { // Visualizar Rubro en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcborubroip(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDSUBNORMA.'">'.$row->DESCSUBNORMA.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbochecklist($parametros) { // Visualizar Checklist en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcbochecklist(?,?,?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDCHECKLIST.'">'.$row->DESCCHECKLIST.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcboformula($parametros) { // Visualizar Formula en CBO	
        
        $procedure = "call usp_at_ctrlprov_getcboformula(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDFORMULA.'">'.$row->DESCFORMULA.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbocriterio($parametros) { // Visualizar Criterio en CBO	
        
        $procedure = "call usp_at_audi_getcbocriterio(?)";
		$query = $this->db-> query($procedure,$parametros);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->IDCRITERIO.'">'.$row->DESCCRITERIO.'</option>';  
            }
               return $listas;
        }{
            return false;
        }	
    }
    public function getcbomodinforme() { // Listar Ensayos	
        $sql = "select cmodeloinforme,dmodelo from mmodeloinforme where ccompania = '1' and carea = '01' and cservicio = '02';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->cmodeloinforme.'">'.$row->dmodelo.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getcboinspvalconf() { // Listar Ensayos	
        $sql = "select cvalor,dvalor from mvalor where sregistro = 'A' and stipovalor = 'N';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->cvalor.'">'.$row->dvalor.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getcboinspformula($cchecklist) { // Listar Ensayos	
        $sql = "select b.cformulaevaluacion,b.dformula 
                from mrchecklistformula a right outer join mformulaevaluacion b on b.cformulaevaluacion = a.cformulaevaluacion  
                where a.cchecklist = '".$cchecklist."';";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->cformulaevaluacion.'">'.$row->dformula.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }
    public function getcboinspcritresul() { // Listar Ensayos	
        $sql = "select ccriterioresultado, dcriterioresultado from mcriterioresultado ;";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->ccriterioresultado.'">'.$row->dcriterioresultado.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }

    public function setreginspeccion($parametros) {  // Registrar evaluacion PT
        $this->db->trans_begin();

        $procedure = "call usp_at_ctrlprov_setpdauditoriainspeccion(?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
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
    public function getcbocierreTipo() { // Listar Ensayos	
        $sql = "select ctipo, dregistro, nvalor from ttabla 
                where ctabla = '09' and ncorrelativo <> 0 and IsNull(nvalor,9) <> 9 and spermitemodificar = 'N' order by dregistro ASC ;";
        $query  = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {

            $listas = '<option value="" selected="selected">::Elegir</option>';
            
            foreach ($query->result() as $row)
            {
                $listas .= '<option value="'.$row->ctipo.'">'.$row->dregistro.'</option>';  
            }
               return $listas;
        }{
            return false;
        }		
    }

}
?>