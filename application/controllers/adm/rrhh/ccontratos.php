<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccontratos extends CI_Controller {
	function __construct() {
		parent:: __construct();	
		$this->load->model('adm/rrhh/mcontratos');
		$this->load->model('mglobales');
		$this->load->library('encryption');
		$this->load->helper(array('form','url','download','html','file'));
		$this->load->library('form_validation');
    }
    
   /** CONTRATOS **/
    public function getbuscarcontratos() {	// Busqueda de Contratos 	
		$varnull = '';

        $descripcion   = $this->input->post('descripcion');
        
        $parametros = array(
			'@descripcion'		=> ($this->input->post('descripcion') == '') ? '%' : '%'.$descripcion.'%',
        );
        
        $resultado = $this->mcontratos->getbuscarcontratos($parametros);
        echo json_encode($resultado);
    } 

	public function setregempleado() {	// Registrar Vacaciones		
		$varnull = 	'';	

		$idempleado     = $this->input->post('mhdnidempleado');
		$idtipodoc      = $this->input->post('mhdntipodoc');
		$nrodoc         = $this->input->post('mtxtnrodoc');
		$sexo           = $this->input->post('mcbosexo');
		$apepaterno     = $this->input->post('mtxtapepat');
		$apematerno     = $this->input->post('mtxtapemat');
		$nombres        = $this->input->post('mtxtnombres');
		$email          = $this->input->post('mtxtemail');
		$fonocelular    = $this->input->post('mtxtcelular');
		$fonofijo       = $this->input->post('mtxttelefono');
		$direccion      = $this->input->post('mtxtdireccion');
		$finiciolaboral	= $this->input->post('txtFIngre');
		$anexo			= $this->input->post('mtxtanexo');
		$emp_email      = $this->input->post('mtxtemailempre');
		$cel_empresa	= $this->input->post('mtxtcelularempre');
		$estado_civil	= $this->input->post('mcboestadocivil');
		$hijos			= $this->input->post('mtxtnrohijos');
		$fecha_nace		= $this->input->post('txtFNace');
		$profesion      = $this->input->post('mcboprofesion');
		$nrocolegioprof	= $this->input->post('mtxtnrocoleg');
		$eps			= $this->input->post('mcboeps');
		$pension		= $this->input->post('mcbopension');
		$entidadpension	= $this->input->post('mcboentidadpension');
		$banco			= $this->input->post('mcbobanco');
		$nroctacte      = $this->input->post('mtxtnroctasueldo');
		$ccompania      = $this->input->post('hrdcia');
		$accion         = $this->input->post('mhdnAccionempleado');

		$parametros = array(
			'@id_empleado'  =>  $idempleado,
			'@id_tipodoc'   =>  $idtipodoc,
			'@nrodoc'       =>  $nrodoc,
			'@sexo'         =>  $sexo,
			'@ape_paterno'  =>  $apepaterno,
			'@ape_materno'  =>  $apematerno,
			'@nombres'      =>  $nombres,
			'@email'        =>  $email,
			'@fono_celular' =>  $fonocelular,
			'@fono_fijo'    =>  $fonofijo,
			'@direccion'    =>  $direccion,
			'@finiciolaboral'    => ($finiciolaboral == $varnull) ? NULL : substr($finiciolaboral, 6, 4).'-'.substr($finiciolaboral,3 , 2).'-'.substr($finiciolaboral, 0, 2),
			'@anexo'    	=>  $anexo,
			'@emp_email'    =>  $emp_email,
			'@cel_empresa'	=>  $cel_empresa,
			'@estado_civil'	=>  $estado_civil,
			'@hijos'		=>  $hijos,
			'@fecha_nace'	=>   ($fecha_nace == $varnull) ? NULL : substr($fecha_nace, 6, 4).'-'.substr($fecha_nace,3 , 2).'-'.substr($fecha_nace, 0, 2),
			'@profesion'	=>  $profesion,
			'@nrocolegioprof'    =>  $nrocolegioprof,
			'@eps'			=>  $eps,
			'@pension'		=>  $pension,
			'@entidadpension'    =>  $entidadpension,
			'@banco'		=>  $banco,
			'@nroctacte'    =>  $nroctacte,
			'@ccompania'    =>  $ccompania,
			'@accion'    	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setregempleado($parametros);
		echo json_encode($respuesta);
	}
}
?>