<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mhelpdesk extends CI_Model {
	function __construct() {
		parent::__construct();	
		$this->load->library('session');
    }
    
    public function getempleados() { // recupera los empleados     
        $sql = "select a.id_empleado, (b.nrodoc+' - '+b.datosrazonsocial) as 'empleado' 
        from adm_rrhh_empleado a join adm_administrado b on b.id_administrado = a.id_administrado join adm_rrhh_contrato c on c.id_empleado = a.id_empleado
        where c.estado_contrato = 'A';";
        $query  = $this->db->query($sql);
            
        if ($query->num_rows() > 0) {
            $listas = '<option value="">::Elegir</option>';            
            foreach ($query->result() as $row) {
                $listas .= '<option value="'.$row->id_empleado.'">'.$row->empleado.'</option>';  
            }
            return $listas;
        }{
            return false;
        }		   
    }	
    
}
?>