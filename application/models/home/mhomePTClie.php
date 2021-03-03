<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MhomePTClie extends CI_Model{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
    }
   
	public function getserviciosclie($ccliente) { //Recuperar Opciones del Usuario
        $sql = "select c.ccliente,
                    sum(if c.idptservicio = 1 then 1 else 0 end if) as 'mapter',
                    sum(if c.idptservicio = 2 then 1 else 0 end if) as 'proconv',
                    sum(if c.idptservicio = 3 then 1 else 0 end if) as 'calfrio',
                    sum(if c.idptservicio = 4 then 1 else 0 end if) as 'proacep',
                    sum(if c.idptservicio = 12 then 1 else 0 end if) as 'evaldesvi',
                    sum(if c.idptservicio = 13 then 1 else 0 end if) as 'cocsechor'
                from pt_informe a
                join pt_evaluacion b on b.idptevaluacion = a.idptevaluacion
                join pt_propuesta c on c.idptpropuesta = b.idptpropuesta
                where c.ccliente = ".$ccliente."
                and a.vigencia = 'A'
                group by c.ccliente;";
		$query = $this->db-> query($sql);

		if ($query->num_rows() > 0) {
            $data = $query->result();
			$query->free_result(); 
			return $data;
		}{
			return False;
		}	
	}
	public function gethome($idrol) { //Recuperar Home del Usuario
        	$sql = "select a.id_rol, a.id_opcion, b.vista_opcion, b.script_opcion 
			from segu_rol a
			join sist_opcion b on b.id_opcion = a.id_opcion
			where a.id_rol = ".$idrol."
			and b.tipo_opcion = 'H';"; 
		$query = $this->db-> query($sql);

		if ($query->num_rows() > 0) {
            $data = $query->result();
			$query->free_result(); 
			return $query->row();
		}{
			return False;
		}	
	}

}
?>