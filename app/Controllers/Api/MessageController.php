<?php

namespace App\Controllers\Api;

use App\Models\MessageModel;
use CodeIgniter\RESTful\ResourceController;

class MessageController extends ResourceController
{
    protected $modelName = MessageModel::class;
    protected $format    = 'json';

    public function create()
    {
        // Obtener el JSON como array asociativo
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->failValidationError('No se recibieron datos válidos en JSON');
        }
        $data['create_at'] = getdate();

        // Insertar en la base de datos
        if (!$this->model->insert($data)) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Mensaje creado exitosamente',
            'id'      => $this->model->getInsertID(),
        ]);
    }

}
