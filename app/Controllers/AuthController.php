<?php
namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function loginForm(): void
    {
        if (!empty($_SESSION['logged_in'])) {
            $this->redirect('/mahasiswa');
        }
        $this->view('auth/login', ['title' => 'Login SI Akademik']);
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = 'Admin';
            $this->flash('success', 'Selamat datang, Admin!');
            $this->redirect('/mahasiswa');
        }

        $this->flash('danger', 'Username atau password salah!');
        $this->redirect('/login');
    }

    public function logout(): void
    {
        unset($_SESSION['logged_in'], $_SESSION['user_name']);
        $this->flash('info', 'Anda telah logout.');
        $this->redirect('/login');
    }
}