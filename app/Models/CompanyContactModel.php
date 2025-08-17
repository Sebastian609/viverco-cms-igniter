<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyContactModel extends Model
{
    protected $table            = 'company_contacts'; // 👈 ojo: el nombre correcto de la tabla
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // porque en tu migración existe deleted_at
    protected $protectFields    = true;

    // Campos que sí se pueden insertar/actualizar
    protected $allowedFields    = [
        'email',
        'phone',
        'maps_url',
        'address',
        'status',
    ];

    // Fechas automáticas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (puedes añadir reglas si quieres validaciones automáticas)
    protected $validationRules = [
        'email'   => 'required|valid_email|max_length[255]',
        'phone'   => 'permit_empty|max_length[20]',
        'address' => 'required|string|max_length[1000]',
        'status'  => 'in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'email' => [
            'required'    => 'El correo es obligatorio.',
            'valid_email' => 'El correo debe tener un formato válido.',
        ],
        'status' => [
            'in_list' => 'El estado solo puede ser "active" o "inactive".',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks (si necesitas lógica antes/después de guardar)
    protected $allowCallbacks = true;
}
