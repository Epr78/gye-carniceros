<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../helpers/utils.php';
require_once __DIR__ . '/../helpers/auth_user.php';

class PedidoController
{
    public function confirmar(): void
    {
        requerirUsuario();

        $nombre = trim($_POST['nombre_cliente'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $fechaRecogida = trim($_POST['fecha_recogida'] ?? '');
        $observaciones = trim($_POST['observaciones'] ?? '');
        $metodoPago = trim($_POST['metodo_pago'] ?? 'efectivo');

        $necesitaCambio = trim($_POST['necesita_cambio'] ?? 'no');
        $importeBillete = trim($_POST['importe_billete'] ?? '');

        $titularTarjeta = trim($_POST['titular_tarjeta'] ?? '');
        $numeroTarjeta = preg_replace('/\s+/', '', trim($_POST['numero_tarjeta'] ?? ''));
        $caducidadTarjeta = trim($_POST['caducidad_tarjeta'] ?? '');
        $cvvTarjeta = trim($_POST['cvv_tarjeta'] ?? '');

        if ($nombre === '' || $telefono === '') {
            $_SESSION['carrito_error'] = 'Debes completar al menos nombre y teléfono para tramitar el pedido.';
            redirect(BASE_URL . '/?route=carrito');
        }

        if (!in_array($metodoPago, ['efectivo', 'tarjeta'], true)) {
            $_SESSION['carrito_error'] = 'El método de pago no es válido.';
            redirect(BASE_URL . '/?route=carrito');
        }

        if ($metodoPago === 'efectivo') {
            if (!in_array($necesitaCambio, ['si', 'no'], true)) {
                $_SESSION['carrito_error'] = 'Debes indicar si necesitas cambio.';
                redirect(BASE_URL . '/?route=carrito');
            }

            if ($necesitaCambio === 'si') {
                if ($importeBillete === '' || !is_numeric($importeBillete) || (float)$importeBillete <= 0) {
                    $_SESSION['carrito_error'] = 'Debes indicar correctamente el importe del billete para preparar el cambio.';
                    redirect(BASE_URL . '/?route=carrito');
                }
            }
        }

        if ($metodoPago === 'tarjeta') {
            if ($titularTarjeta === '' || $numeroTarjeta === '' || $caducidadTarjeta === '' || $cvvTarjeta === '') {
                $_SESSION['carrito_error'] = 'Debes completar todos los datos de la tarjeta para la simulación del pago.';
                redirect(BASE_URL . '/?route=carrito');
            }

            if (!preg_match('/^\d{13,19}$/', $numeroTarjeta)) {
                $_SESSION['carrito_error'] = 'El número de tarjeta simulado no es válido.';
                redirect(BASE_URL . '/?route=carrito');
            }

            if (!preg_match('/^\d{2}\/\d{2}$/', $caducidadTarjeta)) {
                $_SESSION['carrito_error'] = 'La caducidad de la tarjeta debe tener formato MM/AA.';
                redirect(BASE_URL . '/?route=carrito');
            }

            if (!preg_match('/^\d{3,4}$/', $cvvTarjeta)) {
                $_SESSION['carrito_error'] = 'El CVV simulado no es válido.';
                redirect(BASE_URL . '/?route=carrito');
            }
        }

        $carrito = $_SESSION['carrito'] ?? [];

        if (empty($carrito)) {
            $_SESSION['carrito_error'] = 'Tu carrito está vacío.';
            redirect(BASE_URL . '/?route=carrito');
        }

        $productoModel = new Producto();
        $carritoAjustado = [];
        $mensajesAjuste = [];

        foreach ($carrito as $itemCarrito) {
            $productoId = (int)($itemCarrito['producto_id'] ?? 0);
            $cantidad = (float)($itemCarrito['cantidad'] ?? 0);
            $tipoCorte = $itemCarrito['tipo_corte'] ?? 'pieza entera';

            if ($productoId <= 0 || $cantidad <= 0) {
                continue;
            }

            $producto = $productoModel->getById($productoId);

            if (!$producto) {
                $mensajesAjuste[] = 'Se ha eliminado un producto del carrito porque ya no existe.';
                continue;
            }

            $stockActual = (float)($producto['stock_cantidad'] ?? 0);

            if ($stockActual <= 0) {
                $mensajesAjuste[] = 'Se ha eliminado "' . $producto['nombre'] . '" del carrito porque no tiene stock.';
                continue;
            }

            if ($cantidad > $stockActual) {
                $carritoAjustado[] = [
                    'producto_id' => $productoId,
                    'cantidad' => $stockActual,
                    'tipo_corte' => $tipoCorte
                ];

                $mensajesAjuste[] = 'La cantidad de "' . $producto['nombre'] . '" se ha ajustado a ' . rtrim(rtrim(number_format($stockActual, 2, '.', ''), '0'), '.') . ' por falta de stock.';
                continue;
            }

            $carritoAjustado[] = [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'tipo_corte' => $tipoCorte
            ];
        }

        $_SESSION['carrito'] = array_values($carritoAjustado);

        if (!empty($mensajesAjuste)) {
            $_SESSION['carrito_error'] = implode(' ', $mensajesAjuste);
            redirect(BASE_URL . '/?route=carrito');
        }

        if (empty($_SESSION['carrito'])) {
            $_SESSION['carrito_error'] = 'No se puede tramitar el pedido porque ya no hay productos con stock en el carrito.';
            redirect(BASE_URL . '/?route=carrito');
        }

        $items = [];
        $total = 0;

        foreach ($_SESSION['carrito'] as $itemCarrito) {
            $productoId = (int)$itemCarrito['producto_id'];
            $cantidad = (float)$itemCarrito['cantidad'];
            $tipoCorte = $itemCarrito['tipo_corte'] ?? 'pieza entera';

            if ($productoId <= 0 || $cantidad <= 0) {
                continue;
            }

            $producto = $productoModel->getById($productoId);

            if (!$producto) {
                continue;
            }

            $stockActual = (float)($producto['stock_cantidad'] ?? 0);

            if ($stockActual < $cantidad) {
                $_SESSION['carrito_error'] = 'El stock ha cambiado mientras tramitabas el pedido. Revisa de nuevo el carrito.';
                redirect(BASE_URL . '/?route=carrito');
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
                'producto' => $producto,
                'cantidad' => $cantidad,
                'tipo_corte' => $tipoCorte,
                'precio_unitario' => $precio,
                'subtotal' => $subtotal
            ];
        }

        if (empty($items)) {
            $_SESSION['carrito_error'] = 'No se pudo generar el pedido porque el carrito no tiene líneas válidas.';
            redirect(BASE_URL . '/?route=carrito');
        }

        $observacionesPago = '';

        if ($metodoPago === 'efectivo') {
            if ($necesitaCambio === 'si') {
                $observacionesPago = '[PAGO EFECTIVO] Necesita cambio. Paga con billete de ' . number_format((float)$importeBillete, 2, ',', '.') . ' €.';
                $_SESSION['pedido_pago_resumen'] = 'Pago en efectivo. El cliente necesita cambio para un billete de ' . number_format((float)$importeBillete, 2, ',', '.') . ' €.';
            } else {
                $observacionesPago = '[PAGO EFECTIVO] No necesita cambio.';
                $_SESSION['pedido_pago_resumen'] = 'Pago en efectivo. El cliente no necesita cambio.';
            }
        }

        if ($metodoPago === 'tarjeta') {
            $ultimos4 = substr($numeroTarjeta, -4);
            $observacionesPago = '[PAGO TARJETA SIMULADO] Titular: ' . $titularTarjeta . '. Tarjeta terminada en ' . $ultimos4 . '. Caducidad: ' . $caducidadTarjeta . '.';
            $_SESSION['pedido_pago_resumen'] = 'Pago con tarjeta simulado correctamente. Tarjeta terminada en ' . $ultimos4 . '.';
        }

        $observacionesFinales = trim($observaciones);
        if ($observacionesPago !== '') {
            $observacionesFinales = trim($observacionesFinales . "\n" . $observacionesPago);
        }

        $pedidoModel = new Pedido();

        $pedidoId = $pedidoModel->crearPedido([
            'usuario_id' => $_SESSION['usuario']['id'],
            'nombre_cliente' => $nombre,
            'telefono' => $telefono,
            'email' => $email,
            'direccion' => $direccion,
            'fecha_recogida' => $fechaRecogida !== '' ? $fechaRecogida : null,
            'observaciones' => $observacionesFinales,
            'metodo_pago' => $metodoPago,
            'total' => $total
        ], $items);

        if ($pedidoId === false) {
            unset($_SESSION['pedido_pago_resumen']);
            $_SESSION['carrito_error'] = 'No se pudo guardar el pedido. Revisa el stock disponible e inténtalo de nuevo.';
            redirect(BASE_URL . '/?route=carrito');
        }

        unset($_SESSION['carrito']);
        $_SESSION['carrito_ok'] = 'Pedido realizado correctamente.';

        redirect(BASE_URL . '/?route=pedido-exito&id=' . $pedidoId);
    }

    public function exito(): void
    {
        $pedidoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pagoResumen = $_SESSION['pedido_pago_resumen'] ?? '';
        unset($_SESSION['pedido_pago_resumen']);

        view('front/layouts/header');
        view('front/pedido-exito', [
            'pedidoId' => $pedidoId,
            'pagoResumen' => $pagoResumen
        ]);
        view('front/layouts/footer');
    }
}