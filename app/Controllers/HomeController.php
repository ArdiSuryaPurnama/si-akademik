<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        // Contoh jika baris 8 melakukan redirect ke /mahasiswa:
        header('Location: ' . url('/mahasiswa'));
        exit;
    }
}