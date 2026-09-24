<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], // ID admin yang melakukan aksi
            'action'     => ['type' => 'VARCHAR', 'constraint' => 50], // Contoh: 'INSERT', 'UPDATE', 'DELETE'
            'table_name' => ['type' => 'VARCHAR', 'constraint' => 50], // Contoh: 'siswa', 'guru'
            'record_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true], // ID data yang diubah/dihapus
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('audit_logs');
    }

    public function down()
    {
        $this->forge->dropTable('audit_logs');
    }
}