<?php

require_once __DIR__ . '/BaseModel.php';

class Administrador extends BaseModel
{
    public function getByEmail(string $email): array|false
    {
        $sql = "SELECT *
                FROM administradores
                WHERE email = :email
                  AND activo = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }
}