<?php

function view(string $view, array $data = []): void
{
    extract($data);

    $viewFile = VIEW_PATH . '/' . $view . '.php';

    if (!file_exists($viewFile)) {
        echo '<h2>Vista no encontrada: ' . htmlspecialchars($view) . '</h2>';
        return;
    }

    require $viewFile;
}

function redirect(string $url): void
{
    header("Location: $url");
    exit;
}