<?php
include '../modelo/Cliente.php';
$cliente = new Cliente();


if ($_POST['funcion'] == 'buscarCliente') {
    $cliente->buscarCliente();
    $json = array();
    foreach ($cliente->objetos_cliente as $objeto) {
        $json[] = array(
            'cliente_id' => $objeto->id_cliente,
            'cliente_nombre' => $objeto->cliente_nombre,
            'cliente_telefono' => $objeto->cliente_telefono,
            'cliente_correo' => $objeto->cliente_correo,
            'cliente_ruta' => $objeto->ruta_nombre,
            'cliente_ruta_id' => $objeto->id_ruta,
            'cliente_adicional' => $objeto->informacion_adicional,
            'cliente_avatar' => '../img/cliente/' . $objeto->cliente_avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'crearCliente') {
    $new_cliente_nombre = $_POST['new_cliente_nombre'];
    $new_cliente_telefono = $_POST['new_cliente_telefono'];
    $new_cliente_correo = $_POST['new_cliente_correo'];
    $new_cliente_adicional = $_POST['new_cliente_adicional'];
    $new_cliente_ruta = $_POST['new_cliente_ruta'];
    $avatar_default_prod = 'customer.png';
    $cliente->crearCliente($new_cliente_nombre, $new_cliente_telefono, $new_cliente_correo, $new_cliente_adicional, $new_cliente_ruta, $avatar_default_prod);
}
##Funcion borrar un cliente de la base de datos
if ($_POST['funcion'] == 'deleteCliente') {
    $idCliente = $_POST['idCliente'];
    $cliente->borrarCliente($idCliente);
}
##Editar un cliente con registro previo
if ($_POST['funcion'] == 'editarCliente') {
    $edit_cliente_id = $_POST['edit_cliente_id'];
    $edit_cliente_nombre = $_POST['edit_cliente_nombre'];
    $edit_cliente_telefono = $_POST['edit_cliente_telefono'];
    $edit_cliente_correo = $_POST['edit_cliente_correo'];
    $edit_cliente_adicional = $_POST['edit_cliente_adicional'];
    $edit_cliente_ruta = $_POST['edit_cliente_ruta'];

    $cliente->editarCliente($edit_cliente_id, $edit_cliente_nombre, $edit_cliente_telefono, $edit_cliente_correo, $edit_cliente_adicional, $edit_cliente_ruta);
}
##Llenar los clientes 
if ($_POST['funcion'] == 'llenarClientes') {
    $id_ruta = $_POST['idRuta'];
    $cliente->rellenarClientes($id_ruta);
    $json = array();
    foreach ($cliente->objetos_cliente as $objeto) {
        $json[] = array(
            'id' => $objeto->id_cliente,
            'nombre' => $objeto->cliente_nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'clientes') {
    $cliente->clientes();
    $json = array();
    foreach ($cliente->objetos_cliente as $objeto) {
        $json['data'][] = $objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
