<?php
include '../modelo/Vendedor.php';

$vendedor = new Vendedor();
if ($_POST['funcion'] == 'listar') {
    $vendedor->buscarVendedores();
    $json = array();
    foreach ($vendedor->objetos_vendedor as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'crearVendedor') {
    $new_vend_nombre = $_POST['new_vend_nombre'];
    $new_vend_apellidos = $_POST['new_vend_apellidos'];
    $new_vend_telefono = $_POST['new_vend_telefono'];
    $new_vend_ruta = $_POST['new_vend_ruta'];
    $avatar_default_vend = 'customer.png';
    $vendedor->crearVendedor($new_vend_nombre, $new_vend_apellidos, $new_vend_telefono, $new_vend_ruta, $avatar_default_vend);
}
##Funcion borrar un cliente de la base de datos
if ($_POST['funcion'] == 'deleteVendedor') {
    $idVendor = $_POST['id_vendor'];
    $vendedor->borrarVendedor($idVendor);
}
##Llenar los clientes 
if ($_POST['funcion'] == 'llenarVendedores') {
    $vendedor->rellenarVendedores();
    $json = array();
    foreach ($vendedor->objetos_vendedor as $objeto) {
        $json[] = array(
            'id' => $objeto->id_vendedor,
            'nombre' => $objeto->vendedor_nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
