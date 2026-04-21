<?php

require_once __DIR__ . '/../helpers/utils.php';
require_once __DIR__ . '/../models/ContactoMensaje.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Producto.php';

class FrontController
{
   public function inicio(): void
    {
    $productoModel = new Producto();
    $ofertas = $productoModel->getOfertas();

    view('front/layouts/header');
    view('front/inicio', ['ofertas' => $ofertas]);
    view('front/layouts/footer');
    }

    public function quienes(): void
    {
        view('front/layouts/header');
        view('front/quienes');
        view('front/layouts/footer');
    }

    public function productos(): void
    {
        view('front/layouts/header');
        view('front/productos');
        view('front/layouts/footer');
    }

    public function recetas(): void
    {
        $db = Database::connect();

        // RECETAS
        $stmt = $db->query("SELECT * FROM recetas WHERE activa = 1");
        $recetas = $stmt->fetchAll();

        // INGREDIENTES
        $stmt2 = $db->query("
            SELECT rp.*, p.nombre 
            FROM receta_productos rp
            JOIN productos p ON p.id = rp.producto_id
        ");
        $ingredientes = $stmt2->fetchAll();

        view('front/layouts/header');
        view('front/recetas', [
            'recetas' => $recetas,
            'ingredientes' => $ingredientes
        ]);
        view('front/layouts/footer');
    }

    public function ofertas(): void
    {

        $productoModel = new Producto();
        $ofertas = $productoModel->getOfertas();

        view('front/layouts/header');
        view('front/ofertas', ['ofertas' => $ofertas]);
        view('front/layouts/footer');
        
    }
  

    public function contacto(): void
    {
        view('front/layouts/header');
        view('front/contacto');
        view('front/layouts/footer');
    }

    public function enviarContacto(): void
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        if ($nombre === '' || $email === '' || $asunto === '' || $mensaje === '') {
            $_SESSION['contacto_error'] = 'Debes completar nombre, email, asunto y mensaje.';
            redirect(BASE_URL . '/?route=contacto');
        }

        $contactoModel = new ContactoMensaje();

        $ok = $contactoModel->crear([
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'asunto' => $asunto,
            'mensaje' => $mensaje
        ]);

        if (!$ok) {
            $_SESSION['contacto_error'] = 'No se pudo enviar el mensaje. Inténtalo de nuevo.';
            redirect(BASE_URL . '/?route=contacto');
        }

        $_SESSION['contacto_ok'] = 'Tu mensaje se ha enviado correctamente.';
        redirect(BASE_URL . '/?route=contacto');
    }

    public function carrito(): void
    {
        view('front/layouts/header');
        view('front/carrito');
        view('front/layouts/footer');
    }
}