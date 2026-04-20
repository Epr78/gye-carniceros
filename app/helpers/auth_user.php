<?php

require_once __DIR__ . '/utils.php';

function usuarioEstaLogueado(): bool
{
    return !empty($_SESSION['usuario']);
}

function requerirUsuario(): void
{
    if (!usuarioEstaLogueado()) {
        redirect(BASE_URL . '/?route=usuario-login');
    }
}