<?php
namespace App\Repositories;

use App\Core\Model;
use App\Models\Mahasiswa;
use PDO;

class MahasiswaRepository extends Model
{
    protected string $table = 'mahasiswa';

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function all(?string $keyword = null): array
    {
        $sql = "SELECT m.*, p.nama AS prodi_nama
                FROM mahasiswa m
                JOIN prodi p ON m.prodi_id = p.id";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " WHERE m.nim LIKE :kw1 OR m.nama LIKE :kw2";
            $params = [
                'kw1' => "%{$keyword}%",
                'kw2' => "%{$keyword}%",
            ];
        }

        $sql .= " ORDER BY m.nim ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findWithProdi(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT m.*, p.nama AS prodi_nama
             FROM mahasiswa m
             JOIN prodi p ON m.prodi_id = p.id
             WHERE m.id = :id"
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function allProdi(): array
    {
        return $this->db->query("SELECT id, kode, nama FROM prodi ORDER BY kode ASC")->fetchAll();
    }

    public function create(Mahasiswa $mhs): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)"
        );
        $stmt->execute([
            'nim'      => $mhs->getNim(),
            'nama'     => $mhs->getNama(),
            'email'    => $mhs->getEmail(),
            'prodi_id' => $mhs->getProdiId(),
            'angkatan' => $mhs->getAngkatan(),
            'status'   => $mhs->getStatus(),
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, Mahasiswa $mhs): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email, prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id"
        );
        return $stmt->execute([
            'id'       => $id,
            'nim'      => $mhs->getNim(),
            'nama'     => $mhs->getNama(),
            'email'    => $mhs->getEmail(),
            'prodi_id' => $mhs->getProdiId(),
            'angkatan' => $mhs->getAngkatan(),
            'status'   => $mhs->getStatus(),
        ]);
    }
}