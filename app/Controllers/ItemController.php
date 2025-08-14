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
        // Obtener el array de orden desde el POST
        $orderData = $this->request->getPost('order');

        if (!$orderData || !is_array($orderData)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos de orden inválidos']);
        }

        try {
            foreach ($orderData as $item) {
                if (isset($item['id']) && isset($item['orden'])) {
                    $this->itemModel->update($item['id'], [
                        'orden' => $item['orden']
                    ]);
                }
            }

            return $this->response->setJSON(['status' => 'success', 'message' => 'Orden actualizado correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al actualizar el orden: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Item not found.");
        }
        if ($item['img']) {
            unlink(FCPATH . $item['img']);
        }

        $collection = $this->itemModel
            ->select('collection_id')
            ->where('id', $item['id'])
            ->first();


        $this->itemModel->delete($id);


        $collectionData = $this->collectionModel
            ->select('post_id')
            ->where('id', $collection['collection_id'])
            ->first();

        $postId = $collectionData['post_id'];

        // Redirigir usando PRG
        return redirect()->to('/post/edit/' . $postId)
            ->with('success', 'Registro actualizado correctamente.');
    }

    public function update($id)
    {
        // Obtener solo el nombre de la imagen actual
        $itemImg = $this->itemModel
            ->select('img')
            ->find($id);

        $rules = [
            'title_item' => 'required|string|min_length[2]|max_length[255]',
            'copy_item' => 'required|string|min_length[3]|max_length[1000]',
            'button' => 'permit_empty|string|min_length[2]|max_length[100]',
            'redirect' => 'permit_empty|string|min_length[2]|max_length[1000]',
            'img_item' => 'permit_empty|is_image[img_item]|mime_in[img_item,image/jpg,image/jpeg,image/png]|max_size[img_item,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title_item'),
            'copy' => $this->request->getPost('copy_item'),
            'button' => $this->request->getPost('button'),
            'redirect' => $this->request->getPost('redirect'),
        ];

        // Procesar imagen solo si el usuario subió una nueva
        $imgFile = $this->request->getFile('img_item');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {

            // Borrar imagen anterior si existe
            if (!empty($itemImg['img']) && file_exists(FCPATH . $itemImg['img'])) {
                unlink(FCPATH . $itemImg['img']);
            }

            // Guardar la nueva imagen
            $newName = $imgFile->getRandomName();
            $imgFile->move(FCPATH . 'uploads/items', $newName);
            $data['img'] = 'uploads/items/' . $newName;
        }

        // Actualizar en la base de datos
        $collection = $this->itemModel
            ->select('collection_id')
            ->where('id', $id)
            ->first();

        $this->itemModel->update($id, $data);

        $collectionData = $this->collectionModel
            ->select('post_id')
            ->where('id', $collection['collection_id'])
            ->first();

        $postId = $collectionData['post_id'];

        // Redirigir usando PRG
        return redirect()->to('/post/edit/' . $postId)
            ->with('success', 'Registro actualizado correctamente.');

    }


    public function edit($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Item not found.");
        }

        return view('items/edit', [
            'item' => $item,
        ]);
    }


    public function create($collectionId)
    {
        try {
            // Calcular nuevo orden
            $order = $this->itemModel
                ->where('collection_id', $collectionId)
                ->selectMax('orden')
                ->first()['orden'] ?? 0;
            $order += 1000.0;

            // Datos del formulario
            $button = $this->request->getPost('button_item') ?: null;
            $redirect = $this->request->getPost('redirect_item') ?: null;
            $imgPath = null;

            // Imagen (opcional)
            $file = $this->request->getFile('img_item');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validar solo si hay archivo
                $validated = $this->validate([
                    'img_item' => [
                        'mime_in[img_item,image/jpg,image/jpeg,image/png]',
                        'max_size[img_item,4096]',
                    ]
                ]);

                if (!$validated) {
                    log_message('error', 'Validación de imagen falló: ' . json_encode($this->validator->getErrors()));
                    return redirect()->back()->withInput()->with('error', 'Imagen inválida o muy grande.');
                }

                // Crear carpeta si no existe
                $uploadDir = FCPATH . 'uploads/items';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Mover imagen
                $newName = $file->getRandomName();
                if (!$file->move($uploadDir, $newName)) {
                    log_message('error', 'No se pudo mover el archivo: ' . $file->getError());
                    return redirect()->back()->withInput()->with('error', 'Error al subir la imagen.');
                }

                $imgPath = 'uploads/items/' . $newName;
            }

            // Preparar datos
            $itemData = [
                'collection_id' => $collectionId,
                'title' => $this->request->getPost('title_item'),
                'copy' => $this->request->getPost('copy_item'),
                'orden' => $order,
                'status' => 'active',
                'img' => $imgPath, // Puede ser null
                'button' => $button,
                'redirect' => $redirect
            ];

            // Insertar en BD
            if (!$this->itemModel->insert($itemData)) {
                if ($imgPath && file_exists(FCPATH . $imgPath)) {
                    unlink(FCPATH . $imgPath);
                }
                return redirect()->back()->withInput()->with('error', 'Error al crear el item en la base de datos.');
            }

            // Redirigir al post padre
            $post = $this->collectionModel
                ->select('post_id')
                ->where('id', $collectionId)
                ->first();

            if (!$post) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post not found.");
            }

            return redirect()->to("/post/edit/" . $post['post_id'])
                ->with('success', 'Item creado correctamente.');
        } catch (\Exception $e) {
            log_message('error', 'Error general al crear item: ' . $e->getMessage());
            if (isset($imgPath) && $imgPath && file_exists(FCPATH . $imgPath)) {
                unlink(FCPATH . $imgPath);
            }
            return redirect()->back()->withInput()->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }
}