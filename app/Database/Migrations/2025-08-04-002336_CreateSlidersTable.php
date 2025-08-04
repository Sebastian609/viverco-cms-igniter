<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSlidersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'main_text' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'secondary_text'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'img'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'button'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'redirect' => ['type' => 'TEXT', 'null' => true],
            'tipo'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'orden'           => ['type' => 'INT', 'null' => true],
            'status'          => ['type' => 'VARCHAR', 'constraint' => 40],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sliders');
    }

    public function down()
    {
        $this->forge->dropTable('sliders');
    }
}
