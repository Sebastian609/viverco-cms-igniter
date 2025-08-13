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
        $this->itemModel->delete($id);
        return redirect()->back()->with('success', 'Item eliminado correctamente');
    }

    public function edit($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Item not found.");
        }
        return view('items/edit', ['item' => $item]);
    }

    public function create($collectionId)
    {
        try {
            // Debug: Log de datos recibidos
            log_message('info', '=== CREATING ITEM ===');
            log_message('info', 'Collection ID: ' . $collectionId);
            log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
            log_message('info', 'Files: ' . json_encode($this->request->getFiles()));
            log_message('info', 'Request method: ' . $this->request->getMethod());
            
            // Debug: Verificar si hay archivos
            $files = $this->request->getFiles();
            log_message('info', 'Archivos recibidos: ' . json_encode($files));
            
            if (empty($files)) {
                log_message('error', 'NO HAY ARCHIVOS EN LA REQUEST');
            } else {
                foreach ($files as $key => $file) {
                    log_message('info', 'Archivo ' . $key . ': ' . json_encode($file));
                }
            }
            
            // Calcular nuevo orden dentro de la colección específica
            $order = $this->itemModel
                ->where('collection_id', $collectionId)
                ->selectMax('orden')
                ->first()['orden'] ?? 0;
            $order += 1000.0;

            // Obtener datos del formulario
            $button = $this->request->getPost('button_item') ?: null;
            $redirect = $this->request->getPost('redirect_item') ?: null;

            // Manejo de imagen
            $imgPath = null;
            $file = $this->request->getFile('img_item');

            if (!$file || !$file->isValid()) {
                log_message('error', 'Archivo no válido o no recibido');
                return redirect()->back()->withInput()->with('error', 'Debes seleccionar una imagen válida.');
            }

            if ($file->hasMoved()) {
                log_message('error', 'Archivo ya fue movido');
                return redirect()->back()->withInput()->with('error', 'Error con la imagen.');
            }

            // Validar extensión y tamaño
            $validated = $this->validate([
                'img_item' => [
                    'uploaded[img_item]',
                    'mime_in[img_item,image/jpg,image/jpeg,image/png]',
                    'max_size[img_item,4096]',
                ]
            ]);

            if (!$validated) {
                log_message('error', 'Validación falló: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->withInput()->with('error', 'Imagen inválida o muy grande.');
            }

            // Crear directorio si no existe
            $uploadDir = FCPATH . 'uploads/items';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Mover archivo
            $newName = $file->getRandomName();
            if (!$file->move($uploadDir, $newName)) {
                log_message('error', 'No se pudo mover el archivo: ' . $file->getError());
                return redirect()->back()->withInput()->with('error', 'Error al subir la imagen.');
            }

            $imgPath = 'uploads/items/' . $newName;
            log_message('info', 'Imagen guardada en: ' . $imgPath);

            // Preparar datos para inserción
            $itemData = [
                'collection_id' => $collectionId,
                'title' => $this->request->getPost('title_item'),
                'copy' => $this->request->getPost('copy_item'),
                'orden' => $order,
                'status' => 'active',
                'img' => $imgPath,
                'button' => $button,
                'redirect' => $redirect
            ];

            log_message('info', 'Datos del item a insertar: ' . json_encode($itemData));

            // Insertar nuevo item
            $inserted = $this->itemModel->insert($itemData);

            if (!$inserted) {
                log_message('error', 'Error al insertar item: ' . json_encode($this->itemModel->errors()));

                // Eliminar imagen si falla la inserción
                if (file_exists(FCPATH . $imgPath)) {
                    unlink(FCPATH . $imgPath);
                }

                return redirect()->back()->withInput()->with('error', 'Error al crear el item en la base de datos.');
            }

            log_message('info', 'Item creado exitosamente con ID: ' . $inserted);

            // Obtener el post padre
            $post = $this->collectionModel
                ->select('post_id')
                ->where('id', $collectionId)
                ->first();

            if (!$post) {
                log_message('error', 'Post no encontrado para collection: ' . $collectionId);
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Post not found.");
            }

            log_message('info', 'Redirigiendo a post: ' . $post['post_id']);

            // Redirigir al editor del post
            return redirect()->to("/post/edit/" . $post['post_id'])
                ->with('success', 'Item creado correctamente.');

        } catch (\Exception $e) {
            log_message('error', 'Error general al crear item: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());

            // Si hay imagen subida, eliminarla
            if (isset($imgPath) && $imgPath && file_exists(FCPATH . $imgPath)) {
                unlink(FCPATH . $imgPath);
            }

            return redirect()->back()->withInput()->with('error', 'Error inesperado al crear el item: ' . $e->getMessage());
        }
    }
}