<!-- HERO -->
<section class="hero-section hero-cart-page">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1><span>Tu carrito</span></h1>

          <!-- CARRITO -->
        <div class="hero-cart">
            <img src="<?php echo ASSET_URL; ?>/img/carritoderechasinfondo.png" alt="Carrito">
        </div>

        <p class="hero-subtitle">Revisa tus productos antes de finalizar la compra</p>
    </div>
    <div class="hero-cart-icon">
            <div class="cart-body"></div>
            <div class="cart-handle"></div>
    </div>
</section>

<section class="cart">
    <h2>Productos añadidos</h2>

    <?php if (!empty($_SESSION['carrito_error'])): ?>
        <div style="background:#fdecea; color:#8a1f17; border:1px solid #f5c2c0; padding:15px; margin-bottom:20px; border-radius:8px;">
            <?php echo htmlspecialchars($_SESSION['carrito_error']); ?>
        </div>
        <?php unset($_SESSION['carrito_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['carrito_ok'])): ?>
        <div style="background:#edf7ed; color:#1e4620; border:1px solid #b7dfb9; padding:15px; margin-bottom:20px; border-radius:8px;">
            <?php echo htmlspecialchars($_SESSION['carrito_ok']); ?>
        </div>
        <?php unset($_SESSION['carrito_ok']); ?>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="empty-state">
            <p>Tu carrito está vacío.</p>
            <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-primary">Ver productos</a>
        </div>
    <?php else: ?>

        <form method="post" action="<?php echo BASE_URL; ?>/?route=carrito-update">
            <div class="cart-items">
                <?php foreach ($items as $item): ?>
                    <?php $producto = $item['producto']; ?>

                    <div class="cart-item">
                        <img
                            src="<?php echo ASSET_URL; ?>/img/<?php echo htmlspecialchars($producto['imagen'] ?? 'default.jpg'); ?>"
                            alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        >

                        <div class="cart-item__info">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>

                            <p>
                                <?php echo number_format((float)$item['precio_unitario'], 2, ',', '.'); ?> €
                                / <?php echo htmlspecialchars($producto['tipo_venta']); ?>
                            </p>

                            <p>
                                <strong>Tipo de corte:</strong>
                                <?php echo htmlspecialchars($item['tipo_corte']); ?>
                            </p>

                            <p>
                                <strong>Stock disponible:</strong>
                                <?php echo number_format((float)($producto['stock_cantidad'] ?? 0), 2, ',', '.'); ?>
                            </p>

                            <p>
                                Subtotal:
                                <?php echo number_format((float)$item['subtotal'], 2, ',', '.'); ?> €
                            </p>
                        </div>

                        <div class="cart-item__actions">
                            <label>Cantidad</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="cantidades[<?php echo (int)$item['key']; ?>]"
                                value="<?php echo htmlspecialchars((string)$item['cantidad']); ?>"
                            >

                            <a
                                href="<?php echo BASE_URL; ?>/?route=carrito-remove&key=<?php echo (int)$item['key']; ?>"
                                class="btn btn-secondary"
                            >
                                Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h3>Total: <?php echo number_format((float)$total, 2, ',', '.'); ?> €</h3>

                <button type="submit" class="btn btn-secondary">Actualizar carrito</button>
                <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-primary">Seguir comprando</a>
            </div>
        </form>

        <?php if (empty($_SESSION['usuario'])): ?>
            <section class="contact-form" style="margin-top: 40px;">
                <h2>Inicia sesión para comprar</h2>
                <p>
                    <a href="<?php echo BASE_URL; ?>/?route=usuario-login" class="btn btn-primary">Iniciar sesión</a>
                    <a href="<?php echo BASE_URL; ?>/?route=usuario-registro" class="btn btn-secondary">Registrarse</a>
                </p>
            </section>
        <?php else: ?>
            <section class="contact-form" style="margin-top: 40px;">
                <h2>Confirmar pedido</h2>

                <form method="post" action="<?php echo BASE_URL; ?>/?route=pedido-confirmar" id="form-pedido">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" required value="<?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" required value="<?php echo htmlspecialchars($_SESSION['usuario']['telefono'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['usuario']['email'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($_SESSION['usuario']['direccion'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="fecha_recogida">Fecha de recogida</label>
                        <input type="date" id="fecha_recogida" name="fecha_recogida">
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="metodo_pago">Método de pago</label>
                        <select id="metodo_pago" name="metodo_pago" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                        </select>
                    </div>

                    <div id="bloque-efectivo" style="margin-top:20px; padding:15px; border:1px solid #ddd; border-radius:8px;">
                        <h3 style="margin-bottom:15px;">Pago en efectivo</h3>

                        <div class="form-group">
                            <label for="necesita_cambio">¿Necesitas cambio?</label>
                            <select id="necesita_cambio" name="necesita_cambio">
                                <option value="no">No</option>
                                <option value="si">Sí</option>
                            </select>
                        </div>

                        <div class="form-group" id="grupo-billete" style="display:none;">
                            <label for="importe_billete">¿Con qué billete pagas?</label>
                            <input type="number" step="0.01" min="0" id="importe_billete" name="importe_billete" placeholder="Ejemplo: 50">
                        </div>
                    </div>

                    <div id="bloque-tarjeta" style="display:none; margin-top:20px; padding:15px; border:1px solid #ddd; border-radius:8px;">
                        <h3 style="margin-bottom:15px;">Pago con tarjeta (simulado)</h3>

                        <div class="form-group">
                            <label for="titular_tarjeta">Titular de la tarjeta</label>
                            <input type="text" id="titular_tarjeta" name="titular_tarjeta" placeholder="Nombre del titular">
                        </div>

                        <div class="form-group">
                            <label for="numero_tarjeta">Número de tarjeta</label>
                            <input type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="4242 4242 4242 4242" maxlength="19">
                        </div>

                        <div class="form-group">
                            <label for="caducidad_tarjeta">Caducidad</label>
                            <input type="text" id="caducidad_tarjeta" name="caducidad_tarjeta" placeholder="MM/AA" maxlength="5">
                        </div>

                        <div class="form-group">
                            <label for="cvv_tarjeta">CVV</label>
                            <input type="text" id="cvv_tarjeta" name="cvv_tarjeta" placeholder="123" maxlength="4">
                        </div>

                        <p style="margin-top:10px; font-size:0.95rem;">
                            Este pago es una <strong>simulación</strong> para el proyecto DAW. No se realiza ningún cobro real.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary">Confirmar pedido</button>
                </form>
            </section>

            <script>
                (function () {
                    var metodoPago = document.getElementById('metodo_pago');
                    var bloqueEfectivo = document.getElementById('bloque-efectivo');
                    var bloqueTarjeta = document.getElementById('bloque-tarjeta');
                    var necesitaCambio = document.getElementById('necesita_cambio');
                    var grupoBillete = document.getElementById('grupo-billete');

                    function actualizarMetodoPago() {
                        if (metodoPago.value === 'tarjeta') {
                            bloqueTarjeta.style.display = 'block';
                            bloqueEfectivo.style.display = 'none';
                        } else {
                            bloqueTarjeta.style.display = 'none';
                            bloqueEfectivo.style.display = 'block';
                        }
                    }

                    function actualizarCambio() {
                        if (necesitaCambio.value === 'si') {
                            grupoBillete.style.display = 'block';
                        } else {
                            grupoBillete.style.display = 'none';
                        }
                    }

                    metodoPago.addEventListener('change', actualizarMetodoPago);
                    necesitaCambio.addEventListener('change', actualizarCambio);

                    actualizarMetodoPago();
                    actualizarCambio();
                })();
            </script>
        <?php endif; ?>

    <?php endif; ?>
</section>