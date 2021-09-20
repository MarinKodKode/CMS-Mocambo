<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Productos</title>
    <link rel="icon" href="../img/cow.svg" />
    <!-- Select2 style -->
    <link rel="stylesheet" href="../css/select2.css">

    <?php
    include_once 'layouts/nav.php'
    ?>

    <!-- Modal  creación de un producto  nuevo-->
    <div class="modal fade" id="modal_crear_prodcuto" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo producto</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_crear_producto">
                            <input id="id_history_user" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                            <div class="form-group">
                                <label for="">Nombre del producto</label>
                                <input type="text" id="nombre_new_producto" class="form-control" placeholder="Producto" required>
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

    <!-- Modal  cambio de foto de perfil-->
    <div class="modal fade" id="cambioFotoProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar imagen del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="prodAvatar" src="../img/cow.svg" class="profile-user-img img-fluid img-circle" alt="username">
                    </div>
                    <div class="text-center mt-2">
                        <strong id="nombre_prod_modal"></strong>
                    </div>
                    <form id="formLogoProd" enctype="multipart/form-data">
                        <input id="id_history_user_img" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                        <div class="input-group mb-3 mt-4 justify-content-center">
                            <input type="file" name="photo" class="input-group" accept="image/*">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id_logo_prod" id="id_logo_prod">
                            <input type="hidden" name="avatar" id="avatar">
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
                        <h1>Gestión de productos
                            <button id="button_crear_producto" class="btn bg-gradient-primary ml-3" type="button" data-toggle="modal" data-target="#modal_crear_prodcuto">
                                Crear nuevo producto
                            </button>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión de producto</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Buscar un producto</h3>
                        <div class="input-group">
                            <input type="text" id="buscar_producto" placeholder="Ingresa el producto" class="form-control float-left">
                            <div class="input-group-append">
                                <button class="btn btn-default"><i class="fas fa-search"></i></button-btn>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="div_productos" class="row d-flex align-items-stretch">
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
<script src="../js/Producto.js"></script>