<?php
session_start();
require_once __DIR__ . '/../config/app.php';

spl_autoload_register(function (string $class) {
    if (!str_starts_with($class, 'App\\')) return;
    $path = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($path)) require $path;
});

$routes = require __DIR__ . '/../routes/web.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (BASE_URL !== '' && str_starts_with($uri, BASE_URL)) $uri = substr($uri, strlen(BASE_URL));
$uri = '/' . trim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

foreach ($routes[$method] ?? [] as $pattern => [$class, $action]) {
    $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
    if (preg_match($regex, $uri, $m)) {
        $params = array_values(array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY));

        if (str_starts_with($uri, '/mahasiswa')) {
            (new \App\Core\Middleware\AuthMiddleware())->handle();
        }

        // Suntikkan MahasiswaRepository + koneksi PDO saat memanggil MahasiswaController
        $controller = match ($class) {
            \App\Controllers\MahasiswaController::class => new $class(
                new \App\Repositories\MahasiswaRepository(\App\Core\Database::getInstance())
            ),
            default => new $class(),
        };

        $controller->$action(...$params);
        exit;
    }
}

http_response_code(404);
echo '404 - Halaman tidak ditemukan';