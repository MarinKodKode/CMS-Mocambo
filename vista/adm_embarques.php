<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 4) {
    include_once 'layouts/header.php';
?>

    <title>Embarques</title>
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
        <div class="col-md-6 mx-auto">
            <!-- general form elements disabled -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Embarques</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" id="form_embarque">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Checador</label>
                                    <input type="text" class="form-control" placeholder="Checador" readonly value="<?php echo $_SESSION['nombre_us'] ?>">
                                    <input id="id_checador" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="date" class="form-control" placeholder="Fecha" id="fecha_embarque" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ruta</label>
                                    <select name="ruta" id="ruta_embarque" class="form-control select2" style="width: 100%; height:2em;" required></select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vendedor</label>
                                    <select name="ruta" id="vendedor_embarque" class="form-control select2" style="width: 100%; height:2em;" required></select>
                                </div>
                            </div>
                        </div>

                        <!-- input states -->
                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-cheese"></i> Seleccione un producto</label>

                            <select name="ruta" id="producto_embarque" class="form-control select2" style="width: 100%; height:2em;" required></select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputWarning"><i class="fas fa-weight-hanging"></i> Kilogramos embarcados</label>
                            <input type="text" class="form-control" id="kilos_embarcados" placeholder="Enter ..." required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputError"><i class="fas fa-boxes"></i> Piezas embarcadas</label>
                            <input type="number" class="form-control" id="piezas_embarcadas" placeholder="Piezas..." required>
                        </div>

                        <div class="col-sm-12">
                            <!-- textarea -->
                            <div class="form-group">
                                <label> <i class="far fa-comment-alt"></i>Comentarios adicionales</label>
                                <input id="comentarios_embarque" class="form-control" placeholder="Añade un comentario" value="Sin comentarios" />
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning mt-4 float-center">Registrar</button>
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
<script src="../js/Embarques.js"></script>