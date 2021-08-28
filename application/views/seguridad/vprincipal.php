<?php
    $cia = $this->session->userdata('s_cia');
    $idrol = $this->session->userdata('s_idrol');
    $idempleado = $this->session->userdata('s_idempleado');
    $nombres = $this->session->userdata('s_nombre');
    $infousuario = $this->session->userdata('s_infodato');
    $imgperfil = $this->session->userdata('s_druta'); 
    $nombperfil = $this->session->userdata('s_usu'); 
    $usuario = $this->session->userdata('s_usuario');
    $sessionAct = $this->session->userdata('sessionAct');  

    $rutaimagen = public_url_ftp()."Imagenes/user/".$imgperfil;
    if($imgperfil == '' || $imgperfil == false):
        $imgperfil = 'unknown.png';
    elseif(file_exists($rutaimagen)):
        $imgperfil = $imgperfil;
    else:        
        $imgperfil = $imgperfil;
    endif;
    
    if($cia == '1'):
        $ccia = 'fs';
        $title = 'FS';
        $nomCia = 'Grupo FS';
        $claseCabecera = 'navbar-success';
        $hreflogo = 'http://www.grupofs.com/';
    elseif($cia == '2'):
        $ccia = 'fsc';
        $title = 'FSC';
        $nomCia = 'FS Certificaciones';
        $claseCabecera = 'navbar-navy';
        $hreflogo = 'http://www.fscertificaciones.com/';
    endif;

    $añoActual=date("Y");
