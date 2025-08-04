<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderToSliders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sliders', [
            'orden' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'redirect', // Puedes ajustarlo según el orden deseado
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sliders', 'orden');
    }
}
