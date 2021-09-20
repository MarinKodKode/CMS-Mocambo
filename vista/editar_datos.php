<?php
session_start();
if ($_SESSION['id_usuario_tipo'] > 0) {
    include_once 'layouts/header.php';
?>

    <title>Editar Datos</title>
    <link rel="icon" href="../img/cow.svg" />

    <?php
    include_once 'layouts/nav.php'
    ?>

    <!-- Modal cambio de contraseña -->
    <div class="modal fade" id="cambioContraseña" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="modal_pass_img" src="../img/admin_avatar.jpg" class="profile-user-img img-fluid img-circle" alt="username">
                    </div>
                    <div class="text-center mt-2">
                        <strong>
                            <?php
                            echo $_SESSION['nombre_us'];
                            ?>
                        </strong>
                    </div>
                    <form id="editarDatosFormularioPasswordChange">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <em class="fas fa-unlock"></em>
                                </span>
                            </div>
                            <input type="password" id="formOldPasswordChange" class="form-control" placeholder="Contraseña actual">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <em class="fas fa-lock"></em>
                                </span>
                            </div>
                            <input type="text" id="formNewPasswordChange" class="form-control" placeholder="Contraseña nueva">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-danger">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  cambio de foto de perfil-->
    <div class="modal fade" id="cambioFotoPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar foto de perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="mainCardAvatar" src="../img/admin_avatar.jpg" class="profile-user-img img-fluid img-circle" alt="username">
                    </div>
                    <div class="text-center mt-2">
                        <strong>
                            <?php
                            echo $_SESSION['nombre_us'];
                            ?>
                        </strong>
                    </div>
                    <form id="editarDatosFormularioPhotoChange" enctype="multipart/form-data">
                        <div class="input-group mb-3 mt-4 justify-content-center">
                            <input type="file" name="photo" class="input-group" accept="image/*">
                            <input type="hidden" name="funcion" value="cambiar_foto">
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-danger">Guardar cambios</button>
                </div>
                </form>

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
                        <h1>Datos personales</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Datos personales</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>




            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-info card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img id="changeAvatar" src="../img/admin_avatar.jpg" class="profile-user-img img-fluid img-circle" alt="Admin">
                                    </div>
                                    <div class="text-center mt-2">
                                        <button class="btn btn-outline-info btn-sm" type="button" data-toggle="modal" data-target="#cambioFotoPerfil">
                                            Cambiar foto de perfil
                                        </button>
                                    </div>

                                    <input id="id_user" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">


                                    <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">

                                    <h3 id="nombre_us" class="profile-username text-center text-dark">Nombre</h3>
                                    <p id="apellidos_us" class="text-muted text-center">Apellidos</p>
                                    <ul class="list-group list-group">

                                        <li class="list-group-item">
                                            <strong style=" color:#102027">DNi</strong>
                                            <a id="dni_us" class="float-right">25</a>
                                        </li>
                                        <li class="list-group-item">
                                            <strong style=" color:#102027">Tipo de Usuario</strong>
                                            <span id="us_tipo" class="float-right">Administrador</span>
                                        </li>

                                        <button type="button" class="btn btn-block btn-outline-danger mt-2 btn-sm" data-toggle="modal" data-target="#cambioContraseña">Reestablecer contraseña</button>

                                    </ul>
                                </div>
                            </div>
                            <!--Card informacion personal-->
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Información personal</h3>
                                </div>
                                <div class="card-body">
                                    <strong style="color:#0b7300">
                                        <em class="fas fa-phone mr-1"></em>Teléfono
                                    </strong>
                                    <p id="telefono_us" class="text-muted">#######</p>
                                    <strong style="color:#0b7300">
                                        <em class="fas fa-phone-alt mr-1"></em>Teléfono de referencia
                                    </strong>
                                    <p id="phone_us" class="text-muted">######</p>
                                    <strong style="color:#0b7300">
                                        <em class="fas fa-at mr-1"></em>Correo
                                    </strong>
                                    <p id="correo_us" class="text-muted">Correo</p>

                                    <strong style="color:#0b7300">
                                        <em class="fas fa-pencil-alt mr-1"></em>Información adicional
                                    </strong>
                                    <p id="info_us" class="text-muted">Escolaridad, secundaria</p>
                                    <div>
                                        <button type="button" class="btn btn-block bg-gradient-cyan edita">Editar</button>
                                    </div>


                                </div>
                                <div class="card-footer">
                                    <p class="text-muted text-center">Si deseas editar tus datos personales, por favor da aviso a tu adminitrador.</p>
                                </div>
                            </div>
                        </div>
                        <!---Formulaio edicion de datos personales-->
                        <div class="col-md-9">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Editar datos personales</h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-success text-center" id="#EditarDatos_Alert-Editado" style="display:none;">
                                        <span><i class="fas fa-check"> Editado</i></span>
                                    </div>
                                    <form id="#form-usuario" class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="telefono" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Teléfono de referencia</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="phone_form" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-2 col-form-label">Coreo electrónico</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="correo" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="informacion" class="col-sm-2 col-form-label">Información adicional</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="informacion" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="offset-sm-2 col-sm-3 float-center">
                                                <button class="actualiza btn btn-block btn-outline-danger" type="submit">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <p class="text-muted">*Ponte en contacto con el administrador*</p>
                                </div>
                            </div>
                        </div>
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
<script src="../js/Usuario.js"></script>