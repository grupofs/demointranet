
var otblListContratos;

$(document).ready(function() {

});

$("#btnBuscar").click(function (){   
    var param = {
        "descripcion"     : '%',//$('#txtcodprodu').val(),
    }; 

    listarBusqueda(param);
});

listarBusqueda = function(param){
    
    var groupColumn = 1;   

    otblListContratos = $('#tblListContratos').DataTable({
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
        "scrollResize"  : true,
        "scrollY"     	: "400px",
        "scrollX"     	: true,
        "scrollCollapse": true, 
        'AutoWidth'     : true,
        "paging"      	: false,
        "info"        	: true,
        "filter"      	: true, 
        "ordering"		: false,
        "responsive"    : false,
        "select"        : false,  
        'ajax'	: {
            "url"   : baseurl+"adm/rrhh/ccontratos/getbuscarcontratos/",
            "type"  : "POST", 
            "data"  : param,      
            dataSrc : ''        
        },
        'columns'	: [
            {"orderable": false, data: 'ESPACIO', targets: 0, "class": "col-xxs"},
            {"orderable": false, data: 'AREA', targets: 1},
            {"orderable": false, data: 'NROCONTRATO', targets: 2, "class": "col-xm"},
            {"orderable": false, targets: 4,
                render:function(data, type, row){
                if(row.RUTAFOTO == ''){
                    return '<div class="user-block" style="float: none;">' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/clientes/unknown.png"  width="64" height="64" class="img-circle img-bordered-sm">&nbsp;&nbsp;&nbsp;'+
                    '<span class="username"  style="vertical-align: middle; margin-top: -25px;">'+row.EMPLEADO+'</span><span class="description"><h6>'+row.NRODOC+'</h6></span>'+
                    '</div>' ; 
                }else{
                    return '<div>' +
                    '<img src="'+baseurl+'FTPfileserver/Imagenes/clientes/'+row.RUTAFOTO+'"  width="64" height="64" class="img-circle">'+
                    '<div><span class="username" style="vertical-align: middle; margin-left: 0.5em;">'+row.EMPLEADO+'</span><br><h4><b>'+row.NRODOC+'</b></h4></div>'+
                    '</div>' ; 
                }
                }
            },
            {"orderable": false, data: 'CARGO', targets: 5},
            {"orderable": false, 
                render:function(data, type, row){  
                    return '<div style="text-align: center;">' +
                        
                    '</div>';
                }
            }
        ],  
        "columnDefs": [],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'all'} ).nodes();
            var last = null;
			var grupo;
 
            api.column([1], {} ).data().each( function ( ctra, i ) { 
                grupo = api.column(1).data()[i];
                if ( last !== ctra ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8"><strong>'+ctra.toUpperCase()+'</strong></td></tr>'
                    ); 
                    last = ctra;
                }
            } );
        }
    }); 
    otblListContratos.column(1).visible( false );      
    // Enumeracion 
    otblListContratos.on( 'order.dt search.dt', function () { 
        otblListContratos.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw();   
};