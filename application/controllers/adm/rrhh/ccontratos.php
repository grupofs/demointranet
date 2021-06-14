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
        $estadocontrato   = $this->input->post('estadocontrato');
        
        $parametros = array(
			'@descripcion'		=> ($this->input->post('descripcion') == '') ? '%' : '%'.$descripcion.'%',
			'@estadocontrato'	=> $estadocontrato
        );
        
        $resultado = $this->mcontratos->getbuscarcontratos($parametros);
        echo json_encode($resultado);
    } 
	public function setregempleado() {	// Registrar Vacaciones		
		$varnull = 	'';	

		$idempleado     = $this->input->post('mhdnidempleado');
		$id_administrado     = $this->input->post('mhdnidadministrado');
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
		$ccictacte      = $this->input->post('mtxtccictasueldo');
		$ccompania      = $this->input->post('hrdcia');
		$finiciocontrato      = $this->input->post('txtFIni');
		$fterminocontrato      = $this->input->post('txtFTerm');
		$carea      	= $this->input->post('mcboarea');
		$csubarea      	= $this->input->post('mcbosubarea');
		$idcargo      	= $this->input->post('mcbocargo');
		$modalidadcontrato      = $this->input->post('mcbomodalidad');
		$sueldo      	= $this->input->post('mtxtsueldo');
		$accion         = $this->input->post('mhdnAccionempleado');

		$parametros = array(
			'@id_empleado'  =>  $idempleado,
			'@id_administrado'  =>  $id_administrado,
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
			'@ccictacte'    =>  $ccictacte,
			'@ccompania'    =>  $ccompania,
			'@finicio_contrato'	=>   ($finiciocontrato == $varnull) ? NULL : substr($finiciocontrato, 6, 4).'-'.substr($finiciocontrato,3 , 2).'-'.substr($finiciocontrato, 0, 2),
			'@ftermino_contrato'	=>   ($fterminocontrato == $varnull) ? NULL : substr($fterminocontrato, 6, 4).'-'.substr($fterminocontrato,3 , 2).'-'.substr($fterminocontrato, 0, 2),
			'@carea'    =>  $carea,
			'@csubarea'    =>  $csubarea,
			'@idcargo'    =>  $idcargo,
			'@modalidadcontrato'    =>  $modalidadcontrato,
			'@sueldo'    =>  $sueldo,
			'@accion'    	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setregempleado($parametros);
		echo json_encode($respuesta);
	}
    public function getcbopensionentidad() {	// Visualizar los Tipo Equipos de Registro	
		
		$idpension = $this->input->post('idpension');
		$resultado = $this->mcontratos->getcbopensionentidad($idpension);
		echo json_encode($resultado);
	}
	public function setentidadpension() {	// Registrar Vacaciones		

		$idpensionentidad     = $this->input->post('mhdnidpensionentidad');
		$idpension      = $this->input->post('cbotipopension');
		$despensionentidad      = $this->input->post('txtdesentidadpension');
		$accion         = $this->input->post('mhdnAccionentidadpension');

		$parametros = array(
			'@idpensionentidad'	=>  $idpensionentidad,
			'@idpension'   		=>  $idpension,
			'@despensionentidad'	=>  $despensionentidad,
			'@accion'    		=>  $accion,
		);				
		$respuesta = $this->mcontratos->setentidadpension($parametros);
		echo json_encode($respuesta);
	}
    public function getcbobanco() {	// Visualizar los Tipo Equipos de Registro	
		
		$resultado = $this->mcontratos->getcbobanco();
		echo json_encode($resultado);
	}
	public function setbanco() {	// Registrar Vacaciones		

		$idbanco	= $this->input->post('mhdnidbanco');
		$nombanco	= $this->input->post('txtdesbanco');
		$accion		= $this->input->post('mhdnAccionbanco');

		$parametros = array(
			'@idbanco'	=>  $idbanco,
			'@nombanco'	=>  $nombanco,
			'@accion'	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setbanco($parametros);
		echo json_encode($respuesta);
	}
    public function getcboprofesion() {	// Visualizar los Tipo Equipos de Registro	
		
		$resultado = $this->mcontratos->getcboprofesion();
		echo json_encode($resultado);
	}
	public function setprofesion() {	// Registrar Vacaciones		

		$idprofesion	= $this->input->post('mhdnidprofesion');
		$desprofesion	= $this->input->post('txtdesprofesion');
		$accion		= $this->input->post('mhdnAccionprofesion');

		$parametros = array(
			'@idprofesion'	=>  $idprofesion,
			'@desprofesion'	=>  $desprofesion,
			'@accion'	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setprofesion($parametros);
		echo json_encode($respuesta);
	}
    public function getcboarea() {	// Visualizar los Tipo Equipos de Registro	
		
        $ccia   = $this->input->post('ccia');    		
		$resultado = $this->mcontratos->getcboarea($ccia);
		echo json_encode($resultado);
	}
	public function getcbosubarea() {	// Visualizar los Tipo Equipos de Registro	
		
		$ccia = $this->input->post('ccia');
		$carea = $this->input->post('carea');
		$resultado = $this->mcontratos->getcbosubarea($ccia,$carea);
		echo json_encode($resultado);
	}
    public function getcbocargo() {	// Visualizar los Tipo Equipos de Registro	
		
		$resultado = $this->mcontratos->getcbocargo();
		echo json_encode($resultado);
	}
	public function setcargo() {	// Registrar Vacaciones		

		$idcargo	= $this->input->post('mhdnidcargo');
		$nomcargo	= $this->input->post('txtdescargo');
		$accion		= $this->input->post('mhdnAccioncargo');

		$parametros = array(
			'@idcargo'	=>  $idcargo,
			'@nomcargo'	=>  $nomcargo,
			'@accion'	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setcargo($parametros);
		echo json_encode($respuesta);
	}
    public function getcontratosxempleado() {	// Busqueda de Contratos 	
		$varnull = '';

        $id_empleado   = $this->input->post('id_empleado');        
        
        $resultado = $this->mcontratos->getcontratosxempleado($id_empleado);
        echo json_encode($resultado);
    } 
	public function setcontratos() {	// Registrar Vacaciones		
		$varnull = 	'';	

		$idempleado     = $this->input->post('mhdnidempleado_cont');	
		$idcontrato     = $this->input->post('mhdnidcontrato');
		$ccompania     	= $this->input->post('hrdcia_cont');	
		$finiciocontrato      = $this->input->post('txtFIni_cont');
		$fterminocontrato      = $this->input->post('txtFTerm_cont');
		$carea      	= $this->input->post('mcboarea_cont');
		$csubarea      	= $this->input->post('mcbosubarea_cont');
		$idcargo      	= $this->input->post('mcbocargo_cont');
		$modalidadcontrato      = $this->input->post('mcbomodalidad_cont');
		$sueldo      	= $this->input->post('mtxtsueldo_cont');
		$accion         = $this->input->post('mhdnAccioncontrato');

		$parametros = array(
			'@id_empleado'  =>  $idempleado,
			'@id_contrato'  =>  $idcontrato,
			'@ccompania'  =>  $ccompania,
			'@finicio_contrato'	=>   ($finiciocontrato == $varnull) ? NULL : substr($finiciocontrato, 6, 4).'-'.substr($finiciocontrato,3 , 2).'-'.substr($finiciocontrato, 0, 2),
			'@ftermino_contrato'	=>   ($fterminocontrato == $varnull) ? NULL : substr($fterminocontrato, 6, 4).'-'.substr($fterminocontrato,3 , 2).'-'.substr($fterminocontrato, 0, 2),
			'@carea'    =>  $carea,
			'@csubarea'    =>  $csubarea,
			'@idcargo'    =>  $idcargo,
			'@modalidadcontrato'    =>  $modalidadcontrato,
			'@sueldo'    =>  $sueldo,
			'@accion'    	=>  $accion,
		);				
		$respuesta = $this->mcontratos->setcontratos($parametros);
		echo json_encode($respuesta);
	}
	public function setrenovarcontrato() {	// Registrar Vacaciones		
		$varnull = 	'';	
	
		$idcontrato     = $this->input->post('idcontrato');

		$parametros = array(
			'@id_contrato'  =>  $idcontrato,
		);				
		$respuesta = $this->mcontratos->setrenovarcontrato($parametros);
		echo json_encode($respuesta);
	}
	public function setcesarcontrato() {	// Registrar Vacaciones		
		$varnull = 	'';	
	
		$idcontrato     = $this->input->post('idcontrato');
			
		$respuesta = $this->mcontratos->setcesarcontrato($idcontrato);
		echo json_encode($respuesta);
	}
}
?>