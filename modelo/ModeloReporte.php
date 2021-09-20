<?php
include 'Conexion.php';

class ModeloReporte
{
    var $data;

    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function ver($id)
    {
        $sql = "SELECT *  FROM venta_producto JOIN producto on producto.id_producto = venta_producto.vp_id_producto and venta_id_venta =:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id));
        $this->data = $query->fetchall();
        return $this->data;
    }
    function totalesProducto($id_ruta, $fecha)
    {
        $sql = "SELECT producto.producto_nombre, SUM(vp_piezas_vendidas) AS total_pzas_vend , ROUND(SUM(vp_kilos_vendidos),2) AS total_kg_vend,SUM(vp_piezas_devueltas) AS total_pzas_dev, ROUND(SUM(vp_kilos_devueltos),2) AS total_kilos_dev, ROUND(SUM(vp_subtotal),2) AS sobtotal_producto FROM `venta_producto_det` JOIN venta ON venta.id_venta = venta_producto_det.venta_id_venta JOIN producto ON venta_producto_det.vp_id_producto = producto.id_producto WHERE venta.venta_id_ruta =:id_ruta AND venta.venta_fecha LIKE :fecha GROUP BY vp_id_producto";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_ruta' => $id_ruta, ':fecha' => "%$fecha%"));
        $this->data = $query->fetchall();
        return $this->data;
    }
}
