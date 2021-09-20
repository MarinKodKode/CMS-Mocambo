<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2 || $_SESSION['id_usuario_tipo'] == 3) {
    include_once 'layouts/header.php';
?>

    <title>Clientes</title>
    <link rel="icon" href="../img/cow.svg" />
    <!-- Select2 style -->
    <link rel="stylesheet" href="../css/select2.css">

    <?php
    include_once 'layouts/nav.php'
    ?>


    <!-- Modal  creación de un cliente  nuevo-->
    <div class="modal fade" id="modal_crear_cliente" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo cliente</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="form_crear_cliente">
                            <input type="hidden" id="user_mov" value="<?php echo $_SESSION['nombre_us'] ?>">

                            <div class="form-group">
                                <label for="">Nombre del cliente</label>
                                <input type="text" id="nombre_new_cliente" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" id="telefono_new_cliente" class="form-control" placeholder="Teléfono" value="Sin datos">
                            </div>
                            <div class="form-group">
                                <label for="">Correo</label>
                                <input type="text" id="correo_new_cliente" class="form-control" placeholder="Correo" value="Sin datos">
                            </div>
                            <div class="form-group">
                                <label for="">Información adicional</label>
                                <input type="text" id="adicional_new_cliente" class="form-control" placeholder="Información adicional" value="Sin información adicional">
                            </div>
                            <div class="form-group">
                                <label for="">Ruta</label>
                                <select name="ruta" id="rutase" class="form-control select2" style="width: 100%; height:2em;" required></select>
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

    <!-- Modal  modificacion de un cliente-->
    <div class="modal fade" id="modal_editar_cliente" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Editar cliente</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="V_form_editar_cliente">
                            <input type="hidden" id="user_move" value="<?php echo $_SESSION['nombre_us'] ?>">
                            <div class="form-group">
                                <label for="">Nombre del cliente</label>
                                <input type="text" id="edit_cliente_nombre" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" id="edit_cliente_telefono" class="form-control" placeholder="Teléfono" required>
                            </div>
                            <div class="form-group">
                                <label for="">Correo</label>
                                <input type="text" id="edit_cliente_correo" class="form-control" placeholder="Correo" required>
                            </div>
                            <div class="form-group">
                                <label for=""> Información adicional</label>
                                <input type="text" step="any" value="Sin información adicional" id="edit_cliente_adicional" class="form-control" placeholder="Información adicional" required>
                            </div>
                            <div class="form-group">
                                <label for=""> Ruta</label>
                                <select name="edit_cliente_ruta" id="edit_cliente_rutase" class="form-control select2" style="width: 100%; height:2em;"></select>
                            </div>
                            <input type="hidden" name="funcion" id="funcional">
                            <input type="hidden" id="id_edit_cliente">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-info float-right">Editar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Detalle de un cliente-->
    <div class="modal fade" id="vista_venta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card card-secondary">
                    <div class="card-header">
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="center" src="../img/moo.png" alt="" width="100px">
                            <h3 class="m-3">Detalle cliente</h3>
                        </div>

                        <div class="row">
                            <div class="col-md-6 pl-5 pr-5">
                                <div class="form-group">
                                    <label for="cliente">Cliente:</label>
                                    <span id="det_cliente"></span>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono:</label>
                                    <span id="det_telefono"></span>
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo:</label>
                                    <span id="det_correo"></span>
                                </div>
                                <div class="form-group">
                                    <label for="adicional">Información adicional:</label>
                                    <span id="det_adicional"></span>
                                </div>
                                <div class="form-group">
                                    <label for="ruta">Ruta:</label>
                                    <span id="det_ruta"></span>
                                </div>
                                <input type="hidden" id="cliente_deuda">

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deuda">Deuda acumulada:</label>
                                    <span id="det_deuda"></span>
                                </div>
                                <div class="form-group">
                                    <label for="promedio">Promedio de compra:</label>
                                    <span id="det_promedio"></span>
                                </div>
                                <div class="form-group">
                                    <label for="ultima_compra">Última compra</label>
                                    <span id="det_compra"></span>
                                </div>
                            </div>

                        </div>





                    </div>
                    <div class="card-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>

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
                        <h1>Gestión de clientes
                            <button id="button_crear_producto" class="btn bg-gradient-info ml-3" type="button" data-toggle="modal" data-target="#modal_crear_cliente">
                                Crear cliente
                            </button>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión de clientes</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla_clientes" class="display table  table-hover text-nowrap" style="width:100%" aria-describedby="Tabla de clientes">
                            <thead class="bg bg-info">
                                <tr>
                                    <th style="display:none;" id="id_cliente">ID</th>
                                    <th id="cliente">Cliente</th>
                                    <th id="telefono">Teléfono</th>
                                    <th id="ruta">Ruta</th>
                                    <th id="acciones">Acciones</th>
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
<script src="../js/Cliente.js"></script>
<script src="../js/datatables.js"></script>