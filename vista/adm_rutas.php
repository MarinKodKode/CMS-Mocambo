<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Adm | Rutas</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!--Modal nueva ruta-->
    <div class="modal fade" id="crear_ruta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Nueva ruta</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">

                        <div class="alert alert-success text-center" id="addlab" style="display: none;">
                            <span><i class="fas fa-check m-1">Ruta creada</i></span>
                        </div>
                        <div class="alert alert-success text-center" id="noaddlab" style="display: none;">
                            <span><i class="fas fa-times m-1 ">Ya existe la ruta</i></span>
                        </div>

                        <form id="form_crear_ruta">
                            <div class="form-group">
                                <input id="id_user_history" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                                <label for="">Ruta</label>
                                <input type="text" id="nombre_new_ruta" class="form-control" placeholder="Nueva ruta" required>

                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-info float-right">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--Modal editar ruta-->
    <div class="modal fade" id="editar_ruta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Editar ruta</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_editar_ruta">
                            <div class="form-group">
                                <input id="id_user_historya" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                                <label for="">Ruta</label>
                                <input type="text" id="nombreRutaEdit" class="form-control" placeholder="Editar ruta" required>
                                <input type="hidden" id="idEditarRuta">
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-info float-right">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <!-- Modal  cambio de foto de perfil-->
    <div class="modal fade" id="cambioFotoLab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar logo de ruta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="rutaAvatar" src="../img/admin_avatar.jpg" class="profile-user-img img-fluid img-circle" alt="username">
                    </div>
                    <div class="text-center mt-2">
                        <strong id="nombre_ruta_modal"></strong>
                    </div>
                    <form id="formLogoRuta" enctype="multipart/form-data">
                        <div class="input-group mb-3 mt-4 justify-content-center">
                            <input type="file" name="photo" class="input-group" accept="image/*">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id_logo_ruta" id="id_logo_ruta">
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
                        <h1>Gestión de rutas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión de rutas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!--  <div class="card-header">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a href="#laboratorio" class="nav-link active" data-toggle="tab">Laboratorio</a></li>
                                </ul>
                            </div> -->
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="rutas">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #002f6c; color:aliceblue;">
                                                <card class="card-title">Buscar ruta <button type="button" data-toggle="modal" data-target="#crear_ruta" class="btn bg-gradient-danger btn-sm m-2">Crear ruta</button></card>
                                                <div class="input-group">
                                                    <input id="buscar_ruta" type="text" class="form-control float-left" placeholder="Ingrese ruta">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-hover text-nowrap">
                                                    <thead class="table-info">
                                                        <tr>
                                                            <th id="title_ruta">Ruta</th>
                                                            <th id="title_logo">Logo</th>
                                                            <th id="title_info">Clientes</th>
                                                            <th id="title_acciones">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table" id="rutas_body">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/Ruta.js"></script>