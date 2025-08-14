<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CollectionModel;
use CodeIgniter\HTTP\ResponseInterface;

class CollectionController extends BaseController
{
    protected $_collectionModel;

    public function __construct()
    {
        $this->_collectionModel = new CollectionModel();
    }
    public function index()
    {
        //
    }

    public function updateKey()
    {
        $newKey = $this->request->getPost('key');
        $collectionId = $this->request->getPost('collectionId');

        if (empty($newKey) || empty($collectionId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Datos incompletos'
            ]);
        }

        $updated = $this->_collectionModel
            ->where('id', $collectionId)
            ->set(['key' => $newKey])
            ->update();

        return $this->response->setJSON([
            'status' => $updated ? 'success' : 'error',
            'message' => $updated ? 'Clave actualizada' : 'No se pudo actualizar'
        ]);
    }


}
