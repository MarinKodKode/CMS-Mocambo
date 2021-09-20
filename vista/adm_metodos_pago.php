<?php
session_start();
if ($_SESSION['id_usuario_tipo'] > 0) {
    include_once 'layouts/header.php';
?>

    <title>Métodos de pago</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!--Modal nueva ruta-->
    <div class="modal fade" id="nuevo_metodo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Nueva método de pago</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_crear_metodo">
                            <div class="form-group">
                                <label for="">Método</label>
                                <input type="text" id="nombre_new_metodo" class="form-control" placeholder="Nueva método de pago" required>
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Métodos de pago</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Métodos de pago</li>
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
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <card class="card-title"><button type="button" data-toggle="modal" data-target="#nuevo_metodo_pago" class="btn bg-gradient-primary btn-sm m-2">Crear método de pago</button></card>
                                                <div class="input-group">

                                                </div>
                                            </div>
                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-hover text-nowrap">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th id="title_ruta">Método</th>
                                                            <th id="title_logo">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-active" id="metodos_body">

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
<script src="../js/Metodo.js"></script>