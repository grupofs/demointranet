var otblListServiciolab, otblListResultados;
var varfdesde = '%', varfhasta = '%';


$(document).ready(function() {
    $('#tablab a[href="#tablab-list-tab"]').attr('class', 'disabled');
    $('#tablab a[href="#tablab-reg-tab"]').attr('class', 'disabled active');

    $('#tablab a[href="#tablab-list-tab"]').not('#store-tab.disabled').click(function(event){
        $('#tablab a[href="#tablab-list"]').attr('class', 'active');
        $('#tablab a[href="#tablab-reg"]').attr('class', '');
        return true;
    });
    $('#tablab a[href="#tablab-reg-tab"]').not('#bank-tab.disabled').click(function(event){
        $('#tablab a[href="#tablab-reg"]').attr('class' ,'active');
        $('#tablab a[href="#tablab-list"]').attr('class', '');
        return true;
    });
    
    $('#tablab a[href="#tablab-list"]').click(function(event){return false;});
    $('#tablab a[href="#tablab-reg"]').click(function(event){return false;});

    $('#txtFDesde,#txtFHasta,#mtxtFRecep').datetimepicker({
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [0],
        locale:'es'
    });

    fechaAnioActual();
    $('#chkFreg').prop("checked", true);
    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/coti/ccotizacion/getcboclieserv",
        dataType: "JSON",
        async: true,
        success:function(result){
            $('#cboclieserv').html(result);
        },
        error: function(){
            alert('Error, No se puede autenticar por error');
        }
    });

    /*$('#frmRecepcion').validate({
        rules: {
            mtxtmproductoreal: {
                required: true,
            },
        },
        messages: {
            mtxtmproductoreal: {
                required: "Por Favor ingrese Nombre del Producto"
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
            var request = $.ajax({
                url:$('#frmRecepcion').attr("action"),
                type:$('#frmRecepcion').attr("method"),
                data:$('#frmRecepcion').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {
                    otblListProducto.ajax.reload(null,false);
                    Vtitle = 'La Recepcion esta Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype); 
                    $('#mbtnCCreaProduc').click();    
                });
            });
            return false;
        }
    });*/
});

fechaActual = function(){
    var fecha = new Date();		
    var fechatring = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring, 'DD/MM/YYYY') );

};

fechaAnioActual = function(){
    $("#txtFIni").prop("disabled",false);
    $("#txtFFin").prop("disabled",false);
        
    varfdesde = '';
    varfhasta = '';
    
    var fecha = new Date();		
    var fechatring1 = "01/01/" + (fecha.getFullYear() - 1) ;
    var fechatring2 = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;

    $('#txtFDesde').datetimepicker('date', moment(fechatring1, 'DD/MM/YYYY') );
    $('#txtFHasta').datetimepicker('date', moment(fechatring2, 'DD/MM/YYYY') );
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

        
        var fecha = new Date();		
        var fechatring1 = "01/01/" + (fecha.getFullYear() - 1) ;
        var fechatring2 = ("0" + fecha.getDate()).slice(-2) + "/" + ("0"+(fecha.getMonth()+1)).slice(-2) + "/" +fecha.getFullYear() ;
        $('#txtFDesde').datetimepicker('date', fechatring1);
        $('#txtFHasta').datetimepicker('date', fechatring2);

    }else if($("#chkFreg").is(":checked") == false){ 
        $("#txtFIni").prop("disabled",true);
        $("#txtFFin").prop("disabled",true);
        
        varfdesde = '%';
        varfhasta = '%';

        fechaActual();
    }; 
});

$("#btnBuscar").click(function (){
    parametros = paramListarBusqueda();
    getListarBusqueda(parametros);
});

paramListarBusqueda = function (){    
    var v_mes, v_anio

    if(varfdesde != '%'){ varfdesde = $('#txtFIni').val(); }
    if(varfhasta != '%'){ varfhasta = $('#txtFFin').val(); } 
     
    var parametros = {
        "ccliente"      : $('#cboclieserv').val(),
        "buspor"        : $('#cbobuspor').val(), 
        "numero"        : $('#txtbuscarnro').val(), 
        "fini"          : varfdesde, 
        "ffin"          : varfhasta,   
        //"descripcion"   : $('#txtdescri').val(), 
        //"ensayo"        : $('#txtensayo').val(), 
        //"areaserv"      : $('#cboareaserv').val(),
    };  

    return parametros;
    
};

