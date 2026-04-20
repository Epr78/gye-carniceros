<div class="admin-page">
    <h1>Detalle de entrada #<?php echo (int)$entrada['id']; ?></h1>

    <div style="background:#ffffff; color:#111111; padding:20px; border:1px solid #ddd; margin-bottom:20px;">
        <p><strong>Pieza base:</strong> <?php echo htmlspecialchars($entrada['pieza_base_nombre']); ?></p>
        <p><strong>Unidad:</strong> <?php echo htmlspecialchars($entrada['pieza_base_tipo_unidad']); ?></p>
        <p><strong>Cantidad entrada:</strong> <?php echo number_format((float)$entrada['cantidad_entrada'], 2, ',', '.'); ?></p>
        <p><strong>Administrador:</strong> <?php echo htmlspecialchars($entrada['administrador_nombre']); ?></p>
        <p><strong>Observaciones:</strong> <?php echo nl2br(htmlspecialchars($entrada['observaciones'] ?? '')); ?></p>
        <p><strong>Fecha creación:</strong> <?php echo htmlspecialchars($entrada['fecha_creacion']); ?></p>
    </div>

    <h2>Productos generados</h2>

    <?php if (empty($detalles)): ?>
        <p>No hay detalles para esta entrada.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
                <thead>
                    <tr style="background:#a61b1b; color:#fff;">
                        <th style="padding:8px; border:1px solid #ddd;">Producto</th>
                        <th style="padding:8px; border:1px solid #ddd;">Tipo venta</th>
                        <th style="padding:8px; border:1px solid #ddd;">Cantidad generada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($detalle['producto_nombre']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($detalle['tipo_venta']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$detalle['cantidad_generada'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <p class="back-link">
                    <a href="<?php echo BASE_URL; ?>/admin.php?route=entradas">
                        ← Volver a entradas
                    </a>
</div>