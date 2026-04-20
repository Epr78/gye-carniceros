<?php

require_once __DIR__ . '/BaseModel.php';

class Usuario extends BaseModel
{
    public function crear(array $data): int|false
    {
        $sql = "INSERT INTO usuarios (nombre, email, telefono, direccion, password, activo)
                VALUES (:nombre, :email, :telefono, :direccion, :password, 1)";

        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion'],
            'password' => $data['password']
        ]);

        if (!$ok) {
            return false;
        }

        return (int)$this->db->lastInsertId();
    }

    public function getByEmail(string $email): array|false
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE email = :email
                  AND activo = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT *
                FROM usuarios
                WHERE id = :id
                  AND activo = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    // 🔥 NUEVO: obtener todos los usuarios
    public function getAll(): array
    {
        $sql = "SELECT id, nombre, email, telefono, direccion, fecha_creacion
                FROM usuarios
                ORDER BY fecha_creacion DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}