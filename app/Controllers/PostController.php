<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CollectionModel;
use App\Models\ItemModel;
use App\Models\PostModel;

class PostController extends BaseController
{
    protected $postModel;
    protected $collectionModel;
    protected $itemModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
        $this->collectionModel = new CollectionModel();
        $this->itemModel = new ItemModel();
    }
    public function index()
    {
        $posts = $this->postModel->orderBy('orden', 'ASC')->findAll();
        return view('post/index', ['posts' => $posts]);
    }

     public function reorder()
    {
        $json = $this->request->getJSON(true); // Recibe array JSON con id y orden

        foreach ($json as $item) {
            $this->postModel->update($item['id'], [
                'orden' => $item['orden'],
            ]);
        }
        return $this->response->setJSON(['status' => 'success']);
    }
    public function create()
    {
        // Obtener orden máximo de posts y calcular el nuevo
        $maxOrden = $this->postModel->selectMax('orden')->first()['orden'] ?? 0;
        $order = $maxOrden + 1000.0;

        // Crear post
        $id = $this->postModel->insert([
            'title' => '',
            'copy' => '',
            'orden' => $order,
            'status' => 'draft',
        ]);

        // Verificar si ya existe una colección activa para este post
        $hasCollection = $this->collectionModel
            ->where('post_id', $id)
            ->where('status', 'active')
            ->first();

        // Si no hay colección, crearla
        if (!$hasCollection) {
            $collectionMaxOrden = $this->collectionModel->selectMax('orden')->first()['orden'] ?? 0;
            $collectionOrder = $collectionMaxOrden + 1000.0;

            $this->collectionModel->insert([
                'post_id' => $id,
                'key' => 'services',
                'orden' => $collectionOrder,
                'status' => 'active',
            ]);
        }

        // Redirigir al editor
        return redirect()->to("/post/edit/$id");
    }


    public function update($id)
    {
        $post = $this->postModel->find($id);
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post with ID $id not found.");
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'copy' => $this->request->getPost('copy'),
            'status' => $this->request->getPost('status'),
        ];

        $this->postModel->update($id, $data);

        return redirect()->to('/post');
    }

    public function delete($id)
    {
        $post = $this->postModel->find($id);
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post with ID $id not found.");
        }

        // Eliminar la colección asociada
        $this->collectionModel->where('post_id', $id)->delete();

        // Eliminar el post
        $this->postModel->delete($id);

        return redirect()->to('/post');
    }


    public function edit($id)
    {
        $post = $this->postModel
            ->select('id, title, copy, status') // solo columnas necesarias
            ->where('id', $id)
            ->first();

        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post with ID $id not found.");
        }

        $collection = $this->collectionModel->where('post_id', $id)->where('status', 'active')->first();
        if (!$collection) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(message: "Colection not found.");
        }

        $items = $this->itemModel
            ->where('collection_id', $collection['id'])
            ->orderBy('orden', 'ASC')
            ->findAll() ?? [];

        return view('post/edit', ['post' => $post, 'collection' => $collection, 'items' => $items]);
    }

}
