<?php
include 'Conexion.php';

class Venta
{
    var $objetos_venta;

    public function __construct()
    {
        $db = new Conexion();
        $this->access = $db->pdo;
    }

    function registrarVenta($fecha, $ruta, $cliente, $folio, $capturista, $efectivo, $transferencia, $deposito, $cheque, $totalPedido, $totalFinalPagado, $deudaVenta, $estado_venta, $informacion_adicional, $fecha_venta)
    {
        $sql = "INSERT INTO venta (venta_folio, venta_fecha, venta_id_cliente, venta_id_ruta, venta_total_monetario, venta_id_usuario, venta_a_cuenta, venta_adicional, estado_venta, efectivo, transferencia, deposito, cheque, deuda_venta,venta_fecha_nota) values (:folio, :fecha, :id_cliente, :id_ruta, :total_monetario, :id_usuario, :a_cuenta, :adicional, :estado_venta, :efectivo, :transferencia, :deposito, :cheque, :deuda_venta,:fecha_nota)";
        $query = $this->access->prepare($sql);
        $query->execute(array(':folio' => $folio, ':fecha' => $fecha, ':id_cliente' => $cliente, ':id_ruta' => $ruta, ':total_monetario' => $totalPedido, ':id_usuario' => $capturista, ':a_cuenta' => $totalFinalPagado, ':adicional' => $informacion_adicional, ':estado_venta' => $estado_venta, ':efectivo' => $efectivo, ':transferencia' => $transferencia, ':deposito' => $deposito, ':cheque' => $cheque, ':deuda_venta' => $deudaVenta, ':fecha_nota' => $fecha_venta));
    }

