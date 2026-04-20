<?php

require_once __DIR__ . '/BaseModel.php';

class PiezaBase extends BaseModel
{
    public function getActivas(): array
    {
        $sql = "SELECT
                    id,
                    nombre,
                    slug,
                    tipo_unidad,
                    precio_compra_unitario
                FROM piezas_base
                WHERE activa = 1
                ORDER BY nombre ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getTodas(): array
    {
        $sql = "SELECT
                    id,
                    nombre,
                    slug,
                    tipo_unidad,
                    precio_compra_unitario,
                    activa
                FROM piezas_base
                ORDER BY nombre ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT
                    id,
                    nombre,
                    slug,
                    tipo_unidad,
                    precio_compra_unitario,
                    activa
                FROM piezas_base
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function actualizarPrecioCompra(int $id, float $precioCompraUnitario): bool
    {
        $sql = "UPDATE piezas_base
                SET precio_compra_unitario = :precio_compra_unitario
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'precio_compra_unitario' => $precioCompraUnitario
        ]);
    }

    public function getReglasDespiece(int $piezaBaseId): array
    {
        $sql = "SELECT
                    dr.id,
                    dr.pieza_base_id,
                    dr.producto_id,
                    dr.cantidad_resultante,
                    p.nombre AS producto_nombre
                FROM despiece_reglas dr
                INNER JOIN productos p ON p.id = dr.producto_id
                WHERE dr.pieza_base_id = :pieza_base_id
                ORDER BY p.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'pieza_base_id' => $piezaBaseId
        ]);

        return $stmt->fetchAll();
    }
}