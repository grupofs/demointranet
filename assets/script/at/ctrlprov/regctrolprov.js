
var otblListctrlprov;
var varfdesde = '%', varfhasta = '%';

$(document).ready(function() {
    $('#tabctrlprov a[href="#tabctrlprov-list-tab"]').attr('class', 'disabled');
    $('#tabctrlprov a[href="#tabctrlprov-det-tab"]').attr('class', 'disabled active');

    $('#tabctrlprov a[href="#tabctrlprov-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tabctrlprov a[href="#tabctrlprov-list"]').attr('class', 'active');
        $('#tabctrlprov a[href="#tabctrlprov-det"]').attr('class', '');
        return true;
    });
    $('#tabctrlprov a[href="#tabctrlprov-det-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tabctrlprov a[href="#tabctrlprov-det"]').attr('class' ,'active');
        $('#tabctrlprov a[href="#tabctrlprov-list"]').attr('class', '');
        return true;
    });
    
    $('#tabctrlprov a[href="#tabctrlprov-list"]').click(function(event){return false;});
    $('#tabctrlprov a[href="#tabctrlprov-det"]').click(function(event){return false;});

    $('#txtFDesde,#txtFHasta,#txtFInspeccion').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });
    fechaActual();

    /*LLENADO DE COMBOS*/
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboclieserv",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboclieserv').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboclieserv');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboestado",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboestado').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboestado');
        }
    })
    var params = { "sregistro":'T'};
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspector",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboinspector').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspector');
        }
    });

    //
    $('#frmCreactrlprov').validate({
        rules: {
          cboregClie: {
            required: true,
          },
          cboregprovclie: {
            required: true,
          },
          cboregestable: {
            required: true,
          },
          cboregareaclie: {
            required: true,
          },
        },
        messages: {
          cboregClie: {
            required: "Por Favor escoja un Cliente"
          },
          cboregprovclie: {
            required: "Por Favor escoja un Proveedor"
          },
          cboregestable: {
            required: "Por Favor escoja un Establecimiento"
          },
          cboregareaclie: {
            required: "Por Favor escoja un Area"
          },
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
            const botonEvaluar = $('#mbtnGCreactrl');
            var request = $.ajax({
                url:$('#frmCreactrlprov').attr("action"),
                type:$('#frmCreactrlprov').attr("method"),
                data:$('#frmCreactrlprov').serialize(),
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
                    $('#mhdnregIdinsp').val(this.cauditoriainspeccion);
                    
                    Vtitle = 'Inspección Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                    $('#btnBuscar').click();  
                    objPrincipal.liberarBoton(botonEvaluar);    
                });
            });
            return false;
        }
    });
    $('#frmRegInsp').validate({
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
            const botonEvaluar = $('#btnRegistrar');
            var request = $.ajax({
                url:$('#frmRegInsp').attr("action"),
                type:$('#frmRegInsp').attr("method"),
                data:$('#frmRegInsp').serialize(),
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
                    //$('#mhdnregIdinsp').val(this.cauditoriainspeccion);
                    
                    Vtitle = 'Inspección Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);   
                    objPrincipal.liberarBoton(botonEvaluar);    
                });
            });
            return false;
        }
    });
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};
	
$('#txtFDesde').on('change.datetimepicker',function(e){	
    
    $('#txtFHasta').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });	

    var fecha = moment(e.date).format('DD/MM/YYYY');		
    
    $('#txtFHasta').datetimepicker('minDate', fecha);
    $('#txtFHasta').datetimepicker('date', fecha);

});

$("#chkFreg").on("change", function () {
    if($("#chkFreg").is(":checked") == true){ 
        $("#txtFIni").prop("disabled",false);
        $("#txtFFin").prop("disabled",false);
        
        varfdesde = '';
        varfhasta = '';
    }else if($("#chkFreg").is(":checked") == false){ 
        $("#txtFIni").prop("disabled",true);
        $("#txtFFin").prop("disabled",true);
        
        varfdesde = '%';
        varfhasta = '%';
    }; 
});

