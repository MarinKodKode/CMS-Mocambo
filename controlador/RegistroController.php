<?php
include '../modelo/Venta.php';
include_once '../modelo/conexion.php';
$venta = new Venta();
session_start();
##$vendedor = $_SESSION['usuario'];
/*
if ($_POST['funcion'] == 'registrarVenta') {
    $ruta = $_POST['v_ruta'];
    $cliente = $_POST['v_cliente'];
    $folio = $_POST['v_folio'];
    $capturista = $_POST['v_capturista'];
    $efectivo = $_POST['t_efectivo'];
    $transferencia = $_POST['t_transferencia'];
    $deposito = $_POST['t_deposito'];
    $cheque = $_POST['t_cheque'];
    $totalPedido = $_POST['totalPedido'];
    $totalFinalPagado = $_POST['totalFinalPagado'];
    $deudaVenta = $_POST['deudaVenta'];
    $estado_venta = $_POST['estado_venta'];
    $informacion_adicional = $_POST['informacionAdicional'];
    $productos = json_decode($_POST['json']);
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d H:i:s');

    $venta->registrarVenta($fecha, $ruta, $cliente, $folio, $capturista, $efectivo, $transferencia, $deposito, $cheque, $totalPedido, $totalFinalPagado, $deudaVenta, $estado_venta, $informacion_adicional);
    $venta->ultimaVenta();

    foreach ($venta->objetos_venta as $objeto) {
        $id_venta = $objeto->ultima_venta;
        echo $id_venta;
    }

    ##Cargamos los productos en los registros de la venta
    try {
        $db = new Conexion();
        $conexion = $db->pdo;
        $conexion->beginTransaction();
        foreach ($productos as $prod) {
            $subtotal = $prod->precio_unitario * $prod->cantidad_kg;
            $conexion->exec("INSERT INTO venta_producto(vp_id_producto,vp_piezas,vp_precio_unitario,vp_cantidad_kilogramos,vp_llevo,vp_dia_anterior,vp_subtotal,venta_id_venta) values ('$prod->productoID','$prod->piezas','$prod->precio_unitario','$prod->cantidad_kg','$prod->llevo', '$prod->d_a','$subtotal','$id_venta')");
        }
        $conexion->commit();
    } catch (Exception $error) {

        $conexion->rollBack();
        $venta->borrar_venta($id_venta);
        echo $error->getMessage();
    }
}*/

if ($_POST['funcion'] == 'cargarDeudaAcumulada') {
    $id_cliente = $_POST['clienteActual'];

    $venta->deudaAcumulada($id_cliente);
    foreach ($venta->objetos_venta as $objeto) {
        $deudaAcumulada = $objeto->deuda_acumulada;
        ##echo $deudaAcumulada;
    }
    echo $deudaAcumulada;
}
/*Show last purchase client using id_cliente*/
if ($_POST['funcion'] == 'showLastPurchaseClient') {
    $id_cliente = $_POST['clienteActual'];

    $venta->ultimaVentaByCliente($id_cliente);
    foreach ($venta->objetos_venta as $objeto) {
        $lastPurchaseClient = $objeto->ultima_venta;
    }
    echo $lastPurchaseClient;
}
/*Show average purchase client*/
if ($_POST['funcion'] == 'calculateAveragePurchaseClient') {
    $id_cliente = $_POST['clienteActual'];

    $venta->promedioDeCompraByCliente($id_cliente);
    foreach ($venta->objetos_venta as $objeto) {
        $averagePurchase = $objeto->promedio_compra;
    }
    echo $averagePurchase;
}

if ($_POST['funcion'] == 'sumarTotalesMetodos') {
    $venta->deudaAcumulada($id_cliente);
    foreach ($venta->objetos_venta as $objeto) {
        $deudaAcumulada = $objeto->deuda_acumulada;
        ##echo $deudaAcumulada;
    }
    echo $deudaAcumulada;
}

if ($_POST['funcion'] == 'registrarVentas') {
    $ruta = $_POST['v_ruta'];
    $cliente = $_POST['v_cliente'];
    $folio = $_POST['v_folio'];
    $fecha_venta = $_POST['v_venta'];
    $capturista = $_POST['v_capturista'];
    $efectivo = $_POST['t_efectivo'];
    $transferencia = $_POST['t_transferencia'];
    $deposito = $_POST['t_deposito'];
    $cheque = $_POST['t_cheque'];
    $totalPedido = $_POST['totalPedido'];
    $totalFinalPagado = $_POST['totalFinalPagado'];
    $deudaVenta = $_POST['deudaVenta'];
    $estado_venta = $_POST['estado_venta'];
    $informacion_adicional = $_POST['informacionAdicional'];
    $productos = json_decode($_POST['json']);
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d H:i:s');

    $venta->registrarVenta($fecha, $ruta, $cliente, $folio, $capturista, $efectivo, $transferencia, $deposito, $cheque, $totalPedido, $totalFinalPagado, $deudaVenta, $estado_venta, $informacion_adicional, $fecha_venta);
    $venta->ultimaVenta();

    foreach ($venta->objetos_venta as $objeto) {
        $id_venta = $objeto->ultima_venta;
        echo $id_venta;
    }

    ##Cargamos los productos en los registros de la venta
    try {
        $db = new Conexion();
        $conexion = $db->pdo;
        $conexion->beginTransaction();
        foreach ($productos as $prod) {
            $subtotal = $prod->precio_unitario * $prod->cantidad_kg;
            $conexion->exec("INSERT INTO venta_producto_det(vp_id_producto,vp_piezas_vendidas,vp_kilos_vendidos,vp_precio_unitario_kilo,vp_piezas_devueltas,vp_kilos_devueltos,vp_subtotal,venta_id_venta) values ('$prod->productoID','$prod->piezas','$prod->cantidad_kg','$prod->precio_unitario','$prod->piezas_devueltas', '$prod->kilos_devueltos','$subtotal','$id_venta')");
        }
        $conexion->commit();
    } catch (Exception $error) {

        $conexion->rollBack();
        $venta->borrar_venta($id_venta);
        echo $error->getMessage();
    }
}

if ($_POST['funcion'] == 'totalesIngresados') {
    $id_ruta = $_POST['id_ruta'];
    $fecha = $_POST['fecha_reporte'];
    $venta->totalesProducto($id_ruta, $fecha);
    $json = array();
    foreach ($venta->objetos_venta as $objeto) {
        $json[] = $objeto;
    }
    /*
    foreach ($venta->objetos_venta as $objeto) {
        $json[] = array(
            'ruta' => $objeto->ruta_nombre,
            'efectivo' => $objeto->total_efectivo,
            'transferencia' => $objeto->total_transferencia,
            'deposito' => $objeto->total_deposito,
            'cheque' => $objeto->total_cheque,
            'total_ruta' => $objeto->total_ruta
        );
    }*/
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
