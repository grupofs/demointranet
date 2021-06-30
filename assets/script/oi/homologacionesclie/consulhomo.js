
var otblhomologaciones;
var cboEstado
var varfregdesde = '%', varfreghasta = '%', varfinidesde = '%', varfinihasta = '%', varfterdesde = '%', varfterhasta = '%';

$(document).ready(function() {

    $('#txtFregDesde,#txtFregHasta,#txtFiniDesde,#txtFiniHasta,#txtFterDesde,#txtFterHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });
    fechaActual();

    var vccliente = $('#hdnCCliente').val();
    
    /*LLENADO DE COMBOS*/
    var params = { "ccliente":vccliente };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"oi/homologacionesclie/cconsulhomo/getproveedoreshomo",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboProveedor').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboProveedor');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"oi/homologacionesclie/cconsulhomo/getestadoshomo",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboEstado').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboEstado');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"oi/homologacionesclie/cconsulhomo/gettipoprovedorhomo",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboTiporoveedor').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboTiporoveedor');
        }
    });
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFregDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFregHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFiniDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFiniHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFterDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFterHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

$("#chkFreg").on("change", function () {
    if($("#chkFreg").is(":checked") == true){ 
        $("#txtFregIni").prop("disabled",false);
        $("#txtFregFin").prop("disabled",false);
        
        varfregdesde = '';
        varfreghasta = '';
    }else if($("#chkFreg").is(":checked") == false){ 
        $("#txtFregIni").prop("disabled",true);
        $("#txtFregFin").prop("disabled",true);
        
        varfregdesde = '%';
        varfreghasta = '%';
    }; 
});
$("#chkFini").on("change", function () {
    if($("#chkFini").is(":checked") == true){ 
        $("#txtFiniIni").prop("disabled",false);
        $("#txtFiniFin").prop("disabled",false);
        
        varfinidesde = '';
        varfinihasta = '';
    }else if($("#chkFini").is(":checked") == false){ 
        $("#txtFiniIni").prop("disabled",true);
        $("#txtFiniFin").prop("disabled",true);
        
        varfinidesde = '%';
        varfinihasta = '%';
    }; 
});
$("#chkFter").on("change", function () {
    if($("#chkFter").is(":checked") == true){ 
        $("#txtFterIni").prop("disabled",false);
        $("#txtFterFin").prop("disabled",false);
        
        varfterdesde = '';
        varfhasta = '';
    }else if($("#chkFter").is(":checked") == false){ 
        $("#txtFterIni").prop("disabled",true);
        $("#txtFterFin").prop("disabled",true);
        
        varfterdesde = '%';
        varfterhasta = '%';
    }; 
});
	
