<div class="admin-page">
    <h1>Precios de compra de piezas base</h1>

    <?php if (empty($piezasBase)): ?>
        <p>No hay piezas base registradas.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
                <thead>
                    <tr style="background:#a61b1b; color:#fff;">
                        <th style="padding:8px; border:1px solid #ddd;">ID</th>
                        <th style="padding:8px; border:1px solid #ddd;">Nombre</th>
                        <th style="padding:8px; border:1px solid #ddd;">Slug</th>
                        <th style="padding:8px; border:1px solid #ddd;">Unidad</th>
                        <th style="padding:8px; border:1px solid #ddd;">Activa</th>
                        <th style="padding:8px; border:1px solid #ddd;">Precio compra unitario (€)</th>
                        <th style="padding:8px; border:1px solid #ddd;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($piezasBase as $piezaBase): ?>
                        <tr>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$piezaBase['id']; ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($piezaBase['nombre']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($piezaBase['slug']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($piezaBase['tipo_unidad']); ?></td>
                            <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$piezaBase['activa'] === 1 ? 'Sí' : 'No'; ?></td>
                            <td style="padding:8px; border:1px solid #ddd;">
                                <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=pieza-base-precio-actualizar" style="display:flex; gap:8px; align-items:center;">
                                    <input type="hidden" name="id" value="<?php echo (int)$piezaBase['id']; ?>">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="precio_compra_unitario"
                                        value="<?php echo htmlspecialchars(number_format((float)$piezaBase['precio_compra_unitario'], 2, '.', '')); ?>"
                                        style="width:120px;"
                                        required
                                    >

                                    <button type="submit">Guardar</button>
                                </form>
                            </td>
                            <td style="padding:8px; border:1px solid #ddd;">
                                Actualizar precio
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <p style="margin-top:20px;">
        <a href="<?php echo BASE_URL; ?>/admin.php?route=dashboard">Volver al dashboard</a>
    </p>
</div>