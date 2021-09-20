<?php
include '../modelo/Ruta.php';
$ruta = new Ruta();

if ($_POST['funcion'] == 'crear_ruta') {
    $nombre_new_ruta = $_POST['nombre_new_ruta'];
    $avatar_ruta = 'route_def.png';
    $ruta->crear_new_ruta($nombre_new_ruta, $avatar_ruta);
}
##Buscar todas las rutas en la base de datos
if ($_POST['funcion'] == 'buscar_ruta') {
    $ruta->buscar_ruta();
    $json = array();
    foreach ($ruta->objetos_ruta as $objeto) {
        $json[] = array(
            'id' => $objeto->id_ruta,
            'nombre_ruta' => $objeto->ruta_nombre,
            'avatar_ruta' => '../img/lab/' . $objeto->ruta_avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
##Funcion borrar una ruta de la base de datos
if ($_POST['funcion'] == 'deleteRuta') {
    $idRuta = $_POST['idRuta'];
    $ruta->borrarRuta($idRuta);
}
##Cambiar el logo de una ruta, hacer las validaciones del tipo de archivo
if ($_POST['funcion'] == 'cambiarFotoRuta') {
    $idRuta = $_POST['id_logo_ruta'];
    if (($_FILES['photo']['type'] == 'image/jpeg') || ($_FILES['photo']['type'] == 'image/png') || ($_FILES['photo']['type'] == 'image/gif')) {
        $nombre_img = uniqid() . '-' . $_FILES['photo']['name'];
        $route = '../img/lab/' . $nombre_img;
        move_uploaded_file($_FILES['photo']['tmp_name'], $route);

        $ruta->cambiarLogoRuta($idRuta, $nombre_img);

        foreach ($ruta->objetos_ruta as $objeto) {
            if ($objeto->ruta_avatar != 'route_def.png') {
                unlink('../img/lab/' . $objeto->ruta_avatar);
            }
        }
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}

if ($_POST['funcion'] == 'editarRuta') {
    $nombre_edit_ruta = $_POST['nombreRutaEdit'];
    $id_editado = $_POST['idRutaEdit'];
    $ruta->editarRuta($nombre_edit_ruta, $id_editado);
}
if ($_POST['funcion'] == 'searchSpecificItemById') {
    $item_id = $_POST['id_ruta'];
    $data = $ruta->searchSpecificItemById($item_id);
    $json = array();
    foreach ($ruta->objetos_ruta as $objeto) {
        $json[] = array(
            'id' => $objeto->id_ruta,
            'nombre_ruta' => $objeto->ruta_nombre,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'llenarRutas') {
    $ruta->rellenarRutas();
    $json = array();
    foreach ($ruta->objetos_ruta as $objeto) {
        $json[] = array(
            'id' => $objeto->id_ruta,
            'nombre' => $objeto->ruta_nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
