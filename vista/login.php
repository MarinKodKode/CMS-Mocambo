<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/css/all.min.css">
    <link rel="icon" href="../img/cow.svg" />

</head>
<?php
//Validatind there is a current session
session_start();
if (!empty($_SESSION['id_usuario_tipo'])) {

    header('Location: ../controlador/LoginController.php');
} else {

?>

    <body>
        <img class="wave" src="../img/wave.png" alt="">
        <div class="contenedor">
            <div class="img">
                <img src="../img/factorya.svg" alt="">
            </div>
            <div class="contenido-login">
                <form action="../controlador/LoginController.php" method="post">
                    <img src="../img/cow.svg" alt="">
                    <h2>Quesos Camacho</h2>
                    <div class="input-div dni">
                        <div class="i">
                            <em class="fas fa-user"></em>
                        </div>
                        <div class="div">
                            <h5></h5>
                            <input type="text" name="usuario" class="input" placeholder="Identificate">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <em class="fas fa-lock"></em>
                        </div>
                        <div class="div">
                            <h5></h5>
                            <input type="password" name="password" class="input" placeholder="Contraseña">
                        </div>
                    </div>
                    <a href="#">Sistema</a>
                    <input type="submit" class="btn" value="Iniciar sesión">
                </form>
            </div>
        </div>
        <script src="/js/login.js"></script>
    </body>


</html>
<?php
}
?>