$(document).ready(function(){
    let funcion = "listar";    
    let datatable = $('#tabla_vendedores').DataTable( {
        "ajax": {
            "url" : "../controlador/VendedorController.php",
            "method" : "POST",
            "data" : {funcion : funcion}
        },
        "columns": [
            { "data": "v_nombre" },
            { "data": "v_apellido" },
            { "data": "v_ruta" },
            { "data": "v_telefono" },
            { "defaultContent": `<button class="editar_vend btn btn-success" title="Editar" type="button"
                                 data-toggle="modal" data-target="#modal_abonar_cuenta"><i class="far fa-edit"></i></button>
                                 <button class="eliminar_vend btn btn-danger" title="Eliminar" type="button"
                                 data-toggle="modal" data-target="#modal_liquidar_cuenta"><i class="fas fa-trash"></i></button>
                                 `}
        ],
        "language" : espanol
    } );
    $('.select2').select2();
    fillRutas();

    $('#tabla_vendedores tbody').on('click','.eliminar_vend',function(){
        funcion ="deleteVendedor";
        let datos = datatable.row($(this).parents()).data();
        id_vendor = datos.id_vendor;
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger mr-1'
        },
        buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Seguro que quieres borrar el vendedor '+datos.v_nombre+'?',
            text: "Será borrado permanentemente",
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/VendedorController.php',{id_vendor,funcion},(response)=>{
                    console.log(response);
                    if(response=='borrado'){
                            swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'La ruta '+datos.v_nombre+' ha sido eliminada.',
                            'success' ).then(function () {
                        location.reload();});
                        }else{
                            swalWithBootstrapButtons.fire(
                            'Error!',
                            'La ruta '+nombreCliente+' está siendo usada.',
                            'error' )
                        }});
            } else if (result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'No ha sido borrado',
                'Ningun cliente ha sido eliminado.',
                'error')}});
    });

    function fillRutas(){
        funcion = "llenarRutas";
        $.post('../controlador/RutaController.php',{funcion},(response)=>{
            const rutas = JSON.parse(response);
            let template = '';
            rutas.forEach(ruta => {
                template+=`<option value = "${ruta.id}">${ruta.nombre}</option>`;
            });
            $('#ruta_new_vendedor').html(template);
        });
        
    }

    $('#form_crear_vendedor').submit(ev=>{
         let new_vend_nombre = $('#nombre_new_vendedor').val();
         let new_vend_apellidos = $('#apellidos_new_vendedor').val();
         let new_vend_telefono = $('#telefono_new_vendedor').val();
         let new_vend_ruta = $('#ruta_new_vendedor').val();
         funcion = "crearVendedor";
         $.post('../controlador/VendedorController.php',{funcion,new_vend_nombre,new_vend_apellidos,new_vend_telefono,new_vend_ruta},(response)=>{
           if(response=='add'){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Vendedor creado',
                    showConfirmButton: false,
                    timer: 1500 }).then(function () {
                        location.reload();});
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Ya hay un vendedor con ese nombre en la misma ruta',
                    showConfirmButton: false,
                    timer: 2500 })
                    jQuery.noConflict();
                $('#crear_vendedor').modal('hide');
                $('#form_crear_vendedor').trigger('reset');
            }
            ev.preventDefault();
         });
        ev.preventDefault();
    });

    


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