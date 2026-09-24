<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nisn'         => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 100],
            'kelas'        => ['type' => 'VARCHAR', 'constraint' => 10], // X, XI, XII
            'jurusan'      => ['type' => 'VARCHAR', 'constraint' => 50], // MIPA, IPS
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}