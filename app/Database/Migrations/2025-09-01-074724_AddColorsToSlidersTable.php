<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorsToSlidersTable extends Migration
{
    public function up()
    {
        // Agregar campos de personalización de CTA
        $fields = [
            'title_color'      => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true], // Ej: #FFFFFF
            'content_color'    => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'background_color' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'button_text_color' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'button_color'     => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'border_color'     => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'position'         => ['type' => 'ENUM', 'constraint' => ['left','right'], 'default' => 'left'],
        ];

        $this->forge->addColumn('sliders', $fields);
    }

    public function down()
    {
        $columns = [
            'title_color',
            'content_color',
            'background_color',
            'button_text_color',
            'button_color',
            'border_color',
            'position',
        ];

        foreach ($columns as $column) {
            $this->forge->dropColumn('sliders', $column);
        }
    }
}
