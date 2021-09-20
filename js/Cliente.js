$(document).ready(function(){
    let funcion = "clientes";
    let datatable = $('#tabla_clientes').DataTable( {
        "ajax": {
            "url" : "../controlador/ClienteController.php",
            "method" : "POST",
            "data" : {funcion : funcion}
        },
        "columns": [
            { "data": "id_cliente", "visible": false },
            { "data": "cliente_nombre" },
            { "data": "cliente_telefono" },
            { "data": "ruta_nombre" },
            { "defaultContent": `<button class="detalleCliente btn btn-secondary"  title="Información del cliente"     
                                type:"button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-info-circle"></i></button>
                                <button class="editarCliente btn btn-secondary" title="Editar detalles de cliente"  type:"button" data-toggle="modal" data-target="#modal_editar_cliente"><i class="fas fa-pencil-alt"></i></button>
                                 `}
        ],
        "language" : espanol
    } );
    $('.select2').select2();
    fillRutas();
    

    //Carga las ruas existentes en los modales de crear y editar un cliente
    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#rutase').html(template);
            $('#edit_cliente_rutase').html(template);
        });
        
    }
    //Crea un nuevo cliente en la base de datos
    $('#form_crear_cliente').submit(ev=>{
         let new_cliente_nombre = $('#nombre_new_cliente').val();
         let new_cliente_telefono = $('#telefono_new_cliente').val();
         let new_cliente_correo = $('#correo_new_cliente').val();
         let new_cliente_adicional = $('#adicional_new_cliente').val();
         let new_cliente_ruta = $('#rutase').val();
         funcion = "crearCliente";
         $.post('../controlador/ClienteController.php',{funcion,new_cliente_nombre,new_cliente_telefono,new_cliente_correo,new_cliente_adicional,new_cliente_ruta},(response)=>{
            if(response=='add'){
                let user_mov =  $('#user_mov').val();
                let detail_mov =  new_cliente_nombre+ ' en la ruta '+new_cliente_ruta;
                let movimiento = "creó";
                historialCliente(user_mov,movimiento,detail_mov);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente creado',
                    showConfirmButton: false,
                    timer: 1500 }).then(function () {
                        location.reload();});
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un cliente con ese nombre en la misma ruta',
                    showConfirmButton: false,
                    timer: 2500 }).then(function () {
                        location.reload();});
            }
         });
         ev.preventDefault();
     });

    //Identifica el cliente seleccionado y carga sus datos en el modal 
    //para que su información pueda ser modificada
    $('#tabla_clientes tbody').on('click','.editarCliente',function(){
        let datos = datatable.row($(this).parents()).data();
        $('#edit_cliente_nombre').val(datos.cliente_nombre);
        $('#edit_cliente_telefono').val(datos.cliente_telefono);
        $('#edit_cliente_correo').val(datos.cliente_correo);
        $('#edit_cliente_adicional').val(datos.informacion_adicional);
        $('#edit_cliente_rutase').val(datos.id_ruta).trigger('change');
        $('#id_edit_cliente').val(datos.id_cliente);
    });

    /*Lee la información del modal Editar Cliente y la actualiza en la base de datos,
    **también hace validaciones para evitar duplicado de información*/
    $('#V_form_editar_cliente').submit(e=>{
        let edit_cliente_id= $('#id_edit_cliente').val();
        let edit_cliente_nombre= $('#edit_cliente_nombre').val();
        let edit_cliente_telefono= $('#edit_cliente_telefono').val();
        let edit_cliente_correo= $('#edit_cliente_correo').val();
        let edit_cliente_adicional= $('#edit_cliente_adicional').val();
        let edit_cliente_ruta= $('#edit_cliente_rutase').val();
        funcion = 'editarCliente';
        $.post('../controlador/ClienteController.php',{edit_cliente_id,edit_cliente_nombre,edit_cliente_telefono,edit_cliente_correo,edit_cliente_adicional,edit_cliente_ruta,funcion},(response)=>{
            console.log(response);
           if(response == 'edit'){
               let user_mov =  $('#user_move').val();
                let detail_mov =  edit_cliente_nombre+ ' en la ruta '+edit_cliente_ruta;
                let movimiento = "modificó";
                historialCliente(user_mov,movimiento,detail_mov);
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Cliente actualizado',
                    showConfirmButton: false,
                    timer: 1500 }).then(function () {
                        location.reload();});
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un cliente con los mismos datos en esta ruta',
                    showConfirmButton: false,
                    timer: 1500
                        }).then(function () {
                        location.reload();});
            }
        });
        e.preventDefault();
    });

    /*Identifica el cliente que se esta auditando y llama a todos los datos referentes al cliente*/
    $('#tabla_clientes tbody').on('click','.detalleCliente',function(){
        $("#det_deuda").html(""); 
        let datos = datatable.row($(this).parents()).data();
        $('#det_cliente').html(datos.cliente_nombre);
        $('#det_telefono').html(datos.cliente_telefono);
        $('#det_correo').html(datos.cliente_correo);
        $('#det_adicional').html(datos.informacion_adicional);
        $('#det_ruta').html(datos.ruta_nombre);
        $('#cliente_deuda').val(datos.id_cliente);

        let clienteActual = $("#cliente_deuda").val();


        funcion = "cargarDeudaAcumulada";
        $.post('../controlador/RegistroController.php',{clienteActual,funcion},(response)=>{
            let respuesta = JSON.parse(response);
            $("#det_deuda").html(respuesta); 
        });

        funcion = "showLastPurchaseClient";
        $.post('../controlador/RegistroController.php',{clienteActual,funcion},(responses)=>{
            console.log(responses);
            $("#det_compra").html(responses); 
        });

        funcion = "calculateAveragePurchaseClient";
        $.post('../controlador/RegistroController.php',{clienteActual,funcion},(responde)=>{
            console.log(responde);
            $("#det_promedio").html(responde); 
        });
    });

    /*Identifica la creación de un nuevo cliente asi como el usuario que lo crea y lo guarda 
    **en el historial general de movimientos*/
    function historialCliente(user_mov,movimiento,detail_mov){
        let objeto_mov = "cliente";
        funcion = "registrarMovimiento";
         $.post('../controlador/MovimientosController.php',{funcion,user_mov,movimiento,objeto_mov,detail_mov},(response)=>{
             console.log(response);
         });
    }

});
     


