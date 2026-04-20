<?php

require_once __DIR__ . '/BaseModel.php';

class EntradaCompra extends BaseModel
{
    public function crearConDespiece(array $data, array $reglas): int|false
    {
        if (empty($reglas)) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $cantidadEntrada = (float)$data['cantidad_entrada'];
            $costeTotalCompra = (float)$data['coste_total_compra'];

            $cantidadTotalGenerada = 0.0;

            foreach ($reglas as $regla) {
                $cantidadGenerada = $cantidadEntrada * (float)$regla['cantidad_resultante'];
                $cantidadTotalGenerada += $cantidadGenerada;
            }

            if ($cantidadTotalGenerada <= 0) {
                $this->db->rollBack();
                return false;
            }

            $costeUnitarioMedio = $costeTotalCompra / $cantidadTotalGenerada;

            $sqlEntrada = "INSERT INTO entradas_compra (
                                pieza_base_id,
                                administrador_id,
                                cantidad_entrada,
                                coste_total_compra,
                                observaciones
                           ) VALUES (
                                :pieza_base_id,
                                :administrador_id,
                                :cantidad_entrada,
                                :coste_total_compra,
                                :observaciones
                           )";

            $stmtEntrada = $this->db->prepare($sqlEntrada);
            $stmtEntrada->execute([
                'pieza_base_id' => $data['pieza_base_id'],
                'administrador_id' => $data['administrador_id'],
                'cantidad_entrada' => $cantidadEntrada,
                'coste_total_compra' => $costeTotalCompra,
                'observaciones' => $data['observaciones']
            ]);

            $entradaId = (int)$this->db->lastInsertId();