$("#cboclieserv").change(function(){

    var select = document.getElementById("cboclieserv"), //El <select>
    value = select.value, //El valor seleccionado
    text = select.options[select.selectedIndex].innerText;
    document.querySelector('#lblCliente').innerText = text;

    var v_cboclieserv = $('#cboclieserv').val();
    var params = { "ccliente":v_cboclieserv };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboprovxclie",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboprovxclie").html(result);  
            $('#cboprovxclie').val('').trigger("change");         
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboprovxclie');
        }
    });   
    
    /*if(v_cboclieserv != 0){
        $("#btnNuevo").prop("disabled",false);
    }else{
        $("#btnNuevo").prop("disabled",true);
    }*/
});

$("#cboprovxclie").change(function(){

    var v_cboprov = $('#cboprovxclie').val();
    var params = { "cproveedor":v_cboprov };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbomaqxprov",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cbomaqxprov").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cbomaqxprov');
        }
    });    
});

$("#btnBuscar").click(function (){
    
    if(varfdesde != '%'){ varfdesde = $('#txtFDesde').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFHasta').val(); } 
     
    var groupColumn = 0;   
    otblListctrlprov = $('#tblListctrlprov').DataTable({  
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollY"     	: "540px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: false, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
		"dom": 'lfTrtip',
        'ajax'	: {
            "url"   : baseurl+"at/ctrlprov/cregctrolprov/getbuscarctrlprov/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = $('#cboclieserv').val();
                d.fdesde        = varfdesde; 
                d.fhasta        = varfhasta;   
                d.cclienteprov  = $('#cboprovxclie').val();
                d.cclientemaq   = $('#cbomaqxprov').val();
                d.inspector     = $('#cboinspector').val();  
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {data: 'desc_gral', targets: 0,"visible": false},
            {data: 'areacli', targets: 1,"visible": false},
            {data: 'lineaproc', targets: 2,"visible": false},
            {"orderable": false, "class": "col-xxs", 
              render:function(data, type, row){
                if(row.zctipoestadoservicio == '028'){
                    return  '<div class="dropdown" style="text-align: center;">'+
                            '<a  data-toggle="dropdown" href="#"><span class="fas fa-bars"></span></a>'+
                            '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">'+
                                '<li><a title="Programar" style="cursor:pointer; color:#3c763d;" onClick="javascript:fprogramar(\''+row.cauditoriainspeccion+'\',\''+row.desc_gral+'\',\''+row.areacli+'\',\''+row.lineaproc+'\',\''+row.cusuarioconsultor+'\',\''+row.periodo+'\',\''+row.finspeccion+'\',\''+row.zctipoestadoservicio+'\',\''+row.destado+'\',\''+row.ccliente+'\');"><span class="far fa-calendar-alt" aria-hidden="true">&nbsp;</span>&nbsp;Programar</a></li>'+
                                '<li><a data-toggle="modal" title="Covalidar" style="cursor:pointer; color:#3c763d;" data-target="#modalConvalidacion" ><span class="fas fa-file-signature" aria-hidden="true">&nbsp;</span>&nbsp;Convalidar</a></li>'+
                                '<li><a data-toggle="modal" title="Cierre" style="cursor:pointer; color:#3c763d;" data-target="#modalCierreespecial" onClick="javascript:fcierreespecial(\''+row.cauditoriainspeccion+'\',\''+row.desc_gral+'\',\''+row.areacli+'\',\''+row.lineaproc+'\',\''+row.finspeccion+'\',\''+row.zctipoestadoservicio+'\',\''+row.destado+'\',\''+row.ccliente+'\');"><span class="far fa-window-close" aria-hidden="true">&nbsp;</span>&nbsp;Cierres Especiales</a></li>'+
                            '</ul>'+
                        '</div>'  
                }else{
                    return '<div>'+
                        '</div>'
                }               
              }
            },
            {data: 'periodo', "class" : "col-s"},
            {data: 'destado', "class" : "col-sm"},
            {"orderable": false, "class": "col-s", 
              render:function(data, type, row){
                if(row.finspeccion == '01/01/1900'){
                    vfechaip = '';
                }else{
                    vfechaip = row.finspeccion;
                }
                return '<div>'+vfechaip+'</div>'
            }},
            {data: 'inspector', "class" : "col-xm"},
            {data: 'dinformefinal', "class" : "col-sm"},
            {data: 'resultado', "class" : "col-xm"},
            {data: 'espeligro'},
            {responsivePriority: 1, "orderable": false, "class" : "col-s", 
                render:function(data, type, row){
                    return '<div>'+
                    '<a title="Registro" style="cursor:pointer; color:#3c763d;" onClick="javascript:selInspe(\''+row.cauditoriainspeccion+'\',\''+row.desc_gral+'\',\''+row.areacli+'\',\''+row.lineaproc+'\',\''+row.cusuarioconsultor+'\',\''+row.periodo+'\',\''+row.finspeccion+'\',\''+row.cnorma+'\',\''+row.csubnorma+'\',\''+row.cchecklist+'\',\''+row.cmodeloinforme+'\',\''+row.cvalornoconformidad+'\',\''+row.cformulaevaluacion+'\',\''+row.ccriterioresultado+'\',\''+row.dcomentario+'\',\''+row.zctipoestadoservicio+'\',\''+row.destado+'\',\''+row.ccliente+'\');"><span class="fas fa-external-link-alt fa-2x" aria-hidden="true"> </span> </a>'+
                    '&nbsp;'+
                    '<a id="aDelCapa" href="'+row.id_capadet+'" title="Eliminar" style="cursor:pointer; color:#FF0000;"><span class="fas fa-trash-alt fa-2x" aria-hidden="true"> </span></a>'+      
                    '</div>'
                }
            }
        ],  
		"columnDefs": [
            { "targets": [0], "visible": false },
		],  
        "rowCallback":function(row,data){            
            /*if(data.espeligro == "S"){
                $(row).css("color","red");
            }*/
        },
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
			var grupo, grupo01;
 
            api.column([0], {} ).data().each( function ( ctra, i ) {                
                grupo = api.column(1).data()[i];
                grupo01 = api.column(2).data()[i];
                
                speligro = api.column(10).data()[i];
                if(speligro == "S"){
                    var varcolor = "#FF0000";
                }else{
                    var varcolor = "#000000";
                }
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="7" class="subgroup">'+ctra.toUpperCase()+'</td></tr>'+
                        '<tr class="group"><td colspan="3" class="expand">Area : '+grupo+'</td><td colspan="4" class="expand" style="color:'+varcolor+'">Linea : '+grupo01+'</td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        } 
    }); 
    otblListctrlprov.column( 1 ).visible( false );   
    otblListctrlprov.column( 2 ).visible( false );  
    otblListctrlprov.column( 10 ).visible( false ); 


});

$('#tblListctrlprov tbody').on( 'dblclick', 'tr.group', function () {    
    var rowsCollapse = $(this).nextUntil('.group');
    var id = $(this).find("td.subgroup:first-child").text().substr(1,8);

    verInspeccion(id);          
} ); 

$('#tblListctrlprov tbody').on( 'click', 'tr.group', function () {    
    var rowsCollapse = $(this).nextUntil('.group');    
    $(rowsCollapse).toggleClass('hidden');    
} ); 

$('#btn-show-all-children').on('click', function(){
        otblListctrlprov.rows().every(function(){
            var rowsCollapse = $('.group').nextUntil('.group'); 
            $(rowsCollapse).removeClass('hidden'); 
        });
});

$('#btn-hide-all-children').on('click', function(){
        otblListctrlprov.rows().every(function(){
            var rowsCollapse = $('.group').nextUntil('.group'); 
            $(rowsCollapse).removeClass('hidden');           
            $(rowsCollapse).toggleClass('hidden');
        });
});

$("#btnNuevo").click(function (){
    $("#modalCreactrlprov").modal('show');

    $('#frmCreactrlprov').trigger("reset");
    $('#mhdnAccionctrlprov').val('N');

    var vnfecha = new Date();
    var vnano = vnfecha. getFullYear();
    var vnmes = ('00'+vnfecha.getMonth());
    $('#mtxtregPeriodo').val(vnano+'-'+vnmes.substr(-2));

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
    });
    
});

$("#cboregClie").change(function(){
    var v_cboregClie = $('#cboregClie').val();
    var params = { "ccliente":v_cboregClie };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboprovxclie",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboregprovclie").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboregprovclie');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboareaclie",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboregareaclie").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboregareaclie');
        }
    });
});

