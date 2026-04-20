<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../helpers/utils.php';

class UsuarioController
{
    public function login(): void
    {
        view('front/layouts/header');
        view('front/usuario-login');
        view('front/layouts/footer');
    }

    public function registro(): void
    {
        view('front/layouts/header');
        view('front/usuario-registro');
        view('front/layouts/footer');
    }

    public function guardarRegistro(): void
    {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($nombre === '' || $email === '' || $password === '') {
            redirect(BASE_URL . '/?route=usuario-registro');
        }

        $usuarioModel = new Usuario();

        $existe = $usuarioModel->getByEmail($email);
        if ($existe) {
            redirect(BASE_URL . '/?route=usuario-login');
        }

        $usuarioId = $usuarioModel->crear([
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($usuarioId === false) {
            echo '<h2>Error al registrar usuario</h2>';
            return;
        }

        $usuario = $usuarioModel->getById($usuarioId);

        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'telefono' => $usuario['telefono'],
            'direccion' => $usuario['direccion']
        ];

        redirect(BASE_URL . '/?route=carrito');
    }

    public function autenticar(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            redirect(BASE_URL . '/?route=usuario-login');
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->getByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            redirect(BASE_URL . '/?route=usuario-login');
        }

        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'telefono' => $usuario['telefono'],
            'direccion' => $usuario['direccion']
        ];

        redirect(BASE_URL . '/?route=carrito');
    }

    public function logout(): void
    {
        unset($_SESSION['usuario']);
        redirect(BASE_URL . '/?route=inicio');
    }
}