<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Registro de clientes</h1>
        <p>Crea tu cuenta para poder comprar</p>
    </div>
</section>

<section class="contact-form">
    <h2>Crear cuenta</h2>

    <form method="post" action="<?php echo BASE_URL; ?>/?route=usuario-guardar">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrarme</button>
    </form>

    <p style="margin-top:20px;">
        ¿Ya tienes cuenta?
        <a href="<?php echo BASE_URL; ?>/?route=usuario-login">Inicia sesión</a>
    </p>
</section>