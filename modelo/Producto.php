<?php
include 'Conexion.php';

class Producto
{
    var $objetos_prod;
    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }
    function buscar_prod()
    {
        if (!empty($_POST['consultaProducto'])) {
            $consultaProducto = $_POST['consultaProducto'];
            $sql = "SELECT * FROM producto where producto_nombre  like :consultaProducto LIMIT 25";
            $query = $this->access->prepare($sql);
            $query->execute(array(':consultaProducto' => "%$consultaProducto%"));
            $this->objetos_prod = $query->fetchall();
            return $this->objetos_prod;
        } else {
            $sql = "SELECT * FROM producto where producto_nombre not like '' LIMIT 25";
            $query = $this->access->prepare($sql);
            $query->execute();
            $this->objetos_prod = $query->fetchall();
            return $this->objetos_prod;
        }
    }
    function crear_new_producto($nombre_new_prod,  $avatar_default_prod)
    {
        $sql = "SELECT id_producto FROM producto where producto_nombre =:nombre";
        $query = $this->access->prepare($sql);
        $query->execute(array(':nombre' => $nombre_new_prod));
        $this->objetos_prod = $query->fetchall();
        if (!empty($this->objetos_prod)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO producto(producto_nombre,producto_avatar) VALUES (:nombre,:avatar);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre' => $nombre_new_prod, ':avatar' => $avatar_default_prod));
            echo 'add';
        }
    }
    function cambiar_logo_prod($id_prod, $nombre_img)
    {
        $sql = "SELECT producto_avatar FROM producto WHERE id_producto=:id_prod";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_prod' => $id_prod));
        $this->objetos_prod = $query->fetchall();

        $sql = "UPDATE  producto SET producto_avatar=:nombre_img where id_producto=:id_prod";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_prod' => $id_prod, ':nombre_img' => $nombre_img));
        return  $this->objetos_prod;
    }
    function borrarProducto($_CB_producto_id)
    {
        $sql = "DELETE FROM producto where id_producto=:id_delete_prod";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_delete_prod' => $_CB_producto_id));
        if (!empty($query->execute(array(':id_delete_prod' => $_CB_producto_id)))) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
    function buscar_prod_id($ide)
    {
        $sql = "SELECT * FROM producto where id_producto=:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $ide));
        $this->objetos_prod = $query->fetchall();
        return $this->objetos_prod;
    }
    function rellenarProductos()
    {
        $sql = "SELECT * FROM producto  order by producto_nombre asc";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_prod = $query->fetchall();
        return $this->objetos_prod;
    }
}
