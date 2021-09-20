<?php
include_once 'Conexion.php';

class Usuario
{
    var $objetos;
    public function __construct()
    {

        $database = new Conexion();
        $this->access = $database->pdo;
    }
    function Login($dni, $pass)
    {
        $sql = " SELECT * FROM usuario 
        inner join tipo_usuario on id_usuario_tipo=id_tipo_usuario 
        where usuario_dni=:dni and usuario_contrasena=:pass";
        $query = $this->access->prepare($sql);
        $query->execute(array(':dni' => $dni, ':pass' => $pass));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function obtener_datos($id)
    {
        $sql = "SELECT * FROM usuario 
        join tipo_usuario on id_usuario_tipo=id_tipo_usuario and id_usuario=:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function editar($id_usuario, $telefono, $telefono_referencia, $correo, $informacion)
    {
        $sql = "UPDATE usuario SET usuario_telefono=:telefono,usuario_telefono_ref=:telefono_referencia, usuario_correo=:correo, informacion_adicional=:informacion where id_usuario=:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id_usuario,  ':telefono' => $telefono, ':telefono_referencia' => $telefono_referencia, ':correo' => $correo, ':informacion' => $informacion));
    }

    function cambiarcontrasena($id_usuario, $oldpass, $newpass)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario=:id and usuario_contrasena=:oldpass";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id_usuario, ':oldpass' => $oldpass));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            $sql = "UPDATE  usuario SET usuario_contrasena=:newpass where id_usuario=:id";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id' => $id_usuario, ':newpass' => $newpass));
            echo 'updated';
        } else {
            echo 'not';
        }
    }

    function cambiar_photo($id_usuario, $nombre_img)
    {
        $sql = "SELECT usuario_avatar FROM usuario WHERE id_usuario=:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id_usuario));
        $this->objetos = $query->fetchall();

        $sql = "UPDATE  usuario SET usuario_avatar=:nombre_img where id_usuario=:id";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id' => $id_usuario, ':nombre_img' => $nombre_img));

        return  $this->objetos;
    }
    function admBuscarUsuario()
    {
        if (!empty($_POST['consulta'])) {
            $consulta = $_POST['consulta'];
            $sql = "SELECT * FROM usuario join tipo_usuario on id_usuario_tipo=id_tipo_usuario where usuario_nombre LIKE :consulta";

            $query = $this->access->prepare($sql);
            $query->execute(array(':consulta' => "%$consulta%"));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        } else {
            $sql = "SELECT * FROM usuario join tipo_usuario on id_usuario_tipo=id_tipo_usuario WHERE usuario_nombre NOT LIKE '' ORDER BY id_tipo_usuario LIMIT 25 ";

            $query = $this->access->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
    }

    function crear_new_user($nombre_new_user, $apellido_new_user, $telefono_new_user, $dni_new_user, $password_new_user, $tipo, $default_avatar)
    {
        $sql = "SELECT id_usuario FROM usuario where usuario_dni=:dni";
        $query = $this->access->prepare($sql);
        $query->execute(array(':dni' => $dni_new_user));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            echo 'noadd';
        } else {

            $sql = "INSERT INTO usuario(usuario_nombre,usuario_apellido, usuario_telefono, usuario_telefono_ref, usuario_correo, usuario_dni,usuario_contrasena,id_usuario_tipo,usuario_avatar) VALUES (:nombre_new_user,:apellido_new_user,:telefono_new_user, :telefono_ref, :correo,:dni_new_user,:password_new_user,:tipo,:default_avatar);";
            $query = $this->access->prepare($sql);
            $query->execute(array(':nombre_new_user' => $nombre_new_user, ':apellido_new_user' => $apellido_new_user, ':telefono_new_user' => $telefono_new_user, ':telefono_ref' => 'Sin añadir', ':correo' => 'Sin añadir', ':dni_new_user' => $dni_new_user, ':password_new_user' => $password_new_user, ':tipo' => $tipo, ':default_avatar' => $default_avatar,));
            echo 'add';
        }
    }
    function borrar($pass, $id_borrado, $id_usuario)
    {
        $sql = "SELECT id_usuario FROM usuario where id_usuario =:id_usuario and usuario_contrasena =:pass";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario, ':pass' => $pass));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            $sql = "DELETE from usuario where id_usuario=:id";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id' => $id_borrado));
            echo 'borrado';
        } else {
            echo 'noborrado';
        }
    }
    function ascender($pass, $id_ascendido, $id_usuario)
    {
        $sql = "SELECT id_usuario FROM usuario where id_usuario =:id_usuario and usuario_contrasena =:pass";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario, ':pass' => $pass));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            $tipo = 2;
            $sql = "UPDATE usuario SET id_usuario_tipo =:tipo where id_usuario =:id";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id' => $id_ascendido, ':tipo' => $tipo));
            echo 'ascendido';
        } else {
            echo 'noascendido';
        }
    }
    function descender($pass, $id_descendido, $id_usuario)
    {
        $sql = "SELECT id_usuario FROM usuario where id_usuario =:id_usuario and usuario_contrasena =:pass";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_usuario' => $id_usuario, ':pass' => $pass));
        $this->objetos = $query->fetchall();
        if (!empty($this->objetos)) {
            $tipo = 3;
            $sql = "UPDATE usuario SET id_usuario_tipo =:tipo where id_usuario =:id";
            $query = $this->access->prepare($sql);
            $query->execute(array(':id' => $id_descendido, ':tipo' => $tipo));
            echo 'descendido';
        } else {
            echo 'nodescendido';
        }
    }
}