$("#cboregprovclie").change(function(){

    var v_cboclie = $('#cboregClie').val();
    var v_cboprov = $('#cboregprovclie').val();

    var params = { "cproveedor":v_cboprov };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbomaqxprov",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboregmaquiprov").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboregmaquiprov');
        }
    }); 
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbocontacprinc",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cbocontacprinc").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cbocontacprinc');
        }
    });
    cboEstablecimiento(v_cboclie,v_cboprov,'','P'); 
    $('#mtxtregdirestable').val('');  
});

$("#cboregmaquiprov").change(function(){
    
    var v_cboclie = $('#cboregClie').val();
    var v_cboprov = $('#cboregprovclie').val();    
    var v_cbomaqui = $('#cboregmaquiprov').val();
    var v_tipo = 'M'

    if(v_cbomaqui == ''){
        v_tipo = 'P'
    }

    cboEstablecimiento(v_cboclie,v_cboprov,v_cbomaqui,v_tipo);  
    $('#mtxtregdirestable').val('');
});

$("#cboregestable").change(function(){
    var v_cboclie = $('#cboregClie').val();
    var v_cboestable = $('#cboregestable').val();

    var params = { 
        "cestablecimiento"  :   v_cboestable
    };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbolineaproc",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboreglineaproc").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboreglineaproc');
        }
    });

    var parametros = { 
        "cestablecimiento":v_cboestable
    };
    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getdirestable",
        dataType: "JSON",
        async: true,
        data: parametros,
        error: function(){
            alert('Error, No se puede autenticar por error = getdirestable');
        }
    });      
    request.done(function( respuesta ) {            
        $.each(respuesta, function() {
            $('#mtxtregdirestable').val(this.DIRESTABLE);   
        });
    });
});

