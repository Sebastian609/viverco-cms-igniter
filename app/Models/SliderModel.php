<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table            = 'sliders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'main_text',
        'secondary_text',
        'img',
        'button',
        'redirect',
        'tipo',
        'orden',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        // NUEVOS CAMPOS DE PERSONALIZACIÓN DE CTA (sin prefijo)
        'title_color',
        'content_color',
        'background_color',
        'button_text_color',
        'button_color',
        'border_color',
        'position',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
