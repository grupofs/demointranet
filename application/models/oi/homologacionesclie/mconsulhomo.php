<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconsulhomo extends CI_Model {
	function __construct() {
		parent::__construct();	
		$this->load->library('session');
    }
    
	/*****************************/
	/** BUSQUEDAS - HOMOLOGACIONES**/         
        public function getbuscarhomologaciones($parametros) /* Lista la busqueda de homologaciones */
		{
			$procedure = "call sp_appweb_oi_consulta_evalpdtocia(?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$query = $this->db-> query($procedure,$parametros);

			if ($query->num_rows() > 0) { 
				return $query->result();
			}{
				return False;
			}		   
        }
        public function getlistarrequisitos($parametros) /* Lista los detalles de la busqueda de homologaciones */
		{
			$procedure = "call sp_appweb_oi_consulta_evalpdtocia_det(?,?)";
			$query = $this->db-> query($procedure,$parametros);

			if ($query->num_rows() > 0) { 
				return $query->result();
			}{
				return False;
			}		   
		}	
    /*****************************/	
				
	/** LISTAS - HOMOLOGACIONES**/ 
		public function getproveedoreshomo($ccliente) /* Lista de proveedores */
		{ 
		   	$sql = "select distinct a.ccliente, a.drazonsocial from MCLIENTE a join PEVALUACIONPRODUCTO b on a.CCLIENTE = b.CPROVEEDORCLIENTE where b.CCLIENTEPRINCIPAL = ? order by a.drazonsocial;";
		   	$query  = $this->db->query($sql,$ccliente);
		   	
		   	if ($query->num_rows() > 0) {
				$listas = '<option value="%" selected="selected">::Elegir</option>';
				
				foreach ($query->result() as $row)
				{
					$listas .= '<option value="'.$row->ccliente.'">'.$row->drazonsocial.'</option>';  
				}
				return $listas;
			}{
				return false;
			}		   
		}			
		public function getestadoshomo($ccliente) /* Lista de estados */
		{ 
		   $sql = "select distinct b.ctipo, b.dregistro from PPRODUCTOEVALUAR a join TTABLA b ON b.CTIPO = a.ZCESTADOEVALUACION join PEVALUACIONPRODUCTO c on c.cevaluacionproducto = a.cevaluacionproducto where C.CCLIENTEPRINCIPAL = ? order by b.dregistro;";
		   $query  = $this->db->query($sql,$ccliente);
		   	
		   if ($query->num_rows() > 0) {
				$listas = '<option value="%" selected="selected">::Elegir</option>';
				
				foreach ($query->result() as $row)
				{
					$listas .= '<option value="'.$row->ctipo.'">'.$row->dregistro.'</option>';  
				}
				return $listas;
			}{
				return false;
			}		   
		}		
		public function gettipoprovedorhomo($ccliente) /* Lista de tipo de proveedores  */
		{ 
		   $sql = "select distinct b.careacliente, b.dareacliente from PPRODUCTOEVALUAR a join MAREACLIENTE b ON b.CAREACLIENTE = a.ZCTIPOPRODUCTOEVALUAR where b.CCLIENTE = ? order by b.dareacliente;";
		   $query  = $this->db->query($sql,$ccliente);
		   	
		   if ($query->num_rows() > 0) {
				$listas = '<option value="%" selected="selected">::Elegir</option>';
				
				foreach ($query->result() as $row)
				{
					$listas .= '<option value="'.$row->careacliente.'">'.$row->dareacliente.'</option>';  
				}
				return $listas;
			}{
				return false;
			}		   
		}  
		/*****************************/	
					
		/** LISTAS - PRODUCTO A VENCER**/         
        public function getalertasfecha($parametros) /* Lista la busqueda de homologaciones */
		{
			$procedure = "call sp_appweb_oi_alertaxfecha_evalpdto(?,?,?,?)";
			$query = $this->db-> query($procedure,$parametros);

			if ($query->num_rows() > 0) { 
				return $query->result();
			}{
				return False;
			}		   
        }
}
?>