<div class="admin-page">
    <div class="admin-block">

        <!-- HEADER -->
        <div class="admin-header">
            <h1 class="admin-title">Pedidos</h1>

            <a href="<?php echo BASE_URL; ?>/admin.php?route=pedido-crear" class="btn-new">
                + Crear nuevo pedido
            </a>
        </div>

        <?php if (empty($pedidos)): ?>
            <p>No hay pedidos registrados.</p>
        <?php else: ?>

            <div class="table-container">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Fecha recogida</th>
                            <th>Método pago</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Fecha creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?php echo (int)$pedido['id']; ?></td>
                                <td><?php echo htmlspecialchars($pedido['nombre_cliente']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['email'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($pedido['fecha_recogida'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($pedido['metodo_pago'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                                <td><?php echo number_format((float)$pedido['total'], 2, ',', '.'); ?> €</td>
                                <td><?php echo htmlspecialchars($pedido['fecha_creacion']); ?></td>
                                <td style="white-space:nowrap;">

                                    <a href="<?php echo BASE_URL; ?>/admin.php?route=pedido-detalle&id=<?php echo (int)$pedido['id']; ?>" class="btn-view">
                                        Ver detalle
                                    </a>

                                    <form
                                        method="post"
                                        action="<?php echo BASE_URL; ?>/admin.php?route=pedido-eliminar&id=<?php echo (int)$pedido['id']; ?>"
                                        style="display:inline-block; margin-left:10px;"
                                        onsubmit="return confirm('¿Seguro que quieres borrar este pedido?');"
                                    >
                                        <button type="submit" class="btn-delete">
                                            Borrar
                                        </button>
                                    </form>

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

</div>
                           