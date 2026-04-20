<?php

require_once __DIR__ . '/utils.php';

function adminEstaLogueado(): bool
{
    return !empty($_SESSION['admin']);
}

function requerirAdmin(): void
{
    if (!adminEstaLogueado()){
        redirect (BASE_URL . '/admin.php?route=login');


    }
    
}