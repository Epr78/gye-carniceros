<!-- HERO -->
<section class="hero-section hero-blur">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Detalle del producto</h1>
    </div>
</section>

<!-- CONTENIDO -->
<section class="product-detail">

    <?php if (empty($producto)): ?>
        <div style="text-align: center; width: 100%;">
            <h2>Producto no encontrado</h2>
            <p>El producto solicitado no existe o no está disponible.</p>

            <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-primary">
                Volver a productos
            </a>
        </div>
    <?php else: ?>

        <!-- IMAGEN -->
        <div class="product-detail__image">
            <img
                src="<?php echo ASSET_URL; ?>/img/<?php echo htmlspecialchars($producto['imagen'] ?? 'default.jpg'); ?>"
                alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
            >
        </div>

        <!-- INFO -->
        <div class="product-detail__info">

            <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>

            <!-- DESCRIPCIÓN (solo una vez ) -->
            <p class="product-desc">
                <?php echo htmlspecialchars($producto['descripcion'] ?? 'Producto fresco de carnicería.'); ?>
            </p>

            <!-- DATOS -->
            <p><strong>Familia:</strong> <?php echo htmlspecialchars($producto['familia_nombre']); ?></p>
            <p><strong>Tipo de venta:</strong> <?php echo htmlspecialchars($producto['tipo_venta']); ?></p>
            <p><strong>Stock:</strong> <?php echo number_format((float)$producto['stock_cantidad'], 2, ',', '.'); ?></p>

            <!-- PRECIO -->
            <div class="product-price">
                <?php if (!empty($producto['en_oferta']) && !empty($producto['precio_oferta'])): ?>
                    <?php echo number_format((float)$producto['precio_oferta'], 2, ',', '.'); ?> €
                <?php else: ?>
                    <?php echo number_format((float)$producto['precio'], 2, ',', '.'); ?> €
                <?php endif; ?>
            </div>

            <!-- BADGE -->
            <?php if (!empty($producto['en_oferta'])): ?>
                <span class="offer-badge">Producto en oferta</span>
            <?php endif; ?>

          
            <!-- ZONA COMPRA (SEPARADA ) -->
            <div class="product-buy">
                <form method="post" action="<?php echo BASE_URL; ?>/?route=carrito-add">

                    <input type="hidden" name="producto_id" value="<?php echo (int)$producto['id']; ?>">

                    <label>Cantidad</label>
                    <input type="number" name="cantidad" value="1" min="0.01" step="0.01">

                    <label>Tipo de corte</label>
                    <select name="tipo_corte">
                        <option value="filete fino">Filete fino (+1 €/kg)</option>
                        <option value="filete grueso">Filete grueso</option>
                        <option value="pieza entera">Pieza entera</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Añadir al carrito</button>

                </form>
            </div>

            <!-- VOLVER (FUERA DEL FORM ) -->
            <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-secondary btn-volver">
                Volver
            </a>

        </div>

    <?php endif; ?>

</section>