let espanol = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad",
        "collection": "Colección",
        "colvisRestore": "Restaurar visibilidad",
        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
        "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %d fila al portapapeles"
        },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Mostrar todas las filas",
            "1": "Mostrar 1 fila",
            "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir"
    },
    "autoFill": {
        "cancel": "Cancelar",
        "fill": "Rellene todas las celdas con <i>%d<\/i>",
        "fillHorizontal": "Rellenar celdas horizontalmente",
        "fillVertical": "Rellenar celdas verticalmentemente"
    },
    "decimal": ",",
    "searchBuilder": {
        "add": "Añadir condición",
        "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condición",
        "conditions": {
            "date": {
                "after": "Despues",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vacío",
                "equals": "Igual a",
                "notBetween": "No entre",
                "notEmpty": "No Vacio",
                "not": "Diferente de"
            },
            "number": {
                "between": "Entre",
                "empty": "Vacio",
                "equals": "Igual a",
                "gt": "Mayor a",
                "gte": "Mayor o igual a",
                "lt": "Menor que",
                "lte": "Menor o igual que",
                "notBetween": "No entre",
                "notEmpty": "No vacío",
                "not": "Diferente de"
            },
            "string": {
                "contains": "Contiene",
                "empty": "Vacío",
                "endsWith": "Termina en",
                "equals": "Igual a",
                "notEmpty": "No Vacio",
                "startsWith": "Empieza con",
                "not": "Diferente de"
            },
            "array": {
                "not": "Diferente de",
                "equals": "Igual",
                "empty": "Vacío",
                "contains": "Contiene",
                "notEmpty": "No Vacío",
                "without": "Sin"
            }
        },
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Sin paneles de búsqueda",
        "loadMessage": "Cargando paneles de búsqueda",
        "title": "Filtros Activos - %d"
    },
    "select": {
        "1": "%d fila seleccionada",
        "_": "%d filas seleccionadas",
        "cells": {
            "1": "1 celda seleccionada",
            "_": "$d celdas seleccionadas"
        },
        "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
        },
        "rows": {
            "1": "1 fila seleccionada",
            "_": "%d filas seleccionadas"
        }
    },
    "thousands": ".",
    "datetime": {
        "previous": "Anterior",
        "next": "Proximo",
        "hours": "Horas",
        "minutes": "Minutos",
        "seconds": "Segundos",
        "unknown": "-",
        "amPm": [
            "am",
            "pm"
        ]
    },
    "editor": {
        "close": "Cerrar",
        "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
        },
        "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
        },
        "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "_": "¿Está seguro que desea eliminar %d filas?",
                "1": "¿Está seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
        },
        "multi": {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    },
    "info": "Mostrando de _START_ a _END_ de _TOTAL_ registros"
};