<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyContactModel;
class CompanyContactController extends BaseController
{
    protected $companyConctactModel;

    public function __construct()
    {
        $this->companyConctactModel = new CompanyContactModel();
    }
    public function index()
    {
        $contact = $this->companyConctactModel->first() ?? [];
        return view('contact/index', ['contact' => $contact]);
    }


    public function update()
    {
        $data = $this->request->getPost();

        try {
            $base64Image = $this->request->getPost('img');

            // Solo procesar la imagen si existe
            if (!empty($base64Image)) {
                // Limpiar el encabezado base64
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                // Crear carpeta company si no existe
                $uploadPath = FCPATH . 'uploads/company/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generar nombre de archivo único
                $fileName = uniqid('company_') . '.jpg';
                $savePath = $uploadPath . $fileName;

                // Guardar imagen en el servidor
                file_put_contents($savePath, $imageData);

                // Agregar la ruta al array de datos solo si se subió
                $data['img'] = 'uploads/company/' . $fileName;
            }

            // Validar y normalizar iframe si existe
            if (!empty($data['maps_url'])) {
                if (!preg_match('/<iframe[^>]+src="https:\/\/www\.google\.com\/maps\/embed[^"]+"[^>]*><\/iframe>/i', trim($data['maps_url']))) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'El iframe no es válido. Solo se permiten iframes de Google Maps.'
                    ]);
                }

                // Forzar width y height
                $data['maps_url'] = preg_replace(
                    ['/width="\d*"/', '/height="\d*"/'],
                    ['width="1200"', 'height="400"'],
                    $data['maps_url']
                );
            }

            $first = $this->companyConctactModel->first();

            if (is_null($first)) {
                // Insertar nuevo contacto
                $this->companyConctactModel->insert($data);
            } else {
                // Actualizar solo campos enviados
                $updateData = $data;
                if (empty($base64Image)) {
                    unset($updateData['img']);
                }
                $this->companyConctactModel->update($first['id'], $updateData);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Contacto actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Ocurrió un error: ' . $e->getMessage()
            ]);
        }
    }




}
