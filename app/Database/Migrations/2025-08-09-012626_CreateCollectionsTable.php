<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCollectionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'post_id' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'orden' => [
                'type' => 'INT',
                'null' => true
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 40
            ],
            'created_at'     => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at'     => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at'     => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('collections');   
    }

    public function down()
    {
        $this->forge->dropTable('collections');
    }
}
