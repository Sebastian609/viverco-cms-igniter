<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CollectionModel;
use App\Models\ItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class ItemController extends BaseController
{
    protected $itemModel;
    protected $collectionModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->collectionModel = new CollectionModel();
    }
    public function index()
    {
        //
    }

    public function reorder()
    {
        $json = $this->request->getJSON(true); // Recibe array JSON con id y orden

        foreach ($json as $item) {
            $this->itemModel->update($item['id'], [
                'orden' => $item['orden'],
            ]);
        }
        return $this->response->setJSON(['status' => 'success']);
    }


    public function create($collectionId)
    {
        // Calcular nuevo orden dentro de la colección específica
        $order = $this->itemModel
            ->where('collection_id', $collectionId)
            ->selectMax('orden')
            ->first()['orden'] ?? 0;
        $order += 1000.0;

        // Obtener datos del formulario
        $button = $this->request->getPost('button') ?: null;
        $redirect = $this->request->getPost('redirect') ?: null;

        // Insertar nuevo item
        $this->itemModel->insert([
            'collection_id' => $collectionId,
            'title' => $this->request->getPost('title_item'),
            'copy' => $this->request->getPost('copy_item'),
            'orden' => $order,
            'status' => 'active',
            'img' => null,
            'button' => $button,
            'redirect' => $redirect
        ]);

        // Obtener el post padre
        $post = $this->collectionModel
            ->select('post_id')
            ->where('id', $collectionId)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post not found.");
        }

        // Redirigir al editor del post
        return redirect()->to("/post/edit/" . $post['post_id']);
    }

}
