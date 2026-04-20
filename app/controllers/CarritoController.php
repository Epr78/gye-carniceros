<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/utils.php';

class CarritoController
{
    public function index(): void
    {
        $carrito = $_SESSION['carrito'] ?? [];
        $items = [];
        $total = 0;

        if (!empty($carrito)) {
            $productoModel = new Producto();

            foreach ($carrito as $key => $itemCarrito) {
                $productoId = (int)$itemCarrito['producto_id'];
                $cantidad = (float)$itemCarrito['cantidad'];
                $tipoCorte = $itemCarrito['tipo_corte'] ?? 'pieza entera';

                $producto = $productoModel->getById($productoId);

                if (!$producto) {
                    continue;
                }

                $precio = (!empty($producto['en_oferta']) && !empty($producto['precio_oferta']))
                    ? (float)$producto['precio_oferta']
                    : (float)$producto['precio'];

                if ($tipoCorte === 'filete fino' && $producto['tipo_venta'] === 'peso') {
                    $precio += 1;
                }

                $subtotal = $precio * $cantidad;
                $total += $subtotal;

                $items[] = [
                    'key' => $key,
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'tipo_corte' => $tipoCorte,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotal
                ];
            }
        }

        view('front/layouts/header');
        view('front/carrito', [
            'items' => $items,
            'total' => $total
        ]);
        view('front/layouts/footer');
    }

    public function add(): void
    {
        $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
        $cantidad = isset($_POST['cantidad']) ? (float)$_POST['cantidad'] : 1;
        $tipoCorte = trim($_POST['tipo_corte'] ?? 'pieza entera');

        if ($productoId <= 0 || $cantidad <= 0) {
            redirect(BASE_URL . '/?route=carrito');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $_SESSION['carrito'][] = [
            'producto_id' => $productoId,
            'cantidad' => $cantidad,
            'tipo_corte' => $tipoCorte
        ];

        redirect(BASE_URL . '/?route=carrito');
    }

    public function remove(): void
    {
        $key = isset($_GET['key']) ? (int)$_GET['key'] : -1;

        if ($key >= 0 && isset($_SESSION['carrito'][$key])) {
            unset($_SESSION['carrito'][$key]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
        }

        redirect(BASE_URL . '/?route=carrito');
    }

    public function update(): void
    {
        if (!isset($_POST['cantidades']) || !is_array($_POST['cantidades'])) {
            redirect(BASE_URL . '/?route=carrito');
        }

        foreach ($_POST['cantidades'] as $key => $cantidad) {
            $key = (int)$key;
            $cantidad = (float)$cantidad;

            if (!isset($_SESSION['carrito'][$key])) {
                continue;
            }

            if ($cantidad <= 0) {
                unset($_SESSION['carrito'][$key]);
            } else {
                $_SESSION['carrito'][$key]['cantidad'] = $cantidad;
            }
        }

        $_SESSION['carrito'] = array_values($_SESSION['carrito']);

        redirect(BASE_URL . '/?route=carrito');
    }
}