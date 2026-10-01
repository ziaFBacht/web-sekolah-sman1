<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        // Opsi untuk kelas dan jurusan sesuai permintaan
        $kelasOptions = ['X', 'XI', 'XII'];
        $jurusanOptions = ['MIPA', 'IPS'];

        // Kumpulan nama dummy untuk diacak
        $firstNames = ['Ahmad', 'Budi', 'Siti', 'Rina', 'Joko', 'Ayu', 'Rizky', 'Putri', 'Dewi', 'Wahyu', 'Dimas', 'Lina', 'Fajar', 'Ratna', 'Gilang'];
        $lastNames = ['Santoso', 'Wijaya', 'Pratama', 'Sari', 'Kurniawan', 'Lestari', 'Saputra', 'Indah', 'Setiawan', 'Hidayat', 'Mahendra', 'Permatasari', 'Nugroho', 'Kusuma', 'Pangestu'];

        $data = [];

        // Generate 20 data siswa secara acak
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                // Membuat NISN dummy (10 digit)
                'nisn'         => '005' . rand(1000000, 9999999), 
                'nama_lengkap' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                'kelas'        => $kelasOptions[array_rand($kelasOptions)],
                'jurusan'      => $jurusanOptions[array_rand($jurusanOptions)],
                
                // Timestamp standar
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
                
                // Kolom user_id sengaja tidak disertakan agar bernilai NULL di database
            ];
        }

        // Insert semua data ke tabel 'siswa' sekaligus (Batch Insert)
        $this->db->table('siswa')->insertBatch($data);
    }
}
