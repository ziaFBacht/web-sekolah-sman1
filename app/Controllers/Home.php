<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // return view('welcome_message');
        return view('pages/home');
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil Sekolah'
        ];
        
        return view('pages/profil', $data);
    }

   public function berita()
    {
        $beritaModel = new \App\Models\BeritaModel();
        $db = \Config\Database::connect(); // Panggil koneksi DB untuk sanitasi manual
        
        $keyword = $this->request->getGet('q');
        $kategoriFilter = $this->request->getGet('kategori');
        
        $builder = $beritaModel->select('berita.*, users.username as penulis')
                               ->join('users', 'users.id = berita.user_id', 'left')
                               ->where('berita.status', 'published');
        
        // Fitur Search Bar (Pencarian Kata Utuh Tanpa Error CI4)
        if ($keyword) {
            // Escape keyword secara manual agar aman dari SQL Injection
            $escapedKeyword = $db->escapeString($keyword);
            
            // Gunakan sintaks batas kata klasik MariaDB/MySQL
            $regex = '[[:<:]]' . $escapedKeyword . '[[:>:]]';
            
            $builder->groupStart()
                    // Parameter 'false' mencegah CI4 menambahkan tanda '=' secara otomatis
                    ->where("berita.judul REGEXP '$regex'", null, false)
                    ->orWhere("berita.subteks REGEXP '$regex'", null, false)
                    ->orWhere("berita.konten REGEXP '$regex'", null, false)
                    ->groupEnd();
        }

        // Fitur Filter Kategori
        if ($kategoriFilter) {
            $builder->where('berita.kategori', $kategoriFilter);
        }

        // Paginasi 1 Halaman = 5 Berita
        $berita = $builder->orderBy('berita.created_at', 'DESC')->paginate(5);
        $pager = $beritaModel->pager;

        // Penghitungan (Counter) Berita per Kategori
        $kategoriCounts = $beritaModel->select('kategori, COUNT(id) as total')
                                      ->where('status', 'published')
                                      ->groupBy('kategori')
                                      ->findAll();
        
        $kategoriData = [];
        foreach($kategoriCounts as $k) {
            $kategoriData[$k['kategori']] = $k['total'];
        }

        $data = [
            'title'          => 'Portal Berita SMAN 1',
            'berita'         => $berita,
            'pager'          => $pager,
            'kategoriData'   => $kategoriData,
            'keyword'        => $keyword,
            'activeKategori' => $kategoriFilter
        ];
        
        return view('pages/berita', $data);
    }

    public function baca($slug = null)
    {
        $beritaModel = new \App\Models\BeritaModel();
        
        $berita = $beritaModel->getBeritaWithAuthor($slug);
        
        // Jika slug tidak ditemukan di database, lemparkan error 404
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $beritaTerbaru = $beritaModel->where('status', 'published')
                                     ->where('id !=', $berita['id'])
                                     ->orderBy('created_at', 'DESC')
                                     ->limit(5)
                                     ->findAll();

        $data = [
            'title'         => $berita['judul'],
            'berita'        => $berita,
            'beritaTerbaru' => $beritaTerbaru
        ];
        
        return view('pages/baca_berita', $data);
    }
}
