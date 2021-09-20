<?php
include 'Conexion.php';

class Movimiento
{
    var $objetos_mov;

    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function historial()
    {
        $sql = "SELECT  * FROM movimientos";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_mov = $query->fetchall();
        return $this->objetos_mov;
    }
    function insertMov($usuario_mov, $movimiento, $objeto_mov, $detalle_mov, $fecha_mov)
    {
        $sql = "INSERT INTO movimientos(fecha_mov,usuario_mov,movimiento,objeto_mov,detalle_mov) VALUES (:fecha,:usuario,:movimiento,:objeto,:detalle);";
        $query = $this->access->prepare($sql);
        $query->execute(array(':fecha' => $fecha_mov, ':usuario' => $usuario_mov,  ':movimiento' => $movimiento, ':objeto' => $objeto_mov, ':detalle' => $detalle_mov));
        echo 'add';
    }
}