            $sqlDetalle = "INSERT INTO entrada_detalles (
                                entrada_compra_id,
                                producto_id,
                                cantidad_generada,
                                coste_unitario,
                                coste_total
                           ) VALUES (
                                :entrada_compra_id,
                                :producto_id,
                                :cantidad_generada,
                                :coste_unitario,
                                :coste_total
                           )";

            $stmtDetalle = $this->db->prepare($sqlDetalle);

            foreach ($reglas as $regla) {
                $cantidadGenerada = $cantidadEntrada * (float)$regla['cantidad_resultante'];
                $costeTotalLinea = $cantidadGenerada * $costeUnitarioMedio;

                $stmtDetalle->execute([
                    'entrada_compra_id' => $entradaId,
                    'producto_id' => $regla['producto_id'],
                    'cantidad_generada' => $cantidadGenerada,
                    'coste_unitario' => $costeUnitarioMedio,
                    'coste_total' => $costeTotalLinea
                ]);

                $this->sumarStock((int)$regla['producto_id'], $cantidadGenerada);
            }

            $this->db->commit();
            return $entradaId;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function eliminar(int $entradaId): bool
    {
        if ($entradaId <= 0) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $sqlDetalles = "SELECT
                                producto_id,
                                cantidad_generada
                            FROM entrada_detalles
                            WHERE entrada_compra_id = :entrada_compra_id";

            $stmtDetalles = $this->db->prepare($sqlDetalles);
            $stmtDetalles->execute([
                'entrada_compra_id' => $entradaId
            ]);

            $detalles = $stmtDetalles->fetchAll();

            if (empty($detalles)) {
                $sqlExiste = "SELECT id
                              FROM entradas_compra
                              WHERE id = :id
                              LIMIT 1";

                $stmtExiste = $this->db->prepare($sqlExiste);
                $stmtExiste->execute([
                    'id' => $entradaId
                ]);

                if (!$stmtExiste->fetch()) {
                    $this->db->rollBack();
                    return false;
                }
            }

            foreach ($detalles as $detalle) {
                $this->restarStock(
                    (int)$detalle['producto_id'],
                    (float)$detalle['cantidad_generada']
                );
            }

            $sqlDeleteDetalles = "DELETE FROM entrada_detalles
                                 WHERE entrada_compra_id = :entrada_compra_id";

            $stmtDeleteDetalles = $this->db->prepare($sqlDeleteDetalles);
            $stmtDeleteDetalles->execute([
                'entrada_compra_id' => $entradaId
            ]);

            $sqlDeleteEntrada = "DELETE FROM entradas_compra
                                WHERE id = :id";

            $stmtDeleteEntrada = $this->db->prepare($sqlDeleteEntrada);
            $stmtDeleteEntrada->execute([
                'id' => $entradaId
            ]);

            if ($stmtDeleteEntrada->rowCount() <= 0) {
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
        $sql = "SELECT
                    ec.id,
                    ec.pieza_base_id,
                    ec.administrador_id,
                    ec.cantidad_entrada,
                    ec.coste_total_compra,
                    ec.observaciones,
                    ec.fecha_creacion,
                    pb.nombre AS pieza_base_nombre,
                    pb.tipo_unidad AS pieza_base_tipo_unidad,
                    a.nombre AS administrador_nombre
                FROM entradas_compra ec
                INNER JOIN piezas_base pb ON pb.id = ec.pieza_base_id
                INNER JOIN administradores a ON a.id = ec.administrador_id
                ORDER BY ec.fecha_creacion DESC, ec.id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT
                    ec.id,
                    ec.pieza_base_id,
                    ec.administrador_id,
                    ec.cantidad_entrada,
                    ec.coste_total_compra,
                    ec.observaciones,
                    ec.fecha_creacion,
                    pb.nombre AS pieza_base_nombre,
                    pb.tipo_unidad AS pieza_base_tipo_unidad,
                    a.nombre AS administrador_nombre
                FROM entradas_compra ec
                INNER JOIN piezas_base pb ON pb.id = ec.pieza_base_id
                INNER JOIN administradores a ON a.id = ec.administrador_id
                WHERE ec.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function getDetallesByEntradaId(int $entradaId): array
    {
        $sql = "SELECT
                    ed.id,
                    ed.entrada_compra_id,
                    ed.producto_id,
                    ed.cantidad_generada,
                    ed.coste_unitario,
                    ed.coste_total,
                    p.nombre AS producto_nombre,
                    p.tipo_venta
                FROM entrada_detalles ed
                INNER JOIN productos p ON p.id = ed.producto_id
                WHERE ed.entrada_compra_id = :entrada_compra_id
                ORDER BY p.nombre ASC, ed.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'entrada_compra_id' => $entradaId
        ]);

        return $stmt->fetchAll();
    }

    public function contarTodas(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM entradas_compra";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function getUltimas(int $limite = 5): array
    {
        $sql = "SELECT
                    ec.id,
                    ec.cantidad_entrada,
                    ec.coste_total_compra,
                    ec.fecha_creacion,
                    pb.nombre AS pieza_base_nombre,
                    pb.tipo_unidad AS pieza_base_tipo_unidad,
                    a.nombre AS administrador_nombre
                FROM entradas_compra ec
                INNER JOIN piezas_base pb ON pb.id = ec.pieza_base_id
                INNER JOIN administradores a ON a.id = ec.administrador_id
                ORDER BY ec.fecha_creacion DESC, ec.id DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function sumarStock(int $productoId, float $cantidad): void
    {
        $sqlExiste = "SELECT id, cantidad
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
            $stmtUpdate->execute([
                'cantidad' => $cantidad,
                'producto_id' => $productoId
            ]);
        } else {
            $sqlInsert = "INSERT INTO stock (
                            producto_id,
                            cantidad
                          ) VALUES (
                            :producto_id,
                            :cantidad
                          )";

            $stmtInsert = $this->db->prepare($sqlInsert);
            $stmtInsert->execute([
                'producto_id' => $productoId,
                'cantidad' => $cantidad
            ]);
        }
    }

    private function restarStock(int $productoId, float $cantidad): void
    {
        $sqlExiste = "SELECT id, cantidad
                      FROM stock
                      WHERE producto_id = :producto_id
                      LIMIT 1";

        $stmtExiste = $this->db->prepare($sqlExiste);
        $stmtExiste->execute([
            'producto_id' => $productoId
        ]);

        $stock = $stmtExiste->fetch();

        if (!$stock) {
            return;
        }

        $nuevaCantidad = (float)$stock['cantidad'] - $cantidad;

        if ($nuevaCantidad < 0) {
            $nuevaCantidad = 0;
        }

        $sqlUpdate = "UPDATE stock
                      SET cantidad = :cantidad
                      WHERE producto_id = :producto_id";

        $stmtUpdate = $this->db->prepare($sqlUpdate);
        $stmtUpdate->execute([
            'cantidad' => $nuevaCantidad,
            'producto_id' => $productoId
        ]);
    }
}