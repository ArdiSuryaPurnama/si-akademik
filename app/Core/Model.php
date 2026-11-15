<?php
namespace App\Core;

use PDO;

abstract class Model
{
    protected PDO $db;
    protected string $table;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? Database::getInstance();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}