$("#cbotipoestable").change(function(){

    var v_cbotipoestable= $('#cbotipoestable').val();

    var params = { "ctipoestable":v_cbotipoestable };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getmontotipoestable",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $('#txtcostoestable').val(result);         
        },
        error: function(){
            alert('Error, No se puede recuperar Monto del Costo');
        }
    });  
});

cboEstablecimiento = function(cboclie,cboprov,cbomaqui,vtipo){

    var params = { 
        "ccliente":cboclie, 
        "cproveedor":cboprov,
        "cmaquilador":cbomaqui,
        "tipo":vtipo

    };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboregestable",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboregestable").html(result);           
        },
        error: function(){
            alert('Error, No se puede autenticar por error = getcboregestable');
        }
    }); 
};

$('#mbtnCCreactrl').click(function(){  
    $('#btnBuscar').click();
});

iniInspe = function(cusuarioconsultor,consultsreg,cnorma,csubnorma,cchecklist,ccliente,cvalornoconformidad,cmodeloinforme,cformulaevaluacion,ccriterioresultado){
    var params = { "sregistro":consultsreg};
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspector",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result)
        {
            $('#cboinspinspector').html(result);
            $('#cboinspinspector').val(cusuarioconsultor).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspinspector');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbosistemaip",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboinspsistema').html(result);
            //$('#cboinspsistema').val(cnorma).trigger("change");
            document.getElementById("cboinspsistema").value = cnorma;
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspsistema');
        }
    });
    var paramsrubro = { "cnorma":cnorma};
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/ctrlprov/cregctrolprov/getcborubroip",
            dataType: "JSON",
            async: true,
            data: paramsrubro,
            success:function(result)
            {
                $('#cboinsprubro').html(result);
                document.getElementById("cboinsprubro").value = csubnorma;
            },
            error: function(){
                alert('Error, No se puede autenticar por error = cboinsprubro');
            }
        }); 
    
    
    var paramschecklist = { 
        "cnorma":cnorma,
        "csubnorma":csubnorma,
        "ccliente":ccliente,
    };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbochecklist",
        dataType: "JSON",
        async: true,
        data: paramschecklist,
        success:function(result)
        {
            $('#cboinspcchecklist').html(result);
            document.getElementById("cboinspcchecklist").value = cchecklist;
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspcchecklist');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbomodinforme",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboinspmodeloinfo').html(result);
            $('#cboinspmodeloinfo').val(cmodeloinforme).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspmodeloinfo');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspvalconf",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboinspvalconf').html(result);
            $('#cboinspvalconf').val(cvalornoconformidad).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspvalconf');
        }
    });
    var paramsform= { "cchecklist":cchecklist};
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspformula",
        dataType: "JSON",
        async: true,
        data: paramsform,
        success:function(result)
        {
            $('#cboinspformula').html(result);
            $('#cboinspformula').val(cformulaevaluacion).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspformula');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspcritresul",
        dataType: "JSON",
        async: true,
        success:function(result)
        {
            $('#cboinspcritresul').html(result);
            $('#cboinspcritresul').val(ccriterioresultado).trigger("change");
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspcritresul');
        }
    });
};

