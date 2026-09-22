<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'adminutama',
            // Password default: admin123
            'password'   => password_hash('admin123', PASSWORD_BCRYPT),
            'role'       => 'admin',
            'email'      => '',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($data);
    }
}