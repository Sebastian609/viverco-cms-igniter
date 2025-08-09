<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'orden'          => [
                'type' => 'INT',
                'null' => true
            ],
            'title'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'copy'           => [
                'type' => 'TEXT',
                'null' => true
            ],
            'status'         => [
                'type'       => 'VARCHAR',
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
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
