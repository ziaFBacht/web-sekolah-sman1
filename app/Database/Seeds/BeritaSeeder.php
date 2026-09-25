<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $kategoriList = ['Pendidikan', 'Artikel', 'Prestasi', 'Kegiatan', 'Pengumuman'];

        for ($i = 1; $i <= 15; $i++) {
            $kategori = $kategoriList[array_rand($kategoriList)];
            
            // Variasi judul
            $judul = "Simulasi Berita Dummy Ke-{$i} Kategori {$kategori}";
            $slug = url_title($judul, '-', true) . '-' . time() . rand(100, 999);
            
            // Subteks singkat untuk tampilan depan
            $subteks = "Ini adalah ringkasan atau subteks untuk berita dummy ke-{$i}. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
            
            // Konten panjang bergaya Rich Text Editor (HTML)
            $konten = "
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <h3>Sub Judul Berita {$i}</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <ul>
                    <li>Poin penting pertama dari berita ini.</li>
                    <li>Poin penting kedua sebagai pelengkap informasi.</li>
                    <li>Poin ketiga yang merangkum keseluruhan acara.</li>
                </ul>
                <p>Informasi lebih lanjut dapat diakses melalui portal resmi sekolah. Terima kasih atas perhatiannya.</p>
            ";

            // Mengacak tanggal publikasi dari 1 hingga 30 hari ke belakang
            $hariAcak = rand(1, 30);
            $tanggalDibuat = date('Y-m-d H:i:s', strtotime("-{$hariAcak} days"));

            $data[] = [
                'judul'      => $judul,
                'slug'       => $slug,
                'kategori'   => $kategori,
                'subteks'    => $subteks,
                'konten'     => $konten,
                'thumbnail'  => null, // Sengaja null agar jatuh ke gambar placeholder SMAN 1
                'status'     => 'published',
                'user_id'    => 1, // Asumsi ID admin utama adalah 1
                'created_at' => $tanggalDibuat,
                'updated_at' => $tanggalDibuat,
            ];
        }

        // Insert ke database
        $this->db->table('berita')->insertBatch($data);
    }
}