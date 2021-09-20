<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Gestión de usuarios</title>
    <link rel="icon" href="../img/cow.svg" />

    <?php
    include_once 'layouts/nav.php'
    ?>

    <div class="modal fade" id="seguridadAsc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingresa la contraseña para continuar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="modal_confirm" src="../img/lock.png" class="profile-user-img img-fluid img-circle" alt="username">
                    </div>
                    <div class="text-center mt-2 mb-2">
                        <strong>
                            <?php
                            echo $_SESSION['nombre_us'];
                            ?>
                        </strong>
                    </div>
                    <span class="mb-2">Por seguridad debes ingresar tu contraseña</span>
                    <form id="formSecurity">
                        <input id="history_gus" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                        <div class="input-group mb-3 mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <em class="fas fa-unlock"></em>
                                </span>
                            </div>
                            <input type="password" id="confirmpass" class="form-control" placeholder="Contraseña">
                            <input type="hidden" id="id_user">
                            <input type="hidden" id="funcion_adm">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-danger">Confirmar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal  creación de un usuario nuevo-->
    <div class="modal fade" id="crear_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo usuario</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_crear_usuario">
                            <input id="history_gu" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                            <div class="form-group">
                                <label for="">Nombre (s)</label>
                                <input type="text" id="nombre_new_user" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="">Apellido (s)</label>
                                <input type="text" id="apellido_new_user" class="form-control" placeholder="Apellido" required>
                            </div>
                            <div class="form-group">
                                <label for=""> Teléfono</label>
                                <input type="text" id="telefono_new_user" class="form-control" placeholder="Teléfono" required>
                            </div>
                            <div class="form-group">
                                <label for=""> DNI</label>
                                <input type="text" value=" " id="dni_new_user" class="form-control" placeholder="DNI" required>
                            </div>
                            <div class="form-group">
                                <label for="">Contraseña *</label>
                                <input type="text" value="panda" readonly="readonly" id="password_new_user" class="form-control" placeholder="Contraseña" required>
                                <cite class="ml-1"><small>** Recuerde cambiar la contraseña por defecto posteriormente</small></cite>
                            </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-info float-right">Crear</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de usuarios
                            <button id="button_crear_usuario" class="btn bg-gradient-primary ml-3" type="button" data-toggle="modal" data-target="#crear_usuario">
                                Crear nuevo usuario
                            </button>
                        </h1>
                        <input type="hidden" id="tipo_usuario_gu" value="<?php echo $_SESSION['id_usuario_tipo'] ?>">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_registro_venta.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión de usuarios</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Buscar un usuario</h3>
                        <div class="input-group">
                            <input type="text" id="buscar_usuario" placeholder="Ingresa el nombre del usuario" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button-btn>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="div_usuarios" class="row d-flex align-items-stretch">

                        </div>

                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </section>


    </div>
<?php
    include_once 'layouts/footer.php';
} else {
    header('Location:../vista/login.php');
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="../js/Gestion_usuario.js"></script>