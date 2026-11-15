<?php
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\MahasiswaController;

return [
    'GET' => [
        '/'                      => [HomeController::class, 'index'],
        '/login'                 => [AuthController::class, 'loginForm'],
        '/mahasiswa'             => [MahasiswaController::class, 'index'],
        '/mahasiswa/create'      => [MahasiswaController::class, 'create'],
        '/mahasiswa/{id}/edit'   => [MahasiswaController::class, 'edit'],
        '/mahasiswa/{id}'        => [MahasiswaController::class, 'show'],
    ],
    'POST' => [
        '/login'                 => [AuthController::class, 'login'],
        '/logout'                => [AuthController::class, 'logout'],
        '/mahasiswa'             => [MahasiswaController::class, 'store'],
        '/mahasiswa/{id}/update' => [MahasiswaController::class, 'update'],
        '/mahasiswa/{id}/delete' => [MahasiswaController::class, 'destroy'],
    ],
];