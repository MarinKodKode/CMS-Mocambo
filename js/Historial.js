$(document).ready(function(){
    let funcion = "historial";
    
    let datatable = $('#tabla_ventas').DataTable( {
        "ajax": {
            "url" : "../controlador/NotasPendientesController.php",
            "method" : "POST",
            "data" : {funcion : funcion}
        },
        "columns": [
            { "data": "venta_folio" },
            { "data": "venta_fecha" },
            { "data": "cliente" },
            { "data": "ruta" },
            { "data": "capturista" },
            { "data": "estado" },
            { "data": "venta_adicional" },
            { "data": "pedido" },
            { "data": "pagado" },
            { "data": "por_pagar" },
            { "defaultContent": `<button class="ver btn btn-info" title="Detalle de cuenta" type ="button"          
                                  data-toggle="modal" data-target="#vista_venta"><i class="fas fa-search"></i></button>
                                 `}
        ],
        "language" : espanol
    } );

    //Detalla una venta
    $('#tabla_ventas tbody').on('click','.ver',function(){
        let datos = datatable.row($(this).parents()).data();
        let id = datos.id_venta;
        funcion = "ver";

        $('#det_folio_venta').html(datos.venta_folio);
        $('#det_fecha').html(datos.venta_fecha);
        $('#det_cliente').html(datos.cliente);
        $('#det_ruta').html(datos.ruta);
        $('#det_vendedor').html(datos.capturista);
        $('#det_pedido').html(datos.pedido);
        $('#det_pagado').html(datos.pagado);
        $('#det_por_pagar').html(datos.por_pagar);
        $('#det_total_pedido').html(datos.pedido);


        $.post('../controlador/VentaProductoDet.php',{funcion,id},(response)=>{
            let registros = JSON.parse(response);
            //console.log(response)
           let template="";
            $('#registros').html(template);
            registros.forEach(registro => {
                template+=`
                    <tr>
                    <td>${registro.producto_nombre}</td>
                        <td>${registro.vp_piezas_vendidas}</td>
                        <td>${registro.vp_kilos_vendidos}</td>
                        <td>${registro.vp_precio_unitario_kilo}</td>
                        <td>${registro.vp_piezas_devueltas}</td>
                        <td>${registro.vp_kilos_devueltos}</td>
                        <td>${registro.vp_subtotal}</td>
                    </tr>
                `;
                $('#registros').html(template);
            });
        });
    });
     
});
     


let espanol = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ning??n dato disponible en esta tabla",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "??ltimo",
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
        "collection": "Colecci??n",
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
        "add": "A??adir condici??n",
        "button": {
            "0": "Constructor de b??squeda",
            "_": "Constructor de b??squeda (%d)"
        },
        "clearAll": "Borrar todo",
        "condition": "Condici??n",
        "conditions": {
            "date": {
                "after": "Despues",
                "before": "Antes",
                "between": "Entre",
                "empty": "Vac??o",
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
                "notEmpty": "No vac??o",
                "not": "Diferente de"
            },
            "string": {
                "contains": "Contiene",
                "empty": "Vac??o",
                "endsWith": "Termina en",
                "equals": "Igual a",
                "notEmpty": "No Vacio",
                "startsWith": "Empieza con",
                "not": "Diferente de"
            },
            "array": {
                "not": "Diferente de",
                "equals": "Igual",
                "empty": "Vac??o",
                "contains": "Contiene",
                "notEmpty": "No Vac??o",
                "without": "Sin"
            }
        },
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangr??a",
        "title": {
            "0": "Constructor de b??squeda",
            "_": "Constructor de b??squeda (%d)"
        },
        "value": "Valor"
    },
    "searchPanes": {
        "clearMessage": "Borrar todo",
        "collapse": {
            "0": "Paneles de b??squeda",
            "_": "Paneles de b??squeda (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown} ({total})",
        "emptyPanes": "Sin paneles de b??squeda",
        "loadMessage": "Cargando paneles de b??squeda",
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
                "_": "??Est?? seguro que desea eliminar %d filas?",
                "1": "??Est?? seguro que desea eliminar 1 fila?"
            }
        },
        "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">M??s informaci??n&lt;\\\/a&gt;).<\/a>"
        },
        "multi": {
            "title": "M??ltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aqu??, de lo contrario conservar??n sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
        }
    },
    "info": "Mostrando de _START_ a _END_ de _TOTAL_ registros"
};