
var oTable_listamodulo, oTable_listaopcion, oTable_listarol, oTable_listaperm;
var oTable_listaOpcmod;
var collapsedGroupsmod = {};

$(document).ready(function () {
    
});


/*MODULOS*/
    listarModulos = function(){
        var groupColumn = 1; 
        oTable_listamodulo = $('#tablalistaModulos').DataTable({  
            "processing"  	: true,
            "bDestroy"    	: true,
            "stateSave"     : true,
            "bJQueryUI"     : true,
            "scrollY"     	: "365px",
            "scrollX"     	: true, 
            'AutoWidth'     : false,
            "paging"      	: false,
            "info"        	: false,
            "filter"      	: true, 
            "ordering"		: false,
            "responsive"    : false,
            "select"        : true,  
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getlistarmodulos/",
                "type"  : "POST", 
                "data"  : function (d) {  
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {data : null, "class": "col-xxs dtrg"},
                {data: 'CIA'},
                {data: 'AREA', "class": "dtrg"},
                {data: 'id_modulo', "class": "dtrg"},
                {data: 'desc_modulo', "class": "dtrg"},
            ],
            "columnDefs": [{
                "targets": [4], 
                "data": null, 
                "render": function(data, type, row) { 
                    return '<p><i class="'+row.class_icono+'">&nbsp;</i>&nbsp;'+row.desc_modulo+'<p>';
                }
            }],
            rowGroup: {
                startRender : function ( rows, group ) {
                    var collapsed = !!collapsedGroupsmod[group];
        
                    rows.nodes().each(function (r) {
                        r.style.display = collapsed ? 'none' : '';
                    }); 
                    return $('<tr/>')
                    .append('<td colspan="5" style="cursor: pointer;">' + group + ' (' + rows.count() + ')</td>')
                    .attr('data-name', group)
                    .toggleClass('collapsed', collapsed);
                },
                dataSrc: "CIA"
            },
        });
        // Enumeracion 
        oTable_listamodulo.on( 'order.dt search.dt', function () { 
            oTable_listamodulo.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw();  
        
        oTable_listamodulo.column(1).visible( false );  
    };
    /* COMPRIMIR GRUPO */
    $('#tablalistaModulos tbody').on('click', 'tr.dtrg-group', function () {
        var name = $(this).data('name');
        collapsedGroupsmod[name] = !collapsedGroupsmod[name];
        oTable_listamodulo.draw(true);
    }); 

    $('#tablalistaModulos tbody').on('click', 'td.dtrg', function () {
        var tr = $(this).parents('tr');
        var row = oTable_listamodulo.row(tr);
        var rowData = row.data();

        const divEvaluar = $('#divModelo');
        objPrincipal.divCargando(divEvaluar);
        
        $('#mhdnIdmodulo').val(rowData.id_modulo);   
        $('#cboCia').val(rowData.ccompania);     
        $('#mtxtDescrMod').val(rowData.desc_modulo);    
        $('#cbotipo').val(rowData.tipo_modulo);
        $('#mtxticono').val(rowData.class_icono);  

        cambiarCboAreaCia(rowData.ccompania,rowData.carea);    

        $('#mhdnAccionMod').val('A');

        objPrincipal.liberarDiv(divEvaluar); 
    });

    $('#collapseModulo').on('show.bs.collapse', function () {
        listarModulos();
    });

    $('#cboCia').change(function(){ 
        var v_idcia = $( "#cboCia option:selected").attr("value");
        var v_idarea = "0";        
        
        cambiarCboAreaCia(v_idcia,v_idarea);
    });

    cambiarCboAreaCia = function(v_idcia,v_idarea){
        var params = { "ccia" : v_idcia};
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"cglobales/getareacia",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $('#mcboArea').html(result);
                $("#mcboArea").val(v_idarea).trigger("change");   
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
    };

    $('#frmRegModulo').submit(function(event){
        event.preventDefault();
        const botonEvaluar = $('#btnGrabarMod');
        $.ajax({
			beforeSend: function() {
                objPrincipal.botonCargando(botonEvaluar);
            },
            url:$('#frmRegModulo').attr("action"),
            type:$('#frmRegModulo').attr("method"),
            data:$('#frmRegModulo').serialize(),
            success: function (respuesta){            
                oTable_listamodulo.ajax.reload(null,false);
                objPrincipal.liberarBoton(botonEvaluar); 
                Vtitle = 'Se Grabo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);
                $('#btnNuevoMod').click(); 
            },
            error: function(){
                objPrincipal.liberarBoton(botonEvaluar);
                Vtitle = 'No se puede Grabar por error';
                Vtype = 'error';
                sweetalert(Vtitle,Vtype); 
            }
        });
    });

    $('#btnNuevoMod').click(function(){
        $('#frmRegModulo').trigger("reset");
        $('#mhdnIdmodulo').val(''); 
        $('#mhdnAccionMod').val('N');
        $('#cboCia').val('0').change();
    });

/*OPCIONES*/
    listarOpciones = function(){        
        oTable_listaopcion = $('#tablalistaOpcion').DataTable({
            'bJQueryUI'     : true,
            'scrollY'     	: '280px',
            'scrollX'     	: true, 
            'paging'      	: true,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: true,
            'filter'      	: true, 
            "ordering"		: false,  
            'stateSave'     : true, 
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getlistaropciones/",
                "type"  : "POST", 
                "data": function ( d ) {  
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {
                "class"     :   "index",
                orderable   :   false,
                data        :   null,
                targets     :   0
                },
                {data: 'CIA', targets: 1},
                {data: 'desc_modulo', targets: 2},
                {data: 'id_opcion',targets: 3 },
                {data: 'desc_opcion', targets: 4},                          
                {"orderable": false, 
                    render:function(data, type, row){
                        return '<div>' +
                                '<a title="Editar" style="cursor:pointer; color:#3c763d;" onclick="javascript:seleOpcion(\''+row.id_opcion+'\',\''+row.id_modulo+'\',\''+row.desc_opcion+'\',\''+row.ccompania+'\',\''+row.vista_opcion+'\',\''+row.script_opcion+'\');"><span class="fas fa-edit" aria-hidden="true"> </span> </a>' +
                                '</div>' ; 
                    }
                }
            ],         
        });
        // Enumeracion 
        oTable_listaopcion.on( 'order.dt search.dt', function () { 
            oTable_listaopcion.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw();  
    };

    $('#collapseOpcion').on('show.bs.collapse', function () {
        listarOpciones();
    });

    iniModulo = function(ccompania,id_modulo){
        var params = { "ccia" : ccompania};
        
        $('#cboCiaopc').val(ccompania).trigger("change");

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/getmoduloxcia",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $('#cboModulo').html(result);
                $("#cboModulo").val(id_modulo).trigger("change");   
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
    };

    $('#cboCiaopc').change(function(){ 
        var v_idcia = $( "#cboCiaopc option:selected").attr("value");
               
        if ($('#mhdnAccionOpc').val() == 'N'){
            var params = { "ccia" : v_idcia};

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"adm/ti/csistemas/getmoduloxcia",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $('#cboModulo').html(result); 
                },
                error: function(){
                alert('Error, No se puede autenticar por error');
                }
            }); 
        };
        
    });

    seleOpcion = function(id_opcion,id_modulo,desc_opcion,ccompania,vista_opcion,script_opcion){
        $('#frmRegOpcion').trigger("reset");
        $('#mhdnAccionOpc').val('A');  
 
        $('#mhdnIdopcion').val(id_opcion);               
        $('#mtxtDescOpc').val(desc_opcion);        
        $('#mtxtVentana').val(vista_opcion);     
        $('#mtxtJavascript').val(script_opcion);

        iniModulo(ccompania,id_modulo);
        
    };

    $('#frmRegOpcion').submit(function(event){
        event.preventDefault();

        $.ajax({
            url:$('#frmRegOpcion').attr("action"),
            type:$('#frmRegOpcion').attr("method"),
            data:$('#frmRegOpcion').serialize(),
            success: function (respuesta){
                oTable_listaopcion.ajax.reload(null,false);
                Vtitle = 'Se Grabo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);  
                $('#btnNuevoOpc').click(); 
            },
            error: function(){          
                Vtitle = 'No se puede Grabar por error';
                Vtype = 'error';
                sweetalert(Vtitle,Vtype); 
            }
        });
    });

    $('#btnNuevoOpc').click(function(){
        $('#frmRegOpcion').trigger("reset");
        $('#mhdnAccionOpc').val('N'); 

        $('#mhdnIdopcion').val('');
        $('#cboCiaopc').val('0').change();
        $('#cboModulo').val('').change();

        iniModulo("0","0");
    });

/*ROLES*/
    listarRol = function(){        
        oTable_listarol = $('#tablalistaRol').DataTable({
            'bJQueryUI'     : true,
            'scrollY'     	: '280px',
            'scrollX'     	: true, 
            'paging'      	: true,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: true,
            'filter'      	: true, 
            "ordering"		: false,  
            'stateSave'     : true, 
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getlistarroles/",
                "type"  : "POST", 
                "data": function ( d ) {  
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {
                "class"     :   "index",
                orderable   :   false,
                data        :   null,
                targets     :   0
                },
                {data: 'CIA', targets: 1},
                {data: 'id_rol', targets: 2},  
                {data: 'desc_rol', targets: 3},  
                {data: 'desc_opcion', targets: 4},                        
                {"orderable": false, 
                    render:function(data, type, row){
                        return '<div>' +
                                '<a title="Editar" style="cursor:pointer; color:#3c763d;" onclick="javascript:seleRol(\''+row.id_rol+'\',\''+row.desc_rol+'\',\''+row.ccompania+'\',\''+row.id_home+'\',\''+row.comentarios+'\');"><span class="fas fa-edit" aria-hidden="true"> </span> </a>' +
                                '</div>' ; 
                    }
                }
            ],         
        });
        // Enumeracion 
        oTable_listarol.on( 'order.dt search.dt', function () { 
            oTable_listarol.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw();  
    };

    $('#collapseRol').on('show.bs.collapse', function () {
        listarRol();
    });

    iniRol = function(ccompania,id_home){
        var params = { "ccia" : ccompania};
        
        $('#cboCiarol').val(ccompania).trigger("change");

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/gethomexcia",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $('#cboHome').html(result);
                $("#cboHome").val(id_home).trigger("change");   
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
    };

    seleRol = function(id_rol,desc_rol,ccompania,id_home,comentarios){
        $('#mhdnIdrol').val(id_rol);
        $('#mhdnAccionRol').val('A');                                     
        $('#mtxtDescRol').val(desc_rol);        
        $('#mtxtComentario').val(comentarios);  
        iniRol(ccompania,id_home);  
        
    };

    $('#frmRegRol').submit(function(event){
        event.preventDefault();

        $.ajax({
            url:$('#frmRegRol').attr("action"),
            type:$('#frmRegRol').attr("method"),
            data:$('#frmRegRol').serialize(),
            success: function (respuesta){
                oTable_listarol.ajax.reload(null,false);
                Vtitle = 'Se Grabo Correctamente';
                Vtype = 'success';
                sweetalert(Vtitle,Vtype);  
                $('#btnNuevoRol').click(); 
            },
            error: function(){          
                Vtitle = 'No se puede Grabar por error';
                Vtype = 'error';
                sweetalert(Vtitle,Vtype); 
            }
        });
    });

    $('#btnNuevoRol').click(function(){
        $('#frmRegRol').trigger("reset");
        $('#mhdnIdrol').val('');
        $('#mhdnAccionRol').val('N'); 
        iniRol('0',0); 
    });

    $('#cboCiarol').change(function(){ 
        var v_idcia = $( "#cboCiarol option:selected").attr("value");
               
        if ($('#mhdnAccionOpc').val() == 'N'){
            var params = { "ccia" : v_idcia};

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: baseurl+"adm/ti/csistemas/gethomexcia",
                dataType: "JSON",
                async: true,
                data: params,
                success:function(result)
                {
                    $('#cboHome').html(result); 
                },
                error: function(){
                alert('Error, No se puede autenticar por error');
                }
            });  
        };
        
    });

/*PERMISOS*/
    $('#collapsePermiso').on('show.bs.collapse', function () {        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/getcborol",
            dataType: "JSON",
            async: true,
            success:function(result)
            {
                $('#cboRolList').html(result); 
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        });
    });

    $('#cboRolList').change(function(){ 
        var v_idrol = $( "#cboRolList option:selected").attr("value");   
        
        listarPerm(v_idrol);
    });

    listarPerm = function(v_idrol){
        var groupColumn = 1;        
        oTable_listaperm = $('#tablalistaPerm').DataTable({
            'bJQueryUI'     : true,
            'scrollY'     	: '350px',
            'scrollX'     	: true, 
            'paging'      	: true,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: true,
            'filter'      	: true, 
            "ordering"		: false,  
            'stateSave'     : true, 
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getlistarperm/",
                "type"  : "POST", 
                "data": function ( d ) {  
                    d.idrol = v_idrol; 
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {
                "class"     :   "index",
                orderable   :   false,
                data        :   null,
                targets     :   0
                },
                {data: 'desc_modulo', targets: 1},
                {data: 'desc_opcion', targets: 2},   
            ],  
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                var sublast = null;
     
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="3">'+group+'</td></tr>'
                        );
     
                        last = group;
                    }
                } );
            }      
        });
        // Enumeracion 
        oTable_listaperm.on( 'order.dt search.dt', function () { 
            oTable_listaperm.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            } );
        }).draw();  

    };
        
    $('#tablalistaPerm tbody').on( 'click', 'tr.group', function () {
        var currentOrder = oTable_listaperm.order()[0];
    } );

    $('#cboCiaperm').change(function(){ 
        var v_idcia = $( "#cboCiaperm option:selected").attr("value");
        var v_idmodulo = "";   
        var v_idrol = "";      
        
        cambiarCboRolCia(v_idcia,v_idmodulo,v_idrol);
    });

    cambiarCboRolCia = function(v_idcia,v_idmodulo,v_idrol){
        var params = { "ccia" : v_idcia};
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/getmoduloxcia",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $('#cboModulopem').html(result);
                $("#cboModulopem").val(v_idmodulo).trigger("change");   
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/getrolxcia",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                $('#cboRolperm').html(result);
                $("#cboRolperm").val(v_idrol).trigger("change");   
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
    };

    $('#btnRecuperaRol').click(function(){
        v_idrol = $('#cboRolperm').val();
        v_idmodulo = $('#cboModulopem').val(); 

        oTable_listaOpcmod = $('#tablalistaOpcmod').DataTable({
            'bJQueryUI'     : true,
            'scrollY'     	: '350px',
            'scrollX'     	: true, 
            'paging'      	: false,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: false,
            'filter'      	: false, 
            "ordering"		: false,  
            'stateSave'     : true, 
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getrolpermisos/",
                "type"  : "POST", 
                "data": function ( d ) {   
                    d.idrol = v_idrol;  
                    d.idmodulo = v_idmodulo;  
                    d.sele = '0';
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {data: 'desc_opcion', targets: 0},
                {"orderable": false, 
                    render:function(data, type, row){
                        return '<div>' +
                                '<a title="Editar" style="cursor:pointer; color:#3c763d;" onclick="javascript:selePermRol(\''+row.id_rol+'\',\''+row.id_modulo+'\',\''+row.id_opcion+'\',\''+row.sele+'\');"><span class="fas fa-angle-right fa-2x" aria-hidden="true"> </span> </a>' +
                                '</div>' ; 
                    }
                } 
            ]    
        });

        oTable_listaOpcrol = $('#tablalistaOpcrol').DataTable({
            'bJQueryUI'     : true,
            'scrollY'     	: '350px',
            'scrollX'     	: true, 
            'paging'      	: false,
            'processing'  	: true,      
            'bDestroy'    	: true,
            'info'        	: false,
            'filter'      	: false, 
            "ordering"		: false,  
            'stateSave'     : true, 
            'ajax'        : {
                "url"   : baseurl+"adm/ti/csistemas/getrolpermisos/",
                "type"  : "POST", 
                "data": function ( d ) {   
                    d.idrol = v_idrol;  
                    d.idmodulo = v_idmodulo;  
                    d.sele = '1';
                },     
                dataSrc : ''        
            },
            'columns'     : [
                {"orderable": false, targets: 0, 
                    render:function(data, type, row){
                        return '<div>' +
                                '<a title="Editar" style="cursor:pointer; color:#3c763d;" onclick="javascript:selePermRol(\''+row.id_rol+'\',\''+row.id_modulo+'\',\''+row.id_opcion+'\',\''+row.sele+'\');"><span class="fas fa-angle-left fa-2x" aria-hidden="true"> </span> </a>' +
                                '</div>' ; 
                    }
                } ,
                {data: 'desc_opcion', targets: 1},
            ]    
        });
    });

    selePermRol = function(idrol,idmodulo,idopcion,sele){
        var params = { 
            "idrol" : idrol,
            "idmodulo" : idmodulo,
            "idopcion" : idopcion,
            "sele" : sele
        };
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: baseurl+"adm/ti/csistemas/setasignarperm",
            dataType: "JSON",
            async: true,
            data: params,
            success:function(result)
            {
                oTable_listaOpcmod.ajax.reload(null,false);                  
                oTable_listaOpcrol.ajax.reload(null,false);
            },
            error: function(){
            alert('Error, No se puede autenticar por error');
            }
        }); 
    };

