<section class="recipes">

<!-- HERO -->
<section class="hero-section hero-blur">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Recetas</h1>
        <p>Descubre ideas y recetas para disfrutar de nuestros productos.</p>
    </div>
</section>

<!-- TÍTULO -->
<h2 style="text-align:center; margin-bottom:2rem; margin-top:4rem;">
    Nuestras recetas destacadas
</h2>

<!-- GRID RECETAS -->
<section class="recipes-grid">

<?php if (empty($recetas)): ?>
    <p style="text-align:center;">No hay recetas disponibles.</p>
<?php else: ?>

    <?php foreach ($recetas as $receta): ?>

        <?php 
            $imagen = !empty($receta['imagen']) ? $receta['imagen'] : 'default.jpg';
        ?>

        <div class="product-card">
            <img 
                src="<?php echo ASSET_URL; ?>/img/<?php echo htmlspecialchars($imagen); ?>" 
                alt="<?php echo htmlspecialchars($receta['titulo']); ?>"
            >

            <div class="product-card__body">
                <h3><?php echo htmlspecialchars($receta['titulo']); ?></h3>
                
                <p>
                    <?php echo htmlspecialchars($receta['descripcion_corta'] ?? ''); ?>
                </p>

                <button 
                    class="btn btn-primary" 
                    data-open-modal="<?php echo htmlspecialchars($receta['slug']); ?>"
                >
                    Ver receta
                </button>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

</section>

<!-- RECETAS OCULTAS (MODALES) -->
<div style="display:none;">

<?php foreach ($recetas as $receta): ?>

    <article id="<?php echo htmlspecialchars($receta['slug']); ?>">
        <h2><?php echo htmlspecialchars($receta['titulo']); ?></h2>
        <img src="<?php echo ASSET_URL; ?>/img/<?php echo htmlspecialchars($receta['imagen'] ?? 'default.jpg'); ?>" 
        class="recipe-modal-img">

        <!-- INGREDIENTES -->
        <h3>Ingredientes</h3>

        <div class="recipe-box">
            <ul>
                <?php
                $listaIngredientes = explode("\n", $receta['ingredientes'] ?? '');

                $hayIngredientes = false;

                foreach ($listaIngredientes as $item):
                    if (trim($item) !== ''):
                        $hayIngredientes = true;
                ?>
                    <li><?php echo htmlspecialchars($item); ?></li>
                <?php
                    endif;
                endforeach;

                if (!$hayIngredientes):
                ?>
                    <li>No hay ingredientes definidos.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- PREPARACIÓN -->
        <h3>Preparación</h3>

        <div class="recipe-box">
            <p>
                <?php echo nl2br(htmlspecialchars($receta['elaboracion'] ?? '')); ?>
            </p>
        </div>

    </article>

<?php endforeach; ?>

</div>

<!-- MODAL -->
<div id="recipe-modal" class="modal" hidden>
    <div class="modal__content">
        <button class="modal__close" id="recipe-modal-close">&times;</button>
        <div id="recipe-modal-body"></div>
    </div>
</div>

    
</section>