<?php
include_once '../modelo/VentaModelo.php';
$venta_producto = new VentaModelo();


if ($_POST['funcion'] == 'ver') {
    $id = $_POST['id'];
    $venta_producto->ver($id);
    $json = array();
    foreach ($venta_producto->objetos_venta_modelo as $objeto) {
        $json[] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}


if ($_POST['funcion'] == 'totalesProductos') {
    $id_ruta = $_POST['id_ruta'];
    $fecha_reporte = $_POST['fecha_reporte'];
    $venta_producto->totalesProducto($id_ruta, $fecha_reporte);
    $json = array();
    foreach ($venta_producto->objetos_venta_modelo as $objeto) {
        $json[] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
