<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cprincipal extends CI_Controller
{
    function __construct()
    {
        parent:: __construct();
        $this->load->model('mprincipal');
        $this->load->library('session');
    }

    public function principal()
    { // Abrir ventana principal
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/analytics/dashboard.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('analytics/mdashboard');
        $resumenpermisos = $this->mdashboard->getresumenpermisos($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_resumenpermisos'] = $resumenpermisos;
        $data['content_for_layout'] = 'analytics/dashboard';
        $this->parser->parse('seguridad/vprincipal', $data);

    }

    public function principalClie()
    { // Abrir ventana principal
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $idrol = $this->session->userdata('s_idrol');
        $homeData = $this->mprincipal->gethome($idrol);
		if($homeData){
			$vista = $homeData->vista_opcion;
			$script = $homeData->script_opcion;
        }else{
            $vista = 'blank_page';
            $script = '';
        }
        
        $imprimitScripts = [];
        if (!empty($script)) {
            $scripts = explode(';', $script);
            if (is_array($scripts)) {
                foreach ($scripts as $script) {
                    $rutaScript = versionar_archivo('script/' . $script, '.js');
                    if (!empty($rutaScript)) {
                        $imprimitScripts[] = $rutaScript;
                    } else {
                        log_message('error', "Acceso a javascript no encontrada. {$script}");
                    }
                }
            }
        }
        $this->layout->js($imprimitScripts);

        $data['vista'] = 'Ventana';

        if (!empty($vista) && file_exists(VIEWPATH . $vista . '.php')) {
            $data['content_for_layout'] = $vista;
        } else {
            log_message('error', "Acceso a la vista no encontrada. {$vista}");
            $data['content_for_layout'] = 'errors/html/error_view';
        }

        $this->parser->parse('seguridad/vprincipalClie', $data);

    }

    public function perfilusuario()
    { // Abrir ventanas de perfil de usuario
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/perfilusuario.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('mperfilusuario');
        $resumenperfil = $this->mperfilusuario->getresumenperfil($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_perfil'] = $resumenperfil;
        $data['content_for_layout'] = 'seguridad/vperfilusuario';
        $this->parser->parse('seguridad/vprincipal', $data);

    }

    public function perfilcliente()
    { // Abrir ventanas de perfil de cliente
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/perfilcliente.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('mperfilcliente');
        $resumenperfil = $this->mperfilcliente->getresumenperfil($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_perfil'] = $resumenperfil;
        $data['content_for_layout'] = 'seguridad/vperfilcliente';
        $this->parser->parse('seguridad/vprincipalClie', $data);

    }

    public function ventanas()
    { // Abrir ventanas de opcion menu
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $vista = $this->input->post('vista');
        $script = $this->input->post('script');

        $imprimitScripts = [];
        if (!empty($script)) {
            $scripts = explode(';', $script);
            if (is_array($scripts)) {
                foreach ($scripts as $script) {
                    $rutaScript = versionar_archivo('script/' . $script, '.js');
                    if (!empty($rutaScript)) {
                        $imprimitScripts[] = $rutaScript;
                    } else {
                        log_message('error', "Acceso a javascript no encontrada. {$script}");
                    }
                }
            }
        }
        $this->layout->js($imprimitScripts);

        $data['vista'] = 'Ventana';

        if (!empty($vista) && file_exists(VIEWPATH . $vista . '.php')) {
            $data['content_for_layout'] = $vista;
        } else {
            log_message('error', "Acceso a la vista no encontrada. {$vista}");
            $data['content_for_layout'] = 'errors/html/error_view';
        }

        $this->parser->parse('seguridad/vprincipal', $data);

    }

    public function ventanasClie()
    { // Abrir ventanas de opcion menu
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $vista = $this->input->post('vista');
        $script = $this->input->post('script');

        $imprimitScripts = [];
        if (!empty($script)) {
            $scripts = explode(';', $script);
            if (is_array($scripts)) {
                foreach ($scripts as $script) {
                    $rutaScript = versionar_archivo('script/' . $script, '.js');
                    if (!empty($rutaScript)) {
                        $imprimitScripts[] = $rutaScript;
                    } else {
                        log_message('error', "Acceso a javascript no encontrada. {$script}");
                    }
                }
            }
        }
        $this->layout->js($imprimitScripts);

        $data['vista'] = 'Ventana';

        if (!empty($vista) && file_exists(VIEWPATH . $vista . '.php')) {
            $data['content_for_layout'] = $vista;
        } else {
            log_message('error', "Acceso a la vista no encontrada. {$vista}");
            $data['content_for_layout'] = 'errors/html/error_view_clie';
        }

        $this->parser->parse('seguridad/vprincipalClie', $data);

    }

    public function cerrar()
    { // Cerrar Sesion
        $vars = array('s_idusuario', 's_cusuario', 's_usuario', 's_idrol', 's_cia', 's_dmail', 's_passw', 's_changepassw', 's_druta', 's_tipopwd', 's_tipousu', 'login');
        $this->session->unset_userdata($vars);
        $this->session->sess_destroy();
        session_destroy();
    }

    public function getalerta(){
        $idempleado = $this->input->post('idempleado');	
        $resultado = $this->mprincipal->getalerta($idempleado);
        echo json_encode($resultado);
    }
    public function getlistalerta(){	
        $idempleado = $this->input->post('idempleado');
        $resultado = $this->mprincipal->getlistalerta($idempleado);
        echo json_encode($resultado);
    }
    public function viewAlertaInf()
    { 
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/pt/gestion/alertainf.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('mperfilusuario');
        $resumenperfil = $this->mperfilusuario->getresumenperfil($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_perfil'] = $resumenperfil;
        $data['content_for_layout'] = 'pt/gestion/valertainf';
        $this->parser->parse('seguridad/vprincipal', $data);

    }
    public function viewAlertaEst()
    { 
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/pt/gestion/alertaest.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('mperfilusuario');
        $resumenperfil = $this->mperfilusuario->getresumenperfil($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_perfil'] = $resumenperfil;
        $data['content_for_layout'] = 'pt/gestion/valertaest';
        $this->parser->parse('seguridad/vprincipal', $data);

    }
    public function viewAlertaReg()
    { 
        if (!$this->session->userdata("login")) {
            redirect('clogin');
        }
        $this->session->time = time();

        $this->layout->js(array(public_url('script/pt/gestion/alertareg.js')));

        $idempleado = $this->session->userdata('s_idempleado');
        $parametros = array(
            '@idempleado' => $idempleado
        );
        $this->load->model('mperfilusuario');
        $resumenperfil = $this->mperfilusuario->getresumenperfil($parametros);

        $data['vista'] = 'DInternos';
        $data['datos_perfil'] = $resumenperfil;
        $data['content_for_layout'] = 'pt/gestion/valertareg';
        $this->parser->parse('seguridad/vprincipal', $data);

    }

}
