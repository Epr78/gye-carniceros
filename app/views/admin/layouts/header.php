<?php
$pendientes = $pendientes ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - GyE Carniceros</title>
    <link rel="stylesheet" href="<?= ASSET_URL ?>/css/admin.css">
</head>

<body>

<header style="background:#111; color:#fff; padding:16px 24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; max-width:1200px; margin:0 auto;">

        <a href="<?= BASE_URL ?>/" class="admin-logo">
            <div class="logo-circle">G&amp;E</div>
            <span class="logo-text">GyE Carniceros</span>
        </a>    

        <nav>
            <a href="<?= BASE_URL ?>/admin.php?route=dashboard">Dashboard</a>
            <a href="<?= BASE_URL ?>/admin.php?route=pedidos">Pedidos</a>
            <a href="<?= BASE_URL ?>/admin.php?route=productos">Productos</a>
            <a href="<?= BASE_URL ?>/admin.php?route=recetas">Recetas</a>
            <a href="<?= BASE_URL ?>/admin.php?route=entradas">Entradas</a>

            <a href="<?= BASE_URL ?>/admin.php?route=contactos">
                Contactos 
                <?php if ($pendientes > 0): ?>
                    <span style="background:red; color:#fff; padding:2px 6px; border-radius:10px; font-size:12px;">
                        <?= $pendientes ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="<?= BASE_URL ?>/admin.php?route=logout">Salir</a>
        </nav>

    </div>
</header>

<main style="max-width:1200px; margin:30px auto; padding:0 20px;">