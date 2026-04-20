<?php
$esEdicion = isset($receta) && !empty($receta['id']);

$valores = [
    'id' => $receta['id'] ?? '',
    'titulo' => $old['titulo'] ?? ($receta['titulo'] ?? ''),
    'slug' => $old['slug'] ?? ($receta['slug'] ?? ''),
    'descripcion_corta' => $old['descripcion_corta'] ?? ($receta['descripcion_corta'] ?? ''),
    'elaboracion' => $old['elaboracion'] ?? ($receta['elaboracion'] ?? ''),
    'imagen' => $old['imagen'] ?? ($receta['imagen'] ?? '')
];

$activaChecked = isset($old)
    ? isset($old['activa'])
    : ($esEdicion ? !empty($receta['activa']) : true);
?>

<div class="admin-page">
    <div class="admin-block">

        

            <h1 class="admin-title">
                <?php echo $esEdicion ? 'Editar receta' : 'Crear receta'; ?>
            </h1>

            <?php if (!empty($errores)): ?>
                <div style="background:#ffe5e5; color:#8a1f1f; border:1px solid #d99; padding:12px; margin-bottom:20px;">
                    <strong>Corrige estos errores:</strong>
                    <ul style="margin:10px 0 0 20px;">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=<?php echo $esEdicion ? 'receta-actualizar' : 'receta-guardar'; ?>">

                <?php if ($esEdicion): ?>
                    <input type="hidden" name="id" value="<?php echo (int)$valores['id']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="titulo" required
                        value="<?php echo htmlspecialchars((string)$valores['titulo']); ?>">
                </div>

                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" required
                        value="<?php echo htmlspecialchars((string)$valores['slug']); ?>">
                </div>

                <div class="form-group">
                    <label>Descripción corta</label>
                    <input type="text" name="descripcion_corta"
                        value="<?php echo htmlspecialchars((string)$valores['descripcion_corta']); ?>">
                </div>

                <div class="form-group">
                    <label>Elaboración</label>
                    <textarea name="elaboracion" rows="6" required><?php echo htmlspecialchars((string)$valores['elaboracion']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Imagen</label>
                    <input type="text" name="imagen"
                        value="<?php echo htmlspecialchars((string)$valores['imagen']); ?>">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="activa" <?php echo $activaChecked ? 'checked' : ''; ?>>
                        Activa
                    </label>
                </div>
            </form>
         
        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=recetas">
                ← Volver al recetas
            </a>
        </p>

    </div>
</div>

   