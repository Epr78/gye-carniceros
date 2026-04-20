<h1 class="dashboard-title">Dashboard</h1>

<p>Bienvenido al panel de administración.</p>

<?php if (!empty($_SESSION['admin']['nombre'])): ?>
    <p><strong>Administrador:</strong> <?php echo htmlspecialchars($_SESSION['admin']['nombre']); ?></p>
<?php endif; ?>

<br><br>

<h2>Resumen general</h2>
<div class="dashboard-grid">
    
    <div class="dashboard-grid">
    
    <div class="dashboard-card">
        <h3>Pedidos</h3>
        <p>Total: <span class="big"><?php echo (int)$stats['total_pedidos']; ?></span></p>
        <p>Pendientes: <?php echo (int)$stats['pedidos_pendientes']; ?></p>
        <p>Preparados: <?php echo (int)$stats['pedidos_preparados']; ?></p>
        <p>Entregados: <?php echo (int)$stats['pedidos_entregados']; ?></p>
        <p>Cancelados: <?php echo (int)$stats['pedidos_cancelados']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Facturación</h3>
        <p>Total: <span class="big"><?php echo number_format((float)$stats['total_facturado'], 2, ',', '.'); ?> €</span></p>
    </div>

    <div class="dashboard-card">
        <h3>Resumen mes</h3>
        <p>Ventas: <?php echo number_format((float)$stats['ventas_mes'], 2, ',', '.'); ?> €</p>
        <p>Coste: <?php echo number_format((float)$stats['coste_mes'], 2, ',', '.'); ?> €</p>
        <p>Beneficio: <span class="big"><?php echo number_format((float)$stats['beneficio_bruto_mes'], 2, ',', '.'); ?> €</span></p>
    </div>

    <div class="dashboard-card">
        <h3>Productos</h3>
        <p>Total: <span class="big"><?php echo (int)$stats['total_productos']; ?></span></p>
        <p>Activos: <?php echo (int)$stats['productos_activos']; ?></p>
        <p>Sin stock: <?php echo (int)$stats['productos_sin_stock']; ?></p>
        <p>Stock bajo: <?php echo (int)$stats['productos_stock_bajo']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Recetas</h3>
        <p>Total: <?php echo (int)$stats['total_recetas']; ?></p>
        <p>Activas: <?php echo (int)$stats['recetas_activas']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Entradas</h3>
        <p>Total: <span class="big"><?php echo (int)$stats['total_entradas']; ?></span></p>
    </div>

    <div class="dashboard-card">
        <h3>Contactos</h3>
        <p>Total: <?php echo (int)$stats['total_contactos']; ?></p>
        <p>Pendientes: <span class="big"><?php echo (int)$stats['contactos_pendientes']; ?></span></p>
        <a href="<?php echo BASE_URL; ?>/admin.php?route=contactos">Ver mensajes</a>
    </div>

</div>
</div>

<br><br>

