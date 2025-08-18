<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MessageModel;

class MessageController extends BaseController
{
    public function store()
    {
        $messageModel = new MessageModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'message' => $this->request->getPost('message'),
        ];

        $messageModel->insert($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Mensaje enviado correctamente'
        ]);
    }

    public function index()
    {
        $messageModel = new MessageModel();

        // Traer 10 registros por página
        $data['messages'] = $messageModel->paginate(10);

        // Enviar también el objeto de paginación
        $data['pager'] = $messageModel->pager;

        return view('message/index', $data);
    }

}
