<?php
include '../modelo/Metodo.php';
$metodo = new Metodo();


##Buscar todos los metodos en la base de datos
if ($_POST['funcion'] == 'buscarMetodo') {
    $metodo->buscarMetodo();
    $json = array();
    foreach ($metodo->objetos_metodo as $objeto) {
        $json[] = array(
            'id' => $objeto->id_metodo_pago,
            'nombre_metodo' => $objeto->metodo_nombre,
            'avatar_metodo' => '../img/pago/' . $objeto->metodo_avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
##Crear un nuevo metodo de pago en la base de datos
if ($_POST['funcion'] == 'crearMetodo') {
    $new_metodo_nombre = $_POST['new_metodo_nombre'];
    $avatar_metodo = 'salary.png';
    $metodo->crearMetodo($new_metodo_nombre, $avatar_metodo);
}
##Funcion borrar un metodo de la base de datos
if ($_POST['funcion'] == 'deleteMetodo') {
    $idMetodo = $_POST['idMetodo'];
    $metodo->borrarMetodo($idMetodo);
}
