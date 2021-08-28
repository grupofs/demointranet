var otblListalertaest;


$(document).ready(function() { 
    parametros = paramListalertaest();
    getlistalertaest(parametros);  
});


paramListalertaest = function (){    
       
    var param = {
        "idempleado"  : $('#hdidempleado').val(),
    }; 
    return param;    
};

getlistalertaest = function(parametros){    
    otblListalertaest = $('#tblListalertaest').DataTable({ 
        "processing"  	: true,
        "bDestroy"    	: true,
        "stateSave"     : true,
        "bJQueryUI"     : true,
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
            "url"   : baseurl+"pt/calerta/getlistalertaest/",
            "type"  : "POST",             
            "data"  : parametros, 
            dataSrc : ''        
        },
        'columns'	: [
            {data : null, "class" : "col-xxs", orderable : false},
            {data: 'nro_informe', "class": "col-sm"},
            {data: 'estado_inf',responsivePriority: 1,  "class": "col-s",  searchable: false, render: function( data, type, row ){
                if (data == 'F') {
                    return '<input data="username" type="checkbox" name="my-checkbox" checked> Finalizado';
                }else {
                    return '<input data="username" type="checkbox" name="my-checkbox"> Pendiente';
                }
            }},
            {data: 'fecha_informe', "class": "col-s"},
            {data: 'nro_propu', "class": "col-sm"},
            {data: 'RAZONSOCIAL', "class": "col-lm"},
            {data: 'descripcion_serv', "class": "col-lm"},
        ],
        "columnDefs": [{
            "targets": [1], 
            "data": null, 
            "render": function(data, type, row) { 
                return '<p>'+row.nro_informe+'</p>';                 
            }
        }]
    });
    // Enumeracion 
    otblListalertaest.on( 'order.dt search.dt', function () { 
        otblListalertaest.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
          } );
    }).draw(); 
}

$('#tblListalertaest').on('change','input[name="my-checkbox"]', function(event, state) {
    var tipocheck;

    if(this.checked) {
        tipocheck = 'F'
    }else{
        tipocheck = 'P'
    }

    event.preventDefault();
    var table = $('#tblListalertaest').DataTable();
    var seleccionados = table.rows({ selected: true });   
    seleccionados.every(function(key,data){
        IDINFORME = this.data().idptinforme;
        Swal.fire({
            title: 'Confirmar Cambiar de Estado',
            text: "¿Está seguro de Cambiar de Estado?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Cambiar!'
        }).then((result) => {
            if (result.value) {
                $.post(baseurl+"pt/cinforme/setestadoinf/", 
                {
                    idptinforme : IDINFORME,
                    estado_inf  : tipocheck,
                },      
                function(data){     
                    otblListalertaest.ajax.reload(null,false); 
                    Vtitle = 'Se Cambio Correctamente';
                    Vtype = 'success';
                    sweetalert(Vtitle,Vtype);      
                });
            }
        })  
    });
});