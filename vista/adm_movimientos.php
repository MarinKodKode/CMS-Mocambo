<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Notas pendientes</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Historial de movimientos</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_registro_venta.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Historial de movimientos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card card-blue">
                    <div class="card-header" style="background-color: #002f6c;">
                    </div>
                    <div class="card-body">
                        <table id="tabla_movimientos" class="display table table-hover text-nowrap" style="width:100%" aria-describedby="Tabla de notas por pagar">
                            <thead>
                                <tr>
                                    <th id="id_mov">Movimiento</th>
                                    <th id="fecha_mov">Fecha y hora</th>
                                    <th id="usuario_mov">Usuario</th>
                                    <th id="action_mov">Acción</th>
                                    <th id="object_mov">Objeto</th>
                                    <th id="detail_mov">Detalle</th>
                                    <th id="r_mov">Acciones</th>
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
<script src="../js/Movimientos.js"></script>
<script src="../js/datatables.js"></script>