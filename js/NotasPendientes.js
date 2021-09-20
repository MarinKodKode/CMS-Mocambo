$(document).ready(function(){
    let funcion = "listar";
    
    let datatable = $('#tabla_venta').DataTable( {
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
            { "data": "pedido" },
            { "data": "pagado" },
            { "data": "por_pagar" },
            { "defaultContent": `<button class="abonar btn btn-secondary" title="Abonar a cuenta" type="button"
                                 data-toggle="modal" data-target="#modal_abonar_cuenta"><i class="far fa-edit"></i></button>

                                 <button class="liquidar btn btn-success" title="Liquidar cuenta" type="button"
                                 data-toggle="modal" data-target="#modal_liquidar_cuenta"><i class="far fa-check-square"></i></button>

                                 <button class="ver btn btn-info" title="Detalle de cuenta" type ="button" data-toggle="modal" data-target="#vista_venta"><i class="fas fa-search"></i></button>
                                 `}
        ],
        "language" : espanol
    } );

    $('#tabla_venta tbody').on('click','.abonar',function(){
        let datos = datatable.row($(this).parents()).data();
        //let id = datos.id_venta;
        //Datos motrados en pantalla
        $('#ab_folio_venta').html(datos.venta_folio);
        $('#ab_fecha_venta').html(datos.venta_fecha);
        $('#ab_cliente_venta').html(datos.cliente);
        $('#ab_ruta_venta').html(datos.ruta);
        $('#ab_capturista_venta').html(datos.capturista);
        $('#ab_estado_venta').html(datos.estado);
        $('#ab_pedido_venta').html(datos.pedido);
        $('#ab_pagado_venta').html(datos.pagado);
        $('#ab_por_pagar_venta').html(datos.por_pagar);
        $('#ab_fecha_abono').html(fecha());

        //Datos cargados en inputs ocultos
        $('#input_id_venta').val(datos.id_venta);
        $('#input_folio_venta').val(datos.venta_folio);
        $('#input_fecha_nota').val(datos.fecha_nota);
        $('#input_cliente_venta').val(datos.id_cliente);
        $('#input_ruta_venta').val(datos.id_ruta);
        $('#input_pagado_venta').val(datos.pagado);
        $('#input_por_pagar').val(datos.por_pagar);
        $('#input_efectivo').val(datos.efectivo);
        $('#input_transferencia').val(datos.transferencia);
        $('#input_deposito').val(datos.deposito);
        $('#input_cheque').val(datos.cheque);
        
    });
    $('#tabla_venta tbody').on('click','.liquidar',function(){
        let datos = datatable.row($(this).parents()).data();
        //let id = datos.id_venta;
        //Datos motrados en pantalla
        $('#liq__folio_venta').html(datos.venta_folio);
        $('#liq__cliente_venta').html(datos.cliente);
        $('#liq_pedido_venta').html(datos.pedido);
        $('#liq_pagado_venta').html(datos.pagado);
        $('#liq_por_pagar_venta').html(datos.por_pagar);
        $('#liq_fecha_abono').html(fecha());

        //Datos cargados en inputs ocultos
        $('#input_id_liquidar').val(datos.id_venta);
        $('#input_folio_liquidar').val(datos.venta_folio);
        $('#input_fecha_nota_liquidar').val(datos.fecha_nota);
        $('#input_cliente_liquidar').val(datos.id_cliente);
        $('#input_ruta_liquidar').val(datos.id_ruta);
        $('#input_pagado_ventas').val(datos.pagado);
        $('#input_por_pagare').val(datos.por_pagar);
        $('#input_efectivos').val(datos.efectivo);
        $('#input_transferencias').val(datos.transferencia);
        $('#input_depositos').val(datos.deposito);
        $('#input_cheques').val(datos.cheque);
        
    });

    //Procesa y valida que el abono sea correcto
    $(document).on('click','.procesar_abono',(e)=>{ 

        let montoAbono, montoPagar;
        let abono, faltante;
        montoAbono = $("#monto_abonar").val();
        montoPagar = $("#input_por_pagar").val();
        abono = parseFloat(montoAbono);
        faltante = parseFloat(montoPagar);
        //console.log(faltante+abono);
        
        if(abono>faltante){
            ceros();
            montoAbono = $("#monto_abonar").val('0');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El monto debe ser menor a " + montoPagar + " pesos.",
                footer: "Debe hacer un abono menor al monto pedido.",
            });
        }else if(abono == faltante){
            ceros();
            montoAbono = $("#monto_abonar").val('0');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Parece que estas intentando liquidar la cuenta.",
                footer: "Dirigete al apartado para liquidar.",
            });
        }else if(abono == 0){
            ceros();
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No puedes hacer un abono de cero pesos",
                footer: "Ingresa un monto mayor a cero.",
            });
        }
        else{
            registrarAbonoBase();
             Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Abono registrado',
                    showConfirmButton: false,
                    timer: 1500 }).then(function () {
                        location.reload();      
          });
        }
        
    });
    $(document).on('click','.cargarAbono',(e)=>{ 
        let ab_efectivo,ab_trasnferencia, ab_deposito, ab_cheque;
        let efec, transf,dept,cheque;
        let totalAbono;
        ab_efectivo = $("#ab_efectivo").val();
        ab_trasnferencia = $("#ab_transferencia").val();
        ab_deposito = $("#ab_deposito").val();
        ab_cheque = $("#ab_cheque").val();
        
        efec = parseFloat(ab_efectivo);
        transf = parseFloat(ab_trasnferencia);
        dept = parseFloat(ab_deposito);
        cheque = parseFloat(ab_cheque);

        totalAbono = Number(efec+transf+dept+cheque);

        $('#monto_abonar').val(totalAbono);
        
    });
    //Suma el total de los montos para liquidar
    $(document).on('click','.cargarLiquido',(e)=>{ 
        let liq_efectivo,liq_trasnferencia, liq_deposito, liq_cheque;
        let efect, transfe,depto,cheques;
        let totalLiquido;
        liq_efectivo = $("#liq_efectivo").val();
        liq_trasnferencia = $("#liq_transferencia").val();
        liq_deposito = $("#liq_deposito").val();
        liq_cheque = $("#liq_cheque").val();
        
        efect = parseFloat(liq_efectivo);
        transfe = parseFloat(liq_trasnferencia);
        depto = parseFloat(liq_deposito);
        cheques = parseFloat(liq_cheque);

        totalLiquido = Number(efect+transfe+depto+cheques);

        $('#monto_liquidar').val(totalLiquido);
        
    });
    $(document).on('click','.procesar_liquida',(e)=>{ 

        let montoLiquidar, montoPagare;
        let liquido, faltantes;
        montoLiquidar = $("#monto_liquidar").val();
        montoPagare = $("#input_por_pagare").val();
        liquido = parseFloat(montoLiquidar);
        faltantes = parseFloat(montoPagare);
        //console.log(faltantes+liquido);
        
        if(liquido>faltantes || liquido<faltantes){
            ceros();
            montoLiquidar = $("#monto_liquidar").val('0');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El monto debe ser igual a " + montoPagare + " pesos.",
                footer: "Liquida la nota con un monto igual a " + montoPagare +".",
            });
        }else{
           //liquidarNota();
           registrarLiquidoBase();
             Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Nota liquidada',
                    showConfirmButton: false,
                    timer: 1500 }).then(function () {
                        location.reload();});}
    });

    //Detalla una venta
    $('#tabla_venta tbody').on('click','.ver',function(){
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
            console.log(response);
            let registros = JSON.parse(response);
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
     


    /*Una vez validados los campos de el formulario, registramos la venta */
    function registrarAbono() {
        funcion = 'registrarAbono';

        let id_ventare = $('#input_id_venta').val();
        let aCuentaPasada = $('#input_por_pagar').val();
        let abonoTotal = $('#monto_abonar').val();
        let montoPagado = $('#input_pagado_venta').val();
        //Montos pagados
        let efectivoPagado = $('#input_efectivo').val();
        let transPagado = $('#input_transferencia').val();
        let depositoPagado = $('#input_deposito').val();
        let chequePagado = $('#input_cheque').val();
        //Montos para abonar
        let efectivoAbonar = $('#ab_efectivo').val();
        let transAbonar = $('#ab_transferencia').val();
        let depositoAbonar = $('#ab_deposito').val();
        let chequeAbonar = $('#ab_cheque').val();

        let moPag = parseFloat(montoPagado);
        let aCuPa = parseFloat(aCuentaPasada);
        let aboTo = parseFloat(abonoTotal);

        let efPa = parseFloat(efectivoPagado);
        let transPa = parseFloat(transPagado);
        let deptoPa = parseFloat(depositoPagado);
        let chequePa = parseFloat(chequePagado);

        let efAb = parseFloat(efectivoAbonar);
        let transAb = parseFloat(transAbonar);
        let deptoAb = parseFloat(depositoAbonar);
        let chequeAb = parseFloat(chequeAbonar);


        let ac_deuda = Number(aCuPa-aboTo);
        let ac_acuenta = Number(moPag+aboTo);
        let ac_efectivo = Number(efPa+efAb);
        let ac_transf = Number(transPa+transAb);
        let ac_depto = Number(deptoPa+deptoAb);
        let ac_cheque = Number(chequePa+chequeAb);
       $.post('../controlador/NotasPendientesController.php',{funcion,id_ventare, ac_acuenta, ac_efectivo,ac_transf,ac_depto,ac_cheque, ac_deuda},(response)=>{
           console.log("")
         });

       
    }

    //Funcion settear a cero
    function ceros() {
        let ab_efectivo = $("#ab_efectivo").val('0');
        let ab_trasnferencia = $("#ab_transferencia").val('0');
        let ab_deposito = $("#ab_deposito").val('0');
        let ab_cheque = $("#ab_cheque").val('0');
        let montoAbono = $("#monto_abonar").val('0');
    }
    //Obteniendo la fecha actual para poder trabajar
    function fecha() {
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '/' + (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day;
       return output;
    }
    //Funcion para liquidar una nota
    function liquidarNota() {
        funcion = 'liquidarNota';

        let id_ventare = $('#input_id_liquidar').val();
        let aCuentaPasada = $('#input_por_pagare').val();
        let liquido = $('#monto_liquidar').val();
        let montoPagado = $('#input_pagado_ventas').val();
        //Montos pagados
        let efectivoPagado = $('#input_efectivos').val();
        let transPagado = $('#input_transferencias').val();
        let depositoPagado = $('#input_depositos').val();
        let chequePagado = $('#input_cheques').val();
        //Montos para abonar
        let efectivoLiquidar = $('#liq_efectivo').val();
        let transLiquidar = $('#liq_transferencia').val();
        let depositoLiquidar = $('#liq_deposito').val();
        let chequeLiquidar = $('#liq_cheque').val();

        let moPag = parseFloat(montoPagado);
        let aCuPa = parseFloat(aCuentaPasada);
        let moLiq = parseFloat(liquido);

        let efPa = parseFloat(efectivoPagado);
        let transPa = parseFloat(transPagado);
        let deptoPa = parseFloat(depositoPagado);
        let chequePa = parseFloat(chequePagado);

        let efAb = parseFloat(efectivoLiquidar);
        let transAb = parseFloat(transLiquidar);
        let deptoAb = parseFloat(depositoLiquidar);
        let chequeAb = parseFloat(chequeLiquidar);


        let ac_deuda = Number(aCuPa-moLiq);
        let ac_acuenta = Number(moPag+moLiq);
        let ac_efectivo = Number(efPa+efAb);
        let ac_transf = Number(transPa+transAb);
        let ac_depto = Number(deptoPa+deptoAb);
        let ac_cheque = Number(chequePa+chequeAb);
      $.post('../controlador/NotasPendientesController.php',{funcion,id_ventare, ac_acuenta, ac_efectivo,ac_transf,ac_depto,ac_cheque, ac_deuda},(response)=>{
          console.log(reposne);
         });

       
    }

    function registrarAbonoBase() {
        funcion = 'registrarAbonoBase';
        let id_ventare = $('#input_id_venta').val();
        let reg_ab_folio = $('#input_folio_venta').val();
        let reg_ab_fecha_nota = $('#input_fecha_nota').val();
        let reg_ab_cliente = $('#input_cliente_venta').val();
        let reg_ab_ruta = $('#input_ruta_venta').val();
        let reg_ab_cpta = $('#input_cpta_abona').val();
        let reg_ab_pagado = $('#monto_abonar').val();
        let reg_ab_efectivo = $('#ab_efectivo').val();
        let reg_ab_transferencia = $('#ab_transferencia').val();
        let reg_ab_deposito = $('#ab_deposito').val();
        let reg_ab_cheque = $('#ab_cheque').val();

        $.post('../controlador/NotasPendientesController.php',{funcion,reg_ab_folio, reg_ab_cliente, reg_ab_ruta,reg_ab_cpta,reg_ab_pagado,reg_ab_efectivo, reg_ab_transferencia,reg_ab_deposito,reg_ab_cheque,id_ventare,reg_ab_fecha_nota},(response)=>{
            console.log(response);
         });
        
        }
    
    function registrarLiquidoBase() {
        funcion = 'registrarLiquidoBase';
        let id_ventar = $('#input_id_liquidar').val();
        let reg_liq_folio = $('#input_folio_liquidar').val();
        let reg_liq_cliente = $('#input_cliente_liquidar').val();
        let reg_liq_fecha_nota = $('#input_fecha_nota_liquidar').val();
        let reg_liq_ruta = $('#input_ruta_liquidar').val();
        let reg_liq_cpta = $('#input_cpta_liquidar').val();
        let reg_liq_pagado = $('#monto_liquidar').val();
        let reg_liq_efectivo = $('#liq_efectivo').val();
        let reg_liq_transferencia = $('#liq_transferencia').val();
        let reg_liq_deposito = $('#liq_deposito').val();
        let reg_liq_cheque = $('#liq_cheque').val();

        console.log(id_ventar);
        $.post('../controlador/NotasPendientesController.php',{funcion,id_ventar,reg_liq_folio, reg_liq_cliente, reg_liq_ruta,reg_liq_cpta,reg_liq_pagado,reg_liq_efectivo, reg_liq_transferencia,reg_liq_deposito,reg_liq_cheque,reg_liq_fecha_nota},(response)=>{
            console.log(response)
         });}

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