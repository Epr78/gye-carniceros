<!-- HERO OFERTAS -->
<section class="hero-section hero-blur">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Ofertas de la semana</h1>
        <p>Aprovecha nuestras promociones especiales en carnes y preparados.</p>
    </div>
</section>

<!-- GRID DE OFERTAS -->
<section class="products ofertas-bg">
    <h2>Productos en oferta</h2>

    <div class="products-grid">

        <?php if (empty($ofertas)): ?>
            <div class="empty-state">
                <p>Ahora mismo no hay ofertas.</p>
            </div>
        <?php else: ?>

            <?php foreach ($ofertas as $oferta): ?>             
                
                <?php 
                    $imagen = !empty($oferta['imagen']) ? $oferta['imagen'] : 'default.jpg';
                ?>

                <div class="product-card">
                    
                    <img
                        src="<?php echo ASSET_URL . '/img/' . htmlspecialchars($imagen); ?>"
                        alt="<?php echo htmlspecialchars($oferta['nombre']); ?>"
                    >

                    <div class="product-card__body">
                        <h3><?php echo htmlspecialchars($oferta['nombre']); ?></h3>

                        <p>
                            <?php echo htmlspecialchars($oferta['descripcion'] ?? 'Producto en oferta'); ?>
                        </p>

                        <div class="product-bottom">
                            <div class="price-box">
                                <?php if (!empty($oferta['precio_oferta'])): ?>
                                    <span class="price-old">
                                        <?php echo number_format((float)$oferta['precio'], 2, ',', '.'); ?> €
                                    </span>

                                    <span class="price-new">
                                        <?php echo number_format((float)$oferta['precio_oferta'], 2, ',', '.'); ?> €
                                    </span>

                                <?php else: ?>
                                    <span class="price">
                                        <?php echo number_format((float)$oferta['precio'], 2, ',', '.'); ?> €
                                    </span>

                                <?php endif; ?>
                            </div>

                            <a href="<?php echo BASE_URL; ?>/?route=carrito-add&id=<?php echo $oferta['id']; ?>" class="btn btn-primary">
                            Añadir 🛒
                            </a>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</section>