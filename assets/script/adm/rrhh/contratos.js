
var otblListContratos;

$(document).ready(function() {

});

$("#btnBuscar").click(function (){    
    parametros = paramListarBusqueda();
    getListarBusqueda(parametros);    
});

paramListarBusqueda = function (){    
       
    var param = {
        "descripcion"     : '%',//$('#txtcodprodu').val(),
    }; 

    return param;    
};

getListarBusqueda = function(param){
    
    var groupColumn = 0;   

    otblListContratos = $('#tblListContratos').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "540px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"adm/rrhh/ccontratos/getbuscarcontratos/",
            "type"  : "POST", 
            "data"  : param,      
            dataSrc : ''        
        },
        'columns'	: [
            {data: 'AREA'},
            {data: null, "class": "col-xxs"},
            {"orderable": false, "class": "col-xxs", 
              render:function(data, type, row){
                return  '<div class="dropdown" style="text-align: center;">'+
                            '<a  data-toggle="dropdown" href="#"><span class="fas fa-bars"></span></a>'+
                            '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
                                '<li><a data-toggle="modal" title="Contratos" data-target="#modalContratos" onClick=""><span class="fas fa-file-signature" aria-hidden="true">&nbsp;</span>&nbsp;Contratos</a></li>'+
                                '<li><a data-toggle="modal" title="Cese" data-target="#modalCierreespecial" onClick=""><span class="far fa-window-close" aria-hidden="true">&nbsp;</span>&nbsp;Cese de Contrato</a></li>'+
                            '</ul>'+
                        '</div>'
                
              }
            },
            {data: 'ANIO', "class": "col-xxs"},
            {data: 'MES', "class": "col-s"},
            {"orderable": false, "class": "col-lm",
                render:function(data, type, row){
                if(row.RUTAFOTO == ''){
                    return '<div class="user-block" style="float: none;">' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/user/unknown.png"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                    '<span class="username"  style="vertical-align: middle; margin-top: -25px;">'+row.EMPLEADO+'</span><span class="description"><h6>'+row.NRODOC+'</h6></span>'+
                    '</div>' ; 
                }else{
                    return '<div class="user-block" style="float: none;">' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/user/'+row.RUTAFOTO+'"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                    '<span class="username" style="vertical-align: middle; margin-top: -25px;">'+row.EMPLEADO+'</span><span class="description"><h6>'+row.NRODOC+'</h6></span>'+
                    '</div>' ; 
                }
                }
            },
            {data: 'FINICIO', "class": "col-s"},
            {data: 'FFIN', "class": "col-s"},
            {data: 'CARGO', "class": "col-s"},
            {data: 'SUELDO', "class": "dt-body-right col-xs"},
        ],  
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([0], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(0).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="10"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
            
        }
    }); 
    otblListContratos.column(0).visible( false );      
    // Enumeracion 
    otblListContratos.on( 'order.dt search.dt', function () { 
        otblListContratos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
     
    $("#btnexcel").prop("disabled",false);  
};

$('#tblListContratos tbody').on('dblclick', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblListContratos.row(tr);
    var rowData = row.data();
    
    $("#modalCreactrlprov").modal('show');

    $('#frmCreactrlprov').trigger("reset");
    $('#mhdnAccionctrlprov').val('A'); 
    /*$('#tabhallazgocalif a[href="#tabhallazgocalif-det"]').tab('show');
    parametros = paramListDetseguiaacc(rowData.CAREACLIENTE);
    getListDetseguiaacc(parametros);*/
} );

$("#btnNuevo").click(function (){
    $('#frmMantemple').trigger("reset");

    $("#modalMantemple").modal('show');

    $('#mhdnAccionempleado').val('N'); 
    $('#mhdntipodoc').val(1);
/*
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboclieserv",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboregClie').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboregClie');
        }
    });

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbotipoestable",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cbotipoestable').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cbotipoestable');
        }
    });*/
    
});

DNI=function(){
    $('#btntipodoc').html("DNI");
    $('#mhdntipodoc').val(1);
};

EXT=function(){
    $('#btntipodoc').html("CExt");
    $('#mhdntipodoc').val(4);
};

$('input[type=radio][name=rCia]').change(function() {
    if($('#rdFS').prop('checked')){        
        $('#hrdcia').val('1'); 
    }else if ($('#rdFSC').prop('checked')){  
        $('#hrdcia').val('2'); 
    } 
});

$('#modalMantemple').on('show.bs.modal', function (e) {

    $('#txtFIngreso,#txtFInicio,#txtFTermino').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });	
    $('#txtFNacimiento').datetimepicker({
        format: 'DD/MM/YYYY',
        locale:'es'
    });	    
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
    $('#txtFIngreso').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFInicio').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

    $('#hrdcia').val('1'); 

    $('#frmMantemple').validate({
        rules: {
        },
        messages: {
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },        
        submitHandler: function (form) {
            const botonEvaluar = $('#mbtnGManteemp');
            var request = $.ajax({
                url:$('#frmMantemple').attr("action"),
                type:$('#frmMantemple').attr("method"),
                data:$('#frmMantemple').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                    objPrincipal.liberarBoton(botonEvaluar);
                },
                beforeSend: function() {
                    objPrincipal.botonCargando(botonEvaluar);
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    Vtitle = 'Se Grabo Correctamente!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                      
                    parametros = paramListarBusqueda();
                    getListarBusqueda(parametros); 

                    objPrincipal.liberarBoton(botonEvaluar);    
                    $('#mbtnCManteemp').click();    
                });
            });
            return false;
        }
    });
});

$('#txtFInicio').on('change.datetimepicker',function(e){	
    
    $('#txtFTermino').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	
    
    var faño = moment(e.date).add(1, 'years');

    $('#txtFTermino').datetimepicker('date',moment(faño).format('DD/MM/YYYY') );
    

});

