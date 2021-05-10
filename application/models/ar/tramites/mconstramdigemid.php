<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mconstramdigemid extends CI_Model {
    function __construct() {
        parent::__construct();	
        $this->load->library('session');
    }
    
   /** TRAMITES DIGESA **/ 

    public function getconsulta_grid_tr($parametros) { // Recupera Listado de Propuestas      
		$procedure = "call sp_appweb_aarr_consulta_grid_tr(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }

    public function getconsulta_excel_tr($parametros) { // Recupera Listado de Propuestas      
		$procedure = "call sp_appweb_aarr_consulta_excel_tr(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }

    public function getbuscartramite($parametros) { // Recupera Listado de Propuestas      
		$procedure = "call sp_appweb_tramdoc_buscartramite(?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }

    public function getdocum_aarr($parametros) { // Recupera Listado de Propuestas      
		$procedure = "call sp_appweb_tramdoc_docum_aarr(?,?,?,?)";
		$query = $this->db-> query($procedure,$parametros);

		if ($query->num_rows() > 0) { 
			return $query->result();
		}{
			return False;
		}	
    }

}
?>