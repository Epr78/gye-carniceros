<div class="admin-page">

    <div class="admin-block">

        <!-- TÍTULO -->
        <h1 class="admin-title">
            Detalle del pedido #<?php echo (int)$pedido['id']; ?>
        </h1>

        <!-- DATOS PEDIDO -->
        <div class="pedido-box">

            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['nombre_cliente']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($pedido['telefono']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($pedido['email']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['direccion']); ?></p>

            <p><strong>Fecha de recogida:</strong> <?php echo htmlspecialchars($pedido['fecha_recogida']); ?></p>
            <p><strong>Método de pago:</strong> <?php echo htmlspecialchars($pedido['metodo_pago']); ?></p>

            <p><strong>Observaciones:</strong> <?php echo htmlspecialchars($pedido['observaciones']); ?></p>

            <p><strong>Estado actual:</strong> <?php echo htmlspecialchars($pedido['estado']); ?></p>
            <p><strong>Total:</strong> <?php echo number_format((float)$pedido['total'], 2, ',', '.'); ?> €</p>

            <p><strong>Fecha creación:</strong> <?php echo htmlspecialchars($pedido['fecha_creacion']); ?></p>

            <hr>

            <h3>Cambiar estado</h3>

            <form method="post">
                <select name="estado">
                    <option>Pendiente</option>
                    <option>Preparado</option>
                    <option>Entregado</option>
                </select>
                <button type="submit">Guardar estado</button>
            </form>

        </div>

        <br><br>

        <!-- LÍNEAS DEL PEDIDO -->
        <h2 class="admin-subtitle">Líneas del pedido</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Tipo venta</th>
                        <th>Cantidad</th>
                        <th>Tipo corte</th>
                        <th>Precio unitario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles as $linea): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linea['producto_nombre']); ?></td>
                            <td><?php echo htmlspecialchars($linea['tipo_venta']); ?></td>
                            <td><?php echo htmlspecialchars($linea['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($linea['tipo_corte']); ?></td>
                            <td><?php echo number_format((float)$linea['precio_unitario'], 2, ',', '.'); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- VOLVER -->
        <p class="back-link">
                    <a href="<?php echo BASE_URL; ?>/admin.php?route=pedidos">
                        ← Volver al pedidos
                    </a>

    </div>

</div>