<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'collection_id' => [
                'type' => 'INT',
                'unsigned' => true
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
            'orden' => [
                'type' => 'INT',
                'null' => true
            ],
            'img' => [
                'type' => 'VARCHAR', 
                'constraint' => 255, 
                'null' => true
            ],
            'button' => [
                'type' => 'VARCHAR', 
                'constraint' => 100, 
                'null' => true
            ],
            'redirect' => [
                'type' => 'TEXT', 
                'null' => true
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 40
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('collection_id', 'collections', 'id', 'ReSTRICT', 'CASCADE');
        $this->forge->createTable('items');
    }

    public function down()
    {
        $this->forge->dropTable('items');
    }
}
