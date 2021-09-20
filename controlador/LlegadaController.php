<?php
include '../modelo/Llegada.php';
$llegada = new Llegada();


##Crear un producto nuevo en la base de datos
if ($_POST['funcion'] == 'registrar_llegada') {
    $id_checador = $_POST['checador_id'];
    $id_producto = $_POST['producto_id'];
    $id_ruta = $_POST['ruta_id'];
    $fecha_arr = $_POST['fecha_arr'];
    $id_vendedor = $_POST['vendedor_id'];
    $kg_devueltos = $_POST['kg_arr'];
    $piezas_devueltas = $_POST['piezas_arr'];
    $comentarios_arr = $_POST['comentarios'];
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha_arr_emb = date('Y-m-d H:i:s');
    $llegada->registrarLlegada($id_checador, $id_producto, $id_ruta, $fecha_arr, $fecha_arr_emb, $id_vendedor, $kg_devueltos, $piezas_devueltas, $comentarios_arr);
}
