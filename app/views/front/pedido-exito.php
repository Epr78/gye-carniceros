<section class="hero-section">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Pedido confirmado</h1>
        <p>Tu pedido se ha registrado correctamente</p>
    </div>
</section>

<section class="featured-offer">
    <div class="featured-offer__content" style="width: 100%; text-align: center;">
        <h2>Gracias por tu pedido</h2>
        <p>Tu número de pedido es: <strong>#<?php echo (int)$pedidoId; ?></strong></p>

        <?php if (!empty($pagoResumen)): ?>
            <div style="max-width:700px; margin:20px auto; background:#edf7ed; color:#1e4620; border:1px solid #b7dfb9; padding:15px; border-radius:8px;">
                <?php echo htmlspecialchars($pagoResumen); ?>
            </div>
        <?php endif; ?>

        <a href="<?php echo BASE_URL; ?>/?route=inicio" class="btn btn-primary">Volver al inicio</a>
        <a href="<?php echo BASE_URL; ?>/?route=productos" class="btn btn-secondary">Seguir comprando</a>
    </div>
</section>