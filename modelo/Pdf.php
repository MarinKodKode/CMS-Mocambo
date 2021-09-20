<?php
include_once 'ModeloReporte.php';

function getTemplateReport($id_ruta, $fecha_reporte)
{
  ##Calcular fecha
  date_default_timezone_set('America/Mexico_City');
  $fecha = date('d-m-Y H:i:s');

  $data = new ModeloReporte();

  $data->totalesProducto($id_ruta, $fecha_reporte);

  $template = '
    <body>
    <header>
      <div id="logo">
        <img src="../img/cow.svg" width="60" height="60">
      </div>
      <h1 class="title_decoration">Reporte de ruta</h1>
      <div class="data">
        <div>Ruta:  </div>
        <div>Reporte de la fecha:  </div>
        <div>Fecha y hora de emisión: ' . $fecha . ' </div>
        <div class="negocio">Reporte emitido por:  </div>
      </div>';
  /*
    foreach ($data->data as $objeto) {

        $template .= '
    
      <div id="project">
        <div><span>Codigo de Venta: </span>' . $objeto->id_venta . '</div>
        /*
        <div><span>Cliente: </span>' . $objeto->cliente . '</div>
        <div><span>DNI: </span>' . $objeto->dni . '</div>
        <div><span>Fecha y Hora: </span>' . $objeto->fecha . '</div>
        <div><span>Vendedor: </span>' . $objeto->vendedor . '</div>
      </div>';
    }*/
  $template .= '
    </header>
    <main>
      <div class="title_table_container">
        <h3 class="title_table">Totales de pedidos</h3>
      </div>  
      <table class="table_lg">
        <thead>
          <tr class="table_header">
            <th class="table_header_title">Producto</th>
            <th class="table_header_title">Pzas. Vendidas</th>
            <th class="table_header_title">KG. Vendidos</th>
            <th class="table_header_title">Pzas. Devueltas</th>
            <th class="table_header_title">KG. Devueltos</th>
            <th class="table_header_title">Merma</th>
            <th class="table_header_title">Quedó</th>
            <th class="table_header_title">Importe</th>
          </tr>
        </thead>
        <tbody>';

  foreach ($data->data as $objeto) {

    $template .= '<tr>
            
            <td class="table_data">' . $objeto->producto_nombre . '</td>
            <td class="table_data">' . $objeto->total_pzas_vend . '</td>
            <td class="table_data">' . $objeto->total_kg_vend . '</td>
            <td class="table_data">' . $objeto->total_pzas_dev . '</td>
            <td class="table_data">' . $objeto->total_kilos_dev . '</td>
            <td class="table_data">0</td>
            <td class="table_data">0</td>
            <td class="table_data">' . $objeto->sobtotal_producto . '</td>
          </tr>';
  }
  $template .= '
        </tbody>
      </table>

      <div class="containera">
      <span>
        <h1>hola</h1>
      </span>
      <span>
        <h1>hola</h1>
      </span>
        

      </div>

    
      <div id="notices">
        <div>Notas adicionales:</div>
        <div class="notice">*Presentar este comprobante de pago para cualquier reclamo o devolucion.</div>
      </div>
    </main>
    <footer>
      Sistema de Gestión Contable Quesos Camacho.
    </footer>
  </body>';

  return $template;
}
