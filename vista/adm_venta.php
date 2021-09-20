<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2 || $_SESSION['id_usuario_tipo'] == 3) {
    include_once 'layouts/header.php';
?>

    <title>Compras</title>
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
                        <h1 id="title_page" class="d-inline">Quesos Camacho</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Compra</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                            </div>
                            <div class="card-body p-0">
                                <!--
                                <header class="bg bg-light">
                                    <div class="logo_cp">
                                        <img class="float-right" src="../img/moo.png" width="100" height="100">
                                    </div>
                                    <div class="datos_cp">
                                        <div class="form-group row">
                                            <span>Ruta:</span>
                                            <div class="form-group pt-1">
                                                <select name="rutadas" id="rutada" class="form-control select2" style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <span>Cliente:</span>
                                            <div class="form-group">
                                                <select name="clientes" id="clientela" class="select2" style="width: 100%"></select>
                                            </div>
                                            <button class="btn btn-outline-success btn-sm punto">Cargar clientes</button>
                                        </div>
                                        <div class="form-group row">
                                            <span>Folio:</span>
                                            <div class="input-group-append col-md-3">
                                                <input type="text" class="form-control" id="folio_venta" placeholder="Ingresa Folio">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <span class="ml-1">Vendedor:</span>
                                            <input id="id_usuario_actual" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                                            <input id="id_capturista" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                                            <h3 id="usuario_actual" class="ml-2 d-inline">usuario</h3>
                                            <span class="ml-1">Fecha:</span>
                                            <h3 id="fecha_actual" class="ml-2 d-inline">usuario</h3>
                                        </div>
                                    </div>


                                </header> -->
                                <div class="card-body bg-light">
                                    <div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Capturista</label>
                                                    <input type="text" class="form-control" placeholder="Checador" readonly value="<?php echo $_SESSION['nombre_us'] ?>">
                                                    <input id="id_usuario_actual" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                                                    <input id="id_capturista" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Folio</label>
                                                    <input type="text" class="form-control" id="folio_venta" placeholder="Ingresa Folio">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Fecha de venta</label>
                                                    <input id="fecha_venta" type="date" class="form-control" placeholder="Fecha">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Fecha de registro</label>
                                                    <input class="form-control" placeholder="Fecha" id="fecha_actuale" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Ruta</label>
                                                    <select name="rutadas" id="rutada" class="form-control select2" style="width: 100%;"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="d-block">Cliente</label>
                                                    <select name="clientes" id="clientela" class="select2" style="width: 82%;"></select>

                                                    <button class="btn btn-outline-success btn-sm punto">Cargar clientes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <section class="card card-secondary">
                                    <div class="card-header"></div>
                                    <div class="card-body">
                                        <div id="productos_catalogo_body" class="row d-flex align-items-center">
                                        </div>
                                    </div>
                                    <div class="card-footer"></div>

                                </section>
                                <div id="cpo" class="card-body p-0">
                                    <table class="compra table table-hover text-nowrap">
                                        <thead class='table-secondary'>
                                            <tr>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Piezas</th>
                                                <th scope="col">Kilogramos</th>
                                                <th scope="col">Precio Unitario</th>
                                                <th scope="col">Piezas devueltas</th>
                                                <th scope="col">KG devueltos</th>
                                                <th scope="col">D/A</th>
                                                <th scope="col">Dev</th>
                                                <th scope="col">Sub Total</th>
                                                <th scope="col">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-compra" class='table-active'>

                                        </tbody>
                                    </table>
                                    <!-- Final section-->
                                    <!-- Informacion del pago-->
                                    <div class="row mt-4 mb-2 bg bg-light">
                                        <div class="col-md-4">
                                            <div class="card card-secondary">
                                                <div class="card-header d-flex justify-content-center">
                                                    <h3 class="card-title ">
                                                        <i class="fas fa-dollar-sign"></i>
                                                        Totales
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="info-box mb-3 bg-warning p-0">
                                                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text text-left font-weight-bold">Total pedido</span>
                                                            <!--    <span class="info-box-number" id="total_pedidos">10</span> -->
                                                            <input type="number" id="total_pedido" min="1" value="0" placeholder="Total pedido" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="info-box mb-3 bg-info">
                                                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text text-left font-weight-bold">Deuda acumulada</span>
                                                            <input type="number" id="deuda_acumulada" min="1" placeholder="Deuda acumulada" value="0" class="form-control" readonly>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-secondary">
                                                <div class="card-header d-flex">
                                                    <h3 class="card-title">

                                                        Métodos de pago
                                                    </h3>
                                                    <button id="cargarPago" class="btn btn-light btn-sm ml-auto"> <i class=" mr-3 fas fa-cash-register"></i>Cargar pago</button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="info-box mb-0 bg-secondary row">
                                                        <div class="bg bg-secondary col-md-5">
                                                            <label for="" class="d-block mt-3 ml-4">Efectivo:</label>
                                                            <label for="" class="d-block mt-3 ml-4">Transferencia:</label>
                                                            <label for="" class="d-block mt-3 ml-4">Deposito:</label>
                                                            <label for="" class="d-block mt-3 ml-4">Cheque:</label>
                                                        </div>
                                                        <div class="bg bg-secondary col-md-7">
                                                            <input type="number" value="0" title="Pago en efectivo" min="0" id="m_efectivo" class="form-control mt-1">
                                                            <input type="number" value="0" title="Pago por transferencia" min="0" id="m_transferencia" class="form-control mt-1">
                                                            <input type="number" value="0" title="Pago por deposito" id="m_deposito" min="0" class="form-control mt-1">
                                                            <input type="number" value="0" title="Pago por cheque" min="0" id="m_cheque" class="form-control mt-1">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-danger">
                                                <div class="card-header d-flex">
                                                    <h3 class="card-title d-inline">
                                                        <i class="far fa-compass"></i>
                                                        Estado de nota:
                                                    </h3>
                                                    <h3 id="estado_nota_final" class=" ml-2 d-inline card-title">
                                                        Sin cargar pago
                                                    </h3>
                                                    <input type="hidden" id="id_estado_pago" value="1">
                                                </div>
                                                <div class="card-body">
                                                    <div class="info-box mb-3 bg-success">
                                                        <span class="info-box-icon"><i class="fas fa-money-bill-alt"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text text-left ">A cuenta</span>
                                                            <input type="number" id="pago_final" min="1" value="0" class="form-control" readonly>

                                                        </div>
                                                    </div>
                                                    <div class="info-box mb-3 bg-info ">
                                                        <div class="info-box-content col-md-6">
                                                            <span class="info-box-text text-center font-weight-bold">Faltan</span>
                                                            <input type="number" id="faltante_pago_final" min="1" value="0" class="form-control" readonly>

                                                        </div>
                                                        <div class="info-box-content col-md-6">
                                                            <span class="info-box-text text-left font-weight-bold"> <i class="fas fa-info-circle mr-1"></i>Deuda actualizada

                                                            </span>
                                                            <input type="number" id="deuda_actualizada" min="1" value="0" class="form-control" readonly>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin seccion-->
                                    <div class=" card bg bg-light pl-5 pr-5 pt-2">
                                        <div class="info-box mb-3 bg-info">
                                            <span class="info-box-icon"><i class="far fa-comment-dots"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">Información adicional de la compra</span>
                                                <input type="text" id="adicional_compra" value="Venta normal" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-4 mb-2">
                                        <a href="../vista/adm_catalogo.php" class="btn btn-primary btn-block">Seguir comprando</a>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <button class="btn btn-success btn-block procesar_compra" id="procesar_compra">Registrar</button>
                                    </div>
                                </div>
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
<script src="../js/Venta.js"></script>