<?php
    $idusu  = $this -> session -> userdata('s_idusuario');
    $cusu   = $this -> session -> userdata('s_cusuario');
    $cclie  = $this -> session -> userdata('s_ccliente');  
?>

<style>
</style>

<!-- content-header -->
<div class="content-header">   
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Consulta Resultados Generales</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo public_base_url(); ?>cpanel"> <i class="fas fa-tachometer-alt"></i>Home</a></li>
          <li class="breadcrumb-item active">Ctrl. Prov.</li>
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
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>LISTADO DE RESULTADOS GENERALES</b></h3>
                    </div>
                
                    <div class="card-body" style="overflow-x: scroll;">
                        <h2>Skygate front-end LAB Datatable example with dynamic headers</h2>

                        <table id="demotable" class="table table-striped table-condensed dataTable">
                            <thead><tr></tr></thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</section>
<!-- /.Main content -->

<script>
        var data,
                tableName= '#demotable',
                columns,
                str,
                jqxhr = $.ajax('data.json')
                        .done(function () {
                            data = JSON.parse(jqxhr.responseText);

                // Iterate each column and print table headers for Datatables
                $.each(data.columns, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName+'>thead>tr');
                });

                // Add some Render transformations to Columns
                // Not a good practice to add any of this in API/ Json side
                data.columns[0].render = function (data, type, row) {
                    return '<h4>' + data + '</h4>';
                }
                        // Debug? console.log(data.columns[0]);

                $(tableName).dataTable({
                    "data": data.data,
                    "columns": data.columns,
                    "fnInitComplete": function () {
                        // Event handler to be fired when rendering is complete (Turn off Loading gif for example)
                        console.log('Datatable rendering complete');
                    }
                });
            })
            .fail(function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                console.log(msg);
            });
    </script>
