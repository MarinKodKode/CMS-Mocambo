<?php
include '../modelo/Venta.php';

$venta = new Venta();
if ($_POST['funcion'] == 'listar') {
    $venta->buscarVenta();
    $json = array();
    foreach ($venta->objetos_venta as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'historial') {
    $venta->historial();
    $json = array();
    foreach ($venta->objetos_venta as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'registrarAbono') {
    $id_venta = $_POST['id_ventare'];
    $montoActualizado = $_POST['ac_acuenta'];
    $ac_efectivo = $_POST['ac_efectivo'];
    $ac_transf = $_POST['ac_transf'];
    $ac_depto = $_POST['ac_depto'];
    $ac_cheque = $_POST['ac_cheque'];
    $ac_deuda = $_POST['ac_deuda'];

    $venta->registrarAbono($id_venta, $montoActualizado, $ac_efectivo, $ac_transf, $ac_depto, $ac_cheque, $ac_deuda);
    //$venta->updatePayments($id_venta);
}

if ($_POST['funcion'] == 'liquidarNota') {
    $id_venta = $_POST['id_ventare'];
    $montoActualizado = $_POST['ac_acuenta'];
    $ac_efectivo = $_POST['ac_efectivo'];
    $ac_transf = $_POST['ac_transf'];
    $ac_depto = $_POST['ac_depto'];
    $ac_cheque = $_POST['ac_cheque'];
    $ac_deuda = $_POST['ac_deuda'];

    $venta->liquidarNota($id_venta, $montoActualizado, $ac_efectivo, $ac_transf, $ac_depto, $ac_cheque, $ac_deuda);
}
if ($_POST['funcion'] == 'registrarAbonoBase') {
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha_reg = date('Y-m-d H:i:s');

    $id_ventare = $_POST['id_ventare'];
    $folio = $_POST['reg_ab_folio'];
    $fecha_nota = $_POST['reg_ab_fecha_nota'];
    $cliente = $_POST['reg_ab_cliente'];
    $ruta = $_POST['reg_ab_ruta'];
    $capturista = $_POST['reg_ab_cpta'];
    $totalFinalPagado = $_POST['reg_ab_pagado'];
    $efectivo = $_POST['reg_ab_efectivo'];
    $transferencia = $_POST['reg_ab_transferencia'];
    $deposito = $_POST['reg_ab_deposito'];
    $cheque = $_POST['reg_ab_cheque'];

    $venta->registrarAbonoBase($folio, $fecha_reg,  $cliente, $ruta, $capturista, $totalFinalPagado, $efectivo, $transferencia, $deposito, $cheque, $fecha_nota);

    $venta->sumAllPayments($folio, $cliente);

    foreach ($venta->objetos_venta as $objeto) {
        $por_pagar = $objeto->por_pagar;
        echo $por_pagar;
    }

    $venta->updateDebt($id_ventare, $por_pagar);
}
if ($_POST['funcion'] == 'registrarLiquidoBase') {
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha_reg = date('Y-m-d H:i:s');
    $id_ventar = $_POST['id_ventar'];
    $folio = $_POST['reg_liq_folio'];
    $cliente = $_POST['reg_liq_cliente'];
    $date_nota = $_POST['reg_liq_fecha_nota'];
    $ruta = $_POST['reg_liq_ruta'];
    $capturista = $_POST['reg_liq_cpta'];
    $totalFinalPagado = $_POST['reg_liq_pagado'];
    $efectivo = $_POST['reg_liq_efectivo'];
    $transferencia = $_POST['reg_liq_transferencia'];
    $deposito = $_POST['reg_liq_deposito'];
    $cheque = $_POST['reg_liq_cheque'];

    $venta->registrarLiquidoBase($folio, $fecha_reg,  $cliente, $ruta, $capturista, $totalFinalPagado, $efectivo, $transferencia, $deposito, $cheque, $date_nota);

    $venta->updateDataNote($id_ventar);
}
