<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nip', 'nama_lengkap', 'mata_pelajaran', 'user_id'];
    protected $useTimestamps    = false;
}