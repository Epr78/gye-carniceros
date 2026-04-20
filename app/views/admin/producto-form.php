<?php
$esEdicion = isset($producto) && !empty($producto['id']);

$valores = [
    'id' => $producto['id'] ?? '',
    'nombre' => $old['nombre'] ?? ($producto['nombre'] ?? ''),
    'slug' => $old['slug'] ?? ($producto['slug'] ?? ''),
    'precio' => $old['precio'] ?? ($producto['precio'] ?? ''),
    'familia_id' => $old['familia_id'] ?? ($producto['familia_id'] ?? ''),
    'tipo_venta' => $old['tipo_venta'] ?? ($producto['tipo_venta'] ?? ''),
    'descripcion' => $old['descripcion'] ?? ($producto['descripcion'] ?? ''),
    'imagen' => $old['imagen'] ?? ($producto['imagen'] ?? ''),
    'precio_oferta' => $old['precio_oferta'] ?? ($producto['precio_oferta'] ?? '')
];

$enOfertaChecked = isset($old)
    ? isset($old['en_oferta'])
    : !empty($producto['en_oferta']);

$activoChecked = isset($old)
    ? isset($old['activo'])
    : ($esEdicion ? !empty($producto['activo']) : true);

$destacadoChecked = isset($old)
    ? isset($old['destacado'])
    : !empty($producto['destacado']);

$aptoPlanchaChecked = isset($old)
    ? isset($old['apto_plancha'])
    : !empty($producto['apto_plancha']);

$aptoEmpanarChecked = isset($old)
    ? isset($old['apto_empanar'])
    : !empty($producto['apto_empanar']);

$aptoEstofarChecked = isset($old)
    ? isset($old['apto_estofar'])
    : !empty($producto['apto_estofar']);

$sePuedePicarChecked = isset($old)
    ? isset($old['se_puede_picar'])
    : !empty($producto['se_puede_picar']);

$aptoAsarChecked = isset($old)
    ? isset($old['apto_asar'])
    : !empty($producto['apto_asar']);
?>

<div class="admin-page">
    <div class="admin-block">

        <h1 class="admin-title">
            <?php echo $esEdicion ? 'Editar producto' : 'Crear producto'; ?>
        </h1>

        <div class="contact-form">

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

            <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=<?php echo $esEdicion ? 'producto-actualizar' : 'producto-guardar'; ?>">

                <?php if ($esEdicion): ?>
                    <input type="hidden" name="id" value="<?php echo (int)$valores['id']; ?>">
                <?php endif; ?>

                <!-- DATOS BÁSICOS -->
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" required
                        value="<?php echo htmlspecialchars((string)$valores['nombre']); ?>">
                </div>

                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" required
                        value="<?php echo htmlspecialchars((string)$valores['slug']); ?>">
                </div>

                <div class="form-group">
                    <label>Precio</label>
                    <input type="number" step="0.01" min="0.01" name="precio" required
                        value="<?php echo htmlspecialchars((string)$valores['precio']); ?>">
                </div>

                <div class="form-group">
                    <label>Familia</label>
                    <select name="familia_id" required>
                        <option value="">Seleccionar</option>
                        <?php foreach ($familias as $familia): ?>
                            <option
                                value="<?php echo (int)$familia['id']; ?>"
                                <?php echo (string)$valores['familia_id'] === (string)$familia['id'] ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($familia['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipo de venta</label>
                    <select name="tipo_venta" required>
                        <option value="">Seleccionar</option>
                        <option value="peso" <?php echo $valores['tipo_venta'] === 'peso' ? 'selected' : ''; ?>>Peso</option>
                        <option value="unidad" <?php echo $valores['tipo_venta'] === 'unidad' ? 'selected' : ''; ?>>Unidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="5">
                        <?php echo htmlspecialchars((string)$valores['descripcion']); ?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label>Imagen</label>
                    <input type="text" name="imagen"
                        value="<?php echo htmlspecialchars((string)$valores['imagen']); ?>">
                </div>

                <div class="form-group-inline">
                    <label>
                        <input type="checkbox" name="en_oferta" <?php echo $enOfertaChecked ? 'checked' : ''; ?>>
                        En oferta
                    </label>
                </div>

                <div class="form-group">
                    <label>Precio oferta</label>
                    <input type="number" step="0.01" min="0" name="precio_oferta"
                        value="<?php echo htmlspecialchars((string)$valores['precio_oferta']); ?>">
                </div>

                <hr style="margin:25px 0;">

                <!-- FILTROS -->
                <h3>Filtros de preparación</h3>

                <div class="form-group-inline">
                    <label><input type="checkbox" name="apto_plancha" <?php echo $aptoPlanchaChecked ? 'checked' : ''; ?>> Apto para plancha</label><br>
                    <label><input type="checkbox" name="apto_empanar" <?php echo $aptoEmpanarChecked ? 'checked' : ''; ?>> Apto para empanar</label><br>
                    <label><input type="checkbox" name="apto_estofar" <?php echo $aptoEstofarChecked ? 'checked' : ''; ?>> Apto para estofar</label><br>
                    <label><input type="checkbox" name="se_puede_picar" <?php echo $sePuedePicarChecked ? 'checked' : ''; ?>> Se puede picar</label><br>
                    <label><input type="checkbox" name="apto_asar" <?php echo $aptoAsarChecked ? 'checked' : ''; ?>> Apto para asar</label>
                </div>

                <hr style="margin:25px 0;">

                <!-- ESTADO -->
                <div class="form-group-inline">
                    <label><input type="checkbox" name="activo" <?php echo $activoChecked ? 'checked' : ''; ?>> Activo</label>
                    &nbsp;&nbsp;&nbsp;
                    <label><input type="checkbox" name="destacado" <?php echo $destacadoChecked ? 'checked' : ''; ?>> Destacado</label>
                </div>

                <!-- BOTÓN -->
                <div style="margin-top:20px;">
                    <button type="submit" class="btn-view">
                        <?php echo $esEdicion ? 'Actualizar producto' : 'Guardar producto'; ?>
                    </button>
                </div>

            </form>

            <!-- VOLVER -->
            <p class="back-link">
                    <a href="<?php echo BASE_URL; ?>/admin.php?route=productos">
                        ← Volver a productos
                    </a>
            
            </p>

        </div>
    </div>
</div>