var otblListEquipos, otblListRecintos, otblListEstudios;
var collapsedGroupsRe = {}, collapsedGroupsEs = {};
var vccliente = $('#hdnccliente').val(); 

$(document).ready(function() { 
    listEquipo();  
    listRecintos();
    listEstudios(); 
});

listEquipo= function(){    

    otblListEquipos = $('#tblListEquipos').DataTable({  
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollCollapse": true,
        "scrollX"     	: true, 
        'AutoWidth'     : false,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getmapterequipo/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {
              "class"     :   "col-xxs",
              orderable   :   false,
              data        :   'ESPACE',
              targets     :   0
            },
            {data: 'NROINFOR',"class":"col-sm"},
            {data: 'NROEQUIPOS',"class":"col-s"},
            {data: 'AREAEVAL',"class":"col-s"},
            {data: 'NROPOS',"class":"col-s"},
            {data: 'VOLALMA',"class":"col-s"},
            {data: 'PRODUCTO',"class":"col-lm"},
            {data: 'FORMAPRODUCTO',"class":"col-sm"},
            {data: 'ENVASE',"class":"col-sm"},
        ],
        "columnDefs": [{
            "targets": [1], 
            "data": null, 
            "render": function(data, type, row) { 
                if(row.ARCHIVO != "") {
                    return '<p><a title="Descargar" style="cursor:pointer; color:#294ACF;" href="'+baseurl+row.ruta_informe+row.ARCHIVO+'" target="_blank" class="pull-left">'+row.NROINFOR+'&nbsp;<i class="fas fa-cloud-download-alt""></i></a><p>';
                }else{
                    return '<p>'+row.NROINFOR+'</p>';
                }                      
            }
        }]
    });   
    // Enumeracion 
    otblListEquipos.on( 'order.dt search.dt', function () { 
        otblListEquipos.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
};

listRecintos= function(){    

    otblListRecintos = $('#tblListRecintos').DataTable({ 
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollCollapse": true,
        "scrollX"     	: true, 
        'AutoWidth'     : false,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getmapterrecinto/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {data: 'TIPO'},
            {
                "class"     :   "col-xxs",
                orderable   :   false,
                data        :   'ESPACE',
                targets     :   1
            },
            {data: 'NROINFOR',"class":"col-sm"},
            {data: 'EVALUACION',"class":"col-sm"},
            {data: 'NRORECINTOS',"class":"col-sm"},
            {data: 'AREAEVAL',"class":"col-sm"},
            {data: 'NROPOS',"class":"col-sm"},
            {data: 'VOLENFRIA',"class":"col-sm"},
        ],
        rowGroup: {
            startRender : function ( rows, group ) {
                var collapsed = !!collapsedGroupsRe[group];
    
                rows.nodes().each(function (r) {
                    r.style.display = collapsed ? 'none' : '';
                }); 
                return $('<tr/>')
                .append('<td colspan="14" style="cursor: pointer;">' + group + ' (' + rows.count() + ')</td>')
                .attr('data-name', group)
                .toggleClass('collapsed', collapsed);
            },
            dataSrc: "TIPO"
        },
        "columnDefs": [{
            "targets": [2], 
            "data": null, 
            "render": function(data, type, row) { 
                if(row.ARCHIVO != "") {
                    return '<p><a title="Descargar" style="cursor:pointer; color:#294ACF;" href="'+baseurl+row.ruta_informe+row.ARCHIVO+'" target="_blank" class="pull-left">'+row.NROINFOR+'&nbsp;<i class="fas fa-cloud-download-alt""></i></a><p>';
                }else{
                    return '<p>'+row.NROINFOR+'</p>';
                }                      
            }
        }]
    });   
    // Enumeracion 
    otblListRecintos.on( 'order.dt search.dt', function () { 
        otblListRecintos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
    otblListRecintos.column(0).visible( false );  
};
/* COMPRIMIR GRUPO */
$('#tblListRecintos tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsRe[name] = !collapsedGroupsRe[name];
    otblListRecintos.draw(true);
}); 

listEstudios= function(){    

    otblListEstudios = $('#tblListEstudios').DataTable({  
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollCollapse": true,
        "scrollX"     	: true, 
        'AutoWidth'     : false,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getmapterestudio/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {data: 'TIPO'},
            {
                "class"     :   "col-xxs",
                orderable   :   false,
                data        :   'ESPACE',
                targets     :   1
            },
            {data: 'NROINFOR',"class":"col-sm"},
            {data: 'ID',"class":"col-s"},
            {data: 'PRODUCTO',"class":"col-lm"},
            {data: 'FORMAPRODUCTO',"class":"col-sm"},
            {data: 'ENVASE',"class":"col-m"},
        ],
        rowGroup: {
            startRender : function ( rows, group ) {
                var collapsed = !!collapsedGroupsEs[group];
    
                rows.nodes().each(function (r) {
                    r.style.display = collapsed ? 'none' : '';
                }); 
                return $('<tr/>')
                .append('<td colspan="14" style="cursor: pointer;">' + group + ' (' + rows.count() + ')</td>')
                .attr('data-name', group)
                .toggleClass('collapsed', collapsed);
            },
            dataSrc: "TIPO"
        },
        "columnDefs": [{
            "targets": [2], 
            "data": null, 
            "render": function(data, type, row) { 
                if(row.ARCHIVO != "") {
                    return '<p><a title="Descargar" style="cursor:pointer; color:#294ACF;" href="'+baseurl+row.ruta_informe+row.ARCHIVO+'" target="_blank" class="pull-left">'+row.NROINFOR+'&nbsp;<i class="fas fa-cloud-download-alt""></i></a><p>';
                }else{
                    return '<p>'+row.NROINFOR+'</p>';
                }                      
            }
        }]
    });   
    // Enumeracion 
    otblListEstudios.on( 'order.dt search.dt', function () { 
        otblListEstudios.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
    otblListEstudios.column(0).visible( false );
};
/* COMPRIMIR GRUPO */
$('#tblListEstudios tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsEs[name] = !collapsedGroupsEs[name];
    otblListEstudios.draw(true);
}); 
