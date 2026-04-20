<div class="admin-page">
    <div class="admin-block">

        <h1 class="admin-title">Mensajes de contacto</h1>

        <?php if (empty($contactos)): ?>
            <p>No hay mensajes de contacto registrados.</p>
        <?php else: ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Asunto</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($contactos as $contacto): ?>
                            <tr class="<?php echo $contacto['alerta'] ? 'alerta-row' : ''; ?>">

                                <td><?php echo htmlspecialchars($contacto['fecha_creacion']); ?></td>

                                <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>

                                <td><?php echo htmlspecialchars($contacto['email']); ?></td>

                                <td><?php echo htmlspecialchars($contacto['telefono'] ?? ''); ?></td>

                                <td><?php echo htmlspecialchars($contacto['asunto']); ?></td>

                                <td style="white-space:pre-wrap;">
                                    <?php echo htmlspecialchars($contacto['mensaje']); ?>
                                </td>

                                <td>
                                    <?php echo (int)$contacto['contestado'] === 1 ? 'Contestada' : 'Pendiente'; ?>
                                </td>

                                <td>

                                    <!--  RESPONDER -->
                                    <a href="<?php echo BASE_URL; ?>/admin.php?route=contacto-responder&id=<?php echo (int)$contacto['id']; ?>" 
                                        class="btn-reply">
                                            Responder
                                    </a>

                                    <!--  MARCAR -->
                                    <a href="<?php echo BASE_URL; ?>/admin.php?route=contacto-toggle&id=<?php echo (int)$contacto['id']; ?>">
                                        <?php echo (int)$contacto['contestado'] === 1 ? 'Pendiente' : 'Contestada'; ?>
                                    </a>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

        <!--  VOLVER -->
        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=dashboard">
                ← Volver al dashboard
            </a>
        </p>

    </div>
</div>