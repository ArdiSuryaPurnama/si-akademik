<?php
namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $content = __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/layouts/main.php';
    }
    protected function redirect(string $path): void { header('Location: ' . url($path)); exit; }
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}