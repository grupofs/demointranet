<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clogin extends CI_Controller {
	public function __construct(){
		parent:: __construct();	
		$this->load->model('mlogin');
		$this->load->library('encryption');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper(array('form','url','download','html','file'));

	}
	
/****************/
/** LOGEARSE **/ 
	public function index(){
		$this->load->view('Error403');
	}

	// Vista principal
	public function fs(){		
		$data['cia'] = '1';
		$data['alerta'] = '0';		
		$this->load->view('seguridad/vlogin',$data);		
	}

	public function fsc(){
		$data['cia'] = '2';	
		$data['alerta'] = '0';
		$this->load->view('seguridad/vlogin',$data);		
	}

	public function ext(){
		$data['cia'] = '1';	
		$data['alerta'] = '0';
		$this->load->view('seguridad/vloginext',$data);		
	}

	public function principal(){
		redirect('cprincipal/principal');		
	}

	public function principalClie(){
		redirect('cprincipal/principalClie');		
	}
	
	public function ingresar(){ // Ingresar con usuario y clave
		$varnull = '';

		if (!isset($_SESSION['contadorLogin'])) {
			$_SESSION['contadorLogin'] = 0;
		}	

		$chboxsession = ($this->input->post('chboxsession') == $varnull) ? 'N' : 'S';	
		
		$ccia = $this->input->post('cia');
		if ($ccia == '1') :
			$cia = 'fs';
		elseif ($ccia == '2') :
			$cia = 'fsc';
		endif;
		
		$parametros = array(
			'@USUARIO' =>  $this->input->post('txtemail'),
			'@CCIA' =>  $this->input->post('cia')
		);

		$respuesta = $this->mlogin->ingresar($parametros);
		$valor = $respuesta['valor'];
			
		if ($valor == 1) { //Acceso Correcto
			$this->session->set_userdata('sessionAct', $chboxsession);
			$rol = $this->session->userdata('s_idrol');
			$tipousu = $this->session->userdata('s_tipousu');

			if ($tipousu == 'I'):
				$respvalor = 1;
			else:
				$respvalor = 99;
			endif;
			
			$retorno = array(
				'respuesta' =>  "",
				'valor' 	=>  $respvalor
			);			
			echo json_encode($retorno);	

		}else if($valor == -3){ //Acceso restablecer clave bloqueada
			echo json_encode($respuesta);

		}else if($valor == 0){ //Acceso cambio clave
			echo json_encode($respuesta);

		}else if($valor == -2){ //Usuario Incorrecto
			echo json_encode($respuesta);

		}else{ //clave Incorrecta
			if ($_SESSION['contadorLogin']<5): 
				echo json_encode($respuesta);	
				$_SESSION['contadorLogin'] = $_SESSION['contadorLogin'] + 1;

			else:				
				$parametros = array(
					"user_id"			=>	$this-> session-> userdata('s_idusuario'),
					"fecha_bloqueo"		=>	date('Y-m-d H:i:sa'),
					"motivo_bloqueo"	=>	'Agoto las veces de intento para acceder',
					"tipo_acceso"		=>	'B',
				);

				//si el password se ha cambiado correctamente y actualizado los datos para Bloqueo
				if($this->mlogin->changepasw_login($parametros) === TRUE)
				{	
					unset ($_SESSION['contadorLogin']);
					$_SESSION['contadorLogin'] = 0;
											
					$retorno = array(
						'respuesta' =>  "¿Desea Desbloquear Usuario?",
						'valor' 	=>  -3
					);
					echo json_encode($retorno);	
				}				
			endif;
		}

		
	}

	
/*****************************/
/** CAMBIAR PASSWORD **/ 		
	public function change_pass($cia = "") { // Restablecer Cuenta Bloqueada
		$data = array();
		$data["ccia"] = $cia;
		$data['idusuario'] = $this-> session-> userdata('s_idusuario');
		$data['dmail'] = $this-> session-> userdata('s_dmail');
		$data['tipo'] = '2';

		if ($cia  == 'fs' or $cia  == 'fsc' or $cia  == '0') :
			$this->load->view("seguridad/vlogin_changepwd", $data);
		else:
			$this->load->view('welcome_message');
		endif;		
	}
	
	public function changepasw_login() { //procesa el formulario para cambiar el password del usuario	
		$cia = $this->input->post("cia");
		$ccia = $this->input->post("ccia");

		if($this->input->post("tipo") == '2'){
			$parametros = array(
				'@USUARIO' =>  $this-> session -> userdata('s_dmail'),
				'@CIA' =>  $this->input->post('cia')
			);
			if($cia == '0'){
				$respuesta = $this->mlogin->validarpass_services($parametros);
			}else{
				$respuesta = $this->mlogin->validarpass($parametros);
			}
			
			if ($respuesta != 1) {				
				$retorno = array(
					'respuesta' =>  "Debe de ingresar bien su contraseña actual.",
					'valor' 	=>  -4
				);
				echo json_encode($retorno);		
			}else{
				$this->change_pwd();
			}
		}else{
			$this->change_pwd();
		}				
	}

	private function change_pwd() { // Cambia la contraseña del usuario
		date_default_timezone_set('America/Lima');
		$parametros = array(
			"clave_web"			=>	password_hash($this->input->post("conf_password"),PASSWORD_DEFAULT),
			"user_id"			=>	$this->input->post("idusuario"),
			"fcambiopwd"		=>	date('Y-m-d H:i:sa'),
			"change_clave"		=>	'1',
			"tipo_acceso"		=>	'N',
			"fecha_bloqueo"		=>	null,
			"motivo_bloqueo"	=>	'',
			"token"				=>	$this->token(), //ponemos otro token nuevo,
		);

		//si el password se ha cambiado correctamente y actualizado los datos
		if($this->mlogin->changepasw_login($parametros) === TRUE){						
			$retorno = array(
				'respuesta' =>  "Por favor inicia sesión con la nueva contraseña.",
				'valor' 	=>  2
			);
			echo json_encode($retorno);	
		}else{ //en otro caso error					
			$retorno = array(
				'respuesta' =>  "Ha ocurrido un error modificando su password.",
				'valor' 	=>  -5
			);
			echo json_encode($retorno);	
		}
	}
	
/*****************************/
/** RECUPERAR PASSWORD **/ 
	public function unlock_pass($cia='') { // Recuperar Password	
		$data = array();
		$data['ccia'] = $cia;
		$data['idusuario'] = $this-> session-> userdata('s_idusuario');
		$data['dmail'] = $this-> session-> userdata('s_dmail');
		$data['tipo'] = '2';
		$this->load->view('seguridad/vlogin_recoverpwd',$data);
	}

	public function recover_pass($cia='') { // Recuperar Password	
		$data = array();
		$data['ccia'] = $cia;
		$data['idusuario'] = $this-> session-> userdata('s_idusuario');
		$data['dmail'] = $this-> session-> userdata('s_dmail');
		$data['tipo'] = '1';
		$this->load->view('seguridad/vlogin_recoverpwd',$data);
	}
	
	public function request_password() { // recuperar Password		
		$tipo = $this->input->post("tipo");
		$ccia = $this->input->post("ccia");
		$comp = $this->input->post("cia");
		$validar = '0';
		
        if($validar == '0'){  	
        	//obtenemos los datos del usuario porque existe el email
			$userData = $this->mlogin->getUserData($this->input->post("email"));
			$codususer = $userData->id_usuario;
			
			$s_usuario = array(
				's_idusuario' 	=> $userData->id_usuario, 
				's_cia' 		=> $ccia,
				's_dmail' 		=> $userData->email_acceso,
				'login' 		=> TRUE
			);			
			$this -> session -> set_userdata($s_usuario);

        	//enviamos un email al usuario
        	if($userData){				
        		if($this->sendMailRecoveryPass($userData) === TRUE){							
					$retorno = array(
						'respuesta' =>  "Se ha enviado un email a su correo para recuperar su password, tiene 20 minutos",
						'valor' 	=>  3,
						'iduser' 	=>  $codususer
					);
					echo json_encode($retorno);	
        		}else{						
					$retorno = array(
						'respuesta' =>  "Ha ocurrido un error enviando el email, pruebe más tarde.",
						'valor' 	=>  -6,
						'iduser' 	=>  $codususer
					);
					echo json_encode($retorno);	
        		}
        	}else{					
				$retorno = array(
					'respuesta' =>  "Ha ocurrido un error validando email, use otro.",
					'valor' 	=>  -6,
					'iduser' 	=>  null
				);
				echo json_encode($retorno);	
			}
        }
	}

	private function sendMailRecoveryPass($userdata) { // Envio de Email
		
        $from = "intranet@grupofs.com";
        $namfrom = "PLATAFORMA SOPORTE TI";		

        $replyto = "plataforma@grupofs.com";
		$replynam = "PLATAFORMA SOPORTE TI";
		
        //cargamos la libreria email de ci
		$this->load->library("email");
		
		$iduser = $userdata->id_usuario;
		$randAcceso = $userdata->nroseguridad;

		$emailData = $this->mlogin->getconfigemail('011');

		if($emailData){
			$mailhost = $emailData->DSERVER;
			$mailport = $emailData->NPUERTO;
			$mailuser = $emailData->DUSER;
			$mailpass = $emailData->DPASSWORD;
		}
		
		//configuracion para grupofs
		$configGrupofs = array(
			'protocol' => 'smtp',
			'smtp_crypto' => 'tls',
			'smtp_host' => $mailhost,
			'smtp_port' => $mailport,
			'smtp_user' => $mailuser ,
			'smtp_pass' => $mailpass,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
			'crlf' => "\r\n",
		);			
		//$VarToken = $userdata->token;

		$to = $userdata->email_acceso;
        //$cc = 'eortega@grupofs.com';

		$asunto = "[GrupoFS] Solicitud para restablecer la contraseña";
		
		$mensaje = '<div style="width:600px;max-width:100%;background:#fff;border-radius:6px;margin:0 auto"> <img width="100%" src="'.public_url().'images/EmailCab.jpg" tabindex="0"/>';
		$mensaje .= '<div style="padding:0 20px 40px"> <table style="border-spacing:0;float:right;width:100%;line-height:32px;margin-top:16px;font-size:14px;border-radius:4px">  
			<tbody> <tr> <td width="100%"> </td></tr> </tbody> </table> </div>
			<div style="clear:both"></div>
			<h3 style="font-weight:bold;font-size:24px;line-height:36px;margin:16px 0;color:#1e2026">Restablecer la contraseña </h3>
			<p style="font-weight:normal;margin:16px 0 0 0;color:#474d57">Ha solicitado restablecer la contraseña vinculada a la plataforma de la empresa.<a style="color:#396acc;text-decoration:underline"></a> </p>
			<p style="font-weight:normal;color:#474d57">Tenga en cuenta que toda información es obtenida desde la Plataforma Web</p>
			<p style="font-weight:normal;color:#474d57">Para confirmar su solicitud, utilice el código de 6 digitos a continuación: </p>
			<p style="font-weight:normal;color:#474d57"> </p>
			<div style="font-size:32px;margin-top:16px;color:#1e2026">'.$randAcceso.'</div>
			<p style="font-weight:normal;margin:16px 0 0 0;color:#474d57"> </p>
			<p style="font-weight:normal;color:#474d57">El código de verificación tendrá una validez de 20 minutos. No comparta este código con nadie. Si no reconoce esta actividad, comuníquese con nuestro servicio de atención al cliente de inmediato en  
			<a style="text-decoration-line:none;font-weight:normal;line-height:24px;color:#f0b90b" href="https://grupofs.com/#ContactoFS" target="_blank" > https://grupofs.com/#ContactoFS </a>. </p>
			<p style="font-weight:normal;color:#474d57"> </p>
			<p style="font-weight:normal;margin:0;font-size:14px;line-height:22px;color:#76808f;margin-top:36px">Equipo GrupoFS TI<br>Este es un mensaje automático, no responda.</p>
			<p style="font-weight:normal;margin:0;font-size:14px;line-height:22px;color:#aeb4bc;text-align:center">Copyright © sistemas :: 2018-2020 GrupoFS. Todos los Derechos Reservados. - All rights reserved.</p>
			</div>';		
 
        //cargamos la configuración para enviar con gmail
        $this->email->initialize($configGrupofs); 
        $this->email->from($from, $namfrom);
        $this->email->to($to);
        //$this->email->cc($cc);
        $this->email->reply_to($replyto, $replynam);
		$this->email->subject($asunto);
		$this->email->message($mensaje);
		
        if($this->email->send())
        {
        	return TRUE;
		}else{
        	return FALSE;
		}		
	}

	public function valcodigo() { // recuperar Password		
		$iduser = $this->input->post("iduser");
		$codverif = $this->input->post("codverif");
		$varcia = $this->input->post("varcia");
		
        if($codverif <> ''){  	
        	//
			$validacion = $this->mlogin->getvalcodigo($iduser,$codverif);			
        	//
        	if($validacion){							
				$retorno = array(
					'respuesta' =>  "Su código es correcto.",
					'valor' 	=>  1,
					'ccia'		=> $varcia
				);
				echo json_encode($retorno);	
        	}else{					
				$retorno = array(
					'respuesta' =>  "Su código fue rechazado.",
					'valor' 	=>  0,
					'ccia'		=> $varcia
				);
				echo json_encode($retorno);	
			}
        }
	}
	
	/*public function recovery_password() {
		$cia = $this->input->post("ccia");
		redirect(base_url("clogin/change_pass/"+$cia),"refresh");
		//$this->change_pass($cia);
	}*/

	public function recovery_password($cia = "") { // Ejecuta el proceso TOKEN enviado a email ($token = "",$cia = "",$iduser ="",$valverif ="")
		//si el password ha caducado
		/*if($this->checkIsLiveToken($token) === FALSE)
		{
			$this->session->set_flashdata(
				"expired_request", "Si necesita recuperar su password rellene el 
				formulario con su email y le haremos llegar un correo con instrucciones"
			);
			redirect(base_url("clogin/request_password"),"refresh");
		}*/
		$iduser = $this-> session-> userdata('s_idusuario');
		$email = $this-> session-> userdata('s_dmail');

		if($cia  == 1){
			$ccia = 'fs';
		}else if($cia  == 2){
			$ccia = 'fsc';
		}else if($cia  == 0){
			$ccia = '0';
		}

		$data = array();		
		$data["idcia"] = $cia;
		$data["tipo"] = '1';		
		$data["ccia"] = $ccia;		
		$data["idusuario"] = $iduser;	
		$data["dmail"] = $email;
		$data['tipo'] = '1';
		
		//$this->session->set_userdata("id_user_recovery_pass", $this->checkIsLiveToken($token)->id_usuario);
		
		if ($cia  == 1 or $cia  == 2 or $cia  == 0) :
			$this->load->view("seguridad/vlogin_changepwd", $data);
		else:
			$this->load->view('welcome_message');
		endif;
	}	
	private function checkIsLiveToken($token) { // Verifica si el TOKEN a expirado
		return $this->mlogin->checkIsLiveToken($token);
	}	
	private function token() { // Genera un Token para cada usuario
        return sha1(uniqid(rand(),true));
	}
}
?>
