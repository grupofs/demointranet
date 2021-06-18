<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <?php
            if ($ccia == 'fs'):
                $grupo = 'GRUPO FS';
                $cia = 1;
                $colorWind = 'card-success';
                $vcia = 'fs';
            elseif ($ccia == 'fsc'):
                $grupo = 'FS Certificaciones';
                $cia = 2;
                $colorWind = 'card-navy';
                $vcia = 'fsc';
            elseif ($ccia == '0'):
                $grupo = 'FS - FSC';
                $cia = 0;
                $colorWind = 'card-secondary';
                $vcia = 'services';
            endif;

            $set_tipo = $tipo;

            if ($set_tipo == '2'):
                $set_email = $dmail;
            else:
                $set_email = '';
            endif;
        ?>

        <title><?php echo 'RECUPERAR CONTRASEÑA' ?></title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo public_url(); ?>template/GUI/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo public_url(); ?>template/Ionicons/css/ionicons.min.css">  
        <link rel="stylesheet" href="<?php echo public_url(); ?>template/GUI/plugins/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo public_url(); ?>template/GUI/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo public_url(); ?>template/GUI/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/fontsgoogleapis.css">

        <?php if ($cia == 0): ?>
            <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/loginext.css">
            <link rel="shortcut icon" href="<?php echo public_url(); ?>images/favicon.png" type="image/x-icon" />
        <?php elseif ($cia == 1): ?>
            <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/loginfs.css">
            <link rel="shortcut icon" href="<?php echo public_url(); ?>images/ico-fs.ico" type="image/x-icon" />
        <?php elseif ($cia == 2): ?>
            <link rel="stylesheet" href="<?php echo public_url(); ?>cssweb/loginfsc.css">
            <link rel="shortcut icon" href="<?php echo public_url(); ?>images/ico-fsc.ico" type="image/x-icon" />
        <?php endif; ?>

    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo"> 
                <p id="rcornersLogin"><a><b>PASSWORD </b><?php echo $grupo; ?></a> </p>
            </div>
            
                <div class="card <?php echo $colorWind;?>" id="cardemail">
                    <div class="card-header text-center">
                        <h4> RESTABLECER CONTRASEÑA </h4>
                    </div> 
                    <div class='card-body login-card-body'>  
                    <form class="form-horizontal" id="frmrecoverpwd" name="frmrecoverpwd" action="<?= base_url('clogin/request_password')?>" method="POST" enctype="multipart/form-data" role="form">            
                        
                        <input type="hidden" name="cia" value= <?php echo $cia ?> > 
                        <input type="hidden" name="tipo" value= <?php echo $set_tipo ?> > 
                        <input type="hidden" name="ccia" value= <?php echo $ccia ?> > 

                        <?php
                        if($set_tipo == '2'):
                        ?>      
                            <h3><small><b>¡Usuario Bloqueado!</b> <br> Escriba correo electronico de la cuenta.</small></h3>       
                        <?php
                        else:
                        ?>
                            <h4><small><b>¿Olvidó su contraseña?</b> <br> Escriba correo electronico de la cuenta.</small></h4>
                        <?php 
                        endif;
                        ?> 
                            
                        <div class="form-group has-feedback">         
                            <?php
                            if($set_tipo == '2'):
                            ?> 
                                <input type="text" id="email" name="email" class="form-control" value =<?php echo $set_email ?> required readonly>
                            <?php
                            else:
                            ?>
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email')?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Ingrese Correo Electronico" title="mail@example.com" required>
                            <?php 
                            endif;
                            ?>
                        </div>                      
                    </form>
                    </div>     
                    <div class="card-footer" align="right">
                        <div class="text-right">                          
                            <button type="submit" form="frmrecoverpwd" class="btn btn-success" id="idbuttongrupo" >Verificar Email</button>
                            <a id="btnexit" href="<?php echo base_url($vcia) ?>" class="btn btn-warning">Cancelar</a>
                        </div>
                    </div>
                </div>

                <div class="card <?php echo $colorWind;?>" id="cardverif">                 
                    <div class="card-header text-center">
                        <h4> VERIFICACIÓN DE SEGURIDAD</h4>
                    </div> 
                    <div class='card-body login-card-body'>  
                    <form id="frmverifsegu" action="<?= base_url('clogin/valcodigo')?>" method="POST">            
                        <h4><small><b>Complete la siguiente verificación</b> <br> Proceso para garantizar la seguridad de su cuenta.</small></h4>
                            
                        <div class="form-group has-feedback">         
                            <input type="text" id="codverif" name="codverif" class="form-control"  placeholder="Ingrese código de verificación" title="Código enviado a su correo" required>
                        </div>
                        <input type="hidden" name="iduser" id="iduser"> 
                        <input type="hidden" name="varcia" value= <?php echo $cia ?> >                       
                    </form>
                    </div>     
                    <div class="card-footer" align="right">
                        <div class="text-right">                            
                            <button id="btnSiguiente" type="submit" form="frmverifsegu" class="btn btn-success" >Siguiente</button>
                            <button id="btnreturn" type="button"  class="btn btn-warning" >Regresar</button>
                        </div>
                    </div>
                </div>
        </div>

    </body>


<script src="<?php echo public_url(); ?>template/GUI/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo public_url(); ?>template/GUI/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo public_url(); ?>template/GUI/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo public_url(); ?>template/GUI/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo public_url(); ?>template/GUI/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?php echo public_url(); ?>template/GUI/dist/js/adminlte.js"></script>   
<script src="<?php echo public_url(); ?>script/login.js"></script>
<!-- Script Generales -->
<script type="text/javascript">
    var baseurl = "<?php echo base_url();?>";
</script>   
</html>