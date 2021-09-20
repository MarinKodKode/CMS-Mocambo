<?php
include_once '../modelo/usuario.php';
$usuario = new Usuario();
session_start();
$id_usuario = $_SESSION['usuario'];



if ($_POST['funcion'] == 'buscar_usuario') {

    $json = array();
    $usuario->obtener_datos($_POST['dato']);
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'nombre'    => $objeto->usuario_nombre,
            'apellidos' => $objeto->usuario_apellido,
            'dni'       => $objeto->usuario_dni,
            'tipo'      => $objeto->id_usuario_tipo,
            'telefono'  => $objeto->usuario_telefono,
            'correo'    => $objeto->usuario_correo,
            'phone' => $objeto->usuario_telefono_ref,
            'info'      => $objeto->informacion_adicional,
            'tipo_desc'      => $objeto->tipo_usuario,
            'avatar' => '../img/' . $objeto->usuario_avatar
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'capturar_datos') {

    $json = array();
    $id_usuario = $_POST['id_usuario'];
    $usuario->obtener_datos($id_usuario);

    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'telefono'  => $objeto->usuario_telefono,
            'telefono_ref' => $objeto->usuario_telefono_ref,
            'correo'    => $objeto->usuario_correo,
            'info'      => $objeto->informacion_adicional
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
//Update and change personal information
if ($_POST['funcion'] == 'editar_usuario') {
    $id_usuario = $_POST['id_usuario'];
    $telefono = $_POST['telefono'];
    $telefono_referencia = $_POST['telefono_referencia'];
    $correo = $_POST['correo'];
    $informacion = $_POST['informacion'];

    $usuario->editar($id_usuario, $telefono, $telefono_referencia, $correo, $informacion);

    echo 'editado';
}
//Update and change password
if ($_POST['funcion'] == 'cambiarConstrasena') {
    $id_usuario = $_POST['id_usuario'];
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];

    $usuario->cambiarcontrasena($id_usuario, $oldpass, $newpass);
}
if ($_POST['funcion'] == 'cambiar_foto') {
    if (($_FILES['photo']['type'] == 'image/jpeg') || ($_FILES['photo']['type'] == 'image/png') || ($_FILES['photo']['type'] == 'image/gif')) {
        $nombre_img = uniqid() . '-' . $_FILES['photo']['name'];
        $ruta = '../img/' . $nombre_img;
        move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
        $usuario->cambiar_photo($id_usuario, $nombre_img);

        foreach ($usuario->objetos as $objeto) {
            unlink('../img/' . $objeto->usuario_avatar);
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
##Buscar todos los usuarios existentes en la base de datos
if ($_POST['funcion'] == 'buscar_usuario_adm') {
    $json = array();
    $currentDate = new DateTime();
    $usuario->admBuscarUsuario();
    foreach ($usuario->objetos as $objeto) {
        //$naciemiento = new DateTime($objeto->edad);
        //$edad = $naciemiento->diff($currentDate);
        //$edadA = $edad->y;
        $json[] = array(
            'id_usuario'    => $objeto->id_usuario,
            'nombre'    => $objeto->usuario_nombre,
            'apellidos' => $objeto->usuario_apellido,
            'telefono'       => $objeto->usuario_telefono,
            'telefono_ref'      => $objeto->usuario_telefono_ref,
            'correo'  => $objeto->usuario_correo,
            'dni' => $objeto->usuario_dni,
            'adicional'    => $objeto->informacion_adicional,
            'avatar' => '../img/' . $objeto->usuario_avatar,
            'tipo_usuario' => $objeto->tipo_usuario,
            'id_tipo_usuario' => $objeto->id_tipo_usuario
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
//Función crear un usuario nuevo, con caracteristicas para poder ingresar informacion al sistema
if ($_POST['funcion'] == 'create_new_user') {
    $nombre_new_user = $_POST['new_user_nombre'];
    $apellido_new_user = $_POST['new_user_apellido'];
    $telefono_new_user = $_POST['new_user_telefono'];
    $dni_new_user = $_POST['new_user_dni'];
    $password_new_user = $_POST['new_user_password'];
    $tipo = 3;
    $default_avatar = 'default_avatar.png';

    $usuario->crear_new_user($nombre_new_user, $apellido_new_user, $telefono_new_user, $dni_new_user, $password_new_user, $tipo, $default_avatar);
}
##Dar de baja a un usuario del sistema
if ($_POST['funcion'] == 'borrarUsuario') {
    $pass = $_POST['pass'];
    $id_borrado = $_POST['id_usuario'];
    $usuario->borrar(
        $pass,
        $id_borrado,
        $id_usuario
    );
}
##Ascender de nivel y funciones a un usuario en especifico
if ($_POST['funcion'] == 'ascender') {
    $pass = $_POST['pass'];
    $id_ascendido = $_POST['id_usuario'];
    $usuario->ascender($pass, $id_ascendido, $id_usuario);
}

if ($_POST['funcion'] == 'descender') {
    $pass = $_POST['pass'];
    $id_descendido = $_POST['id_usuario'];
    $usuario->descender($pass, $id_descendido, $id_usuario);
}
