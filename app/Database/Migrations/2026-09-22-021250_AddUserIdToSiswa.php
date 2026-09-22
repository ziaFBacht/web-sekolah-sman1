<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddUserIdToSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('siswa', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('siswa', 'user_id');
    }
}