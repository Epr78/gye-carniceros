<?php

require_once __DIR__ . '/BaseModel.php';

class Pedido extends BaseModel
{
    public function crearPedido(array $datosPedido, array $items): int|false
    {
        try {
            $this->db->beginTransaction();

            foreach ($items as $item) {
                $producto = $item['producto'];
                $productoId = (int)$producto['id'];
                $cantidadSolicitada = (float)$item['cantidad'];

                if (!$this->hayStockSuficiente($productoId, $cantidadSolicitada)) {
                    $this->db->rollBack();
                    return false;
                }
            }

            $sqlPedido = "INSERT INTO pedidos (
                            usuario_id,
                            nombre_cliente,
                            telefono,
                            email,
                            direccion,
                            fecha_recogida,
                            observaciones,
                            metodo_pago,
                            estado,
                            total
                          ) VALUES (
                            :usuario_id,
                            :nombre_cliente,
                            :telefono,
                            :email,
                            :direccion,
                            :fecha_recogida,
                            :observaciones,
                            :metodo_pago,
                            'pendiente',
                            :total
                          )";

            $stmtPedido = $this->db->prepare($sqlPedido);
            $stmtPedido->execute([
                'usuario_id' => $datosPedido['usuario_id'],
                'nombre_cliente' => $datosPedido['nombre_cliente'],
                'telefono' => $datosPedido['telefono'],
                'email' => $datosPedido['email'],
                'direccion' => $datosPedido['direccion'],
                'fecha_recogida' => $datosPedido['fecha_recogida'],
                'observaciones' => $datosPedido['observaciones'],
                'metodo_pago' => $datosPedido['metodo_pago'],
                'total' => $datosPedido['total']
            ]);

            $pedidoId = (int)$this->db->lastInsertId();

            $sqlDetalle = "INSERT INTO pedido_detalles (
                            pedido_id,
                            producto_id,
                            nombre_producto,
                            tipo_venta,
                            cantidad,
                            tipo_corte,
                            precio_unitario,
                            coste_unitario,
                            coste_total,
                            subtotal
                           ) VALUES (
                            :pedido_id,
                            :producto_id,
                            :nombre_producto,
                            :tipo_venta,
                            :cantidad,
                            :tipo_corte,
                            :precio_unitario,
                            :coste_unitario,
                            :coste_total,
                            :subtotal
                           )";

            $stmtDetalle = $this->db->prepare($sqlDetalle);

            foreach ($items as $item) {
                $producto = $item['producto'];
                $productoId = (int)$producto['id'];
                $cantidadSolicitada = (float)$item['cantidad'];

                $costeUnitario = $this->getCosteUnitarioActual($productoId);
                $costeTotal = $costeUnitario * $cantidadSolicitada;

                $stmtDetalle->execute([
                    'pedido_id' => $pedidoId,
                    'producto_id' => $productoId,
                    'nombre_producto' => $producto['nombre'],
                    'tipo_venta' => $producto['tipo_venta'],
                    'cantidad' => $cantidadSolicitada,
                    'tipo_corte' => $item['tipo_corte'] ?? null,
                    'precio_unitario' => $item['precio_unitario'],
                    'coste_unitario' => $costeUnitario,
                    'coste_total' => $costeTotal,
                    'subtotal' => $item['subtotal']
                ]);

                if (!$this->descontarStock($productoId, $cantidadSolicitada)) {
                    $this->db->rollBack();
                    return false;
                }
            }

            $this->db->commit();
            return $pedidoId;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function eliminar(int $pedidoId): bool
    {
        if ($pedidoId <= 0) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $pedido = $this->getById($pedidoId);

            if (!$pedido) {
                $this->db->rollBack();
                return false;
            }

            $sqlDeleteDetalles = "DELETE FROM pedido_detalles
                                  WHERE pedido_id = :pedido_id";

            $stmtDeleteDetalles = $this->db->prepare($sqlDeleteDetalles);
            $stmtDeleteDetalles->execute([
                'pedido_id' => $pedidoId
            ]);

            $sqlDeletePedido = "DELETE FROM pedidos
                                WHERE id = :id";

            $stmtDeletePedido = $this->db->prepare($sqlDeletePedido);
            $stmtDeletePedido->execute([
                'id' => $pedidoId
            ]);

            if ($stmtDeletePedido->rowCount() <= 0) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM pedidos
                ORDER BY fecha_creacion DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT *
                FROM pedidos
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function getDetallesByPedidoId(int $pedidoId): array
    {
        $sql = "SELECT 
                pd.*, 
                p.nombre AS producto_nombre
            FROM pedido_detalles pd
            INNER JOIN productos p ON p.id = pd.producto_id
            WHERE pd.pedido_id = :pedido_id
            ORDER BY pd.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pedido_id' => $pedidoId]);

        return $stmt->fetchAll();
    }
    

    public function actualizarEstado(int $id, string $estado): bool
    {
        $estadosValidos = ['pendiente', 'preparado', 'entregado', 'cancelado'];

        if (!in_array($estado, $estadosValidos, true)) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $pedido = $this->getById($id);

            if (!$pedido) {
                $this->db->rollBack();
                return false;
            }

            $estadoActual = (string)($pedido['estado'] ?? '');

            if ($estadoActual === $estado) {
                $this->db->commit();
                return true;
            }

            $detalles = $this->getDetallesByPedidoId($id);

            if ($estadoActual !== 'cancelado' && $estado === 'cancelado') {
                foreach ($detalles as $detalle) {
                    if (!$this->sumarStock(
                        (int)$detalle['producto_id'],
                        (float)$detalle['cantidad']
                    )) {
                        $this->db->rollBack();
                        return false;
                    }
                }
            }

            if ($estadoActual === 'cancelado' && $estado !== 'cancelado') {
                foreach ($detalles as $detalle) {
                    $productoId = (int)$detalle['producto_id'];
                    $cantidad = (float)$detalle['cantidad'];

                    if (!$this->hayStockSuficiente($productoId, $cantidad)) {
                        $this->db->rollBack();
                        return false;
                    }
                }

                foreach ($detalles as $detalle) {
                    if (!$this->descontarStock(
                        (int)$detalle['producto_id'],
                        (float)$detalle['cantidad']
                    )) {
                        $this->db->rollBack();
                        return false;
                    }
                }
            }

            $sql = "UPDATE pedidos
                    SET estado = :estado
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $ok = $stmt->execute([
                'estado' => $estado,
                'id' => $id
            ]);

            if (!$ok) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM pedidos";
        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarPorEstado(string $estado): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM pedidos
                WHERE estado = :estado";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'estado' => $estado
        ]);

        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function sumarTotalFacturado(): float
    {
        $sql = "SELECT COALESCE(SUM(total), 0) AS total_facturado
                FROM pedidos
                WHERE estado IN ('pendiente', 'preparado', 'entregado')";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (float)($row['total_facturado'] ?? 0);
    }

