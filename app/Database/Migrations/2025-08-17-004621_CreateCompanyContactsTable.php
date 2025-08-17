<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompanyContactsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'maps_url' => [
                'type' => 'TEXT'
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 1000
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => false,
                'default' => 'active'
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
        $this->forge->createTable('company_contacts');
    }

    public function down()
    {
        $this->forge->dropTable('company_contacts');
    }
}
