<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!-- HERO -->
<section class="hero-section">
    <div class="hero-overlay"></div>

    <div class="hero-content">

        <div class="hero__avatars">
            <div class="avatar">
                <img src="<?php echo ASSET_URL; ?>/img/G.png" alt="Guillermo">
            </div>

            <div class="avatar">
                <img src="<?php echo ASSET_URL; ?>/img/E.png" alt="Esther">
            </div>
        </div>

        <h1>GyE Carniceros</h1>

        <p class="hero-cta">
            Carne fresca y de calidad cada día desde el año 2010
        </p>

        <div class="hero__buttons">
            <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-primary">
                Ver productos
            </a>

            <a href="<?php echo BASE_URL; ?>/?route=contacto" class="btn btn-secondary">
                Contactar
            </a>
        </div>

    </div>
</section>

<!-- BENEFICIOS -->
<section class="benefits">

    <div class="benefit">
        <div class="benefit__icon">🥩</div>
        <h3>Carne fresca diaria</h3>
        <p>Producto fresco traído cada día.</p>
    </div>

    <div class="benefit">
        <div class="benefit__icon">🚚</div>
        <h3>Reparto a domicilio</h3>
        <p>Entrega rápida en tu casa.</p>
    </div>

    <div class="benefit">
        <div class="benefit__icon">💰</div>
        <h3>Calidad-precio</h3>
        <p>La mejor relación calidad-precio.</p>
    </div>

</section>

<!-- OFERTAS -->
<section class="offers">
    <div class="container">

        <h2>Ofertas de la semana</h2>

        <div class="products-grid">

            <div class="product-card">
                <img src="<?php echo ASSET_URL; ?>/img/hmixta.jpg" alt="Hamburguesas">
                <h3>Hamburguesas artesanales</h3>
                <span>6.90€/kg</span>
            </div>

            <div class="product-card">
                <img src="<?php echo ASSET_URL; ?>/img/alitasdepollo.avif" alt="Alitas">
                <h3>Alitas de pollo</h3>
                <span>4.90€/kg</span>
            </div>

            <div class="product-card">
                <img src="<?php echo ASSET_URL; ?>/img/chorizofrescoremovebg.png" alt="Chorizo">
                <h3>Chorizo fresco</h3>
                <span>5.50€/kg</span>
            </div>

        </div>
    </div>
</section>