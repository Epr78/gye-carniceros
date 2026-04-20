<div class="admin-page">
    <div class="admin-block">

        <!--HEADER -->
        <div class="admin-header">
            <h1 class="admin-title">Entradas</h1>

        <a href="<?php echo BASE_URL; ?>/admin.php?route=entrada-crear" class="btn-new">
                + Registrar nueva entrada
        </a>
    </div>

    <?php if (empty($entradas)): ?>
        <p>No hay entradas registradas.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
                <thead>
                    <tr style="background:#a61b1b; color:#fff;">
                        <th style="padding:8px; border:1px solid #ddd;">ID</th>
                        <th style="padding:8px; border:1px solid #ddd;">Pieza base</th>
                        <th style="padding:8px; border:1px solid #ddd;">Unidad</th>
                        <th style="padding:8px; border:1px solid #ddd;">Cantidad entrada</th>
                        <th style="padding:8px; border:1px solid #ddd;">Administrador</th>
                        <th style="padding:8px; border:1px solid #ddd;">Fecha</th>
                        <th style="padding:8px; border:1px solid #ddd;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$entrada['id']; ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['pieza_base_nombre']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['pieza_base_tipo_unidad']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$entrada['cantidad_entrada'], 2, ',', '.'); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['administrador_nombre']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['fecha_creacion']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;">
                                <a href="<?php echo BASE_URL; ?>/admin.php?route=entrada-detalle&id=<?php echo (int)$entrada['id']; ?>">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=dashboard">
                ← Volver al dashboard
            </a>
        </p>
    <?php endif; ?>
</div>