<?php
include 'Conexion.php';

class Llegada
{
    var $objetos_llegada;
    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function registrarLlegada($id_checador, $id_producto, $id_ruta, $fecha_arr, $fecha_arr_emb, $id_vendedor, $kg_devueltos, $piezas_devueltas, $comentarios_arr)
    {
        $sql = "SELECT id_desembarque FROM desembarque where id_producto =:producto and des_id_ruta =:ruta and id_vendedor =:vendedor and fecha_desembarque =:fecha_des ";
        $query = $this->access->prepare($sql);
        $query->execute(array(':producto' => $id_producto, ':ruta' => $id_ruta, ':vendedor' => $id_vendedor, ':fecha_des' => $fecha_arr));
        $this->objetos_llegada = $query->fetchall();
        if (!empty($this->objetos_llegada)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO desembarque(id_usuario_registra,id_producto,des_id_ruta,fecha_desembarque,fecha_reg_des,id_vendedor,des_kg_devueltos,des_piezas_devueltas,comentarios) VALUES (:checador,:producto,:ruta,:fecha_des,:fecha_reg_des,:vendedor,:kilos,:piezas,:comentarios);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':checador' => $id_checador, ':producto' => $id_producto, ':ruta' => $id_ruta, ':fecha_des' => $fecha_arr, ':fecha_reg_des' => $fecha_arr_emb, ':vendedor' => $id_vendedor, ':kilos' => $kg_devueltos, ':piezas' => $piezas_devueltas, ':comentarios' => $comentarios_arr));
            echo 'add';
        }
    }
}
