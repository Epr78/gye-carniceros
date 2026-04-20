<div class="admin-page">
    <div class="admin-block">

        <h1 class="admin-title">Crear pedido</h1>

        <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=pedido-guardar">

            <div class="form-group">
                <label>Cliente</label>
                <input type="text" name="nombre_cliente" required>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email">
            </div>

            <div class="form-group">
                <label>Total (€)</label>
                <input type="number" step="0.01" name="total" required>
            </div>

            <button type="submit" class="btn-new">
                Guardar pedido
            </button>

        </form>

        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=pedidos">
                ← Volver a pedidos
            </a>
        </p>

    </div>
</div>