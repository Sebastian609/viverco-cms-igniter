<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveTipoFromSliders extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("sliders","tipo");
        $this->forge->dropColumn("sliders","orden");
    }

    public function down()
    {
        $this->forge->addColumn('sliders', [
            'tipo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'redirect' // Puedes ajustar según el orden original
            ],
            'orden' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'tipo' // Puedes ajustar según el orden original
            ],
        ]);
    }
}
