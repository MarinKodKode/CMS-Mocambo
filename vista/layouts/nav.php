  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- SweetAlert2 style -->
  <link rel="stylesheet" href="../css/sweetalert2.css">
  <!-- Select2 style -->
  <link rel="stylesheet" href="../css/select2.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/compra.css">
  <link rel="stylesheet" href="../css/datatables.css">
  <script src="../js/jquery.min.js"></script>
  </head>

  <body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light" aria-label="Hola">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" id="menu" data-widget="pushmenu" data-auto-collapse-size="2000" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <?php
          if ($_SESSION['id_usuario_tipo'] != 4) {

          ?>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="../vista/adm_registro_venta.php" class="nav-link">Inicio</a>
            </li>
          <?php

          }
          ?>


        </ul>



        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <a href="../controlador/Logout.php">Cerrar sesión</a>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <?php
        if ($_SESSION['id_usuario_tipo'] != 4) {

        ?>
          <a href="../vista/adm_registro_venta.php" class="brand-link">
            <img src="../img/moo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Inicio</span>
          </a>
        <?php
        }
        ?>
        <!-- Sidebar -->
        <div class="sidebar mb-5">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img id="nav_img" src="../img/man.svg" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
              <a href="#" class="d-block">
                Administrador <br>
                <?php
                echo $_SESSION['nombre_us'];
                ?>
              </a>
            </div>
          </div>



          <!-- Sidebar Menu -->
          <nav class="mt-2" aria-label="Sistema">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-header">Usuario</li>

              <li class="nav-item">
                <a href="../vista/editar_datos.php" class="nav-link">
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p>
                    Editar datos personales
                  </p>
                </a>
              </li>
              <?php
              if ($_SESSION['id_usuario_tipo'] == 1) {

              ?>
                <li class="nav-item">
                  <a href="../vista/adm_usuario.php" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Gestionar usuarios
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_movimientos.php" class="nav-link">
                    <i class="fas fa-history"></i>
                    <p class="ml-3">
                      Historial de movimientos
                    </p>
                  </a>
                </li>
              <?php

              }
              ?>
              <?php
              if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2 || $_SESSION['id_usuario_tipo'] == 3) { ?>

                <li class="nav-header">Funciones administrativas</li>
                <li class="nav-item">
                  <a href="adm_cliente.php" class="nav-link">
                    <i class="far fa-address-card"></i>
                    <p class="ml-4">
                      Clientes
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_notas_pen.php" class="nav-link">
                    <i class="far fa-folder-open"></i>
                    <p class="ml-4">
                      Notas pendientes
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_reporte.php" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    <p class="ml-4">
                      Reporte
                    </p>
                  </a>
                </li>
              <?php
              }
              ?>
              <?php
              if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 2) { ?>

                <li class="nav-item">
                  <a href="adm_rutas.php" class="nav-link">
                    <i class="fas fa-route"></i>
                    <p class="ml-4">
                      Rutas
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_productos.php" class="nav-link">
                    <i class="fas fa-cubes"></i>
                    <p class="ml-4">
                      Productos
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_historial.php" class="nav-link">
                    <i class="fas fa-history"></i>
                    <p class="ml-4">
                      Historial de ventas
                    </p>
                  </a>
                </li>

                <li class="nav-header">Personal</li>
                <li class="nav-item">
                  <a href="adm_vendedores.php" class="nav-link">
                    <i class="fas fa-user-check"></i>
                    <p class="ml-4">
                      Vendedores
                    </p>
                  </a>
                </li>
              <?php
              }
              ?>

              <?php
              if ($_SESSION['id_usuario_tipo'] == 1 || $_SESSION['id_usuario_tipo'] == 4) {

              ?>
                <li class="nav-header">Embarques</li>
                <li class="nav-item">
                  <a href="adm_embarques.php" class="nav-link">
                    <i class="fas fa-truck"></i>
                    <p class="ml-4">
                      Embarques
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="adm_llegadas.php" class="nav-link">
                    <i class="fas fa-truck-loading"></i>
                    <p class="ml-4">
                      Llegadas
                    </p>
                  </a>
                </li>
              <?php

              }
              ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->

      </aside>
      <script src="../js/Usuario.js"></script>
      <script>
        $(document).ready(function() {
          $('[data-widget="pushmenu"]').PushMenu('collapse')
        });
      </script>