    public function getUltimos(int $limite = 5): array
    {
        $sql = "SELECT *
                FROM pedidos
                ORDER BY fecha_creacion DESC, id DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getResumenMesActual(): array
    {
        $sql = "SELECT
                    COALESCE(SUM(pd.subtotal), 0) AS ventas_mes,
                    COALESCE(SUM(pd.coste_total), 0) AS coste_mes
                FROM pedido_detalles pd
                INNER JOIN pedidos p ON p.id = pd.pedido_id
                WHERE p.fecha_creacion >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                  AND p.fecha_creacion < DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH)
                  AND p.estado IN ('pendiente', 'preparado', 'entregado')";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        $ventasMes = (float)($row['ventas_mes'] ?? 0);
        $costeMes = (float)($row['coste_mes'] ?? 0);

        return [
            'ventas_mes' => $ventasMes,
            'coste_mes' => $costeMes,
            'beneficio_bruto_mes' => $ventasMes - $costeMes
        ];
    }

    private function getCosteUnitarioActual(int $productoId): float
    {
        $sql = "SELECT ed.coste_unitario
                FROM entrada_detalles ed
                INNER JOIN entradas_compra ec ON ec.id = ed.entrada_compra_id
                WHERE ed.producto_id = :producto_id
                ORDER BY ec.fecha_creacion DESC, ed.id DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'producto_id' => $productoId
        ]);

        $row = $stmt->fetch();

        return (float)($row['coste_unitario'] ?? 0);
    }

    private function hayStockSuficiente(int $productoId, float $cantidadSolicitada): bool
    {
        $sql = "SELECT COALESCE(cantidad, 0) AS cantidad
                FROM stock
                WHERE producto_id = :producto_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'producto_id' => $productoId
        ]);

        $row = $stmt->fetch();

        $stockActual = (float)($row['cantidad'] ?? 0);

        return $stockActual >= $cantidadSolicitada;
    }

    private function descontarStock(int $productoId, float $cantidadSolicitada): bool
    {
        $sql = "SELECT id, COALESCE(cantidad, 0) AS cantidad
                FROM stock
                WHERE producto_id = :producto_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'producto_id' => $productoId
        ]);

        $stock = $stmt->fetch();

        if (!$stock) {
            return false;
        }

        $stockActual = (float)$stock['cantidad'];

        if ($stockActual < $cantidadSolicitada) {
            return false;
        }

        $nuevaCantidad = $stockActual - $cantidadSolicitada;

        $sqlUpdate = "UPDATE stock
                      SET cantidad = :cantidad
                      WHERE producto_id = :producto_id";

        $stmtUpdate = $this->db->prepare($sqlUpdate);

        return $stmtUpdate->execute([
            'cantidad' => $nuevaCantidad,
            'producto_id' => $productoId
        ]);
    }

    private function sumarStock(int $productoId, float $cantidad): bool
    {
        $sqlExiste = "SELECT id, COALESCE(cantidad, 0) AS cantidad
                      FROM stock
                      WHERE producto_id = :producto_id
                      LIMIT 1";

        $stmtExiste = $this->db->prepare($sqlExiste);
        $stmtExiste->execute([
            'producto_id' => $productoId
        ]);

        $stock = $stmtExiste->fetch();

        if ($stock) {
            $sqlUpdate = "UPDATE stock
                          SET cantidad = cantidad + :cantidad
                          WHERE producto_id = :producto_id";

            $stmtUpdate = $this->db->prepare($sqlUpdate);

            return $stmtUpdate->execute([
                'cantidad' => $cantidad,
                'producto_id' => $productoId
            ]);
        }

        $sqlInsert = "INSERT INTO stock (
                        producto_id,
                        cantidad
                      ) VALUES (
                        :producto_id,
                        :cantidad
                      )";

        $stmtInsert = $this->db->prepare($sqlInsert);

        return $stmtInsert->execute([
            'producto_id' => $productoId,
            'cantidad' => $cantidad
        ]);
    }
}