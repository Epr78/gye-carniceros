<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/utils.php';

class ProductoController
{
    public function index(): void
    {
        $productoModel = new Producto();

        $familia = trim($_GET['familia'] ?? '');
        $oferta = isset($_GET['oferta']) && $_GET['oferta'] === '1' ? '1' : '';
        $apto = trim($_GET['apto'] ?? '');

        $filtros = [
            'familia' => $familia,
            'oferta' => $oferta,
            'apto' => $apto
        ];

        $productos = $productoModel->getActivosFiltrados($filtros);
        $familias = $productoModel->getFamilias();

        view('front/layouts/header');
        view('front/productos', [
            'productos' => $productos,
            'familias' => $familias,
            'familiaActual' => $familia,
            'ofertaActual' => $oferta,
            'aptoActual' => $apto
        ]);
        view('front/layouts/footer');
    }

    public function show(string $slug): void
    {
        $productoModel = new Producto();
        $producto = $productoModel->getBySlug($slug);

        if (!$producto) {
            echo '<h2>Producto no encontrado</h2>';
            return;
        }

        view('front/layouts/header');
        view('front/producto-detalle', [
            'producto' => $producto
        ]);
        view('front/layouts/footer');
    }

    public function ofertas(): void
    {
        $productoModel = new Producto();
        $productos = $productoModel->getOfertas();

        view('front/layouts/header');
        view('front/ofertas', [
            'productos' => $productos
        ]);
        view('front/layouts/footer');
    }
}