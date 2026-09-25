<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddSubteksToBerita extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita', [
            'subteks' => ['type' => 'VARCHAR', 'constraint' => 500, 'after' => 'kategori', 'null' => true]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('berita', 'subteks');
    }
}