?>  
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title .'-'. $añoActual ?> | INTRANET</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo public_url(); ?>images/ico-<?php echo $ccia; ?>.ico" type="image/x-icon" />
    <?php if ($cia == 1): ?>
            <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/mainfs.css">
    <?php elseif ($cia == 2): ?>
            <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/mainfsc.css">
    <?php endif; ?>
  <!-- CSS general proyecto -->
  <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/estiloGeneral.css">   
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">        
        <input type="hidden" id="hdidempleado" name="hdidempleado" value= <?php echo $idempleado; ?> >
        <input type="hidden" id="hdsessionAct" name="hdsessionAct" value= <?php echo $sessionAct; ?> >
        <input type="hidden" id="hdnidrol" name="hdnidrol" value= <?php echo $idrol;?> >
        <input type="hidden" id="hdnccia" name="hdnccia" value= <?php echo $ccia;?> >
        <input type="hidden" id="hdncia" name="hdncia" value= <?php echo $cia;?> >

        <!-- MAIN CABECERA  -->
        <nav class="main-header navbar navbar-expand navbar-dark <?php echo $claseCabecera ?>">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block nomcab">
                    <h3>BIENVENIDO,</h3>
                </li>
                <li class="nav-item d-none d-sm-inline-block nomcab">
                    <h3 style="margin-left:5px;"><?php echo $nombres ?></h3>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown" id="dropAlerta">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span id="spanAlertas" class="badge badge-warning navbar-badge">0</span>
                    </a>
                    <div id="divListAlertas" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span id="spanNroAlertas" class="dropdown-item dropdown-header">0 Alertas</span>
                        <div id="divalertas">
                        </div>
                    </div>
                </li>
                <!-- PERFIL USUARIO -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?php echo base_url()?>perfil" >
                        <i class="fas fa-address-card fa-2x"></i>
                    </a>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="" onclick="CerrarSesion();" >
                        <i class="fas fa-sign-out-alt fa-2x"></i>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large fa-2x"></i>    
                    </a>
                </li> -->
            </ul>
        </nav>
        <!-- /.CABECERA  -->

        <!-- MAIN MENU -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- CIA Logo -->
            <a href="<?php echo $hreflogo ?>" class="brand-link <?php echo $claseCabecera ?>" target="_blank">
                <img src="<?php echo public_url(); ?>images/logo-<?php echo $ccia; ?>.png"  alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo $nomCia ?></span>
            </a>

            <!-- Panel Lateral I -->
            <div class="sidebar">
                <!-- Usuario -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo public_url_ftp(); ?>Imagenes/user/<?php echo $imgperfil ?>"  class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <h6 style="color:#fff;"><?php echo $usuario ?></h6> 
                    </div>
                </div>

                <!-- Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="<?php echo base_url()?>jobdesk" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>INTERNO</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                            $ci = &get_instance();
                            $ci->load->model("mprincipal");
                            $arearol= $ci->mprincipal->getareasacceso($cia,$idrol);
                            if ($arearol){
                            foreach($arearol as $marearol){                
                        ?>   
                        <li class="nav-header"><?php echo $marearol->darea; ?></li>                  
                        <?php
                            $carea = $marearol->carea;
                            $modulorol= $ci->mprincipal->getmenumodulo($cia,$idrol,$carea);
                            if ($modulorol){
                            foreach($modulorol  as $mmodulorol){
                        ?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon <?php echo $mmodulorol->class_icono; ?>"></i>
                                <p>
                                    <?php echo $mmodulorol->desc_modulo; ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">                  
                            <?php
                                $idmodulo = $mmodulorol->id_modulo;
                                $opcionrol= $ci->mprincipal->getmenuopciones($idrol,$idmodulo);
                                if ($opcionrol){                                
                                foreach($opcionrol  as $mopcionrol){
                                    $vista = $mopcionrol->vista_opcion;
                                    $script = $mopcionrol->script_opcion;
                            ?>
                                <li class="nav-item">
                                    <form method="post" action="<?php echo base_url()?>jobdesk" class="inline">
                                        <input type="hidden" name="vista" value="<?php echo $vista; ?>">
                                        <input type="hidden" name="script" value="<?php echo $script; ?>">
                                        <button type="submit" name="submit_param" value="submit_value" class="nav-link" >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?php echo $mopcionrol->desc_opcion; ?></p>
                                        </button>
                                    </form>
                                </li>              
                            <?php
                                }} 
                            ?>    
                            </ul>
                        </li>               
                        <?php
                            }} 
                            }} 
                        ?>   
                                         
                    </ul>
                </nav>
                <!-- /.menu -->
            </div>
            <!-- /.sidebar -->

        </aside>
        <!-- /.MENU  -->

        <!-- MAIN CONTENIDO -->
        <div class="content-wrapper" id="admin">
            <?php 
                if($vista == 'DInterno'):
                    $this->load->view($content_for_layout,$datos_ventana);
                else:                    
                    if($vista == 'DPerfil'):
                        $this->load->view($content_for_layout,$datos_ventana);
                    else:
                        $this->load->view($content_for_layout);
                    endif;
                endif;
            ?>
        </div>
        <!-- /.CONTENIDO  -->

        <!-- MAIN FOOTER -->
        <footer class="main-footer">
            <strong>Copyright &copy; sistemas :: 2018-2021 <a href="http://grupofs.com">GrupoFS</a>.</strong>
            Todos los Derechos Reservados. - All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.4.0 
            </div>
        </footer>
        <!-- /.FOOTER  -->

        <!-- Panel Lateral D -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.Panel Lateral D -->        

        <!-- Modal Session Expirar -->
        <div class="modal fade" id="modalExpired">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">CIERRE DE SESIÓN</h4>
                        <button type="button" id="cerrarModal" name="cerrarModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                    
                    <!-- Modal body -->
                    <div class="modal-body">                    
                        <div class="callout callout-danger">
                            <p>EN:</p>
                            <h1 id="timerDiv" style="text-align:center"></h1>
                            <br>
                            <p class="text-danger">Cuenta regresiva antes de cierre de sesión de forma automática</p>
                        </div>
                    </div>                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="btnContinuar" name="btnContinuar" class="btn btn-block btn-success btn-lg" data-dismiss="modal">Continuar</button>
                    </div>                    
                </div>
            </div>
        </div>   
        <!-- /.Modal Session Expirar -->    

    </div>

    <?php $this->load->view('seguridad/vprincipalJS');  ?> 

    <!-- Principal Main -->
    <script src="<?php echo public_url(); ?>script/principal.js?v1000000002"></script>

    <!-- Script Generales -->
    <script type="text/javascript">
        const BASE_URL = "<?php echo base_url();?>";
        var baseurl = "<?php echo base_url();?>";
        var ccia = "<?php echo $ccia ?>";
    </script>    

    <?php echo $this->layout->getJs(); ?>

</body>
</html>




