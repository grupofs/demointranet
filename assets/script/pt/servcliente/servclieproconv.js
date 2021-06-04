
var otblListEquipos, otblListProductos;
var collapsedGroupsEq = {};
var vccliente = $('#hdnccliente').val(); 

$(document).ready(function() { 
    listEquipo();  
    listProducto();     
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
            "url"   : baseurl+"pt/cservcliente/getproconvequipo/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'TIPO'},
            {
              "class"     :   "col-xxs",
              orderable   :   false,
              data        :   'ESPACE',
              targets     :   1
            },
            {"class":"col-xm", "orderable": false, data: 'NROINFOR'},
            {"class":"col-xm", "orderable": false, data: 'MEDIOCAL'},
            {"class":"col-xm", "orderable": false, data: 'FABRI'},
            {"class":"col-sm", "orderable": false, data: 'ENVASE'},
            {"class":"col-m", "orderable": false, data: 'DIMENSION'},
            {"class":"col-xs", "orderable": false, data: 'IDENTIF'}, 
        ],
        rowGroup: {
            startRender : function ( rows, group ) {
                var collapsed = !!collapsedGroupsEq[group];
    
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
        }/*,{
            "targets": [1], 
            "data": 'ESPACE',
            "render": function(data, type, row) {
                if(row.idptregestudio == 1){
                    $(row).find('tr').removeClass( 'details-control' );
                    alert(row.idptregestudio);
                };
                return row.ESPACE;
            }
        }*/]
    });   
    // Enumeracion 
    otblListEquipos.on( 'order.dt search.dt', function () { 
        otblListEquipos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
    otblListEquipos.column(0).visible( false ); 
};

/* COMPRIMIR GRUPO */
$('#tblListEquipos tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblListEquipos.draw(true);
}); 

//$('#contenido').find(".dataTables_scrollBody").css('height', $('#contenido').height() - 20);

listProducto= function(){    

    otblListProductos = $('#tblListProductos').DataTable({  
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : true,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getproconvproducto/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'TIPO'},
            {
              "class"     :   "col-xxs",
              orderable   :   false,
              data        :   null,
              targets     :   1
            },
            {"class":"col-xm", "orderable": false, data: 'NROINFOR'},
            {"class":"col-lm", "orderable": false, data: 'PRODUCTO'},
            {"class":"col-sm", "orderable": false, data: 'ENVASE'},
            {"class":"col-s", "orderable": false, data: 'NROPROCAL'},
            {"class":"col-sm", "orderable": false, data: 'DIMENSION'},
            {"class":"col-sm", "orderable": false, data: 'TIPOEQUIPO'},
            {"class":"col-sm", "orderable": false, data: 'IDENEQUIPO'},
            {"class":"col-sm", "orderable": false, data: 'FABRIEQUIPO'},
        ],
        rowGroup: {
            startRender : function ( rows, group ) {
                var collapsed = !!collapsedGroupsEq[group];
    
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
    otblListProductos.on( 'order.dt search.dt', function () { 
        otblListProductos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();  
    otblListProductos.column(0).visible( false ); 
};
// COMPRIMIR GRUPO 
$('#tblListProductos tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblListProductos.draw(true);
}); 

