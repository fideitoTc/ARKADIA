<?php 

require '../config/config.php';
require '../config/database.php';


if(isset($_POST['action'])){

    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar') {
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);

        if($respuesta > 0){
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', ',');
    } elseif ($action == 'eliminar') {
        $datos['ok'] = eliminar($id);
    } else {
        $datos['ok'] = false;
    }
    echo json_encode($datos);
}

function agregar($id, $cantidad){
    $res = 0;
    if($id > 0 && $cantidad > 0 && is_numeric($cantidad)){
        if(isset($_SESSION['carrito']['productos'][$id])){
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $db = new database();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT count(idproducto) FROM productosp WHERE idproducto=? AND activo=1");
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0) {
            
                $sql = $con->prepare("SELECT precioproducto, descuentoproducto FROM productosp WHERE idproducto=? AND activo=1 LIMIT 1");
                $sql->execute([$id]);
                $resultado = $sql->fetch(PDO::FETCH_ASSOC);
                $precio = $resultado['precioproducto'];
                $descuento = $resultado['descuentoproducto'];
                $precio_descuento = $precio - (($precio * $descuento) / 100);
                $res = $cantidad * $precio_descuento;

                return $res;
        }
    }else {
        return $res;
    }
}
}

function eliminar($id){
    if($id > 0) {
        if (isset($_SESSION['carrito']['productos'][$id])){
            unset($_SESSION['carrito']['productos'][$id]);
            return true;
        }
    }else {
        return false;
    }
}

?>