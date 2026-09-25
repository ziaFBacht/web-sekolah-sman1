<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['judul', 'slug', 'kategori', 'subteks', 'konten', 'thumbnail', 'status', 'user_id'];

    // Otomatis mengurus created_at dan updated_at
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Fungsi tambahan untuk mengambil berita beserta nama penulisnya (berelasi dengan tabel users)
    public function getBeritaWithAuthor($slug = false)
    {
        if ($slug === false) {
            return $this->select('berita.*, users.username as penulis')
                        ->join('users', 'users.id = berita.user_id', 'left')
                        ->orderBy('berita.created_at', 'DESC')
                        ->findAll();
        }

        // PERBAIKAN: Gunakan 'berita.slug' secara eksplisit
        return $this->select('berita.*, users.username as penulis')
                    ->join('users', 'users.id = berita.user_id', 'left')
                    ->where('berita.slug', $slug)
                    ->first();
    }
}