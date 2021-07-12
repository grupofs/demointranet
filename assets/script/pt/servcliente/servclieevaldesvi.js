
var otblListEstudios;
var collapsedGroupsEq = {};
var vccliente = $('#hdnccliente').val(); 

$(document).ready(function() { 
    listEstudios();  
});

listEstudios= function(){    

    otblListEstudios = $('#tblListEstudios').DataTable({          
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
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getevaldesviestudio/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [            
            {data: 'TIPO'},
            {data: null, "class" : "col-xxs"},
            {data: 'NROINFOR', "class":"col-sm"},
            {data: 'DESC', "class":"col-lm"},
            {data: 'PRODUCTO', "class":"col-m"},
            {data: 'ENVASE', "class":"col-sm"},
            {data: 'DIMENSION', "class":"col-sm"},
            {data: 'NRODEVCAL', "class":"col-s"},
            {data: 'TIPOEQUIPO', "class":"col-sm"},
            {data: 'IDEN', "class":"col-xs"},
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
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblListEstudios.draw(true);
}); 