$('#txtFregDesde').on('change.datetimepicker',function(e){	
    
    $('#txtFregHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    var fecha = moment(e.date).format('DD/MM/YYYY');		
    
    $('#txtFregHasta').datetimepicker('minDate', fecha);
    $('#txtFregHasta').datetimepicker('date', fecha);

});	
$('#txtFiniDesde').on('change.datetimepicker',function(e){	
    
    $('#txtFiniHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    var fecha = moment(e.date).format('DD/MM/YYYY');		
    
    $('#txtFiniHasta').datetimepicker('minDate', fecha);
    $('#txtFiniHasta').datetimepicker('date', fecha);

});	
$('#txtFterDesde').on('change.datetimepicker',function(e){	
    
    $('#txtFterHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    var fecha = moment(e.date).format('DD/MM/YYYY');		
    
    $('#txtFterHasta').datetimepicker('minDate', fecha);
    $('#txtFterHasta').datetimepicker('date', fecha);

});

$("#btnBuscar").click(function (){    
    parametros = paramListhomologaciones();
    getListhomologaciones(parametros);
    
});

paramListhomologaciones = function (){    
    
    if(document.getElementById("cboEstado").value == ""){
        cboEstado = ["%"];
    }else{
        cboEstado = $('#cboEstado').val();
    }
    
    if(varfregdesde != '%'){ varfregdesde = $('#txtFregIni').val(); }
    if(varfreghasta != '%'){ varfreghasta = $('#txtFregFin').val(); }
    if(varfinidesde != '%'){ varfinidesde = $('#txtFiniIni').val(); }
    if(varfinihasta != '%'){ varfinihasta = $('#txtFiniFin').val(); }
    if(varfterdesde != '%'){ varfterdesde = $('#txtFregIni').val(); }
    if(varfterhasta != '%'){ varfterhasta = $('#txtFregFin').val(); }  
   
    var parametros = {
        "ccia"          : '2',
        "ccliente"      : $('#hdnCCliente').val(),
        "proveedor"     : $('#cboProveedor').val(),
        "estado"        : cboEstado,
        "tipoproveedor" : $('#cboTiporoveedor').val(),
        "producto"      : $('#txtProducto').val(),
        "marca"         : $('#txtMarca').val(),
        "fregini"       : varfregdesde,
        "fregfin"       : varfreghasta,
        "finiini"       : varfinidesde,
        "finifin"       : varfinihasta,
        "ftermini"      : varfterdesde,
        "ftermfin"      : varfterhasta,
    };  
  
    return parametros;    
};

getListhomologaciones = function(parametros){       
    otblhomologaciones = $('#tblhomologaciones').DataTable({
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
        "ajax"	: {
            "url"   : baseurl+"oi/homologacionesclie/cconsulhomo/getbuscarhomologaciones",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''      
        },
        "columns"	: [
            {data: null, "class": "details-control col-xxs"},
            {data: 'FECHA', "class": "dt-body-center col-s"},
            {data: 'FECHAEVALUA', "class": "dt-body-center col-s"},
            {data: 'FECHAESTADOEVALUACION', "class": "dt-body-center col-s"},
            {data: 'ESTADOEVALUACION', "class": "col-sm"},
            {data: 'TIPOPRODUCTOEVALUAR', "class": "col-sm"},
            {data: 'PROVEEDOR', "class": "col-xm"},
            {data: 'PRODUCTO', "class": "col-m"},
            {data: 'MARCA', "class": "col-sm"}, 
            {"orderable": false, 
              render:function(data, type, row){
              }
            }
        ],
        "columnDefs": [
          {
              "defaultContent": " ",
              "targets": "_all"
          }
        ],
        'order'       : [[ 1, "desc" ]] 
    });
     
    $("#btnexcel").prop("disabled",false);

    // Seleccionar por click
    $('#tblhomologaciones tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            otblhomologaciones.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
  });
};

function format ( d, e ) {
    var dato = '';
    var resultado = '<div style="padding-left:45px; padding-right:200px;">'+ 
            '<table border="0" class="display">' +
            '<tr><th colspan="3" style="font-weight:bold; background-color: #BDBDBD; padding-left:20px;">INFORMACIÓN DEL PRODUCTO :</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Envase Primario</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.ENVASEPRIMARIO+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Envase Secundario</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.ENVASESECUNDARIO+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Vida Útil</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.VIDAUTIL+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Condiciones de Almacenamiento</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.CONDICIONESDEALMACENAMIENTO+'</th></tr>'+
            '<tr><th><br></th></tr>'+                    
            '<tr><th colspan="3" style="font-weight:bold; background-color: #BDBDBD; padding-left:20px;">INFORMACIÓN DEL ESTABLECIMIENTO :</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Fabricante/Dirección:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.FABRICANTEDIRECCION+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Almacèn/Dirección:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.ALMACENDIRECCION+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Contacto (1):</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.CONTACTO1+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Cargo:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.CARGO1+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Telefono:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.TELEFONO1+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Correo:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.EMAIL1+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Contacto (2):</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.CONTACTO2+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Cargo:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.CARGO2+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Telefono:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.TELEFONO2+'</th></tr>'+
            '<tr><th colspan="2" style="font-weight:bold; padding-left:10px;">Correo:</th><th></th></tr>'+
            '<tr><th></th><th colspan="2" style="font-weight:normal; padding-left:10px;">'+e.EMAIL2+'</th></tr>'+
            '<tr><th><br></th></tr>'+
            '<tr><th colspan="3" style="font-weight:bold; background-color: #BDBDBD; padding-left:20px;">INFORMACIÓN DE LOS REQUISITOS :</th></tr>';

    $.each(d,function(i,item){
                        
        if (item.DUBICACIONFILESERVER !== null){                    
            dato = dato + '<tr><th style="padding-left:30px;" width="10%" align="center"><a href="'+baseurl+'FTPfileserver/Archivos/'+item.DUBICACIONFILESERVER+'" target="_blank" class="btn btn-default btn-xs pull-left"><i class="fas fa-download" style="color:black" data-original-title="ARCHIVO" data-toggle="tooltip"></i></a></th>';
        }else{
            dato = dato +  '<tr><th style="padding-left:30px;" width="10%" align="center"></th>';
        }  
        
        if (item.STITULO == 'N'){
            dato = dato + '<th style="font-weight:normal; padding-left:20px;" width="40%">'+item.DDOCUMENTO+'</th>'+
                '<th style="font-weight:normal; padding-left:20px;">'+item.RESULTADO+'</th></tr>';
                
        }else if (item.STITULO == 'S'){
            dato = dato + '<th style="font-weight:bold; padding-left:20px;" width="40%">'+item.DDOCUMENTO+'</th>'+
                '<th style="font-weight:normal; padding-left:20px;">'+item.RESULTADO+'</th></tr>';
        }           
        
    });

    resultado = resultado + dato + '<tr><th><br></th></tr>'+
    '<tr><th colspan="3" style="font-weight:bold; background-color: #BDBDBD; padding-left:20px;">OBSERVACIONES :</th></tr>'+
    '<tr><th colspan="5" style="font-weight:normal; padding-left:20px; height:auto; width:100%;">'+e.DOBSERVACIONTEXT+'<th style=""></th></tr>'+
    '<tr><th><br></th></tr>'+
    '<tr><th colspan="3" style="font-weight:bold; background-color: #BDBDBD; padding-left:20px;">ACUERDOS :</th></tr>'+
    '<tr><th colspan="5" style="font-weight:normal; padding-left:20px; height:auto; width:100%;">'+e.DACUERDOSTEXT+'<th style=""></th></tr>'+
    '<tr><th><br></th></tr></table></div>';
    

    return resultado;            
}

/* DETALLE HOMOLOGACIONES */
var detailRows = [];

$('#tblhomologaciones tbody').on( 'click', 'td.details-control', function () {
    
        var tr = $(this).closest('tr');
        var row = otblhomologaciones.row(tr);
        
        if ( row.child.isShown() ) {                    
            row.child.hide();
            tr.removeClass( 'details' );
        }
        else {
            var A = row.data()
            var VCEVAL = A.CEVALUACIONPRODUCTO;
            var VCPRODUCTO = A.CPRODUCTOFSEVALUAR;
            
            $.post(baseurl+"oi/homologacionesclie/cconsulhomo/getlistarrequisitos",
            {
                ceval:VCEVAL,
                cproducto:VCPRODUCTO
            },
            function(data){ 
                var c = JSON.parse(data);
                row.child( format(c, row.data()) ).show();  
                tr.addClass('details');       
            }
            );   
        }

});