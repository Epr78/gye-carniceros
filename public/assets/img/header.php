<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GyE Carniceros</title>

<link rel="stylesheet" href="<?php echo ASSET_URL; ?>/css/style.css">
</head>

<body>



<header class="header">

    <div class="header__logo">

        <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['email'] === 'admin@gyecarniceros.local'): ?>
            <a href="<?php echo BASE_URL; ?>/admin.php" style="display:flex; align-items:center; gap:0.75rem;">
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/">
        <?php endif; ?>

            <div class="logo-circle">G&amp;E</div>
            <span class="logo-text">GyE Carniceros</span>

        </a>
    </div>

    <nav class="header__nav">
        <a href="<?php echo BASE_URL; ?>/">Inicio</a>

        <a href="<?php echo BASE_URL; ?>/?route=quienes">Quiénes somos</a>

        <a href="<?php echo BASE_URL; ?>/?route=productos">Productos</a>

        <a href="<?php echo BASE_URL; ?>/?route=ofertas">Ofertas</a>

        <a href="<?php echo BASE_URL; ?>/?route=recetas">Recetas</a>

        <a href="<?php echo BASE_URL; ?>/?route=contacto">Contacto</a>

        <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['email'] === 'admin@gyecarniceros.local'): ?>
        <a href="<?php echo BASE_URL; ?>/admin.php">Admin</a>
        <?php endif; ?>


        <?php if (!usuarioEstaLogueado()): ?>
            <a href="<?php echo BASE_URL; ?>/?route=usuario-login">Iniciar sesión</a>
        <?php endif; ?>

        <?php if (usuarioEstaLogueado()): ?>
            <span style="font-weight:600;">
                Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
            </span>

            <a href="<?php echo BASE_URL; ?>/?route=usuario-logout">Cerrar sesión</a>
        <?php endif; ?>
    </nav>

    <a href="<?php echo BASE_URL; ?>/?route=carrito" class="header__cart">
        🛒 <span>Carrito</span>
    </a>

</header>

<!-- BANNER -->
<div class="project-banner" id="banner">
    <span>⚠️ Proyecto académico — Web demostrativa</span>
    <span class="close-banner">✖</span>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const banner = document.getElementById("banner");
    const closeBtn = document.querySelector(".close-banner");

    // SIEMPRE visible (modo demo)
    banner.style.display = "flex";

    closeBtn.addEventListener("click", function() {
        banner.style.display = "none";
    });

});
</script>


<main>
