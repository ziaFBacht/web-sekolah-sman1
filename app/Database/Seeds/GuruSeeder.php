<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        // Opsi mata pelajaran umum di SMA
        $mapelOptions = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 
            'Kimia', 'Biologi', 'Sejarah', 'Geografi', 
            'Ekonomi', 'Sosiologi', 'Pendidikan Agama', 'PJOK', 'Seni Budaya', 'Informatika'
        ];

        // Kumpulan nama dummy untuk diacak
        $firstNames = ['Budi', 'Siti', 'Agus', 'Sri', 'Joko', 'Endang', 'Iwan', 'Ratna', 'Eko', 'Dwi', 'Tri', 'Ahmad', 'Nur', 'Wahyu', 'Hendra'];
        $lastNames = ['Santoso', 'Wijaya', 'Susanti', 'Wahyuni', 'Setiawan', 'Lestari', 'Kurniawan', 'Hidayat', 'Purnomo', 'Sari', 'Pratama', 'Saputra'];
        
        // Kumpulan gelar akademik guru
        $gelar = ['S.Pd.', 'M.Pd.', 'S.Kom.', 'S.Si.', 'M.Si.', 'S.E.'];

        $data = [];

        // Generate 20 data guru secara acak
        for ($i = 0; $i < 20; $i++) {
            $nama = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)] . ', ' . $gelar[array_rand($gelar)];
            
            $data[] = [
                // Membuat NIP dummy (Format standar 18 digit: Tahun Lahir + Bulan + Tanggal + Kode)
                'nip'            => '19' . rand(70, 95) . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . '200' . rand(1, 9) . rand(1, 2) . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT), 
                'nama_lengkap'   => $nama,
                'mata_pelajaran' => $mapelOptions[array_rand($mapelOptions)],
                // Kolom user_id sengaja tidak disertakan agar bernilai NULL di database
            ];
        }

        // Insert semua data ke tabel 'guru' sekaligus (Batch Insert)
        $this->db->table('guru')->insertBatch($data);
    }
}