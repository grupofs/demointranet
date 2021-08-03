const objLista = {
    /**
     * Verifica si se encuentra cargando la lista
     * @var {Boolean}
     */
    cargando: false,
    /**
     * Objeto de la tabla
     * @var {Object}
     */
    oTableLista: null
};

$(function () {

    /**
     * Busqueda de area
     */
    objLista.buscar1 = function () {
        if (objLista.cargando) {
            sweetalert('Aún existe una carga pediente, porfavor espere!', 'error');
        } else {
            if (objLista.oTableLista) {
                objLista.oTableLista.ajax.reload(null, false);
            } else {
                const boton = $('#btnBuscar');
                objLista.cargando = true;
                this.oTableLista = $('#tblLista').DataTable({
                    'bJQueryUI': true,
                    'scrollY': '400px',
                    'scrollX': true,
                    'processing': true,
                    'bDestroy': true,
                    'paging': true,
                    'info': true,
                    'filter': true,
                    'ajax': {
                        "url": BASE_URL + "pt/mante/cservicios/lista",
                        "type": "POST",
                        "data": function (d) {
                            d.nombre = $('#txtNombre').val();
                        },
                        beforeSend: function () {
                            objPrincipal.botonCargando(boton);
                        },
                        dataSrc: function (data) {
                            objPrincipal.liberarBoton(boton);
                            objLista.cargando = false;
                            return data;
                        }
                    },
                    'columns': [
                        {data: null, "class": "index", orderable: false, targets: 0 },
                        {data: 'descripcion_serv', orderable: false, targets: 1},
                        {data: 'abreviatura_serv', orderable: false, targets: 2},
                        {data: 'tipo_servicio', orderable: false, targets: 3},
                        {data: 'vigencia', orderable: false, targets: 4},
                    ]
                });
                objLista.oTableLista.on('order.dt search.dt', function () {
                    objLista.oTableLista.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
            }
        }
    };

    /**
     * Crea un nueva area
     */
    objLista.crearArea = function () {
        objGenerar.crear();
    };

    /**
     * Poder editar el proveedor
     * @param id
     * @param boton
     */
    objLista.editar = function (id, boton) {
        if (objLista.cargando) {
            sweetalert('Aún existe una carga pediente, porfavor espere!', 'error');
        } else {
            boton = $(boton);
            objLista.cargando = true;
            $.ajax({
                url: BASE_URL + 'ar/evalprod/carea/buscar',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                beforeSend: function () {
                    objPrincipal.botonCargando(boton);
                }
            }).done(function (response) {
                if (response && response.area && response.area.id_area) {
                    objGenerar.abrir(
                        response.area.id_area,
                        response.area.nombre,
                        response.contactos
                    );
                    $('#tabReg2-tab').click();
                } else {
                    sweetalert('El área no pudo ser encontrado.', 'error');
                }
            }).fail(function () {
                sweetalert('Error en el proceso de ejecución HTTP', 'error');
            }).always(function () {
                objPrincipal.liberarBoton(boton);
                objLista.cargando = false;
            });
        }
    };

    objLista.eliminar = function(id, boton) {
        sweetalert('Lo siento, el eliminar esta en mantenimiento!', 'info');
    }


    /* ******** */
    /**
     * Listar de servicio
     */
    objLista.viewList = function () {
        $.ajax({
           url:  BASE_URL + "pt/mante/cservicios/lista",
           method: "GET"
        }).done(function(data){
            $('tbody').html(data)
            objLista.tableData()
        })
    };
    objLista.tableData = function () {
        $('#tblLista').Tabledit({
            url:'pt/mante/cservicios/guardar',
            eventType: 'dblclick',
            editButton: false,
            deleteButton: false,
            hideIdentifier: true,
            columns:{
                identifier : [0,'idptservicio'],
                editable:[[1,'descripcion_serv'],[2, 'vigencia', '{"A": "ACTIVO", "I": "INACTIVO"}'],[3,'abreviatura_serv'],[4, 'tipo_servicio', '{"1": "REG. INFORME", "2": "TRAMITE", "3": "MODULAR"}']]
            },
            onSuccess: function(data, textStatus, jqXHR) {
                objLista.viewList
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                console.log('onFail(jqXHR, textStatus, errorThrown)');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            },
            onAjax: function(action, serialize) {
                console.log('onAjax(action, serialize)');
                console.log(action);
                console.log(serialize);
            }
        });
    };

});

$(document).ready(function () {

    objLista.viewList();

    $('#tabReg1-tab').click(function() {
        objGenerar.abrir(0, '', []);
        objLista.buscar();
    });

    $('#btnBuscar').click(objLista.viewList);

    $('#btnNuevoArea').click(function () {
        $('#tabReg2-tab').click();
    });

    $('#tblLista').on('draw.dt',function(){
        
    });

    

});