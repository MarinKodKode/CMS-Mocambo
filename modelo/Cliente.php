<?php
include 'Conexion.php';

class Cliente
{
    var $objetos_cliente;

    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function buscarCliente()
    {
        if (!empty($_POST['consultaCliente'])) {
            $consulta = $_POST['consultaCliente'];
            $sql = "SELECT * FROM cliente JOIN ruta on id_ruta_cliente = id_ruta and cliente.cliente_nombre  like :consulta LIMIT 25";
            $query = $this->access->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos_cliente = $query->fetchall();
            return $this->objetos_cliente;
        } else {
            $sql = "SELECT * FROM cliente JOIN ruta on id_ruta_cliente = id_ruta and cliente.cliente_nombre  not like '' LIMIT 25";
            $query = $this->access->prepare($sql);
            $query->execute();
            $this->objetos_cliente = $query->fetchall();
            return $this->objetos_cliente;
        }
    }
    function crearCliente($cliente_nombre, $cliente_telefono, $cliente_correo, $cliente_adicional, $cliente_ruta, $avatar_default_prod)
    {
        $sql = "SELECT id_cliente FROM cliente where cliente_nombre =:nombre and id_ruta_cliente=:ruta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':nombre' => $cliente_nombre, ':ruta' => $cliente_ruta));
        $this->objetos_cliente = $query->fetchall();
        if (!empty($this->objetos_cliente)) {
            echo 'noadd';
        } else {
            $sql = "INSERT INTO cliente(cliente_nombre,cliente_telefono,cliente_correo,cliente_avatar,informacion_adicional,id_ruta_cliente) VALUES (:nombre,:telefono,:correo,:avatar,:adicional,:ruta);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre' => $cliente_nombre, ':telefono' => $cliente_telefono,  ':correo' => $cliente_correo, ':avatar' => $avatar_default_prod, ':adicional' => $cliente_adicional, ':ruta' => $cliente_ruta));
            echo 'add';
        }
    }
    function borrarCliente($idCliente)
    {
        $sql = "DELETE FROM cliente where id_cliente=:idCliente";
        $query = $this->access->prepare($sql);
        $query->execute(array(':idCliente' => $idCliente));
        if (!empty($query->execute(array(':idCliente' => $idCliente)))) {
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
    function editarCliente($id_cliente, $cliente_nombre, $cliente_telefono, $cliente_correo, $cliente_adicional, $cliente_ruta)
    {
        $sql = "SELECT id_cliente FROM cliente where id_cliente!=:id_cliente_ and cliente_nombre=:nombre and id_ruta_cliente=:cliente_ruta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_cliente_' => $id_cliente, ':nombre' => $cliente_nombre, ':cliente_ruta' => $cliente_ruta));
        $this->objetos_cliente = $query->fetchall();
        if (!empty($this->objetos_cliente)) {
            echo 'noedit';
        } else {
            $sql = "UPDATE cliente SET cliente_nombre=:nombre, cliente_telefono=:telefono,cliente_correo=:correo,informacion_adicional=:adicional, id_ruta_cliente=:cliente_ruta where id_cliente=:id_edit_cliente";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id_edit_cliente' => $id_cliente, ':nombre' => $cliente_nombre, ':telefono' => $cliente_telefono, ':correo' => $cliente_correo, ':adicional' => $cliente_adicional, ':cliente_ruta' => $cliente_ruta));
            echo 'edit';
        }
    }
    function rellenarClientes($id_ruta)
    {
        $sql = "SELECT * FROM cliente where id_ruta_cliente=:id_ruta order by cliente_nombre asc";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_ruta' => $id_ruta));
        $this->objetos_cliente = $query->fetchall();
        return $this->objetos_cliente;
    }

    function clientes()
    {
        $sql = "SELECT * FROM cliente JOIN ruta on id_ruta_cliente = id_ruta";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_cliente = $query->fetchall();
        return $this->objetos_cliente;
    }
}
