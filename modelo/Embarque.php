<?php
include 'Conexion.php';

class Embarque
{
    var $objetos_embarque;
    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function registrarEmbarque($id_checador, $id_producto, $id_ruta, $fecha_emb, $fecha_reg_emb, $id_vendedor, $kg_embarcados, $piezas_embarcadas, $comentarios_emb)
    {
        $sql = "SELECT id_embarque FROM embarque where id_producto =:producto and emb_id_ruta =:ruta and id_vendedor =:vendedor and embarque_fecha =:fecha_emb ";
        $query = $this->access->prepare($sql);
        $query->execute(array(':producto' => $id_producto, ':ruta' => $id_ruta, ':vendedor' => $id_vendedor, ':fecha_emb' => $fecha_emb));
        $this->objetos_embarque = $query->fetchall();
        if (!empty($this->objetos_embarque)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO embarque(id_usuario_registra,id_producto,emb_id_ruta,embarque_fecha,fecha_reg,id_vendedor,emb_kg_embarcados,emb_piezas_embarcadas,comentarios) VALUES (:checador,:producto,:ruta,:fecha_emb,:fecha_reg,:vendedor,:kilos,:piezas,:comentarios);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':checador' => $id_checador, ':producto' => $id_producto, ':ruta' => $id_ruta, ':fecha_emb' => $fecha_emb, ':fecha_reg' => $fecha_reg_emb, ':vendedor' => $id_vendedor, ':kilos' => $kg_embarcados, ':piezas' => $piezas_embarcadas, ':comentarios' => $comentarios_emb));
            echo 'add';
        }
    }
}
