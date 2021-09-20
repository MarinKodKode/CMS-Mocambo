<?php
include_once 'Conexion.php';

class Ruta
{
    var $objetos_ruta;
    public function __construct()
    {

        $database = new Conexion();
        $this->access = $database->pdo;
    }

    function crear_new_ruta($nombre_new_ruta, $avatar_ruta)
    {
        $sql = "SELECT id_ruta FROM ruta where ruta_nombre=:nombre_ruta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':nombre_ruta' => $nombre_new_ruta));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO ruta(ruta_nombre,ruta_avatar) VALUES (:nombre_ruta,:avatar);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre_ruta' => $nombre_new_ruta, ':avatar' => $avatar_ruta));
            echo 'add';
        }
    }

    function buscar_ruta()
    {
        if (!empty($_POST['consulta_ruta'])) {
            $consulta_ruta = $_POST['consulta_ruta'];
            $sql = "SELECT * FROM ruta where ruta_nombre LIKE :consulta_ruta";
            $query = $this->access->prepare($sql);
            $query->execute(array(':consulta_ruta' => "%$consulta_ruta%"));
            $this->objetos_ruta = $query->fetchall();
            return $this->objetos_ruta;
        } else {
            $sql = "SELECT * FROM ruta  WHERE ruta_nombre  NOT LIKE '' ORDER BY ruta_nombre LIMIT 25 ";
            $query = $this->access->prepare($sql);
            $query->execute();
            $this->objetos_ruta = $query->fetchall();
            return $this->objetos_ruta;
        }
    }

    function searchSpecificItemById($item_id)
    {
        $sql = "SELECT * FROM ruta where id_ruta=:item_id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':item_id' => $item_id));
        $this->objetos_ruta = $query->fetchall();
        return $this->objetos_ruta;
    }
    function borrarRuta($idRuta)
    {
        $sql = "DELETE FROM ruta where id_ruta=:idRuta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idRuta' => $idRuta));
        if (!empty($query->execute(array(':idRuta' => $idRuta)))) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
    function cambiarLogoRuta($idRuta, $nombre_img)
    {
        $sql = "SELECT ruta_avatar FROM ruta WHERE id_ruta=:idRuta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idRuta' => $idRuta));
        $this->objetos_ruta = $query->fetchall();

        $sql = "UPDATE  ruta SET ruta_avatar=:nombre_img where id_ruta=:idRuta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idRuta' => $idRuta, ':nombre_img' => $nombre_img));
        return  $this->objetos_ruta;
    }
    function editarRuta($nombre_edit_ruta, $id_editado)
    {
        $sql = "SELECT id_ruta FROM ruta where id_ruta!=:id_edit_ruta and ruta_nombre =:nombre";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_edit_ruta' => $id_editado, ':nombre' => $nombre_edit_ruta));
        $this->objetos_prod = $query->fetchall();
        if (!empty($this->objetos_prod)) {
            echo 'noedit';
        } else {
            $sql = "UPDATE ruta  SET ruta_nombre=:nombre_edit_ruta where id_ruta=:id_editado";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id_editado' => $id_editado, ':nombre_edit_ruta' => $nombre_edit_ruta));
            echo 'editado';
        }
    }
    function rellenarRutas()
    {
        $sql = "SELECT * FROM ruta order by ruta_nombre asc";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_ruta = $query->fetchall();
        return $this->objetos_ruta;
    }
}
