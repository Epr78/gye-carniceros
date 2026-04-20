<?php
$valores = [
    'pieza_base_id' => $old['pieza_base_id'] ?? '',
    'cantidad_entrada' => $old['cantidad_entrada'] ?? '',
    'coste_total_compra' => $old['coste_total_compra'] ?? '',
    'observaciones' => $old['observaciones'] ?? ''
];
?>

<div class="admin-page">
    <div class="admin-block">

        <h1 class="admin-title">Nueva entrada de mercancía</h1>

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

        <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=entrada-guardar">

            <div class="form-group">
                <label>Pieza base</label>
                <select name="pieza_base_id" id="pieza_base_id" required>
                    <option value="">Seleccionar</option>
                    <?php foreach ($piezasBase as $piezaBase): ?>
                        <option
                            value="<?php echo (int)$piezaBase['id']; ?>"
                            data-precio-compra="<?php echo htmlspecialchars((string)$piezaBase['precio_compra_unitario']); ?>"
                            <?php echo (string)$valores['pieza_base_id'] === (string)$piezaBase['id'] ? 'selected' : ''; ?>
                        >
                            <?php echo htmlspecialchars($piezaBase['nombre']); ?> (<?php echo htmlspecialchars($piezaBase['tipo_unidad']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Precio compra unitario (€)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    id="precio_compra_unitario"
                    value=""
                    readonly
                >
            </div>

            <div class="form-group">
                <label>Cantidad de entrada</label>
                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="cantidad_entrada"
                    id="cantidad_entrada"
                    required
                    value="<?php echo htmlspecialchars((string)$valores['cantidad_entrada']); ?>"
                >
            </div>

            <div class="form-group">
                <label>Coste total de compra (€)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    name="coste_total_compra"
                    id="coste_total_compra"
                    required
                    value="<?php echo htmlspecialchars((string)$valores['coste_total_compra']); ?>"
                >
            </div>

            <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" rows="5"><?php echo htmlspecialchars((string)$valores['observaciones']); ?></textarea>
            </div>

            <button type="submit" class="btn-primary">
                Registrar entrada
            </button>

        </form>

        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=entradas">
                ← Volver a entradas
            </a>
        </p>

    </div>
</div>