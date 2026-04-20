<!-- HERO -->
<section class="hero-section hero-blur">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Nuestros productos</h1>
        <p>Descubre nuestra selección de carnes frescas</p>
    </div>
</section>

<section style="padding:20px;">
    <form method="get" action="<?php echo BASE_URL; ?>/" style="max-width:1100px; margin:0 auto 20px auto; background:#fff; padding:20px; border:1px solid #ddd; border-radius:8px;">
        <input type="hidden" name="route" value="productos">

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:15px;">
            <div>
                <label for="familia" style="display:block; margin-bottom:6px; font-weight:600;">Familia</label>
                <select name="familia" id="familia" style="width:100%; padding:10px;">
                    <option value="">Todas</option>
                    <?php foreach (($familias ?? []) as $fam): ?>
                        <option value="<?php echo htmlspecialchars($fam['slug']); ?>" <?php echo (($familiaActual ?? '') === $fam['slug']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($fam['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="apto" style="display:block; margin-bottom:6px; font-weight:600;">Preparación</label>
                <select name="apto" id="apto" style="width:100%; padding:10px;">
                    <option value="">Cualquiera</option>
                    <option value="plancha" <?php echo (($aptoActual ?? '') === 'plancha') ? 'selected' : ''; ?>>Plancha</option>
                    <option value="empanar" <?php echo (($aptoActual ?? '') === 'empanar') ? 'selected' : ''; ?>>Empanar</option>
                    <option value="estofar" <?php echo (($aptoActual ?? '') === 'estofar') ? 'selected' : ''; ?>>Estofar</option>
                    <option value="picar" <?php echo (($aptoActual ?? '') === 'picar') ? 'selected' : ''; ?>>Picar</option>
                    <option value="asar" <?php echo (($aptoActual ?? '') === 'asar') ? 'selected' : ''; ?>>Asar</option>
                </select>
            </div>

            <div>
                <label for="oferta" style="display:block; margin-bottom:6px; font-weight:600;">Oferta</label>
                <select name="oferta" id="oferta" style="width:100%; padding:10px;">
                    <option value="">Todas</option>
                    <option value="1" <?php echo (($ofertaActual ?? '') === '1') ? 'selected' : ''; ?>>Solo ofertas</option>
                </select>
            </div>
        </div>

        <div style="margin-top:15px; display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-secondary">Limpiar filtros</a>
        </div>
    </form>
</section>

<!-- GRID PRODUCTOS -->
<section class="products">
    <div class="products-grid">

        <?php if (empty($productos)): ?>
            <div class="empty-state">
                <p>No hay productos disponibles con esos filtros.</p>
                <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-primary">Ver todos</a>
            </div>
        <?php else: ?>

            <?php foreach ($productos as $producto): ?>
                <div class="product-card">
                    <img
                        src="<?php echo ASSET_URL; ?>/img/<?php echo htmlspecialchars($producto['imagen'] ?? 'default.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                    >

                    <div class="product-card__body">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>

                        <p>
                            <?php echo htmlspecialchars($producto['descripcion'] ?? 'Producto fresco de carnicería.'); ?>
                        </p>

                        <div class="product-tags">
                            <span><?php echo htmlspecialchars($producto['familia_nombre'] ?? 'Sin familia'); ?></span>
                            <span><?php echo htmlspecialchars($producto['tipo_venta'] ?? ''); ?></span>
                        </div>

                        <div class="product-tags">
                            <?php if (!empty($producto['apto_plancha'])): ?>
                                <span>Plancha</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_empanar'])): ?>
                                <span>Empanar</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_estofar'])): ?>
                                <span>Estofar</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_picar'])): ?>
                                <span>Picar</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_asar'])): ?>
                                <span>Asar</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_ahumar'])): ?>
                                <span>Ahumar</span>
                            <?php endif; ?>

                            <?php if (!empty($producto['apto_freir'])): ?>
                                <span>Freir</span>
                            <?php endif; ?>

                        </div>

                        <div class="product-tags">
                            <span>
                                Stock:
                                <?php echo number_format((float)($producto['stock_cantidad'] ?? 0), 2, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="product-bottom">
                            <span class="price">
                                <?php echo number_format((float)$producto['precio'], 2, ',', '.'); ?> €
                            </span>

                            <?php if (isset($producto['en_oferta']) && $producto['en_oferta'] == 1): ?>
                                <a href="<?php echo BASE_URL; ?>/?route=ofertas" class="offer-badge">
                                Oferta
                                </a>
                             <?php endif; ?>

                            <a href="<?php echo BASE_URL; ?>/?route=producto&slug=<?php echo urlencode($producto['slug']); ?>"
                                class="btn btn-primary btn-card">
                                    Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</section>