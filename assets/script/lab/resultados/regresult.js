var otblListServiciolab, otblListResultados;
var varfdesde = '%', varfhasta = '%';
var collapsedGroupsEq = {},collapsedGroupsEq1 = {},collapsedGroupsEq2 = {};


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

    
    $('#frmIngresult').validate({
        rules: {
            mcboum: {
            required: true,
          },
        },
        messages: {
            mcboum: {
            required: "Por Favor escoja una UM"
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
            const botonEvaluar = $('#mbtnGIngresult');
            var request = $.ajax({
                url:$('#frmIngresult').attr("action"),
                type:$('#frmIngresult').attr("method"),
                data:$('#frmIngresult').serialize(),
                error: function(){
                    Vtitle = 'Error en Guardar!!!';
                    Vtype = 'error';
                    sweetalert(Vtitle,Vtype); 
                },
                beforeSend: function() {
                    objPrincipal.botonCargando(botonEvaluar);
                }
            });
            request.done(function( respuesta ) {
                var posts = JSON.parse(respuesta);
                
                $.each(posts, function() {                    
                    
                    Vtitle = 'Cotizacion Guardada!!!';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);   
                    objPrincipal.liberarBoton(botonEvaluar); 
                    
                    getListResultados(this.cinternoordenservicio);

                    $('#mbtnCIngresult').click();
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

    otblListServiciolab = $('#tblListServiciolab').DataTable({ 
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
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
            "url"   : baseurl+"lab/resultados/cregresult/getbuscaringresoresult",
            "type"  : "POST", 
            "data"  : parametros,     
            dataSrc : ''      
        }, 
        'columns'	: [
            {data: 'DCLIENTE'},
            {data: 'cinternoordenservicio'},
            {data: 'NROCOTI'},
            {data: 'ELABORADOPOR'},
            {data: 'NORDENTRABAJO'},
            {data: 'BLANCO', "className":"col-xxs"},
            {data: 'CODMUESTRA'},
            {data: 'REALPRODUCTO'},
            {data: 'BLANCO', "className":"col-xxs"},
            {data: 'TIPOENSAYO'},
            {data: 'CODENSAYO'},
            {data: 'ENSAYO'},
            {data: 'BLANCO'},
            {data: 'BLANCO'},
            {data: 'BLANCO', "className":"col-xxs"},
        ],
        rowGroup: {
            startRender : function ( rows, group, level ) {
                
                if ( level == 0 ) {
                    var varcclie = rows
                        .data()
                        .reduce( function (a, b) {
                            return b.ccliente;
                        }, 0) ; 

                    var collapsed = !!collapsedGroupsEq[varcclie];
        
                    rows.nodes().each(function (r) {
                        r.style.display = collapsed ? 'none' : '';
                    });   
              
                    
                    return $('<tr/>')
                    .append('<td colspan="8" style="cursor: pointer;">' + group + '</td>')
                    .attr('data-name', varcclie)
                    .toggleClass('collapsed', collapsed);

                } else if ( level == 1 ){
                    var varid = rows
                        .data()
                        .reduce( function (a, b) {
                            return b.cinternoordenservicio;
                        }, 0) ;

                    var collapsed = !!collapsedGroupsEq1[varid];
        
                    rows.nodes().each(function (r) {
                        r.style.display = collapsed ? 'none' : '';
                    }); 


                    return $('<tr/>')
                    .append('<td colspan="5" style="cursor: pointer;">' + group + '</td><td></td><td></td><td></td>')
                    .attr('data-name', varid)
                    .toggleClass('collapsed', collapsed);
                    
                } else if ( level == 2 ){
                    var varcod = rows
                        .data()
                        .reduce( function (a, b) {
                            return b.cinternoordenservicio+b.CODMUESTRA;
                        }, 0) ;

                    var collapsed = !!collapsedGroupsEq2[varcod];
        
                    rows.nodes().each(function (r) {
                        r.style.display = collapsed ? 'none' : '';
                    }); 
                    
                    return $('<tr/>')
                    .append('<td></td><td colspan="4" style="cursor: pointer;">' + group.toUpperCase() + '</td><td></td><td></td><td></td>')
                    .attr('data-name', varcod)
                    .toggleClass('collapsed', collapsed);
                }
                 
            },
            dataSrc: ["DCLIENTE","NROCOTI","REALPRODUCTO"]
        },
    }); 
    otblListServiciolab.column(0).visible( false ); 
    otblListServiciolab.column(1).visible( false ); 
    otblListServiciolab.column(2).visible( false ); 
    otblListServiciolab.column(3).visible( false );
    otblListServiciolab.column(4).visible( false );  
    otblListServiciolab.column(6).visible( false );  
    otblListServiciolab.column(7).visible( false );  
    otblListServiciolab.column(12).visible( true ); 
    otblListServiciolab.column(14).visible( true );  

    $("#btnexcel").prop("disabled",false);  
};

/* COMPRIMIR GRUPO 
$('#tblListServiciolab tbody').on('click', 'tr.dtrg-level-0', function () {      
    var name = $(this).data('name');
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblListServiciolab.draw(true);
});
$('#tblListServiciolab tbody').on('click', 'tr.dtrg-level-1', function () {    
    var name = $(this).data('name');
    collapsedGroupsEq1[name] = !collapsedGroupsEq1[name];
    otblListServiciolab.draw(true);
}); */
$('#tblListServiciolab tbody').on('click', 'tr.dtrg-level-2', function () {    
    var name = $(this).data('name');
    collapsedGroupsEq2[name] = !collapsedGroupsEq2[name];
    otblListServiciolab.draw(true);
}); 

$('#tblListServiciolab tbody').on('dblclick', 'tr.dtrg-level-1', function () {
    var id = $(this).data('name');
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

    var groupColumn = 0;
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
        "filter"      	: true, 
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
            {data: 'censayofs'},
            {data: 'densayo'},
            {data: 'unidadmedida'},
            {data: 'ESPECIFICACION'},
            {data: 'RESULTADO'},
            {data: 'sresultado'},
            {data: 'dinfensayo'},
            {data: 'BLANCO'},
        ],
        "drawCallback": function ( settings ) {      
            var api = this.api();
            var tableRows = api.rows( {page:'current'} ).nodes();

            var lastGroup = null;

            var groupName = null;
            var groupName01 = null;

            api.column([0], {} ).data().each( function ( ctra, i ) {
                groupName = api.column(2).data()[i];
                groupName01 = api.column(3).data()[i];

                if ( lastGroup !== groupName ) {
                    $(tableRows).eq( i ).before(
                        '<tr class="group"> <td> </td> <td>'+groupName.toUpperCase()+'</td> <td colspan="7">'+groupName01.toUpperCase()+'</td> </tr>'
                    ); 
                    lastGroup = groupName;
                 }

            } );
        }   
    }); 
    otblListResultados.column(2).visible(false); 
    otblListResultados.column(3).visible(false); 
    otblListResultados.column(10).visible(false); 
    // Enumeracion 
    otblListResultados.on( 'order.dt search.dt', function () { 
        otblListResultados.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();    
};

$('#tblListResultados tbody').on('dblclick', 'td', function () {
    var tr = $(this).parents('tr');
    var row = otblListResultados.row(tr);
    var rowData = row.data();

    if(rowData.cinternoordenservicio){
        $("#modalIngresult").modal('show');
        $('#frmIngresult').trigger("reset");        

        $('#mhdncinternoordenservicio').val(rowData.cinternoordenservicio);
        $('#mhdncinternocotizacion').val(rowData.cinternocotizacion);
        $('#mhdnnversioncotizacion').val(rowData.nversioncotizacion);
        $('#mhdnnordenproducto').val(rowData.nordenproducto);
        $('#mhdncmuestra').val(rowData.cmuestra);
        $('#mhdncensayo').val(rowData.censayo);
        $('#mhdnnviausado').val(rowData.nviausado);

        document.querySelector('#nomtipoensayo').innerText = rowData.tipoensayo;
        document.querySelector('#muestra').innerText = rowData.codmuestra+' '+rowData.drealproducto;

        $('#mtxtcodensayo').val(rowData.censayofs);
        $('#mtxtnomensayo').val(rowData.densayo);
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"lab/resultados/cregresult/getcboum",
            dataType: "JSON",
            async: true,
            success:function(result){
                $('#mcboum').html(result);
                $('#mcboum').val(rowData.zctipounidadmedida).trigger("change");
            },
            error: function(){
                alert('Error, No se puede autenticar por error cboum');
            }
        });
        
        if(rowData.condi_espe == 'Ausencia'){
            ausencia();  
        }else if(rowData.condi_espe == '='){     
            igual(); 
        }else if(rowData.condi_espe == '<'){     
            mayor(); 
        }else if(rowData.condi_espe == '>'){     
            menor(); 
        }else if(rowData.condi_espe == '<='){     
            mayorigual(); 
        }else if(rowData.condi_espe == '>='){     
            menorigual(); 
        }

        $('#mtxtvalor_esp').val(rowData.valor_espe);
        $('#mcbosexponente_esp').val(rowData.esexpo_espe).trigger("change");
        $('#mtxtvalorexpo_esp').val(rowData.valexpo_espe);
        
        if(rowData.condi_resul == 'Ausencia'){
            ausencia_resul();  
        }else if(rowData.condi_resul == '='){     
            igual_resul(); 
        }else if(rowData.condi_resul == '<'){     
            mayor_resul(); 
        }else if(rowData.condi_resul == '>'){     
            menor_resul(); 
        }else if(rowData.condi_resul == '<='){     
            mayorigual_resul(); 
        }else if(rowData.condi_resul == '>='){     
            menorigual_resul(); 
        }
        
        $('#mtxtvalor_resul').val(rowData.valor_resul);
        $('#mcbosexponente_resul').val(rowData.esexpo_resul).trigger("change");
        $('#mtxtvalorexpo_resul').val(rowData.valexpo_resul);
        $('#mcboresultado').val(rowData.sresultado).trigger("change");
    }else{
        alert('ok');
    }
    
    

    //$('#mhdnidempleado').val(rowData.cinternoordenservicio);
});

ausencia=function(){
    $('#btncondi').html("Ausencia");
    $('#mhdncondi').val("Ausencia");
};
igual=function(){
    $('#btncondi').html("=");
    $('#mhdncondi').val("=");
};
mayor=function(){
    $('#btncondi').html("<");
    $('#mhdncondi').val("<");
};
menor=function(){
    $('#btncondi').html(">");
    $('#mhdncondi_').val(">");
};
mayorigual=function(){
    $('#btncondi').html("<=");
    $('#mhdncondi').val("<=");
};
menorigual=function(){
    $('#btncondi').html(">=");
    $('#mhdncondi').val(">=");
};

ausencia_resul=function(){
    $('#btncondi_resul').html("Ausencia");
    $('#mhdncondi_res').val("Ausencia");
};
igual_resul=function(){
    $('#btncondi_resul').html("=");
    $('#mhdncondi_res').val("=");
};
mayor_resul=function(){
    $('#btncondi_resul').html("<");
    $('#mhdncondi_res').val("<");
};
menor_resul=function(){
    $('#btncondi_resul').html(">");
    $('#mhdncondi_res').val(">");
};
mayorigual_resul=function(){
    $('#btncondi_resul').html("<=");
    $('#mhdncondi_res').val("<=");
};
menorigual_resul=function(){
    $('#btncondi_resul').html(">=");
    $('#mhdncondi_res').val(">=");
};

$('#modalIngresult').on('show.bs.modal', function (e) {

    

});

$('#btnRetornarLista').click(function(){
    $('#tablab a[href="#tablab-list"]').tab('show');  
});
/*
$('#tblListResultados tbody').on( 'dblclick', 'tr.group', function () {     
    var idmuestra = $(this).find("td.groupOt:first-child").text().substr(0,3);
    var idot = $('#txtidordenservicio').val();
    window.open(baseurl+"lab/resultados/cregresult/pdfInformeMuestra/"+idot+"/"+idmuestra);
    
} ); 
*/