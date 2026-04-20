<?php

require_once __DIR__ . '/BaseModel.php';

class Receta extends BaseModel
{
    public function getTodas(): array
    {
        $sql = "SELECT *
                FROM recetas
                ORDER BY fecha_creacion DESC, id DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT *
                FROM recetas
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function existeSlug(string $slug, int $excludeId = 0): bool
    {
        $sql = "SELECT id
                FROM recetas
                WHERE slug = :slug";

        if ($excludeId > 0) {
            $sql .= " AND id != :id";
        }

        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $params = [
            'slug' => $slug
        ];

        if ($excludeId > 0) {
            $params['id'] = $excludeId;
        }

        $stmt->execute($params);

        return (bool)$stmt->fetch();
    }

    public function crear(array $data): bool
    {
        $sql = "INSERT INTO recetas (
                    titulo,
                    slug,
                    descripcion_corta,
                    elaboracion,
                    imagen,
                    activa
                ) VALUES (
                    :titulo,
                    :slug,
                    :descripcion_corta,
                    :elaboracion,
                    :imagen,
                    :activa
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'titulo' => trim($data['titulo']),
            'slug' => trim($data['slug']),
            'descripcion_corta' => trim($data['descripcion_corta'] ?? '') !== '' ? trim($data['descripcion_corta']) : null,
            'elaboracion' => trim($data['elaboracion']),
            'imagen' => trim($data['imagen'] ?? '') !== '' ? trim($data['imagen']) : null,
            'activa' => isset($data['activa']) ? 1 : 0
        ]);
    }

    public function actualizar(array $data): bool
    {
        $sql = "UPDATE recetas
                SET titulo = :titulo,
                    slug = :slug,
                    descripcion_corta = :descripcion_corta,
                    elaboracion = :elaboracion,
                    imagen = :imagen,
                    activa = :activa
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => (int)$data['id'],
            'titulo' => trim($data['titulo']),
            'slug' => trim($data['slug']),
            'descripcion_corta' => trim($data['descripcion_corta'] ?? '') !== '' ? trim($data['descripcion_corta']) : null,
            'elaboracion' => trim($data['elaboracion']),
            'imagen' => trim($data['imagen'] ?? '') !== '' ? trim($data['imagen']) : null,
            'activa' => isset($data['activa']) ? 1 : 0
        ]);
    }

    public function toggleActivo(int $id): void
    {
        $sql = "UPDATE recetas
                SET activa = CASE WHEN activa = 1 THEN 0 ELSE 1 END
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }

    public function contarTodas(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM recetas";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarActivas(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM recetas
                WHERE activa = 1";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }
}