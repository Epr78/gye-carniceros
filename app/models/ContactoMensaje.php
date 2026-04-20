<?php

require_once __DIR__ . '/BaseModel.php';

class ContactoMensaje extends BaseModel
{
    public function crear(array $data): bool
{
    // Detectar palabras clave (queja)
    $mensaje = strtolower($data['mensaje']);

    $palabrasClave = [
        'dura',
        'duro',
        'mala',
        'malo',
        'fatal',
        'queja',
        'reclamacion',
        'reclamación',
        'mal',
        'no estaba bien'
    ];

    $alerta = 0;

    foreach ($palabrasClave as $palabra) {
        if (strpos($mensaje, $palabra) !== false) {
            $alerta = 1;
            break;
        }
    }

    $sql = "INSERT INTO contacto_mensajes (
                nombre,
                email,
                telefono,
                asunto,
                mensaje,
                contestado,
                alerta
            ) VALUES (
                :nombre,
                :email,
                :telefono,
                :asunto,
                :mensaje,
                0,
                :alerta
            )";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        'nombre' => $data['nombre'],
        'email' => $data['email'],
        'telefono' => $data['telefono'] !== '' ? $data['telefono'] : null,
        'asunto' => $data['asunto'],
        'mensaje' => $data['mensaje'],
        'alerta' => $alerta
    ]);
}

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM contacto_mensajes
                ORDER BY contestado ASC, fecha_creacion DESC, id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT *
                FROM contacto_mensajes
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function toggleContestado(int $id): bool
    {
        $sql = "UPDATE contacto_mensajes
                SET contestado = CASE WHEN contestado = 1 THEN 0 ELSE 1 END
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM contacto_mensajes";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarPendientes(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM contacto_mensajes
                WHERE contestado = 0";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function contarAlertas(): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM contacto_mensajes
                WHERE alerta = 1 AND contestado = 0";

        $stmt = $this->db->query($sql);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }
}