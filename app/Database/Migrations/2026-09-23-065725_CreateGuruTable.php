<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nip'            => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nama_lengkap'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'mata_pelajaran' => ['type' => 'VARCHAR', 'constraint' => 100],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}