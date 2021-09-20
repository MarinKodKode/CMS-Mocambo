<?php
require_once('../vendor/autoload.php');
require_once('../modelo/Pdf.php');

$id_ruta = $_POST['rutaReporte'];
$fecha_reporte = $_POST['fechaReporte'];
$templateReport = getTemplateReport($id_ruta, $fecha_reporte);
$styleCss = file_get_contents("../css/reporte.css");

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($styleCss, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($templateReport, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output("../pdf/reporte_" . $id_ruta . "_" . $fecha_reporte . ".pdf", "F");
