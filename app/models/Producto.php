<?php

require_once __DIR__ . '/BaseModel.php';

class Producto extends BaseModel
{
    public function getTodos(): array
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                ORDER BY f.nombre ASC, p.nombre ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function getActivos(): array
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.activo = 1
                  AND f.activa = 1
                ORDER BY p.nombre ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function getActivosFiltrados(array $filtros): array
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.activo = 1
                  AND f.activa = 1";

        $params = [];

        if (!empty($filtros['familia'])) {
            $sql .= " AND f.slug = :familia";
            $params['familia'] = $filtros['familia'];
        }

        if (!empty($filtros['oferta'])) {
            $sql .= " AND p.en_oferta = 1
                      AND p.precio_oferta IS NOT NULL
                      AND p.precio_oferta > 0";
        }

        if (!empty($filtros['apto'])) {
            $campo = match ($filtros['apto']) {
                'plancha' => 'p.apto_plancha',
                'empanar' => 'p.apto_empanar',
                'estofar' => 'p.apto_estofar',
                'picar' => 'p.se_puede_picar',
                'asar' => 'p.apto_asar',
                default => null
            };

            if ($campo !== null) {
                $sql .= " AND {$campo} = 1";
            }
        }

        $sql .= " ORDER BY f.nombre ASC, p.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getOfertas(): array
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.activo = 1
                  AND f.activa = 1
                  AND p.en_oferta = 1
                  AND p.precio_oferta IS NOT NULL
                  AND p.precio_oferta > 0
                ORDER BY p.nombre ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function getByFamiliaSlug(string $familiaSlug): array
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.activo = 1
                  AND f.activa = 1
                  AND f.slug = :familia_slug
                ORDER BY p.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'familia_slug' => $familiaSlug
        ]);

        return $stmt->fetchAll();
    }

    public function getBySlug(string $slug): array|false
    {
        $sql = "SELECT
                    p.*,
                    f.nombre AS familia_nombre,
                    f.slug AS familia_slug,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                INNER JOIN familias f ON f.id = p.familia_id
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.slug = :slug
                  AND p.activo = 1
                  AND f.activa = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'slug' => $slug
        ]);

        return $stmt->fetch();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT
                    p.*,
                    COALESCE(s.cantidad, 0) AS stock_cantidad
                FROM productos p
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function getFamilias(): array
    {
        $sql = "SELECT
                    id,
                    nombre,
                    slug
                FROM familias
                WHERE activa = 1
                ORDER BY nombre ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function existeSlug(string $slug, ?int $excludeId = null): bool
    {
        $sql = "SELECT id
                FROM productos
                WHERE slug = :slug";

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->db->prepare($sql);

        $params = [
            'slug' => $slug
        ];

        if ($excludeId !== null) {
            $params['id'] = $excludeId;
        }

        $stmt->execute($params);

        return (bool)$stmt->fetch();
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO productos (
                    familia_id,
                    nombre,
                    slug,
                    descripcion,
                    precio,
                    tipo_venta,
                    imagen,
                    en_oferta,
                    precio_oferta,
                    activo,
                    destacado,
                    apto_plancha,
                    apto_empanar,
                    apto_estofar,
                    se_puede_picar,
                    apto_asar
                ) VALUES (
                    :familia_id,
                    :nombre,
                    :slug,
                    :descripcion,
                    :precio,
                    :tipo_venta,
                    :imagen,
                    :en_oferta,
                    :precio_oferta,
                    :activo,
                    :destacado,
                    :apto_plancha,
                    :apto_empanar,
                    :apto_estofar,
                    :se_puede_picar,
                    :apto_asar
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'familia_id' => $data['familia_id'],
            'nombre' => $data['nombre'],
            'slug' => $data['slug'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'tipo_venta' => $data['tipo_venta'],
            'imagen' => $data['imagen'],
            'en_oferta' => isset($data['en_oferta']) ? 1 : 0,
            'precio_oferta' => $data['precio_oferta'] !== '' ? $data['precio_oferta'] : null,
            'activo' => isset($data['activo']) ? 1 : 0,
            'destacado' => isset($data['destacado']) ? 1 : 0,
            'apto_plancha' => isset($data['apto_plancha']) ? 1 : 0,
            'apto_empanar' => isset($data['apto_empanar']) ? 1 : 0,
            'apto_estofar' => isset($data['apto_estofar']) ? 1 : 0,
            'se_puede_picar' => isset($data['se_puede_picar']) ? 1 : 0,
            'apto_asar' => isset($data['apto_asar']) ? 1 : 0
        ]);
    }

    public function actualizar(array $data): bool
    {
        $sql = "UPDATE productos SET
                    familia_id = :familia_id,
                    nombre = :nombre,
                    slug = :slug,
                    descripcion = :descripcion,
                    precio = :precio,
                    tipo_venta = :tipo_venta,
                    imagen = :imagen,
                    en_oferta = :en_oferta,
                    precio_oferta = :precio_oferta,
                    activo = :activo,
                    destacado = :destacado,
                    apto_plancha = :apto_plancha,
                    apto_empanar = :apto_empanar,
                    apto_estofar = :apto_estofar,
                    se_puede_picar = :se_puede_picar,
                    apto_asar = :apto_asar
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $data['id'],
            'familia_id' => $data['familia_id'],
            'nombre' => $data['nombre'],
            'slug' => $data['slug'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'tipo_venta' => $data['tipo_venta'],
            'imagen' => $data['imagen'],
            'en_oferta' => isset($data['en_oferta']) ? 1 : 0,
            'precio_oferta' => $data['precio_oferta'] !== '' ? $data['precio_oferta'] : null,
            'activo' => isset($data['activo']) ? 1 : 0,
            'destacado' => isset($data['destacado']) ? 1 : 0,
            'apto_plancha' => isset($data['apto_plancha']) ? 1 : 0,
            'apto_empanar' => isset($data['apto_empanar']) ? 1 : 0,
            'apto_estofar' => isset($data['apto_estofar']) ? 1 : 0,
            'se_puede_picar' => isset($data['se_puede_picar']) ? 1 : 0,
            'apto_asar' => isset($data['apto_asar']) ? 1 : 0
        ]);
    }

    public function cambiarEstadoActivo(int $id): bool
    {
        $sql = "UPDATE productos
                SET activo = CASE WHEN activo = 1 THEN 0 ELSE 1 END
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function actualizarStock(int $productoId, float $cantidad): bool
    {
        $sqlExiste = "SELECT id
                      FROM stock
                      WHERE producto_id = :id
                      LIMIT 1";

        $stmtExiste = $this->db->prepare($sqlExiste);
        $stmtExiste->execute([
            'id' => $productoId
        ]);

        if ($stmtExiste->fetch()) {
            $sql = "UPDATE stock
                    SET cantidad = :cantidad
                    WHERE producto_id = :id";
        } else {
            $sql = "INSERT INTO stock (
                        producto_id,
                        cantidad
                    ) VALUES (
                        :id,
                        :cantidad
                    )";
        }

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $productoId,
            'cantidad' => $cantidad
        ]);
    }

    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarActivos(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE activo = 1";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarSinStock(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos p
                LEFT JOIN stock s ON s.producto_id = p.id
                WHERE s.cantidad IS NULL
                   OR s.cantidad <= 0";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarStockBajo(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM (
                    SELECT
                        p.id,
                        COALESCE(s.cantidad, 0) AS stock_cantidad,
                        LOWER(f.slug) AS familia_slug,
                        LOWER(p.nombre) AS producto_nombre,
                        LOWER(p.slug) AS producto_slug,
                        CASE
                            WHEN LOWER(f.slug) = 'pollo' THEN 10
                            WHEN LOWER(f.slug) = 'elaborados'
                                 AND (
                                     LOWER(p.nombre) LIKE '%hamburgues%'
                                     OR LOWER(p.slug) LIKE '%hamburgues%'
                                 ) THEN 10
                            WHEN LOWER(f.slug) = 'elaborados' THEN 2
                            WHEN LOWER(f.slug) IN ('vacuno', 'ternera', 'cerdo') THEN 5
                            ELSE 5
                        END AS umbral_stock_bajo
                    FROM productos p
                    INNER JOIN familias f ON f.id = p.familia_id
                    LEFT JOIN stock s ON s.producto_id = p.id
                    WHERE p.activo = 1
                ) AS t
                WHERE t.stock_cantidad > 0
                  AND t.stock_cantidad <= t.umbral_stock_bajo";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function getProductosStockBajo(): array
    {
        $sql = "SELECT *
                FROM (
                    SELECT
                        p.id,
                        p.nombre,
                        p.slug,
                        p.tipo_venta,
                        f.nombre AS familia_nombre,
                        f.slug AS familia_slug,
                        COALESCE(s.cantidad, 0) AS stock_cantidad,
                        CASE
                            WHEN LOWER(f.slug) = 'pollo' THEN 10
                            WHEN LOWER(f.slug) = 'elaborados'
                                 AND (
                                     LOWER(p.nombre) LIKE '%hamburgues%'
                                     OR LOWER(p.slug) LIKE '%hamburgues%'
                                 ) THEN 10
                            WHEN LOWER(f.slug) = 'elaborados' THEN 2
                            WHEN LOWER(f.slug) IN ('vacuno', 'ternera', 'cerdo') THEN 5
                            ELSE 5
                        END AS umbral_stock_bajo
                    FROM productos p
                    INNER JOIN familias f ON f.id = p.familia_id
                    LEFT JOIN stock s ON s.producto_id = p.id
                    WHERE p.activo = 1
                ) AS t
                WHERE t.stock_cantidad > 0
                  AND t.stock_cantidad <= t.umbral_stock_bajo
                ORDER BY t.stock_cantidad ASC, t.nombre ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}