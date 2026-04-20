<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/helpers/utils.php';
require_once __DIR__ . '/../app/helpers/auth_user.php';
require_once __DIR__ . '/../app/controllers/FrontController.php';
require_once __DIR__ . '/../app/controllers/ProductoController.php';
require_once __DIR__ . '/../app/controllers/CarritoController.php';
require_once __DIR__ . '/../app/controllers/PedidoController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

parse_str($_SERVER['QUERY_STRING'], $query);
$route = $query['route'] ?? 'inicio';

$frontController = new FrontController();
$productoController = new ProductoController();
$carritoController = new CarritoController();
$pedidoController = new PedidoController();
$usuarioController = new UsuarioController();

switch ($route) {
    case 'inicio':
        $frontController->inicio();
        break;

    case 'quienes':
        $frontController->quienes();
        break;

    case 'productos':
        $productoController->index();
        break;

    case 'producto':
        $slug = $_GET['slug'] ?? '';

        if ($slug === '') {
            echo 'Producto no encontrado';
            break;
        }

        $productoController->show($slug);
        break;

    case 'recetas':
        $frontController->recetas();
        break;

    case 'ofertas':
        $frontController->ofertas();
        break;

    case 'contacto':
        $frontController->contacto();
        break;

    case 'contacto-enviar':
        $frontController->enviarContacto();
        break;

    case 'carrito':
        $carritoController->index();
        break;

    case 'carrito-add':
        $carritoController->add();
        break;

    case 'carrito-remove':
        $carritoController->remove();
        break;

    case 'carrito-update':
        $carritoController->update();
        break;

    case 'pedido-confirmar':
        $pedidoController->confirmar();
        break;

    case 'pedido-exito':
        $pedidoController->exito();
        break;

    case 'usuario-login':
        $usuarioController->login();
        break;

    case 'usuario-registro':
        $usuarioController->registro();
        break;

    case 'usuario-guardar':
        $usuarioController->guardarRegistro();
        break;

    case 'usuario-autenticar':
        $usuarioController->autenticar();
        break;

    case 'admin':
        header("Location: " . BASE_URL . "/admin.php");
    exit;

    case 'usuario-logout':
        $usuarioController->logout();
        break;

    default:
        echo 'Página no encontrada';
        break;
}