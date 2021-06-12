<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** COTIZACION **/ 
class Mregresult extends CI_Model {
	function __construct() {
		parent:: __construct();	
		$this->load->library('session');
    }
    
   /** LISTADO **/ 

    public function getbuscaringresoresult($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getbuscaringresoresult(?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getrecuperaservicio($cinternoordenservicio) { // Listar Ensayos	
        $sql = "select c.drazonsocial, a.fanalisis, a.hanalisis, b.dcotizacion, b.fcotizacion, a.nordenservicio, a.fordenservicio,
            b.cinternocotizacion, b.nversioncotizacion, a.cinternoordenservicio
        from pordenserviciotrabajo a
            join pcotizacionlaboratorio b on b.cinternocotizacion = a.cinternocotizacion AND b.nversioncotizacion = a.nversioncotizacion
            join mcliente c ON c.ccliente = b.ccliente
        where a.cinternoordenservicio = ".$cinternoordenservicio.";";        
        $query  = $this->db->query($sql);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
    public function getlistresultados($parametros) { // Buscar Cotizacion	
        $procedure = "call usp_lab_coti_getlistresultados(?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}		
    }
}
?>