<?php
session_start();
if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2 || $_SESSION['id_usuario_tipo'] == 3) {
    include_once 'layouts/header.php';
?>

    <title>Reporte</title>
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
                        <h1 class="d-inline">Reporte de ruta</h1>
                        <button id="generarReporteBTN" class=" ml-3 btn btn-outline-info btn-sm">Generar reporte</button>
                        <button id="generateReport" class="ml-3 btn btn-outline-danger btn-sm">Imprimir reporte</button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <select name="rutadas" id="rutadad" class="form-control select2" style="width: 100%; height :2rem"></select>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section id="printedArea" class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card col-12">
                        <div class="row card-header d-flex">
                            <div class="col-6">
                                <div>
                                    <h3 class="card-title d-inline font-weight-bold">Reporte generado el: </h3>
                                    <h3 class="card-title d-inline ml-2" id="fecha_reporte">Date time</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="col-md-3">
                                    <h3 class="card-title ml-auto d-inline font-weight-bold">Ruta: </h3>
                                    <h3 class="card-title ml-auto d-inline" id="ruta_show"></h3>
                                </div>
                            </div>
                            <div class="col-6 mt-2">

                                <div>
                                    <h3 class="card-title d-inline  font-weight-bold">Reporte generado por: </h3>
                                    <input id="nombre_usuario_reporta" type="hidden" value="<?php echo $_SESSION['nombre_us'] ?>">
                                    <input id="id_usuario_reporta" type="hidden" value="<?php echo $_SESSION['usuario'] ?>">
                                    <h3 class="card-title d-inline ml-2" id="usuario_reporte">Date time</h3>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <h3 class="card-title ml-2 d-inline font-weight-bold">Fecha reportada: </h3>
                                <input type="date" id="fecha_ventas_reporte" class="d-inline form-control form-control-sm col-6 ml-3 bg-warning border-dark font-weight-bold">
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="text-black">
                                        <th id="producto_rep">Producto</th>
                                        <th id="pzas_ven_rep">Pzas. Vendidas</th>
                                        <th id="kg_rep">Kg. Vendidos</th>
                                        <th id="pzas_Dev">Pzas. Devueltas</th>
                                        <th id="kg_Dev">Kg. Devueltos</th>
                                        <th style="width: 8rem;" id="merma">Merma</th>
                                        <th style="width:8rem" id="quedo">Quedó</th>
                                        <!--      <th id="total">Total</th>-->
                                        <th id="importe">Importe</th>
                                    </tr>
                                </thead>
                                <tbody class="table" id="totalesProductoBody">

                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="row mb-2 bg bg-light">
                <!--Tabla de totales condensados-->

                <!--
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Totales kilogramos</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-sm table-bordered table-hover">
                                <thead class="bg-info">
                                    <tr>
                                        <th id="producto_sec">Producto</th>
                                        <th id="tots_">Total <br> Monetario</th>
                                        <th id="tot_kilos">Total <br> Kiligramos</th>
                                        <th id="promedio">Promedio <br> Precio Kilo</th>
                                    </tr>
                                </thead>
                                <tbody class="table-active" id="totalesProductoBodySecondary">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>-->

                <!--Tabla de totales por metodo de pago-->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Totales ingresados desglosados</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box mb-0 bg-light row">
                                <div class="bg bg-light col-md-5">
                                    <label for="" class="d-block mt-3 ml-2 font-weight-bold">Efectivo:</label>
                                    <label for="" class="d-block mt-3 ml-2 font-weight-bold">Transferencia:</label>
                                    <label for="" class="d-block mt-3 ml-2 font-weight-bold">Deposito:</label>
                                    <label for="" class="d-block mt-3 ml-2 font-weight-bold">Cheque:</label>
                                    <label for="" class="d-block mt-3 ml-2 font-weight-bold">Total ruta:</label>
                                </div>
                                <div class="bg bg-light col-md-7">
                                    <input type="number" value="0" title="Pago en efectivo" min="0" id="r_efectivo" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Pago por transferencia" min="0" id="r_transferencia" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Pago por deposito" id="r_deposito" min="0" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Pago por cheque" min="0" id="r_cheque" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Total de ruta" min="0" id="r_total" class="form-control mt-1 bg-warning font-weight-bold border border-dark" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Tabla de totales desglosados y comparaciones-->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Datos</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box mb-0 bg-light row">
                                <div class="bg bg-light col-md-5">
                                    <label for="" class="d-block mt-3 ml-4 font-weight-normal">*Cuenta:</label>
                                    <label for="" class="d-block mt-3 ml-4 font-weight-normal">Diferencia:</label>
                                    <label for="" class="d-block mt-3 ml-4 font-weight-normal">Ctas pagadas:</label>
                                    <label for="" class="d-block mt-3 ml-4 font-weight-normal">Merma:</label>
                                </div>
                                <div class="bg bg-light col-md-7">
                                    <input type="number" value="0" title="Cuenta del reporte fisico" min="0" id="r_efectivo" class="form-control mt-1 bg-light border border-dark">
                                    <input type="number" value="0" title="Diferencia reporte fisico y por computadora" min="0" id="r_transferencia" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Cuentas pagadas" id="r_deposito" min="0" class="form-control mt-1 bg-light" readonly>
                                    <input type="number" value="0" title="Merma" min="0" id="r_cheque" class="form-control mt-1 bg-light">
                                </div>
                                <div class="mt-4 ml-4 font-italic text-sm"> *Cuenta del reporte fisico</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 bg bg-light">
                <!--Tabla de totales condensados-->


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Totales kilogramos</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-sm table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="text-black">
                                        <th id="producto_sec">Producto</th>
                                        <th id="tots_">Total <br> Monetario</th>
                                        <th id="tot_kilos">Total <br> Kiligramos</th>
                                        <th id="promedio">Promedio <br> Precio Kilo</th>
                                    </tr>
                                </thead>
                                <tbody class="table" id="totalesProductoBodySecondary">

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!--Tabla de totales desglosados y comparaciones-->
                <div class="col-md-6">
                    <div class=" card">
                        <div class="card-header">
                            <h3 class="card-title">Comentarios ó notas adicionales</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="far fa-comment-dots"></i></span>
                                <div class="info-box-content">
                                    <textarea type="text" id="comments_reporte" value="Información adicional" class="form-control h-5"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </section>

    </div>


<?php
    include_once 'layouts/footer.php';
} else {
    header('Location:../vista/login.php');
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/htmlpdf.bundle.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/Reporte.js"></script>