<main class="login-page">

    <div class="login-box">
        <h1>Login administrador</h1>

        <form method="post" action="<?php echo BASE_URL; ?>/admin.php?route=autenticar">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>

        </form>
    </div>

</main>