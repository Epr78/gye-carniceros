<?php

require_once __DIR__ . '/../helpers/utils.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Administrador.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/PiezaBase.php';
require_once __DIR__ . '/../models/EntradaCompra.php';
require_once __DIR__ . '/../models/Receta.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/ContactoMensaje.php';

class AdminController
{
    public function login(): void
    {
        view('admin/login');
    }

    public function autenticar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            redirect(BASE_URL . '/admin.php?route=login');
        }

        $adminModel = new Administrador();
        $admin = $adminModel->getByEmail($email);

        if (!$admin || !password_verify($password, $admin['password'])) {
            redirect(BASE_URL . '/admin.php?route=login');
        }

        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'nombre' => $admin['nombre'],
            'email' => $admin['email']
        ];

        redirect(BASE_URL . '/admin.php?route=dashboard');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ELIMINAR TODO
         $_SESSION = [];

        // DESTRUIR SESION COMPLETAMENTE
         session_destroy();

        // REDIRIGIR
            header("Location: " . BASE_URL . "/admin.php?route=login");
            exit;
    }

    public function dashboard(): void
    {
        $pedidoModel = new Pedido();
        $productoModel = new Producto();
        $entradaModel = new EntradaCompra();
        $recetaModel = new Receta();
        $usuarioModel = new Usuario();
        $contactoModel = new ContactoMensaje();

        $resumenMes = $pedidoModel->getResumenMesActual();

        $stats = [
            'total_pedidos' => $pedidoModel->contarTodos(),
            'pedidos_pendientes' => $pedidoModel->contarPorEstado('pendiente'),
            'pedidos_preparados' => $pedidoModel->contarPorEstado('preparado'),
            'pedidos_entregados' => $pedidoModel->contarPorEstado('entregado'),
            'pedidos_cancelados' => $pedidoModel->contarPorEstado('cancelado'),
            'total_facturado' => $pedidoModel->sumarTotalFacturado(),
            'ventas_mes' => $resumenMes['ventas_mes'],
            'coste_mes' => $resumenMes['coste_mes'],
            'beneficio_bruto_mes' => $resumenMes['beneficio_bruto_mes'],
            'total_productos' => $productoModel->contarTodos(),
            'productos_activos' => $productoModel->contarActivos(),
            'productos_sin_stock' => $productoModel->contarSinStock(),
            'productos_stock_bajo' => $productoModel->contarStockBajo(),
            'total_entradas' => $entradaModel->contarTodas(),
            'total_recetas' => $recetaModel->contarTodas(),
            'recetas_activas' => $recetaModel->contarActivas(),
            'total_contactos' => $contactoModel->contarTodos(),
            'contactos_pendientes' => $contactoModel->contarPendientes()
        ];

        $ultimosPedidos = $pedidoModel->getUltimos(5);
        $ultimasEntradas = $entradaModel->getUltimas(5);
        $productosStockBajo = $productoModel->getProductosStockBajo();
        $usuarios = $usuarioModel->getAll();
        $ultimosContactos = array_slice($contactoModel->getAll(), 0, 5);

        view('admin/dashboard', [
            'stats' => $stats,
            'ultimosPedidos' => $ultimosPedidos,
            'ultimasEntradas' => $ultimasEntradas,
            'productosStockBajo' => $productosStockBajo,
            'usuarios' => $usuarios,
            'ultimosContactos' => $ultimosContactos
        ]);
    }

    public function pedidos(): void
    {
        $pedidoModel = new Pedido();
        $pedidos = $pedidoModel->getAll();

        view('admin/pedidos', [
            'pedidos' => $pedidos
        ]);
    }

    public function pedidoDetalle(int $id): void
    {
        $pedidoModel = new Pedido();

        $pedido = $pedidoModel->getById($id);
        $detalles = $pedidoModel->getDetallesByPedidoId($id);

        if (!$pedido) {
            echo '<h2>Pedido no encontrado</h2>';
            return;
        }

        view('admin/pedido-detalle', [
            'pedido' => $pedido,
            'detalles' => $detalles
        ]);
    }

    public function pedidoCrear()
    {
        view('admin/pedido-form');
    }

    public function pedidoGuardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/admin.php?route=pedidos');
        exit;
        }

        $nombre = trim($_POST['nombre_cliente'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $fechaRecogida = trim($_POST['fecha_recogida'] ?? '');
        $metodoPago = trim($_POST['metodo_pago'] ?? '');
        $estado = trim($_POST['estado'] ?? 'pendiente');
        $total = (float)($_POST['total'] ?? 0);

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del cliente es obligatorio.';
        }

        if ($telefono === '') {
            $errores[] = 'El teléfono es obligatorio.';
        }

        if ($total <= 0) {
            $errores[] = 'El total debe ser mayor que 0.';
        }

        if (!empty($errores)) {
            view('admin/layouts/header');
            view('admin/pedido-form', [
                'errores' => $errores,
                'old' => $_POST
            ]);
            view('admin/layouts/footer');
            return;
        }

        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO pedidos
            (nombre_cliente, telefono, email, direccion, fecha_recogida, metodo_pago, estado, total, fecha_creacion)
            VALUES
            (:nombre_cliente, :telefono, :email, :direccion, :fecha_recogida, :metodo_pago, :estado, :total, NOW())
        ");

        $stmt->execute([
            'nombre_cliente' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'fecha_recogida' => $fechaRecogida,
            'metodo_pago' => $metodoPago,
            'estado' => $estado,
            'total' => $total
        ]);

        header('Location: ' . BASE_URL . '/admin.php?route=pedidos');
        exit;
    }

    public function actualizarEstadoPedido(int $id): void
    {
        $estado = trim($_POST['estado'] ?? '');

        if ($id <= 0 || $estado === '') {
            redirect(BASE_URL . '/admin.php?route=pedidos');
        }

        $pedidoModel = new Pedido();
        $pedidoModel->actualizarEstado($id, $estado);

        redirect(BASE_URL . '/admin.php?route=pedido-detalle&id=' . $id);
    }

    public function eliminarPedido(int $id): void
    {
        if ($id <= 0) {
            redirect(BASE_URL . '/admin.php?route=pedidos');
        }

        $pedidoModel = new Pedido();
        $pedidoModel->eliminar($id);

        redirect(BASE_URL . '/admin.php?route=pedidos');
    }

    public function productos(): void
    {
        $model = new Producto();
        $productos = $model->getTodos();

        view('admin/productos', [
            'productos' => $productos
        ]);
    }

    public function crearProducto(): void
    {
        $model = new Producto();
        $familias = $model->getFamilias();

        view('admin/producto-form', [
            'familias' => $familias
        ]);
    }

    public function guardarProducto(): void
    {
        $model = new Producto();

        $nombre = trim($_POST['nombre'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $familiaId = (int)($_POST['familia_id'] ?? 0);
        $tipoVenta = trim($_POST['tipo_venta'] ?? '');
        $precioOferta = trim($_POST['precio_oferta'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre es obligatorio.';
        }

        if ($slug === '') {
            $errores[] = 'El slug es obligatorio.';
        } elseif ($model->existeSlug($slug)) {
            $errores[] = 'Ya existe un producto con ese slug.';
        }

        if ($precio <= 0) {
            $errores[] = 'El precio debe ser mayor que 0.';
        }

        if ($familiaId <= 0) {
            $errores[] = 'Debes seleccionar una familia.';
        }

        if (!in_array($tipoVenta, ['peso', 'unidad'], true)) {
            $errores[] = 'El tipo de venta debe ser "peso" o "unidad".';
        }

        if ($precioOferta !== '') {
            $precioOfertaFloat = (float)$precioOferta;

            if ($precioOfertaFloat <= 0) {
                $errores[] = 'El precio de oferta debe ser mayor que 0.';
            }

            if ($precioOfertaFloat >= $precio) {
                $errores[] = 'El precio de oferta debe ser menor que el precio normal.';
            }
        }

        if (!empty($errores)) {
            $familias = $model->getFamilias();

            view('admin/producto-form', [
                'familias' => $familias,
                'errores' => $errores,
                'old' => $_POST
            ]);
            return;
        }

        $model->crear($_POST);

        redirect(BASE_URL . '/admin.php?route=productos');
    }

    public function editarProducto(int $id): void
    {
        $model = new Producto();
        $producto = $model->getById($id);

        if (!$producto) {
            echo '<h2>Producto no encontrado</h2>';
            return;
        }

        $familias = $model->getFamilias();

        view('admin/producto-form', [
            'producto' => $producto,
            'familias' => $familias
        ]);
    }

    public function actualizarProducto(): void
    {
        $model = new Producto();

        $id = (int)($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $familiaId = (int)($_POST['familia_id'] ?? 0);
        $tipoVenta = trim($_POST['tipo_venta'] ?? '');
        $precioOferta = trim($_POST['precio_oferta'] ?? '');

        $errores = [];

        if ($id <= 0) {
            $errores[] = 'ID de producto inválido.';
        }

        if ($nombre === '') {
            $errores[] = 'El nombre es obligatorio.';
        }

        if ($slug === '') {
            $errores[] = 'El slug es obligatorio.';
        } elseif ($model->existeSlug($slug, $id)) {
            $errores[] = 'Ya existe otro producto con ese slug.';
        }

        if ($precio <= 0) {
            $errores[] = 'El precio debe ser mayor que 0.';
        }

        if ($familiaId <= 0) {
            $errores[] = 'Debes seleccionar una familia.';
        }

        if (!in_array($tipoVenta, ['peso', 'unidad'], true)) {
            $errores[] = 'El tipo de venta debe ser "peso" o "unidad".';
        }

        if ($precioOferta !== '') {
            $precioOfertaFloat = (float)$precioOferta;

            if ($precioOfertaFloat <= 0) {
                $errores[] = 'El precio de oferta debe ser mayor que 0.';
            }

            if ($precioOfertaFloat >= $precio) {
                $errores[] = 'El precio de oferta debe ser menor que el precio normal.';
            }
        }

        if (!empty($errores)) {
            $familias = $model->getFamilias();
            $producto = $_POST;

            view('admin/producto-form', [
                'producto' => $producto,
                'familias' => $familias,
                'errores' => $errores
            ]);
            return;
        }

        $model->actualizar($_POST);

        redirect(BASE_URL . '/admin.php?route=productos');
    }

    public function toggleProducto(int $id): void
    {
        if ($id <= 0) {
            redirect(BASE_URL . '/admin.php?route=productos');
        }

        $model = new Producto();
        $model->cambiarEstadoActivo($id);

        redirect(BASE_URL . '/admin.php?route=productos');
    }

    public function actualizarStock(): void
    {
        $productoId = (int)($_POST['producto_id'] ?? 0);
        $cantidad = (float)($_POST['cantidad'] ?? 0);

        if ($productoId <= 0) {
            redirect(BASE_URL . '/admin.php?route=productos');
        }

        if ($cantidad < 0) {
            redirect(BASE_URL . '/admin.php?route=productos');
        }

        $model = new Producto();
        $model->actualizarStock($productoId, $cantidad);

        redirect(BASE_URL . '/admin.php?route=productos');
    }

    public function piezasBasePrecios(): void
    {
        $piezaBaseModel = new PiezaBase();
        $piezasBase = $piezaBaseModel->getTodas();

        view('admin/piezas-base-precios', [
            'piezasBase' => $piezasBase
        ]);
    }

    public function actualizarPrecioPiezaBase(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $precioCompraUnitario = (float)($_POST['precio_compra_unitario'] ?? 0);

        if ($id <= 0 || $precioCompraUnitario < 0) {
            redirect(BASE_URL . '/admin.php?route=piezas-base-precios');
        }

        $piezaBaseModel = new PiezaBase();
        $piezaBaseModel->actualizarPrecioCompra($id, $precioCompraUnitario);

        redirect(BASE_URL . '/admin.php?route=piezas-base-precios');
    }

    public function entradaForm(): void
    {
        $piezaBaseModel = new PiezaBase();
        $piezasBase = $piezaBaseModel->getActivas();

        view('admin/entrada-form', [
            'piezasBase' => $piezasBase
        ]);
    }

    public function guardarEntrada(): void
    {
        $piezaBaseId = (int)($_POST['pieza_base_id'] ?? 0);
        $cantidadEntrada = (float)($_POST['cantidad_entrada'] ?? 0);
        $costeTotalCompra = (float)($_POST['coste_total_compra'] ?? 0);
        $observaciones = trim($_POST['observaciones'] ?? '');

        $errores = [];

        if ($piezaBaseId <= 0) {
            $errores[] = 'Debes seleccionar una pieza base.';
        }

        if ($cantidadEntrada <= 0) {
            $errores[] = 'La cantidad de entrada debe ser mayor que 0.';
        }

        if ($costeTotalCompra <= 0) {
            $errores[] = 'El coste total de compra debe ser mayor que 0.';
        }

        $piezaBaseModel = new PiezaBase();
        $piezaBase = $piezaBaseModel->getById($piezaBaseId);

        if (!$piezaBase || (int)$piezaBase['activa'] !== 1) {
            $errores[] = 'La pieza base seleccionada no es válida.';
        }

        $reglas = $piezaBaseId > 0 ? $piezaBaseModel->getReglasDespiece($piezaBaseId) : [];

        if (empty($reglas)) {
            $errores[] = 'Esa pieza base no tiene reglas de despiece configuradas.';
        }

        if (!empty($errores)) {
            $piezasBase = $piezaBaseModel->getActivas();

            view('admin/entrada-form', [
                'piezasBase' => $piezasBase,
                'errores' => $errores,
                'old' => $_POST
            ]);
            return;
        }

        $entradaModel = new EntradaCompra();

        $entradaId = $entradaModel->crearConDespiece([
            'pieza_base_id' => $piezaBaseId,
            'administrador_id' => $_SESSION['admin']['id'],
            'cantidad_entrada' => $cantidadEntrada,
            'coste_total_compra' => $costeTotalCompra,
            'observaciones' => $observaciones
        ], $reglas);

        if ($entradaId === false) {
            $piezasBase = $piezaBaseModel->getActivas();

            view('admin/entrada-form', [
                'piezasBase' => $piezasBase,
                'errores' => ['No se pudo registrar la entrada.'],
                'old' => $_POST
            ]);
            return;
        }

        redirect(BASE_URL . '/admin.php?route=productos');
    }

    public function entradas(): void
    {
        $entradaModel = new EntradaCompra();
        $entradas = $entradaModel->getAll();

        view('admin/entradas', [
            'entradas' => $entradas
        ]);
    }

    public function entradaDetalle(int $id): void
    {
        $entradaModel = new EntradaCompra();

        $entrada = $entradaModel->getById($id);
        $detalles = $entradaModel->getDetallesByEntradaId($id);

        if (!$entrada) {
            echo '<h2>Entrada no encontrada</h2>';
            return;
        }

        view('admin/entrada-detalle', [
            'entrada' => $entrada,
            'detalles' => $detalles
        ]);
    }

    public function eliminarEntrada(int $id): void
    {
        if ($id <= 0) {
            redirect(BASE_URL . '/admin.php?route=entradas');
        }

        $entradaModel = new EntradaCompra();
        $entradaModel->eliminar($id);

        redirect(BASE_URL . '/admin.php?route=entradas');
    }

    public function recetas(): void
    {
        $recetaModel = new Receta();
        $recetas = $recetaModel->getTodas();

        view('admin/recetas', [
            'recetas' => $recetas
        ]);
    }

    public function crearReceta(): void
    {
        view('admin/receta-form');
    }

    public function guardarReceta(): void
    {
        $recetaModel = new Receta();

        $titulo = trim($_POST['titulo'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $elaboracion = trim($_POST['elaboracion'] ?? '');

        $errores = [];

        if ($titulo === '') {
            $errores[] = 'El título es obligatorio.';
        }

        if ($slug === '') {
            $errores[] = 'El slug es obligatorio.';
        } elseif ($recetaModel->existeSlug($slug)) {
            $errores[] = 'Ya existe una receta con ese slug.';
        }

        if ($elaboracion === '') {
            $errores[] = 'La elaboración es obligatoria.';
        }

        if (!empty($errores)) {
            view('admin/receta-form', [
                'errores' => $errores,
                'old' => $_POST
            ]);
            return;
        }

        $recetaModel->crear($_POST);

        redirect(BASE_URL . '/admin.php?route=recetas');
    }

    public function editarReceta(int $id): void
    {
        $recetaModel = new Receta();
        $receta = $recetaModel->getById($id);

        if (!$receta) {
            echo '<h2>Receta no encontrada</h2>';
            return;
        }

        view('admin/receta-form', [
            'receta' => $receta
        ]);
    }

    public function actualizarReceta(): void
    {
        $recetaModel = new Receta();

        $id = (int)($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $elaboracion = trim($_POST['elaboracion'] ?? '');

        $errores = [];

        if ($id <= 0) {
            $errores[] = 'ID de receta inválido.';
        }

        if ($titulo === '') {
            $errores[] = 'El título es obligatorio.';
        }

        if ($slug === '') {
            $errores[] = 'El slug es obligatorio.';
        } elseif ($recetaModel->existeSlug($slug, $id)) {
            $errores[] = 'Ya existe otra receta con ese slug.';
        }

        if ($elaboracion === '') {
            $errores[] = 'La elaboración es obligatoria.';
        }

        if (!empty($errores)) {
            $receta = $_POST;

            view('admin/receta-form', [
                'receta' => $receta,
                'errores' => $errores
            ]);
            return;
        }

        $recetaModel->actualizar($_POST);

        redirect(BASE_URL . '/admin.php?route=recetas');
    }

    public function toggleReceta(int $id): void
    {
        if ($id <= 0) {
            redirect(BASE_URL . '/admin.php?route=recetas');
        }

        $recetaModel = new Receta();
        $recetaModel->toggleActivo($id);

        redirect(BASE_URL . '/admin.php?route=recetas');
    }

    public function contactos(): void
    {
        $contactoModel = new ContactoMensaje();
        $contactos = $contactoModel->getAll();

        view('admin/contactos', [
            'contactos' => $contactos
        ]);
    }

    public function contactoToggle(int $id): void
    {
        if ($id <= 0) {
            redirect(BASE_URL . '/admin.php?route=contactos');
        }

        $contactoModel = new ContactoMensaje();
        $contactoModel->toggleContestado($id);

        redirect(BASE_URL . '/admin.php?route=contactos');
    }

    public function contactoResponder(int $id): void
{
    require_once __DIR__ . '/../models/ContactoMensaje.php';

    $model = new ContactoMensaje();

    // Obtener mensaje
    $contacto = $model->getById($id);

    if (!$contacto) {
        redirect(BASE_URL . '/admin.php?route=contactos');
    }

    // Marcar como contestado
    if ((int)$contacto['contestado'] === 0) {
        $model->toggleContestado($id);
    }

    // Redirigir al mail
    $email = urlencode($contacto['email']);
    $nombre = urlencode($contacto['nombre']);

    $subject = urlencode('Respuesta GyE Carniceros');
    $body = urlencode("Hola $nombre,\n\n");

    header("Location: mailto:$email?subject=$subject&body=$body");
    exit;
}


}