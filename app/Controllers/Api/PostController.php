<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CollectionModel;
use App\Models\ItemModel;

class PostController extends ResourceController
{
    protected $modelName = 'App\Models\PostModel';
    protected $format = 'json';

    public function index()
    {
        $collectionModel = new CollectionModel();
        $itemModel       = new ItemModel();

        // 1. Obtener todos los posts activos
        $posts = $this->model
            ->where('status', 'active')
            ->orderBy('orden', 'ASC')
            ->findAll() ?? [];

        // 2. Recorrer cada post
        foreach ($posts as &$post) {
            // 2.1 Obtener colecciones relacionadas a este post
            $collections = $collectionModel
                ->where('post_id', $post['id'])
                ->where('status', 'active')
                ->orderBy('orden', 'ASC')
                ->findAll();

            // 2.2 Recorrer cada colección para obtener sus items
            foreach ($collections as &$collection) {
                $items = $itemModel
                    ->where('collection_id', $collection['id'])
                    ->where('status', 'active')
                    ->orderBy('orden', 'ASC')
                    ->findAll();
                $collection['items'] = $items;
            }

            // 2.3 Asignar las colecciones al post
            $post['collections'] = $collections;
        }

        return $this->respond($posts);
    }
}