quitarFecha = function(){
    $('#txtFInsp').val('Sin Fecha');
};

$("#cboinspsistema").change(function(){
    var v_cnorma = $( "#cboinspsistema option:selected").attr("value");
    
    var paramsrubro = { "cnorma":v_cnorma};
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"at/ctrlprov/cregctrolprov/getcborubroip",
            dataType: "JSON",
            async: true,
            data: paramsrubro,
            success:function(result)
            {
                $('#cboinsprubro').html(result);
            },
            error: function(){
                alert('Error, No se puede autenticar por error = cboinsprubro');
            }
        });  
});

$("#cboinsprubro").change(function(){
    var v_csubnorma = $( "#cboinsprubro option:selected").attr("value");
    var v_cnorma = $('#cboinspsistema').val();
    var v_ccliente = $('#mhdnccliente').val();
    var paramschecklist = { 
        "cnorma":v_cnorma,
        "csubnorma":v_csubnorma,
        "ccliente":v_ccliente,
    };
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbochecklist",
        dataType: "JSON",
        async: true,
        data: paramschecklist,
        success:function(result)
        {
            $('#cboinspcchecklist').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspcchecklist');
        }
    });
});

$("#cboinspcchecklist").change(function(){
    var v_cchecklist = $( "#cboinspcchecklist option:selected").attr("value");
    var paramsform= { "cchecklist":v_cchecklist};
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcboinspformula",
        dataType: "JSON",
        async: true,
        data: paramsform,
        success:function(result)
        {
            $('#cboinspformula').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cboinspformula');
        }
    });
});

selInspe = function(cauditoriainspeccion,desc_gral,areacli,lineaproc,cusuarioconsultor,periodo,fservicio,cnorma,csubnorma,cchecklist,cmodeloinforme,cvalornoconformidad,cformulaevaluacion,ccriterioresultado,dcomentario,zctipoestadoservicio,destado,ccliente){
    $('#tabctrlprov a[href="#tabctrlprov-det"]').tab('show'); 
    
    $('#frmRegInsp').trigger("reset");

    $('#mtxtidinsp').val(cauditoriainspeccion); 
    $('#mfechainsp').val(fservicio);
    $('#mhdnAccioninsp').val('A');
    $('#mhdnccliente').val(ccliente);  

    iniInspe(cusuarioconsultor,'T',cnorma,csubnorma,cchecklist,ccliente,cvalornoconformidad,cmodeloinforme,cformulaevaluacion,ccriterioresultado);

    $('#mtxtinspdatos').val(desc_gral); 
    $('#mtxtinsparea').val('AREÁ : '+areacli); 
    $('#mtxtinsplinea').val('LINEA : '+lineaproc); 
    
    $('#cboinspperiodo').val(periodo);
    $('#mtxtinspcoment').val(dcomentario);
    $('#mhdnzctipoestado').val(zctipoestadoservicio);
    $('#txtinspestado').val(destado);
    
    $('#txtFInspeccion').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });
    if(fservicio == '01/01/1900'){        
        $('#txtFInsp').val('Sin Fecha');
    }else{
        $('#txtFInsp').val(fservicio);
    }

};
fechaActualinsp = function(fservicio){    
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear();
    $('#txtFInspeccion').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );    

};

