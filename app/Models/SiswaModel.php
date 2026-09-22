<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nisn', 'nama_lengkap', 'kelas', 'jurusan', 'user_id'];
    protected $useTimestamps    = true;
}