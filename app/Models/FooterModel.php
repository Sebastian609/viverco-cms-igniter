<?php

namespace App\Models;

use CodeIgniter\Model;

class FooterModel extends Model
{
    protected $table            = 'footer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'main_text',
        'button_text',
        'redirect',
        'facebook_link',
        'instagram_link',
        'tiktok_link',
        'linkedin_link',
        'terms',
        'privacy'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // 🔹 Validaciones
    protected $validationRules = [
        'main_text'      => 'required|string|min_length[10]|max_length[1000]',
        'button_text'    => 'required|string|min_length[2]|max_length[255]',
        'redirect'       => 'required|valid_url',
        'facebook_link'  => 'permit_empty|valid_url',
        'instagram_link' => 'permit_empty|valid_url',
        'tiktok_link'    => 'permit_empty|valid_url',
        'linkedin_link'  => 'permit_empty|valid_url',
        'terms'          => 'required',
        'privacy'        => 'required',
    ];

    protected $validationMessages = [
        'main_text' => [
            'required' => 'El texto principal es obligatorio.',
            'min_length' => 'El texto principal debe tener al menos 10 caracteres.',
        ],
        'button_text' => [
            'required' => 'El texto del botón es obligatorio.',
        ],
        'redirect' => [
            'required' => 'El enlace de redirección es obligatorio.',
            'valid_url' => 'Debe ingresar una URL válida para la redirección.'
        ],
        'facebook_link' => [
            'valid_url' => 'El enlace de Facebook debe ser una URL válida.'
        ],
        'instagram_link' => [
            'valid_url' => 'El enlace de Instagram debe ser una URL válida.'
        ],
        'tiktok_link' => [
            'valid_url' => 'El enlace de TikTok debe ser una URL válida.'
        ],
        'linkedin_link' => [
            'valid_url' => 'El enlace de LinkedIn debe ser una URL válida.'
        ],
        'terms' => [
            'required' => 'El enlace de términos es obligatorio.',
            'valid_url' => 'El enlace de términos debe ser una URL válida.'
        ],
        'privacy' => [
            'required' => 'El enlace de privacidad es obligatorio.',
            'valid_url' => 'El enlace de privacidad debe ser una URL válida.'
        ],
    ];

    protected $skipValidation = false;
}
