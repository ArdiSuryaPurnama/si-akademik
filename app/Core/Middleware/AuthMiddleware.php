<?php
namespace App\Core\Middleware;

class AuthMiddleware
{
    public function handle(): void
    {
        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['flash'] = [
                'type'    => 'warning',
                'message' => 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.'
            ];
            header('Location: ' . url('/login'));
            exit;
        }
    }
}