fprogramar = function(cauditoriainspeccion,desc_gral,areacli,lineaproc,cusuarioconsultor,periodo,fservicio,zctipoestadoservicio,destado,ccliente){
    $('#tabctrlprov a[href="#tabctrlprov-det"]').tab('show'); 
    
    $('#frmRegInsp').trigger("reset");

    $('#mtxtidinsp').val(cauditoriainspeccion); 
    $('#mfechainsp').val(fservicio);
    $('#mhdnAccioninsp').val('A');
    $('#mhdnccliente').val(ccliente);  

    iniInspe(cusuarioconsultor,'T','','','',ccliente,'','','','');

    $('#mtxtinspdatos').val(desc_gral); 
    $('#mtxtinsparea').val('AREÁ : '+areacli); 
    $('#mtxtinsplinea').val('LINEA : '+lineaproc); 
    
    $('#cboinspperiodo').val(periodo);
    $('#mhdnzctipoestado').val(zctipoestadoservicio);
    $('#txtinspestado').val(destado);

    $('#swplaninsp').val('S').trigger("change");
    
    $('#txtFInspeccion').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });
    if(fservicio == '01/01/1900'){        
        $('#txtFInsp').val('Sin Fecha');
    }else{
        $('#txtFInsp').val(fservicio);
    }
    
    $('#mtxtHsalidaperm').datetimepicker({
        format: 'hh:mm A',
        locale:'es',
        stepping: 15
    });	
    $('#mtxtHsalidaperm').datetimepicker('minDate', moment('08:00 AM', 'hh:mm A') );
    $('#mtxtHsalidaperm').datetimepicker('maxDate', moment('05:45 PM', 'hh:mm A') );
    $('#mtxtHsalidaperm').datetimepicker('date', moment('08:00 AM', 'hh:mm A') );

    $('#Btnplan').show();
};


$('#modalCierreespecial').on('shown.bs.modal', function (e) { 
    $("#txtcierreidinsp").prop({readonly:true}); 
    $("#txtcierrefservicio").prop({readonly:true});
    
    $('#txtcierreFProgramado').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es',
        autoclose: true,
        todayBtn: true
    });

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getcbocierreTipo",
        dataType: "JSON",
        async: true,
        success:function(result){
            $("#cbocierreTipo").html(result); 
        },
        error: function(){
            alert('Error, No se puede autenticar por error = cbocierreTipo');
        }
    })
    
    
});
fcierreespecial = function(cauditoriainspeccion,desc_gral,areacli,lineaproc,fservicio,zctipoestadoservicio,destado,ccliente){
   
    $('#txtcierreidinsp').val(cauditoriainspeccion);
    $('#mhdnfservicio').val(fservicio);
    $('#mhdnAccioncierre').val('N');
    fechaActualcierre();
};
fechaActualcierre = function(fservicio){    
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear();
    $('#txtcierreFProg').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') ); 
    $('#txtcierrefservicio').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );    

};

$('#swplaninsp').on('switchChange.bootstrapSwitch',function (event, state) {
    if($('#swplaninsp').prop('checked')){
        $('#Btnplan').show(); 
    }else{
        $('#Btnplan').hide(); 
    }
    
});

$('#btnRetornarLista').click(function(){
    $('#tabctrlprov a[href="#tabctrlprov-list"]').tab('show');  
});

verInspeccion = function(id){
    $("#modalCreactrlprov").modal('show');

    var parametros = { 
        "idinspeccion":id 
    };
    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"at/ctrlprov/cregctrolprov/getrecuperainsp",
        dataType: "JSON",
        async: true,
        data: parametros,
        error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });      
    request.done(function( respuesta ) {            
        $.each(respuesta, function() {
            var $idtipoproducto = this.id_tipoproducto;  
            var $idsiparticula = this.id_siparticula;  

            $('#txtNombprodReg06').val(this.nombre_producto);
            $('#txtPHmatprimaReg06').val(this.ph_materia_prima);
            $('#txtPHprodfinReg06').val(this.ph_producto_final);

            $('#cbollevapartReg06').val(this.particulas).trigger("change");
            
            
        });
    });
};

cargarInspeccion = function(id, idclie, idprov, idmaq, idestable, idarea, idlinea){
    var params = { 
        "idptregestudio":v_RegEstu 
    };

    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/getTipoproducto",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboTipoprodReg06").html(result);
            $('#cboTipoprodReg06').val($idtipoproducto).trigger("change");  
        },
        error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    });
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"pt/cinforme/getParticulas",
        dataType: "JSON",
        async: true,
        data: params,
        success:function(result){
            $("#cboParticulasReg06").html(result); 
            $('#cboParticulasReg06').val($idsiparticula).trigger("change"); 
        },
        error: function(){
            alert('Error, no se puede cargar la lista desplegable de establecimiento');
        }
    })
};