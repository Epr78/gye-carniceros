<?php

require_once __DIR__ . '/paths.php';

date_default_timezone_set('Europe/Madrid');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detectar protocolo (http o https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// Detectar host
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Detectar entorno automáticamente
$isLocal = (
    $host === 'localhost' ||
    str_contains($host, '127.0.0.1')
);

// Base path SOLO en local
$basePath = $isLocal ? '/gye-carniceros/public' : '';

// BASE URL dinámica
define('BASE_URL', $protocol . '://' . $host . $basePath);

// ✅ URL de assets CORREGIDA
define('ASSET_URL', $basePath . '/assets');