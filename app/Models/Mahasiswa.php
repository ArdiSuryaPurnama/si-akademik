<?php
namespace App\Models;

class Mahasiswa
{
    private ?int $id = null;
    private string $nim;
    private string $nama;
    private string $email = '';
    private int $prodiId = 1;
    private int $angkatan;
    private string $status = 'aktif';
    private string $prodi = '';

    public function __construct(
        string $nim,
        string $nama,
        string $email = '',
        int $prodiId = 1,
        ?int $angkatan = null,
        string $status = 'aktif',
        string $prodi = ''
    ) {
        $this->setNim($nim);
        $this->setNama($nama);
        if ($email !== '') {
            $this->setEmail($email);
        }
        $this->setProdiId($prodiId);
        $this->setAngkatan($angkatan ?? (int)$this->getAngkatanDariNim());
        $this->setStatus($status);
        $this->prodi = trim($prodi);
    }

    // --- GETTER ---
    public function getId(): ?int       { return $this->id; }
    public function getNim(): string    { return $this->nim; }
    public function getNama(): string   { return $this->nama; }
    public function getEmail(): string  { return $this->email; }
    public function getProdiId(): int   { return $this->prodiId; }
    public function getAngkatan(): int  { return $this->angkatan; }
    public function getStatus(): string { return $this->status; }

    // --- SETTER DENGAN VALIDASI (Acara 9) ---
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setNim(string $nim): void
    {
        $nim = strtoupper(trim($nim));
        if ($nim === '' || strlen($nim) < 7) {
            throw new \InvalidArgumentException('NIM tidak boleh kosong dan minimal 7 karakter.');
        }
        $this->nim = $nim;
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);
        if ($nama === '' || strlen($nama) < 3) {
            throw new \InvalidArgumentException('Nama mahasiswa wajib diisi (minimal 3 karakter).');
        }
        $this->nama = $nama;
    }

    public function setEmail(string $email): void
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Format email tidak valid.');
        }
        $this->email = $email;
    }

    public function setProdiId(int $prodiId): void
    {
        if ($prodiId <= 0) {
            throw new \InvalidArgumentException('Program studi wajib dipilih.');
        }
        $this->prodiId = $prodiId;
    }

    public function setAngkatan(int $angkatan): void
    {
        if ($angkatan < 2000 || $angkatan > 2100) {
            throw new \InvalidArgumentException('Tahun angkatan tidak valid.');
        }
        $this->angkatan = $angkatan;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, ['aktif', 'cuti', 'lulus'], true)) {
            throw new \InvalidArgumentException('Status mahasiswa harus aktif, cuti, atau lulus.');
        }
        $this->status = $status;
    }

    // --- PEMBACAAN DIGIT NIM POLIJE ---

    public function getProdi(): string
    {
        return $this->prodi !== '' ? $this->prodi : $this->getProdiDariNim();
    }

    // Digit 1 (index 0): Kode & Nama Jurusan POLIJE (A - I)
    public function getKodeJurusan(): string
    {
        return substr($this->nim, 0, 1);
    }

    public function getJurusan(): string
    {
        return match ($this->getKodeJurusan()) {
            'A' => 'Produksi Pertanian',
            'B' => 'Teknologi Pertanian',
            'C' => 'Peternakan',
            'D' => 'Manajemen Agribisnis',
            'E' => 'Teknologi Informasi',
            'F' => 'Bahasa, Komunikasi, dan Pariwisata',
            'G' => 'Kesehatan',
            'H' => 'Teknik',
            'I' => 'Bisnis',
            default => 'Jurusan Tidak Diketahui',
        };
    }

    // Digit 2 (index 1): Jenjang Pendidikan
    public function getJenjang(): string
    {
        return match (substr($this->nim, 1, 1)) {
            '3' => 'Diploma Tiga (D3)',
            '4' => 'Sarjana Terapan (D4)',
            '5' => 'Magister Terapan (S2)',
            default => 'Jenjang Tidak Diketahui',
        };
    }

    // Digit 1-3 (index 0, panjang 3): Kode & Nama Program Studi sesuai Jurusan
    public function getKodeProdi(): string
    {
        return substr($this->nim, 0, 3);
    }

    public function getProdiDariNim(): string
    {
        return match ($this->getKodeProdi()) {
            // A - Jurusan Produksi Pertanian
            'A31' => 'D3 Produksi Tanaman Hortikultura',
            'A32' => 'D3 Produksi Tanaman Perkebunan',
            'A41' => 'D4 Teknik Produksi Benih',
            'A42' => 'D4 Teknologi Produksi Tanaman Pangan',
            'A43' => 'D4 Budidaya Tanaman Perkebunan',
            'A44' => 'D4 Pengelolaan Perkebunan Kopi',

            // B - Jurusan Teknologi Pertanian
            'B31' => 'D3 Keteknikan Pertanian',
            'B32' => 'D3 Teknologi Industri Pangan',
            'B41' => 'D4 Teknologi Rekayasa Pangan',

            // C - Jurusan Peternakan
            'C31' => 'D3 Produksi Ternak',
            'C41' => 'D4 Manajemen Bisnis Unggas',
            'C42' => 'D4 Teknologi Pakan Ternak',

            // D - Jurusan Manajemen Agribisnis
            'D31' => 'D3 Manajemen Agribisnis',
            'D41' => 'D4 Manajemen Agroindustri',
            'D42' => 'D4 Akuntansi Sektor Publik',
            'D43' => 'D4 Manajemen Pemasaran Internasional',

            // E - Jurusan Teknologi Informasi
            'E31' => 'D3 Manajemen Informatika',
            'E32' => 'D3 Teknik Komputer',
            'E41' => 'D4 Teknik Informatika',
            'E42' => 'D4 Teknologi Rekayasa Komputer',
            'E43' => 'D4 Bisnis Digital',

            // F - Jurusan Bahasa, Komunikasi, dan Pariwisata
            'F31' => 'D3 Bahasa Inggris',
            'F41' => 'D4 Destinasi Pariwisata',
            'F42' => 'D4 Produksi Media',

            // G - Jurusan Kesehatan
            'G41' => 'D4 Manajemen Informasi Kesehatan',
            'G42' => 'D4 Gizi Klinik',
            'G43' => 'D4 Promosi Kesehatan',

            // H - Jurusan Teknik
            'H41' => 'D4 Teknik Energi Terbarukan',
            'H42' => 'D4 Mesin Otomotif',
            'H43' => 'D4 Teknologi Rekayasa Mekatronika',
            'H44' => 'D4 Rekayasa Perangkat Mekanik',

            // I - Jurusan Bisnis
            'I31' => 'D3 Administrasi Bisnis',
            'I41' => 'D4 Akuntansi Sektor Publik',
            'I42' => 'D4 Manajemen Pemasaran Internasional',
            'I43' => 'D4 Logistik Perdagangan Internasional',

            default => 'Prodi ' . $this->getJurusan() . ' (' . $this->getKodeProdi() . ')',
        };
    }

    // Digit 4-5 (index 3, panjang 2): Tahun Angkatan dari NIM ("E41251140" -> "25" -> "2025")
    public function getAngkatanDariNim(): string
    {
        $tahun = substr($this->nim, 3, 2);
        return ctype_digit($tahun) ? '20' . $tahun : date('Y');
    }

    // Digit 6-9 (index 5, panjang 4): Nomor Urut Mahasiswa ("E41251140" -> "1140")
    public function getNomorUrut(): string
    {
        return substr($this->nim, 5, 4);
    }
}