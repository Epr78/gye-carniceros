<div class="admin-page">
    <div class="admin-block">

        <!--HEADER -->
        <div class="admin-header">
            <h1 class="admin-title">Productos</h1>

    
        <a href="<?php echo BASE_URL; ?>/admin.php?route=producto-crear" class="btn-new">
            + Crear nuevo producto
        </a>
    </div>


    <?php if (empty($productos)): ?>
        <p>No hay productos registrados.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
                <thead>
                    <tr style="background:#a61b1b; color:#fff;">
                        <th style="padding:8px; border:1px solid #ddd;">ID</th>
                        <th style="padding:8px; border:1px solid #ddd;">Nombre</th>
                        <th style="padding:8px; border:1px solid #ddd;">Familia</th>
                        <th style="padding:8px; border:1px solid #ddd;">Precio</th>
                        <th style="padding:8px; border:1px solid #ddd;">Stock</th>
                        <th style="padding:8px; border:1px solid #ddd;">Activo</th>
                        <th style="padding:8px; border:1px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $familiaActual = ''; ?>

                    <?php foreach ($productos as $producto): ?>
                        <?php if ($familiaActual !== $producto['familia_nombre']): ?>
                            <?php $familiaActual = $producto['familia_nombre']; ?>
                            <tr>
                                <td colspan="7" style="padding:10px; border:1px solid #ddd; background:#f4e4cf; font-weight:700;">
                                    Familia: <?php echo htmlspecialchars($familiaActual); ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td style="padding:8px; border:1px solid #ddd;">
                                <?php echo (int)$producto['id']; ?>
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <?php echo htmlspecialchars($producto['familia_nombre']); ?>
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <?php echo number_format((float)$producto['precio'], 2, ',', '.'); ?> €
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=producto-stock" style="display:flex; gap:8px; align-items:center; margin:0;">
                                    <input type="hidden" name="producto_id" value="<?php echo (int)$producto['id']; ?>">

                                    <input
                                        type="number"
                                        name="cantidad"
                                        step="0.01"
                                        min="0"
                                        value="<?php echo htmlspecialchars((string)number_format((float)($producto['stock_cantidad'] ?? 0), 2, '.', '')); ?>"
                                        style="width:90px;"
                                    >

                                    <button type="submit">Guardar</button>
                                </form>
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <?php echo (int)$producto['activo'] === 1 ? 'Sí' : 'No'; ?>
                            </td>

                            <td style="padding:8px; border:1px solid #ddd;">
                                <a href="<?php echo BASE_URL; ?>/admin.php?route=producto-editar&id=<?php echo (int)$producto['id']; ?>">
                                    Editar
                                </a>
                                |
                                <a href="<?php echo BASE_URL; ?>/admin.php?route=producto-toggle&id=<?php echo (int)$producto['id']; ?>">
                                    <?php echo (int)$producto['activo'] === 1 ? 'Desactivar' : 'Activar'; ?>
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