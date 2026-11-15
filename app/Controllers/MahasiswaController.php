<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Mahasiswa;
use App\Repositories\MahasiswaRepository;

class MahasiswaController extends Controller
{
    public function __construct(private MahasiswaRepository $repo) {}

    public function index(): void
    {
        $keyword = trim($_GET['q'] ?? '');
        $daftar  = $this->repo->all($keyword !== '' ? $keyword : null);

        $this->view('mahasiswa/index', [
            'title'   => 'Daftar Mahasiswa',
            'daftar'  => $daftar,
            'keyword' => $keyword,
        ]);
    }

    public function create(): void
    {
        $this->view('mahasiswa/create', [
            'title'     => 'Tambah Mahasiswa',
            'prodiList' => $this->repo->allProdi(),
        ]);
    }

    public function store(): void
    {
        try {
            $mhs = new Mahasiswa(
                $_POST['nim'] ?? '',
                $_POST['nama'] ?? '',
                $_POST['email'] ?? '',
                (int)($_POST['prodi_id'] ?? 1),
                (int)($_POST['angkatan'] ?? date('Y')),
                $_POST['status'] ?? 'aktif'
            );
            $this->repo->create($mhs);
            $this->flash('success', 'Data mahasiswa berhasil ditambahkan.');
            $this->redirect('/mahasiswa');
        } catch (\Throwable $e) {
            $this->flash('danger', 'Validasi gagal: ' . $e->getMessage());
            $this->redirect('/mahasiswa/create');
        }
    }

    public function show(string $id): void
    {
        $mhs = $this->repo->findWithProdi((int)$id);
        if (!$mhs) {
            http_response_code(404);
            echo 'Data mahasiswa tidak ditemukan.';
            return;
        }
        echo 'Detail Mahasiswa: ' . htmlspecialchars($mhs['nim'] . ' - ' . $mhs['nama'] . ' (' . $mhs['prodi_nama'] . ')');
    }

    public function edit(string $id): void
    {
        $mhs = $this->repo->find((int)$id);
        if (!$mhs) {
            $this->flash('danger', 'Data mahasiswa tidak ditemukan.');
            $this->redirect('/mahasiswa');
        }

        $this->view('mahasiswa/edit', [
            'title'     => 'Edit Mahasiswa',
            'mhs'       => $mhs,
            'prodiList' => $this->repo->allProdi(),
        ]);
    }

    public function update(string $id): void
    {
        try {
            $mhs = new Mahasiswa(
                $_POST['nim'] ?? '',
                $_POST['nama'] ?? '',
                $_POST['email'] ?? '',
                (int)($_POST['prodi_id'] ?? 1),
                (int)($_POST['angkatan'] ?? date('Y')),
                $_POST['status'] ?? 'aktif'
            );
            $this->repo->update((int)$id, $mhs);
            $this->flash('success', 'Data mahasiswa berhasil diperbarui.');
            $this->redirect('/mahasiswa');
        } catch (\Throwable $e) {
            $this->flash('danger', 'Validasi gagal: ' . $e->getMessage());
            $this->redirect('/mahasiswa/' . (int)$id . '/edit');
        }
    }

    public function destroy(string $id): void
    {
        $this->repo->delete((int)$id);
        $this->flash('info', 'Data mahasiswa berhasil dihapus.');
        $this->redirect('/mahasiswa');
    }
}