<?php
include_once 'Conexion.php';

class Metodo
{
    var $objetos_metodo;
    public function __construct()
    {
        $database = new Conexion();
        $this->access = $database->pdo;
    }
    function buscarMetodo()
    {
        $sql = "SELECT * FROM metodo_pago ORDER BY metodo_nombre LIMIT 25 ";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_metodo = $query->fetchall();
        return $this->objetos_metodo;
    }
    function crearMetodo($new_metodo_nombre, $avatar_metodo)
    {
        $sql = "SELECT id_metodo_pago FROM metodo_pago where metodo_nombre=:nombre_metodo";
        $query = $this->access->prepare($sql);
        $query->execute(array(':nombre_metodo' => $new_metodo_nombre));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO metodo_pago(metodo_nombre,metodo_avatar) VALUES (:nombre_metodo,:avatar);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre_metodo' => $new_metodo_nombre, ':avatar' => $avatar_metodo));
            echo 'add';
        }
    }
    function borrarMetodo($idMetodo)
    {
        $sql = "DELETE FROM metodo_pago where id_metodo_pago=:idMetodo";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idMetodo' => $idMetodo));
        if (!empty($query->execute(array(':idMetodo' => $idMetodo)))) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
}
