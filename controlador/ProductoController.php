<?php
include '../modelo/Producto.php';
$producto = new Producto();

##Buscar y listar todos los productos en la base de datos
if ($_POST['funcion'] == 'buscarProducto') {
    $producto->buscar_prod();
    $json = array();
    foreach ($producto->objetos_prod as $objeto) {
        $json[] = array(
            'id' => $objeto->id_producto,
            'nombre' => $objeto->producto_nombre,
            'avatar_prod' => '../img/prod/' . $objeto->producto_avatar,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
##Crear un producto nuevo en la base de datos
if ($_POST['funcion'] == 'crear_nuevo_producto') {
    $nombre_new_prod = $_POST['nombre'];
    $avatar_default_prod = 'queso.png';
    $producto->crear_new_producto($nombre_new_prod, $avatar_default_prod);
}
##Cambiar el logo o imagen de un producto existente
if ($_POST['funcion'] == 'cambiarLogoProducto') {
    $id_prod = $_POST['id_logo_prod'];
    if (($_FILES['photo']['type'] == 'image/jpeg') || ($_FILES['photo']['type'] == 'image/png') || ($_FILES['photo']['type'] == 'image/gif')
    ) {
        $nombre_img = uniqid() . '-' . $_FILES['photo']['name'];
        $ruta = '../img/prod/' . $nombre_img;
        move_uploaded_file($_FILES['photo']['tmp_name'], $ruta);
        $producto->cambiar_logo_prod($id_prod, $nombre_img);
        foreach ($producto->objetos_prod as $objeto) {
            if ($objeto->producto_avatar != 'queso.png') {
                unlink('../img/prod/' . $objeto->producto_avatar);
            }
        }
        $json = array();
        $json[] = array(
            'ruta' => $ruta,
            'alert' => 'edit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    } else {
        $json = array();
        $json[] = array(
            'alert' => 'noedit'
        );
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
}
##Borrar un producto de la base de datos
if ($_POST['funcion'] == 'deleteProducto') {
    $_CB_producto_id = $_POST['CB_producto_id'];
    $producto->borrarProducto($_CB_producto_id);
}

if ($_POST['funcion'] == 'buscar_producto_id') {
    $id = $_POST['id_producto'];
    $producto->buscar_prod_id($id);
    $json = array();
    foreach ($producto->objetos_prod as $objeto) {
        $json[] = array(
            'id' => $objeto->id_producto,
            'nombre' => $objeto->producto_nombre,
            'avatar_prod' => '../img/prod/' . $objeto->producto_avatar,
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
##Llenar los productos 
if ($_POST['funcion'] == 'llenarProductos') {
    $producto->rellenarProductos();
    $json = array();
    foreach ($producto->objetos_prod as $objeto) {
        $json[] = array(
            'id' => $objeto->id_producto,
            'nombre' => $objeto->producto_nombre
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if ($_POST['funcion'] == 'carryProduct') {
    $html = "";
    $productos = json_decode($_POST['productos']);
    foreach ($productos as $resultado) {
        $producto->buscar_prod_id($resultado->productoID);
        foreach ($producto->objetos_prod as $object) {

            $subtotal = $resultado->cantidad_kg * $resultado->precio_unitario;
            $html .= "
                <tr prodId='$object->id_producto' prodPrecio='$object->producto_nombre'>
                        <td>$object->producto_nombre</td> 
                        <td>
                            <input type='number' min='1' class='form-control piezas' value='$resultado->piezas'></input>
                        </td>
                        <td>
                            <input type='number' min='1' class='form-control cantidad_kg' value='$resultado->cantidad_kg'></input>
                        </td>
                        <td class='precio'>
                            <input type='number' min='1' class='form-control precio_unitario' value='$resultado->precio_unitario'></input>
                        </td>
                        <td>
                            <input type='number' min='1' class='form-control piezas_devueltas' value='$resultado->piezas_devueltas'></input>
                        </td>
                        <td>
                            <input type='number' min='1' class='form-control kilos_devueltos' value='$resultado->kilos_devueltos'></input>
                        </td>
                        <td class='subtotales'>
                            <h5>$subtotal</h5>
                        </td>
                        <td><button class='borrar_eleccion btn btn-danger'><i class='fas fa-times-circle'></i></button></td>
                    </tr>
            ";
        }
    }
    echo $html;
}
