<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Vendedores</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!-- Modal  creación de un vendedor  nuevo-->
    <div class="modal fade" id="crear_vendedor" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo vendedor</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_crear_vendedor">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" id="nombre_new_vendedor" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="">Apellidos</label>
                                <input type="text" id="apellidos_new_vendedor" class="form-control" placeholder="Apellidos" required>
                            </div>
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" id="telefono_new_vendedor" class="form-control" placeholder="Teléfono" required>
                            </div>
                            <div class="form-group">
                                <label for="">Ruta</label>
                                <select name="ruta" id="ruta_new_vendedor" class="form-control select2" style="width: 100%; height:2em;" required></select>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right">Crear</button>
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
                        <h1>Vendedores</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Vendedores</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-blue">
                    <div class="card-header" style="background-color: #00766c;">
                        <h3 class="card-title">Buscar vendedores</h3>
                        <button type="button" data-toggle="modal" data-target="#crear_vendedor" class="btn bg-gradient-info btn-sm ml-5">Crear vendedor</button>

                    </div>
                    <div class="card-body">
                        <table id="tabla_vendedores" class="display table table-hover text-nowrap" style="width:100%" aria-describedby="Tabla de notas por pagar">
                            <thead>
                                <tr>
                                    <th id="ven_nombre">Nombre</th>
                                    <th id="ven_apellido">Apellido</th>
                                    <th id="ven_ruta">Ruta</th>
                                    <th id="ven_adicional">Adicional</th>
                                    <th id="ven_acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
<script src="../js/select2.js"></script>
<script src="../js/Vendedores.js"></script>
<script src="../js/datatables.js"></script>