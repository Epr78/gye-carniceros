<!-- HERO -->
<section class="hero-section hero-login">
    <div class="hero-overlay"></div>

    <div class="hero-content">

        <h1>Acceso de clientes</h1>
        <p class="hero-cta">Inicia sesión para poder comprar</p>
    </div>
</section>

<section class="user-login-page">

    <div class="login-box">

        <h2>Iniciar sesión</h2>

        <?php if (!empty($error ?? '')): ?>
            <div style="background:#c81414; color:#fff; padding:10px; margin-bottom:15px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>/?route=usuario-autenticar">

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>

        </form>

        <p class="login-link">
            ¿No tienes cuenta?
            <a href="<?= BASE_URL ?>/?route=usuario-registro">
                Regístrate aquí
            </a>
        </p>

    </div>

</section>