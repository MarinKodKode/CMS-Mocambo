<?php
include '../modelo/Movimiento.php';

$movimiento = new Movimiento();

if ($_POST['funcion'] == 'historial_mov') {
    $movimiento->historial();
    $json = array();
    foreach ($movimiento->objetos_mov as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'registrarMovimiento') {

    $usuario_mov = $_POST['user_mov'];
    $movimiente = $_POST['movimiento'];
    $objeto_mov = $_POST['objeto_mov'];
    $detalle_mov = $_POST['detail_mov'];
    date_default_timezone_set('America/Mexico_City');
    $fecha_mov = date('Y-m-d H:i:s');

    $movimiento->insertMov($usuario_mov, $movimiente, $objeto_mov, $detalle_mov, $fecha_mov);
}
