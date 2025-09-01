<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToCompanyContactsTable extends Migration
{
    public function up()
    {
        $fields = [
            'img' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // permite que sea opcional
            ],
        ];

        $this->forge->addColumn('company_contacts', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('company_contacts', 'img');
    }
}
