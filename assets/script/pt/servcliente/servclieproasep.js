
var otblListProductos;
var collapsedGroupsRe = {};
var vccliente = $('#hdnccliente').val(); 

$(document).ready(function() { 
    listProducto()   
});

listProducto= function(){    

    otblListProductos = $('#tblListProductos').DataTable({  
        'responsive'    : false,
        'bJQueryUI'     : true,
        "scrollResize"  : true,
        'scrollY'     	: '200px',
        'scrollX'     	: true, 
        'paging'      	: true,
        'processing'  	: true,     
        'bDestroy'    	: true,
        'AutoWidth'     : false,
        'info'        	: true,
        'filter'      	: true, 
        'ordering'		: false,  
        'stateSave'     : true,
        'ajax'	: {
            "url"   : baseurl+"pt/cservcliente/getproasepproducto/",
            "type"  : "POST", 
            "data": function ( d ) {
                d.ccliente      = vccliente;
            },     
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'TIPO'},
            {
                "class"     :   "details-control col-xs",
                orderable   :   false,
                data        :   null,
                targets     :   1
            },
            {data: 'NROINFOR',"class":"col-sm"},
            {data: 'NOMPROD',"class":"col-lm"},
            {data: 'ph_materia_prima',"class":"col-sm"},
            {data: 'ph_producto_final',"class":"col-sm"},
            {data: 'PARTICULA',"class":"col-sm"},
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
    collapsedGroupsRe[name] = !collapsedGroupsRe[name];
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
           '<thead style="background-color:#FFFFFF;"><tr><th>CLASE DE EQUIPO</th><th>TIPO DE EQUIPO</th><th>FABRICANTE EQUIPO</th><th>ID EQUIPO</th></thead><tbody>' +
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
                    {data: 'claseequipo'},
                    {data: 'tipoequipo'},
                    {data: 'FABRIEQUIPO'},
                    {data: 'identificacion'},
                              
                ], 
            });

        tr.addClass('details');
    }
});