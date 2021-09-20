<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 4) {
    include_once 'layouts/header.php';
?>

    <title>Llegadas</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-6 mx-auto">
            <!-- general form elements disabled -->
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Llegadas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="form_llegadas">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Checador</label>
                                    <input type="text" class="form-control" placeholder="Checador" disabled="" value="<?php echo $_SESSION['nombre_us'] ?>">
                                </div>
                                <input id="id_checador_arr" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" placeholder="Fecha" id="fecha_llegada" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ruta</label>
                                    <select name="ruta" id="ruta_llegada" class="form-control select2" style="width: 100%; height:2em;" required></select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vendedor</label>
                                    <select name="vendor" id="vendedor_llegada" class="form-control select2" style="width: 100%; height:2em;" required></select>
                                </div>
                            </div>
                        </div>

                        <!-- input states -->
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-cheese"></i> Seleccione un producto</label>
                            <select name="ruta" id="producto_llegada" class="form-control select2" style="width: 100%; height:2em;" required></select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputWarning"><i class="fas fa-weight-hanging"></i> Kilogramos devueltos</label>
                            <input type="text" class="form-control" id="kilos_devueltos" placeholder="Enter ..." required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputError"><i class="fas fa-boxes"></i> Piezas devueltas</label>
                            <input type="number" class="form-control" id="piezas_devueltas" placeholder="Piezas..." required>
                        </div>

                        <div class="col-sm-12">
                            <!-- textarea -->
                            <div class="form-group">
                                <label> <i class="far fa-comment-alt"></i>Comentarios adicionales</label>
                                <input class="form-control" placeholder="Añade un comentario" value="Sin comentarios" id="comentarios_llegada" />
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-4 float-center">Registrar</button>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
    </div>
<?php
    include_once 'layouts/footer.php';
} else {
    header('Location:../vista/login.php');
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/datatables.js"></script>
<script src="../js/Llegadas.js"></script>