<?php if (!empty($productosStockBajo)): ?>
    <h2>Productos con stock bajo</h2>

    <div style="overflow-x:auto; margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
            <thead>
                <tr style="background:#d97706; color:#fff;">
                    <th style="padding:8px; border:1px solid #ddd;">Producto</th>
                    <th style="padding:8px; border:1px solid #ddd;">Familia</th>
                    <th style="padding:8px; border:1px solid #ddd;">Tipo venta</th>
                    <th style="padding:8px; border:1px solid #ddd;">Stock actual</th>
                    <th style="padding:8px; border:1px solid #ddd;">Umbral</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productosStockBajo as $producto): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($producto['familia_nombre']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($producto['tipo_venta']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$producto['stock_cantidad'], 2, ',', '.'); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$producto['umbral_stock_bajo'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<br><br>

<h2>Accesos rápidos</h2>

<div class="quick-links">

    <a href="<?php echo BASE_URL; ?>/admin.php?route=pedidos">Gestionar pedidos</a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=productos">Gestionar productos</a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=piezas-base-precios">
        Gestionar precios de compra
    </a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=recetas">Gestionar recetas</a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=entrada">
        Registrar entrada de mercancía
    </a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=entradas">
        Ver historial de entradas
    </a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=contactos">
        Ver mensajes de contacto
    </a>

    <a href="<?php echo BASE_URL; ?>/admin.php?route=logout" class="danger">
        Cerrar sesión
    </a>

</div>

<br><br>

<h2>Últimos pedidos</h2>

<?php if (empty($ultimosPedidos)): ?>
    <p>No hay pedidos recientes.</p>
<?php else: ?>
    <div style="overflow-x:auto; margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
            <thead>
                <tr style="background:#a61b1b; color:#fff;">
                    <th style="padding:8px; border:1px solid #ddd;">ID</th>
                    <th style="padding:8px; border:1px solid #ddd;">Cliente</th>
                    <th style="padding:8px; border:1px solid #ddd;">Estado</th>
                    <th style="padding:8px; border:1px solid #ddd;">Total</th>
                    <th style="padding:8px; border:1px solid #ddd;">Fecha</th>
                    <th style="padding:8px; border:1px solid #ddd;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimosPedidos as $pedido): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$pedido['id']; ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($pedido['nombre_cliente']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($pedido['estado']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$pedido['total'], 2, ',', '.'); ?> €</td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($pedido['fecha_creacion']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;">
                            <a href="<?php echo BASE_URL; ?>/admin.php?route=pedido-detalle&id=<?php echo (int)$pedido['id']; ?>">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<br><br>

<h2>Últimas entradas</h2>

<?php if (empty($ultimasEntradas)): ?>
    <p>No hay entradas recientes.</p>
<?php else: ?>
    <div style="overflow-x:auto; margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
            <thead>
                <tr style="background:#a61b1b; color:#fff;">
                    <th style="padding:8px; border:1px solid #ddd;">ID</th>
                    <th style="padding:8px; border:1px solid #ddd;">Pieza base</th>
                    <th style="padding:8px; border:1px solid #ddd;">Unidad</th>
                    <th style="padding:8px; border:1px solid #ddd;">Cantidad</th>
                    <th style="padding:8px; border:1px solid #ddd;">Coste compra</th>
                    <th style="padding:8px; border:1px solid #ddd;">Administrador</th>
                    <th style="padding:8px; border:1px solid #ddd;">Fecha</th>
                    <th style="padding:8px; border:1px solid #ddd;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimasEntradas as $entrada): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$entrada['id']; ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['pieza_base_nombre']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($entrada['pieza_base_tipo_unidad']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)$entrada['cantidad_entrada'], 2, ',', '.'); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo number_format((float)($entrada['coste_total_compra'] ?? 0), 2, ',', '.'); ?> €</td>
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
<?php endif; ?>

<br><br>

<h2>Últimos mensajes de contacto</h2>

<?php if (empty($ultimosContactos)): ?>
    <p>No hay mensajes de contacto registrados.</p>
<?php else: ?>
    <div style="overflow-x:auto; margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
            <thead>
                <tr style="background:#333; color:#fff;">
                    <th style="padding:8px; border:1px solid #ddd;">Fecha</th>
                    <th style="padding:8px; border:1px solid #ddd;">Nombre</th>
                    <th style="padding:8px; border:1px solid #ddd;">Email</th>
                    <th style="padding:8px; border:1px solid #ddd;">Asunto</th>
                    <th style="padding:8px; border:1px solid #ddd;">Estado</th>
                    <th style="padding:8px; border:1px solid #ddd;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimosContactos as $contacto): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($contacto['fecha_creacion']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($contacto['email']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($contacto['asunto']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo (int)$contacto['contestado'] === 1 ? 'Contestada' : 'Pendiente'; ?></td>
                        <td style="padding:8px; border:1px solid #ddd;">
                            <a href="<?php echo BASE_URL; ?>/admin.php?route=contactos">Ver todos</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<br><br>

<h2>Usuarios registrados</h2>

<?php if (empty($usuarios)): ?>
    <p>No hay usuarios registrados.</p>
<?php else: ?>
    <div style="overflow-x:auto; margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse; background:#fff; color:#111;">
            <thead>
                <tr style="background:#333; color:#fff;">
                    <th style="padding:8px; border:1px solid #ddd;">Nombre</th>
                    <th style="padding:8px; border:1px solid #ddd;">Email</th>
                    <th style="padding:8px; border:1px solid #ddd;">Teléfono</th>
                    <th style="padding:8px; border:1px solid #ddd;">Dirección</th>
                    <th style="padding:8px; border:1px solid #ddd;">Fecha de creación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?></td>
                        <td style="padding:8px; border:1px solid #ddd;"><?php echo htmlspecialchars($usuario['fecha_creacion']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>