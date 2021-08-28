<?php
    $idusu = $this -> session -> userdata('s_idusuario');
    $codusu = $this -> session -> userdata('s_cusuario');
    $infousuario = $this->session->userdata('s_infodato');
    $idempleado = $this->session->userdata('s_idempleado');
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-file-alt"></i> Informes Incompletos</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>main">Home</a></li>
          <li class="breadcrumb-item active">Gestion Procesos Termicos</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Listado de Informes Pendientes</h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">                        
                        <input type="hidden" id="hdidempleado" name="hdidempleado" value= <?php echo $idempleado; ?> >
                        <table id="tblListalertainf" class="table table-striped table-bordered compact" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>N° Informe</th>
                                <th>Fecha Informe</th>
                                <th>Cliente</th>
                                <th>Detalle</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</section>
<!-- /.Main content -->

<!-- /.modal-crear-informe --> 
<div class="modal fade" id="modalCreaInfor" data-backdrop="static" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" id="frmCreaInfor" name="frmCreaInfor" action="<?= base_url('pt/cinforme/setinforme')?>" method="POST" enctype="multipart/form-data" role="form"> 

        <div class="modal-header text-center bg-success">
            <h4 class="modal-title w-100 font-weight-bold">Registro de Informe</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">  
            <p class="statusMsg"></p>           
            <input type="hidden" id="mhdnIdInfor" name="mhdnIdInfor"> <!-- ID -->
            <input type="hidden" id="mhdnAccionInfor" name="mhdnAccionInfor">

            <input type="hidden" id="mhdnIdpteval" name="mhdnIdpteval">
            <input type="hidden" id="mhdnIdresponsable" name="mhdnIdresponsable">
                        
            <div class="form-group">
                <div class="row">                    
                    <div class="col-sm-4">
                        <div class="text-info">Fecha Informe</div>
                        <div class="input-group date" id="mtxtFreginforme" data-target-input="nearest">
                            <input type="text" id="mtxtFinfor" name="mtxtFinfor" class="form-control datetimepicker-input" data-target="#mtxtFreginforme"/>
                            <div class="input-group-append" data-target="#mtxtFreginforme" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>                        
                    </div>   
                    <div class="col-sm-4">                              
                        <div class="checkbox" id="lbchkinf">
                            <div class="text-info">Nro Informe  &nbsp;&nbsp;
                                <b><input type="checkbox" id="chkNroAntiguo" name="chkNroAntiguo" > Antiguo</b>
                            </div>
                        </div>  
                        <div>                            
                            <input type="text" name="mtxtNroinfor" class="form-control" id="mtxtNroinfor">
                            <span style="color: #b94a48">Ej. 0100-2018/PT/FS</span>
                            <br>
                            <span style="color: #b94a48">Ej. 0100B-2018/PT/FS</span>
                        </div>
                    </div>           
                    <div class="col-sm-4"> 
                        <div class="text-info">Responsable<span style="color: #FD0202">*</span></div> 
                        <div>                            
                            <select class="form-control" id="mcboContacInfor" name="mcboContacInfor" >
                                <option value=1>SU-TZE LIU</option>
                                <option value=42>CARLOS VILLACORTA</option>
                                <option value=64>JOSE OLIDEN</option>
                            </select>
                        </div>
                    </div> 
                </div>                
            </div> 
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Archivo</div>                        
                        <div class="input-group">
                            <input class="form-control" type="text" name="mtxtNomarchinfor" id="mtxtNomarchinfor">                            
                            <span class="input-group-append">                                
                                <div class="fileUpload btn btn-secondary">
                                    <span>Subir Archivo</span>
                                    <input type="file" class="upload" id="mtxtArchivoinfor" name="mtxtArchivoinfor" onchange="escogerArchivo()"/>                      
                                </div> 
                            </span>  
                        </div>
                        <span style="color: red; font-size: 13px;">+ Los archivos deben estar en formato pdf, docx o xlsx y no deben pesar mas de 60 MB</span>                        
                        <input type="hidden" name="mtxtRutainfor" id="mtxtRutainfor">
                        <input type="hidden" name="mtxtArchinfor" id="mtxtArchinfor">
                        <input type="hidden" name="sArchivo" id="sArchivo" value="N"> 
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <div class="row">                
                    <div class="col-sm-12">
                        <div class="text-info">Comentario <span style="color: #FD0202">*</span></div>
                        <div>   
                            <textarea class="form-control" cols="20" data-val="true" data-val-length="No debe superar los 500 caracteres." data-val-length-max="500" id="mtxtDetaInfor" name="mtxtDetaInfor" rows="2" data-val-maxlength-max="500" data-validation="required"></textarea>
                            <span class="help-inline" style="padding-left:0px; color:#999; font-size:0.9em;">Caracteres: 0 / 500</span>    
                        </div> 
                    </div> 
                </div>                
            </div>               
        </div>

        <div class="modal-footer justify-content-between" style="background-color: #dff0d8;">
            <button type="reset" class="btn btn-default" id="mbtnCCreaInfor" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info" id="mbtnGCreaInfor">Grabar</button>
        </div>
      </form>
    </div>
  </div>
</div>  
<!-- /.modal-->

<script type="text/javascript">
    var baseurl = "<?php echo base_url();?>"; 
</script>