    function ultimaVenta()
    {
        $sql = "SELECT MAX(id_venta) as ultima_venta FROM venta";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    function ultimaVentaByCliente($id_cliente)
    {
        $sql = "SELECT cliente.cliente_nombre, MAX(venta.venta_fecha) as ultima_venta FROM venta JOIN cliente ON venta.venta_id_cliente = cliente.id_cliente WHERE cliente.id_cliente = :id_cliente";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_cliente' => $id_cliente));
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    /*Calcula el promedio de compra de un cliente, tomando como base las ultimas 10 compras*/
    function promedioDeCompraByCliente($id_cliente)
    {
        $sql = "select ROUND(AVG(venta.venta_total_monetario),2) AS promedio_compra from (SELECT * FROM venta WHERE venta_id_cliente =:id_cliente AND venta_total_monetario NOT LIKE '0' ORDER BY venta_fecha DESC LIMIT 10) venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_cliente' => $id_cliente));
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    function borrar_venta($id_venta)
    {
        $sql = "DELETE FROM venta where id_venta=:id_venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta));
    }
    function deudaAcumulada($id_cliente)
    {
        $sql = "SELECT ROUND(SUM(deuda_venta), 2) AS deuda_acumulada FROM venta WHERE venta_id_cliente =:id_cliente";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_cliente' => $id_cliente));
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    function buscarVenta()
    {
        $sql = "SELECT  id_venta,venta_folio, venta_fecha, cliente.cliente_nombre AS cliente, cliente.id_cliente AS id_cliente, ruta.ruta_nombre AS ruta, ruta.id_ruta AS id_ruta, usuario.usuario_nombre AS capturista,usuario.id_usuario AS id_user, estado_ventas.estado_venta AS estado, venta.venta_total_monetario as pedido, ROUND(venta.venta_total_monetario - venta.deuda_venta,2) AS pagado, venta.deuda_venta AS por_pagar, venta.efectivo AS efectivo, venta.transferencia AS transferencia, venta.deposito AS deposito, venta.cheque AS cheque,venta.venta_fecha_nota AS fecha_nota FROM `venta` JOIN cliente ON venta.venta_id_cliente = cliente.id_cliente JOIN ruta ON venta.venta_id_ruta = ruta.id_ruta JOIN usuario ON venta.venta_id_usuario = usuario.id_usuario JOIN estado_ventas ON venta.estado_venta = estado_ventas.id_estado AND estado_ventas.id_estado NOT LIKE '%1%';";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }
    function historial()
    {
        $sql = "SELECT  id_venta,venta_folio, venta_fecha, cliente.cliente_nombre AS cliente, cliente.id_cliente AS id_cliente, ruta.ruta_nombre AS ruta, ruta.id_ruta AS id_ruta, usuario.usuario_nombre AS capturista,usuario.id_usuario AS id_user, estado_ventas.estado_venta AS estado,venta_adicional, venta.venta_total_monetario as pedido, venta.venta_a_cuenta AS pagado, venta.deuda_venta AS por_pagar, venta.efectivo AS efectivo, venta.transferencia AS transferencia, venta.deposito AS deposito, venta.cheque AS cheque FROM `venta` JOIN cliente ON venta.venta_id_cliente = cliente.id_cliente JOIN ruta ON venta.venta_id_ruta = ruta.id_ruta JOIN usuario ON venta.venta_id_usuario = usuario.id_usuario JOIN estado_ventas ON venta.estado_venta = estado_ventas.id_estado ORDER BY id_venta DESC;";
        $query = $this->access->prepare($sql);
        $query->execute();
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    function registrarAbono($id_venta, $montoActualizado, $ac_efectivo, $ac_transf, $ac_depto, $ac_cheque, $ac_deuda)
    {
        /*$sql = "UPDATE venta SET venta_a_cuenta=:acuenta, estado_venta=:estado, efectivo=:efectivo,transferencia=:transferencia,deposito=:deposito,cheque=:cheque, deuda_venta=:deuda_venta where id_venta=:id_venta";*/
        $sql = "UPDATE venta SET venta_a_cuenta=:acuenta, estado_venta=:estado, deuda_venta=:deuda_venta where id_venta=:id_venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta, ':acuenta' => $montoActualizado, ':estado' => '3', ':efectivo' => $ac_efectivo, ':transferencia' => $ac_transf, ':deposito' => $ac_depto, ':cheque' => $ac_cheque, ':deuda_venta' => $ac_deuda));
        echo 'abonado';
    }
    function liquidarNota($id_venta, $montoActualizado, $ac_efectivo, $ac_transf, $ac_depto, $ac_cheque, $ac_deuda)
    {
        $sql = "UPDATE venta SET venta_a_cuenta=:acuenta, estado_venta=:estado, efectivo=:efectivo,transferencia=:transferencia,deposito=:deposito,cheque=:cheque, deuda_venta=:deuda_venta where id_venta=:id_venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta, ':acuenta' => $montoActualizado, ':estado' => '1', ':efectivo' => $ac_efectivo, ':transferencia' => $ac_transf, ':deposito' => $ac_depto, ':cheque' => $ac_cheque, ':deuda_venta' => $ac_deuda));
        echo 'liquidado';
    }

    function registrarAbonoBase($folio, $fecha,  $cliente, $ruta, $capturista, $totalFinalPagado, $efectivo, $transferencia, $deposito, $cheque, $fecha_nota)
    {
        $sql = "INSERT INTO venta (venta_folio, venta_fecha, venta_id_cliente, venta_id_ruta, venta_total_monetario, venta_id_usuario, venta_a_cuenta, venta_adicional, estado_venta, efectivo, transferencia, deposito, cheque, deuda_venta, venta_fecha_nota) values (:folio, :fecha, :id_cliente, :id_ruta, :total_monetario, :id_usuario, :a_cuenta, :adicional, :estado_venta, :efectivo, :transferencia, :deposito, :cheque, :deuda_venta, :fecha_nota)";
        $query = $this->access->prepare($sql);
        $query->execute(array(':folio' => $folio, ':fecha' => $fecha, ':id_cliente' => $cliente, ':id_ruta' => $ruta, ':total_monetario' => '0', ':id_usuario' => $capturista, ':a_cuenta' => $totalFinalPagado, ':adicional' => 'abono', ':estado_venta' => 1, ':efectivo' => $efectivo, ':transferencia' => $transferencia, ':deposito' => $deposito, ':cheque' => $cheque, ':deuda_venta' => '0', ':fecha_nota' => $fecha_nota));
        echo 'abonadoEnBase';
    }

    function sumAllPayments($folio, $cliente)
    {
        $sql = "SELECT SUM(venta_total_monetario)-SUM(efectivo+transferencia+deposito+cheque) AS por_pagar FROM `venta` where venta_folio =:folio and venta_id_cliente=:id_cliente";
        $query = $this->access->prepare($sql);
        $query->execute(array(':folio' => $folio, ':id_cliente' => $cliente));
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }

    function updateDebt($id_ventare, $por_pagar)
    {
        $sql = "UPDATE venta SET deuda_venta=:por_pagar where id_venta=:id_venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_venta' => $id_ventare, ':por_pagar' => $por_pagar));
        echo 'updatedDebt';
    }

    function updateDataNote($id_ventar)
    {
        $sql = "UPDATE venta SET estado_venta=:stateNote, deuda_venta=:debtNull where id_venta=:id_venta";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_venta' => $id_ventar, ':stateNote' => 1, 'debtNull' => 0));
        echo 'updatedLiquido';
    }


    function registrarLiquidoBase($folio, $fecha,  $cliente, $ruta, $capturista, $totalFinalPagado, $efectivo, $transferencia, $deposito, $cheque, $date_nota)
    {
        $sql = "INSERT INTO venta (venta_folio, venta_fecha, venta_id_cliente, venta_id_ruta, venta_total_monetario, venta_id_usuario, venta_a_cuenta, venta_adicional, estado_venta, efectivo, transferencia, deposito, cheque, deuda_venta, venta_fecha_nota) values (:folio, :fecha, :id_cliente, :id_ruta, :total_monetario, :id_usuario, :a_cuenta, :adicional, :estado_venta, :efectivo, :transferencia, :deposito, :cheque, :deuda_venta, :fecha_nota)";
        $query = $this->access->prepare($sql);
        $query->execute(array(':folio' => $folio, ':fecha' => $fecha, ':id_cliente' => $cliente, ':id_ruta' => $ruta, ':total_monetario' => '0', ':id_usuario' => $capturista, ':a_cuenta' => $totalFinalPagado, ':adicional' => 'liquido', ':estado_venta' => 1, ':efectivo' => $efectivo, ':transferencia' => $transferencia, ':deposito' => $deposito, ':cheque' => $cheque, ':deuda_venta' => '0', ':fecha_nota' => $date_nota));
        echo 'liquidoEnBase';
    }
    function totalesProducto($id_ruta, $fecha)
    {
        $sql = "SELECT ruta.ruta_nombre,ROUND(SUM(venta.efectivo),2) AS total_efectivo,ROUND(SUM(venta.transferencia),2) AS total_transferencia,ROUND(SUM(venta.deposito),2) AS total_deposito,ROUND(SUM(venta.cheque),2) AS total_cheque,ROUND(SUM(venta.venta_a_cuenta),2) AS total_ruta FROM venta JOIN ruta ON venta.venta_id_ruta = ruta.id_ruta WHERE venta.venta_id_ruta =:id_ruta AND venta.venta_fecha LIKE :fecha";
        $query = $this->access->prepare($sql);
        $query->execute(array(':id_ruta' => $id_ruta, ':fecha' => "%$fecha%"));
        $this->objetos_venta = $query->fetchall();
        return $this->objetos_venta;
    }
}
