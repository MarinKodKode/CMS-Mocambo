<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) {
    include_once 'layouts/header.php';
?>

    <title>Historial de movimientos</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!--Crear un lote -->
    <div class="modal fade" id="vista_venta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detalle de venta</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-6 pl-5">
                                <div class="form-group">
                                    <label for="det_folio_venta">Folio:</label>
                                    <span id="det_folio_venta"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_fecha">Fecha:</label>
                                    <span id="det_fecha"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_cliente">Cliente:</label>
                                    <span id="det_cliente"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_ruta">Ruta:</label>
                                    <span id="det_ruta"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_vendedor">Registró:</label>
                                    <span id="det_vendedor"></span>
                                </div>
                            </div>
                            <div class="col-6 pl-5">
                                <div class="form-group">
                                    <label for="det_pedido">Pedido:</label>
                                    <span id="det_pedido"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_pagado">Pagado:</label>
                                    <span id="det_pagado"></span>
                                </div>
                                <div class="form-group">
                                    <label for="det_por_pagar">Por pagar:</label>
                                    <span id="det_por_pagar"></span>
                                </div>
                            </div>

                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead class="bg bg-info">
                                <tr>
                                    <th id="det_producto">Producto</th>
                                    <th id="det_piezas">Pzas. Vendidas</th>
                                    <th id="kg_vendidos">Kg. Vendidos</th>
                                    <th id="det_precio_unit">Precio unitario</th>
                                    <th id="det_kilos">Pzas. Devueltas</th>
                                    <th id="det_vendio">Kg.Vendidos</th>
                                    <th id="det_llevo">Subtotal producto</th>
                                    <!--<th id="det_devo">Devolvió</th>
                                    <th id="det_subtotal">Subtotal</th>-->
                                </tr>
                            </thead>
                            <tbody class="table-light" id="registros">

                            </tbody>
                        </table>
                        <div class="mt-4 badge badge-warning float-right mr-5">
                            <h5 class="m-3 d-inline">Total pedido: </h5>
                            <h5 class="m-3 d-inline" id="det_total_pedido"></h5>
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
                        <table id="tabla_ventas" class="display table table-hover text-nowrap" style="width:100%" aria-describedby="Tabla de notas por pagar">
                            <thead>
                                <tr>
                                    <th id="folio">Folio</th>
                                    <th id="r_fecha">Fecha</th>
                                    <th id="r_cliente">Cliente</th>
                                    <th id="r_ruta">Ruta</th>
                                    <th id="r_capturista">Capturista</th>
                                    <th id="r_estado">Estado nota</th>
                                    <th id="r_informacion">Información</th>
                                    <th id="r_pedido">Pedido</th>
                                    <th id="r_pagado">Pagado</th>
                                    <th id="r_por_pagar">Por pagar</th>
                                    <th id="r_acciones">Acciones</th>
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
<script src="../js/_jquery.min.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/Historial.js"></script>
<script src="../js/datatables.js"></script>