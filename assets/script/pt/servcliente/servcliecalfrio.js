
var otblListEquipos, otblListProductos;
var vccliente = $('#hdnccliente').val();
var collapsedGroupsEq = {} ;

$(document).ready(function() { 
    listProducto()   
});

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
        "responsive"    : false,
        "select"        : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getcalfrioproducto/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {"class":"col-sm", data: 'TIPO'},
            {
              "class"     :   "details-control col-xs",
              orderable   :   false,
              data        :   null,
              targets     :   1
            },
            {"class":"col-sm", data: 'NROINFOR'},
            {"class":"col-lm", data: 'PRODUCTO'},
            {"class":"col-xm", data: 'ENVASE'},
            {"class":"col-xm", data: 'DIMENSION'},
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
    otblListProductos.on( 'order.dt search.dt', function () { 
        otblListProductos.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw() 
    otblListProductos.column(0).visible( false ); 
};
/* COMPRIMIR GRUPO */
$('#tblListProductos tbody').on('click', 'tr.dtrg-group', function () {
    var name = $(this).data('name');
    collapsedGroupsEq[name] = !collapsedGroupsEq[name];
    otblListProductos.draw(true);
}); 
/* DETALLE TRAMITES */
$('#tblListProductos tbody').on( 'click', 'td.details-control', function () {
            
   // var tr = $(this).closest('tr');
    var tr = $(this).parents('tr');
    var row = otblListProductos.row(tr);
    var rowData = row.data();
    
    if ( row.child.isShown() ) {                    
        row.child.hide();
        tr.removeClass( 'details' );
    }
    else {
        otblListProductos.rows().every(function(){
            // If row has details expanded
            if(this.child.isShown()){
                // Collapse row details
                this.child.hide();
                $(this.node()).removeClass('details');
            }
        })
        row.child( 
           '<table id="tblListEquipos" class="display compact" style="width:100%;  background-color:#D3DADF; padding-top: -10px; border-bottom: 2px solid black;">'+
           '<thead style="background-color:#FFFFFF;"><tr><th>TIPO DE EQUIPO</th><th>FABRICANTE EQUIPO</th></thead><tbody>' +
            '</tbody></table>').show();
            
            otblListEquipos = $('#tblListEquipos').DataTable({
                "bJQueryUI"     : true,
                'bStateSave'    : true,
                'scrollY'       : false,
                'scrollX'       : true,
                'scrollCollapse': false,
                'bDestroy'    : true,
                'paging'      : false,
                'info'        : false,
                'filter'      : false,   
                'stateSave'   : true,
                'ajax'        : {
                    "url"   : baseurl+"pt/cinforme/getlistequipoxprod/",
                    "type"  : "POST", 
                    "data": function ( d ) {
                        d.Idregprod = rowData.idptregproducto;
                    },     
                    dataSrc : ''        
                },
                'columns'     : [
                    {"orderable": false, data: 'tipoequipo'},
                    {"orderable": false, data: 'FABRIEQUIPO'},
                              
                ], 
            });

        tr.addClass('details');
    }
});