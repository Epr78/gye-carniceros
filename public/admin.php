<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/helpers/utils.php';
require_once __DIR__ . '/../app/helpers/auth.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$route = $_GET['route'] ?? 'login';


require_once __DIR__ . '/../app/models/ContactoMensaje.php';

$contactoModel = new ContactoMensaje();
$alertas = $contactoModel->contarAlertas();

if ($route === 'dashboard' && $alertas > 0) {
    header('Location: ' . BASE_URL . '/admin.php?route=contactos');
    exit;
}

$controller = new AdminController();

switch ($route) {
    case 'login':
       view('admin/layouts/header');
        $controller->login();
        view('admin/layouts/footer');
    break;

    case 'autenticar':
        $controller->autenticar();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'dashboard':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->dashboard();
        view('admin/layouts/footer');
        break;

    case 'pedidos':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->pedidos();
        view('admin/layouts/footer');
        break;

    case 'pedido-detalle':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        view('admin/layouts/header');
        $controller->pedidoDetalle($id);
        view('admin/layouts/footer');
        break;
    
    case 'pedido-crear':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->pedidoCrear();
        view('admin/layouts/footer');
        break;

    case 'pedido-guardar':
        requerirAdmin();
        $controller->pedidoGuardar();
        break;
    
    case 'pedido-estado':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->actualizarEstadoPedido($id);
        break;

    case 'pedido-eliminar':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->eliminarPedido($id);
        break;

    case 'productos':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->productos();
        view('admin/layouts/footer');
        break;

    case 'producto-crear':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->crearProducto();
        view('admin/layouts/footer');
        break;

    case 'producto-guardar':
        requerirAdmin();
        $controller->guardarProducto();
        break;

    case 'producto-editar':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        view('admin/layouts/header');
        $controller->editarProducto($id);
        view('admin/layouts/footer');
        break;

    case 'producto-actualizar':
        requerirAdmin();
        $controller->actualizarProducto();
        break;

    case 'producto-toggle':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller->toggleProducto($id);
        break;

    case 'producto-stock':
        requerirAdmin();
        $controller->actualizarStock();
        break;

    case 'piezas-base-precios':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->piezasBasePrecios();
        view('admin/layouts/footer');
        break;

    case 'pieza-base-precio-actualizar':
        requerirAdmin();
        $controller->actualizarPrecioPiezaBase();
        break;

    case 'entrada-crear':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->entradaForm();
        view('admin/layouts/footer');
        break;

    case 'entrada-guardar':
        requerirAdmin();
        $controller->guardarEntrada();
        break;

    case 'entradas':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->entradas();
        view('admin/layouts/footer');
        break;

    case 'entrada-detalle':
        requerirAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        view('admin/layouts/header');
        $controller->entradaDetalle($id);
        view('admin/layouts/footer');
        break;

    case 'recetas':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->recetas();
        view('admin/layouts/footer');
        break;

    case 'receta-crear':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->crearReceta();
        view('admin/layouts/footer');
        break;

    case 'receta-guardar':
        requerirAdmin();
        $controller->guardarReceta();
        break;

    case 'receta-editar':
        requerirAdmin();
        $id = (int)($_GET['id'] ?? 0);

        view('admin/layouts/header');
        $controller->editarReceta($id);
        view('admin/layouts/footer');
        break;

    case 'receta-actualizar':
        requerirAdmin();
        $controller->actualizarReceta();
        break;

    case 'receta-toggle':
        requerirAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $controller->toggleReceta($id);
        break;

    case 'contactos':
        requerirAdmin();
        view('admin/layouts/header');
        $controller->contactos();
        view('admin/layouts/footer');
        break;

    case 'contacto-toggle':
        requerirAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $controller->contactoToggle($id);
        break;

    case 'contacto-responder':
        requerirAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $controller->contactoResponder($id);
        break;

    default:
        echo '<h2>Página de administración no encontrada</h2>';
        break;
}