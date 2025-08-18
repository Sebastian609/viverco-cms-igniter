<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FooterModel;

class FooterController extends BaseController
{
    protected $footerModel;

    public function __construct()
    {
        $this->footerModel = new FooterModel();
    }

    public function index()
    {
        $footer = $this->footerModel->first() ?? [];
        return view('footer/index', ['footer' => $footer]);
    }

    public function update()
    {
        $data = $this->request->getPost();
        try {
            $first = $this->footerModel->first();

            if (is_null($first)) {
                // Insertar si no existe
                $this->footerModel->insert($data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Footer creado correctamente'
                ]);
            }

            // Actualizar el único registro
            $this->footerModel->update($first['id'], $data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Footer actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Ocurrió un error: ' . $e->getMessage()
            ]);
        }
    }
}
