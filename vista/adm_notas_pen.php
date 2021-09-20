<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2 || $_SESSION['id_usuario_tipo'] == 3) {
    include_once 'layouts/header.php';
?>

    <title>Notas pendientes</title>
    <link rel="icon" href="../img/cow.svg" />
    <script src="../js/Usuario.js"></script>

    <?php
    include_once 'layouts/nav.php'
    ?>
    <!--Modal abonar a una cuenta-->
    <div class="modal fade" id="modal_abonar_cuenta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="ab_folio_venta" class="h5 col-4">Folio:</label>
                                    <span id="ab_folio_venta" class="h5 col-8">1</span>
                                    <input type="hidden" id="input_id_venta" class="h5 col-8">
                                    <input type="hidden" id="input_folio_venta" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="ab_fecha_venta" class="h5 col-4">Fecha:</label>
                                    <span id="ab_fecha_venta" class="h5 col-8"></span>
                                    <input type="hidden" id="input_fecha_nota" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="ab_cliente_venta" class="h5 col-4">Cliente:</label>
                                    <span id="ab_cliente_venta" class="h5 col-8">Cliente</span>
                                    <input type="hidden" id="input_cliente_venta" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="ab_ruta_venta" class="h5 col-4">Ruta:</label>
                                    <span id="ab_ruta_venta" class="h5 col-8"></span>
                                    <input type="hidden" id="input_ruta_venta" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="ab_capturista_venta" class="h5 col-4">Capturista venta:</label>
                                    <span id="ab_capturista_venta" class="h5 col-8">1</span>
                                    <input type="hidden" id="input_cpta_venta" class="h5 col-8" value="<?php echo $_SESSION['usuario'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ab_estado_venta" class="h5 col-4">Estado:</label>
                                    <span id="ab_estado_venta" class="h5 col-8">1</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="ab_pedido_venta" class="h5 col-4">Pedido:</label>
                                    <span id="ab_pedido_venta" class="h5 col-8">1</span>
                                </div>
                                <div class="form-group">
                                    <label for="ab_pagado_venta" class="h5 col-4">Pagado:</label>
                                    <span id="ab_pagado_venta" class="h5 col-8">1</span>
                                    <input type="hidden" id="input_pagado_venta" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="ab_por_pagar_venta" class="h5 col-4">Por pagar:</label>
                                    <span id="ab_por_pagar_venta" class="h5 col-8">1</span>
                                    <input id="input_por_pagar" type="hidden" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="ab_capturista_abono" class="h5 col-4">Capturista que abona:</label>
                                    <span id="ab_capturista_abono" class="h5 col-8"><?php echo $_SESSION['nombre_us'] ?></span>
                                    <input type="hidden" id="input_cpta_abona" class="h5 col-8" value="<?php echo $_SESSION['usuario'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ab_fecha_abono" class="h5 col-4">Fecha del abono:</label>
                                    <span id="ab_fecha_abono" class="h5 col-8"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card card-info">
                                    <div class="card-header d-flex">
                                        <h3 class="card-title">

                                            Métodos de abono
                                        </h3>
                                        <button id="cargarAbono" class=" cargarAbono btn btn-light btn-sm ml-auto"> <i class=" mr-3 fas fa-cash-register"></i>Cargar pago</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box mb-0 bg-info row">
                                            <div class="bg bg-info col-md-5">
                                                <label for="ab_efectivo" class="d-block mt-3 ml-4">Efectivo:</label>
                                                <label for="ab_transferencia" class="d-block mt-3 ml-4">Transfer.:</label>
                                                <label for="ab_deposito" class="d-block mt-3 ml-4">Deposito:</label>
                                                <label for="ab_cheque" class="d-block mt-3 ml-4">Cheque:</label>
                                                <label for="monto_abonar" class="d-block mt-3 ml-4">Total:</label>
                                            </div>
                                            <div class="bg bg-info col-md-7">
                                                <input type="number" value="0" title="Pago en efectivo" min="0" id="ab_efectivo" class="form-control mt-1">
                                                <input id="input_efectivo" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por transferencia" min="0" id="ab_transferencia" class="form-control mt-1">
                                                <input id="input_transferencia" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por deposito" id="ab_deposito" min="0" class="form-control mt-1">
                                                <input id="input_deposito" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por cheque" min="0" id="ab_cheque" class="form-control mt-1">
                                                <input id="input_cheque" type="hidden" value="0">
                                                <input type="number" value="0" title="Total a abonar" min="0" id="monto_abonar" class="form-control mt-1" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        <button type="button" class="procesar_abono btn btn-outline-danger float-right mr-2">Abonar</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--Liquidar una cuenta-->
    <div class="modal fade" id="modal_liquidar_cuenta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Liquidar nota</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="liq_folio_venta" class="h5 col-4">Folio:</label>
                                    <span id="liq__folio_venta" class="h5 col-8">1</span>
                                    <input id="input_id_liquidar" type="hidden" value="0">
                                    <input id="input_folio_liquidar" type="hidden" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="liq_pedido_venta" class="h5 col-4">Cliente:</label>
                                    <span id="liq__cliente_venta" class="h5 col-8">1</span>
                                    <input id="input_cliente_liquidar" type="hidden" value="0">
                                    <input id="input_ruta_liquidar" type="hidden" value="0">
                                    <input id="input_cpta_liquidar" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                                    <input type="hidden" id="input_fecha_nota_liquidar" class="h5 col-8">

                                </div>
                                <div class="form-group">
                                    <label for="liq_pedido_venta" class="h5 col-4">Pedido:</label>
                                    <span id="liq_pedido_venta" class="h5 col-8">1</span>
                                </div>
                                <div class="form-group">
                                    <label for="liq_pagado_venta" class="h5 col-4">Pagado:</label>
                                    <span id="liq_pagado_venta" class="h5 col-8">1</span>
                                    <input type="hidden" id="input_pagado_ventas" class="h5 col-8">
                                </div>
                                <div class="form-group">
                                    <label for="liq_por_pagar_venta" class="h5 col-4">Por pagar:</label>
                                    <span id="liq_por_pagar_venta" class="h5 col-8">1</span>
                                    <input id="input_por_pagare" type="hidden" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="liq_fecha_abono" class="h5 col-4">Fecha que liquida:</label>
                                    <span id="liq_fecha_abono" class="h5 col-8"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-blue">
                                    <div class=" card-header d-flex">
                                        <h3 class="card-title">
                                            Métodos para liquidar
                                        </h3>
                                        <button id="cargarLiquido" class="cargarLiquido btn btn-light btn-sm ml-auto"> <i class=" mr-3 fas fa-cash-register"></i>Cargar pago</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box mb-0 bg-info row">
                                            <div class="bg bg-info col-md-5">
                                                <label for="liq_efectivo" class="d-block mt-3 ml-4">Efectivo:</label>
                                                <label for="liq_transferencia" class="d-block mt-3 ml-4">Transfer.:</label>
                                                <label for="liq_deposito" class="d-block mt-3 ml-4">Deposito:</label>
                                                <label for="liq_cheque" class="d-block mt-3 ml-4">Cheque:</label>
                                                <label for="monto_liquidar" class="d-block mt-3 ml-4">Total:</label>
                                            </div>
                                            <div class="bg bg-info col-md-7">
                                                <input type="number" value="0" title="Pago en efectivo" min="0" id="liq_efectivo" class="form-control mt-1">
                                                <input id="input_efectivos" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por transferencia" min="0" id="liq_transferencia" class="form-control mt-1">
                                                <input id="input_transferencias" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por deposito" id="liq_deposito" min="0" class="form-control mt-1">
                                                <input id="input_depositos" type="hidden" value="0">
                                                <input type="number" value="0" title="Pago por cheque" min="0" id="liq_cheque" class="form-control mt-1">
                                                <input id="input_cheques" type="hidden" value="0">
                                                <input type="number" value="0" title="Total a abonar" min="0" id="monto_liquidar" class="form-control mt-1" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right mr-2">Cerrar</button>
                        <button type="button" class="procesar_liquida btn btn-danger float-right mr-2">Liquidar nota</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--Detalle de la venta -->
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
                            <thead class="table-info">
                                <tr>
                                    <th id="det_producto">Producto</th>
                                    <th id="det_piezas">Pzas vendidas</th>
                                    <th id="det_precio_unit">Kg vendidos</th>
                                    <th id="det_kilos">Precio unitario</th>
                                    <th id="det_vendio">Pzas devueltas</th>
                                    <th id="det_llevo">Kg devueltos</th>
                                    <th id="det_devo">Subtotal</th>
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
                        <h1>Notas pendientes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Notas pendientes</li>
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
                        <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%" aria-describedby="Tabla de notas por pagar">
                            <thead>
                                <tr>
                                    <th id="folio">Folio</th>
                                    <th id="r_fecha">Fecha</th>
                                    <th id="r_cliente">Cliente</th>
                                    <th id="r_ruta">Ruta</th>
                                    <th id="r_capturista">Capturista</th>
                                    <th id="r_estado">Estado nota</th>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/NotasPendientes.js"></script>
<script src="../js/datatables.js"></script>