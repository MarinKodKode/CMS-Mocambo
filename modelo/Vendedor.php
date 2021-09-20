<?php
include 'Conexion.php';

class Vendedor
{
    var $objetos_vendedor;

    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }
    function buscarVendedores()
    {
        $sql = "SELECT vendedor.id_vendedor AS id_vendor, vendedor.vendedor_nombre AS v_nombre, vendedor.vendedor_apellido AS v_apellido, ruta.ruta_nombre AS v_ruta, vendedor.vendedor_telefono AS v_telefono FROM vendedor JOIN ruta ON vendedor.vendedor_ruta = ruta.id_ruta;";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_vendedor = $query->fetchall();
        return $this->objetos_vendedor;
    }
    function crearVendedor($new_vend_nombre, $new_vend_apellidos, $new_vend_telefono, $new_vend_ruta, $avatar_default_vend)
    {
        $sql = "SELECT id_vendedor FROM vendedor where vendedor_nombre =:nombre and vendedor_ruta=:ruta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':nombre' => $new_vend_nombre, ':ruta' => $new_vend_ruta));
        $this->objetos_vendedor = $query->fetchall();
        if (!empty($this->objetos_vendedor)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO vendedor(vendedor_nombre,vendedor_apellido,vendedor_ruta,vendedor_avatar,vendedor_telefono) VALUES (:nombre,:apellidos,:ruta,:avatar,:telefono);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre' => $new_vend_nombre, ':apellidos' => $new_vend_apellidos,  ':ruta' => $new_vend_ruta, ':avatar' => $avatar_default_vend, ':telefono' => $new_vend_telefono));
            echo 'add';
        }
    }
    function borrarVendedor($idVendor)
    {
        $sql = "DELETE FROM vendedor where id_vendedor=:idVendor";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idVendor' => $idVendor));
        if (!empty($query->execute(array(':idVendor' => $idVendor)))) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
    function rellenarVendedores()
    {
        $sql = "SELECT * FROM vendedor  order by vendedor_nombre asc";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_vendedor = $query->fetchall();
        return $this->objetos_vendedor;
    }
}
