<?php
include_once '../modelo/Usuario.php';
session_start();
$user = $_POST['usuario'];
$pass = $_POST['password'];

echo $user;

$usuario = new Usuario();


if (!empty($_SESSION['id_usuario_tipo'])) {

    switch ($_SESSION['id_usuario_tipo']) {
        case 1:
            header('Location: ../vista/adm_registro_venta.php');
            break;
        case 2:
            header('Location: ../vista/adm_registro_venta.php');
            break;
        case 3:
            header('Location: ../vista/adm_registro_venta.php');
            break;
        case 4:
            header('Location: ../vista/adm_embarques.php');
            break;
    }
} else {
    $usuario->Login($user, $pass);
    if (!empty($usuario->objetos)) {
        foreach ($usuario->objetos as $objeto) {
            $_SESSION['usuario'] = $objeto->id_usuario;
            $_SESSION['id_usuario_tipo'] = $objeto->id_usuario_tipo;
            $_SESSION['nombre_us'] = $objeto->usuario_nombre;
        }


        switch ($_SESSION['id_usuario_tipo']) {

            case 1:
                header('Location: ../vista/adm_registro_venta.php');
                break;
            case 2:
                header('Location: ../vista/adm_registro_venta.php');
                break;
            case 3:
                header('Location: ../vista/adm_registro_venta.php');
                break;
            case 4:
                header('Location: ../vista/adm_embarques.php');
                break;
        }
    } else {
        $var = "El usuario o la contraseña son incorrectos";
        echo "<script> alert('" . $var . "');
             window.location.href='../vista/login.php';
</script>";
    }
}
