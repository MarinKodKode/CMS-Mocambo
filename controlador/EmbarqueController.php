<?php
include '../modelo/Embarque.php';
$embarque = new Embarque();


##Crear un producto nuevo en la base de datos
if ($_POST['funcion'] == 'registrar_embarque') {
    $id_checador = $_POST['checador_id'];
    $id_producto = $_POST['producto_id'];
    $id_ruta = $_POST['ruta_id'];
    $fecha_emb = $_POST['fecha_emb'];
    $id_vendedor = $_POST['vendedor_id'];
    $kg_embarcados = $_POST['kg_emb'];
    $piezas_embarcadas = $_POST['piezas_emb'];
    $comentarios_emb = $_POST['comentarios'];
    ##Calcular fecha
    date_default_timezone_set('America/Mexico_City');
    $fecha_reg_emb = date('Y-m-d H:i:s');
    $embarque->registrarEmbarque($id_checador, $id_producto, $id_ruta, $fecha_emb, $fecha_reg_emb, $id_vendedor, $kg_embarcados, $piezas_embarcadas, $comentarios_emb);
}