getListarBusqueda = function(){    
    var groupColumn = 0;   

    otblListServiciolab = $('#tblListServiciolab').DataTable({ 
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
        "ajax"	: {
            "url"   : baseurl+"lab/resultados/cregresult/getbuscaringresoresult",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''      
        }, 
        'columns'	: [
            {data: 'BLANCO', "className":"col-xxs"},
            {data: 'cinternoordenservicio'},
            {data: 'DCLIENTE'},
            {data: 'COTIZACION'},
            {data: 'ORDENTRABAJO'},
            {data: 'NOMPROD', "className":"col-m"},
            {data: 'NROMUESTRA'},
            {data: 'LOCAL'},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var tableRows = api.rows( {page:'current'} ).nodes();

            var lastGroup = null;
            var lastSub = null;
            var lastSub01 = null;

            var groupName = null;
            var mySubGroup = null;
            var mySubGroup01 = null;
            var mySubGroup02 = null;

            api.column([0], {} ).data().each( function ( ctra, i ) {
                groupName = api.column(2).data()[i];

                mySubGroup = api.column(3).data()[i];
                mySubGroup01 = api.column(4).data()[i];
                mySubGroup02 = api.column(1).data()[i];

                if ( lastGroup !== groupName ) {
                    $(tableRows).eq( i ).before(
                        '<tr class="group"><td colspan="8">'+groupName.toUpperCase()+'</td></tr>'
                    ); 
                    lastGroup = groupName;
                 }

                if (lastSub !== mySubGroup) {
                    $(tableRows).eq( i ).before(
                        '<tr class="subgroup"><td class="groupCoti">'+mySubGroup02.toUpperCase()+'</td><td colspan="2">Cotización: '+mySubGroup.toUpperCase()+'</td><td>OT: '+mySubGroup01.toUpperCase()+'</td></tr>'
                    ); 
                    lastSub = mySubGroup;
                }
            } );
        }   
    }); 
    otblListServiciolab.column(1).visible( false ); 
    otblListServiciolab.column(2).visible( false ); 
    otblListServiciolab.column(3).visible( false );  
    otblListServiciolab.column(4).visible( false );  

    $("#btnexcel").prop("disabled",false);  
};

$('#tblListServiciolab tbody').on( 'dblclick', 'tr.subgroup', function () {     
    var id = $(this).find("td.groupCoti:first-child").text().substr(0,8);
    $('#tablab a[href="#tablab-reg"]').tab('show');
    verResultados(id);
} ); 

verResultados = function(id){
    var parametros = { 
        "cinternoordenservicio":id 
    };
    var request = $.ajax({
        type: 'ajax',
        method: 'post',
        url: baseurl+"lab/resultados/cregresult/getrecuperaservicio",
        dataType: "JSON",
        async: true,
        data: parametros,
        error: function(){
            alert('Error, no se puede cargar el servicio');
        }
    });      
    request.done(function( respuesta ) {            
        $.each(respuesta, function() { 

            $('#txtcliente').val(this.drazonsocial);
            $('#mtxtFanali').val(this.fanalisis);
            $('#mtxtHanali').val(this.hanalisis);
            $('#txtcotizacion').val(this.dcotizacion);
            $('#txtfcotizacion').val(this.fcotizacion);  
            $('#txtnroot').val(this.nordenservicio);  
            $('#txtfot').val(this.fordenservicio);  
            $('#txtidcotizacion').val(this.cinternocotizacion);  
            $('#txtnroversion').val(this.nversioncotizacion);  
            $('#txtidordenservicio').val(this.cinternoordenservicio);            
            
        });
    });
    getListResultados(id);
};


getListResultados = function(id){         
    var parametros = {
        "cinternoordenservicio" : id,
    };  

    otblListResultados = $('#tblListResultados').DataTable({ 
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
        "ajax"	: {
            "url"   : baseurl+"lab/resultados/cregresult/getlistresultados",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''      
        }, 
        'columns'	: [
            {data: 'BLANCO', "className":"col-xxs"},
            {data: 'tipoensayo'},
            {data: 'codmuestra'},
            {data: 'drealproducto'},
            {data: 'censayofs', "className":"col-s"},
            {data: 'densayo', "className":"col-m"},
            {data: 'unidadmedida', "className":"col-s"},
            {data: 'despecificacion', "className":"col-sm"},
            {data: 'dresultado', "className":"col-sm"},
            {data: 'sresultado', "className":"col-s"},
            {data: 'dinfensayo'},
            {data: 'BLANCO'},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var tableRows = api.rows( {page:'current'} ).nodes();

            var lastGroup = null;

            var groupName = null;
            var groupName01 = null;
            var groupName02 = null;

            api.column([0], {} ).data().each( function ( ctra, i ) {
                groupName = api.column(2).data()[i];
                groupName01 = api.column(3).data()[i];
                groupName02 = api.column(10).data()[i];

                if ( lastGroup !== groupName ) {
                    $(tableRows).eq( i ).before(
                        '<tr class="group"><td class="groupOt" colspan="2">'+groupName.toUpperCase()+'</td><td colspan="3">'+groupName01.toUpperCase()+'</td><td colspan="2">'+groupName02.toUpperCase()+'</td></tr>'
                    ); 
                    lastGroup = groupName;
                 }

            } );
        }   
    }); 
    otblListResultados.column(2).visible( false ); 
    otblListResultados.column(3).visible( false ); 
    otblListResultados.column(10).visible( false ); 
    // Enumeracion 
    otblListResultados.on( 'order.dt search.dt', function () { 
        otblListResultados.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();    
};

$('#btnRetornarLista').click(function(){
    $('#tablab a[href="#tablab-list"]').tab('show');  
});

$('#tblListResultados tbody').on( 'dblclick', 'tr.group', function () {     
    var idmuestra = $(this).find("td.groupOt:first-child").text().substr(0,3);
    var idot = $('#txtidordenservicio').val();
    window.open(baseurl+"lab/resultados/cregresult/pdfInformeMuestra/"+idot+"/"+idmuestra);
    
} ); 
