<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CompanyContactModel;
use CodeIgniter\HTTP\ResponseInterface;

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
        // Validar iframe
        if (!empty($data['maps_url'])) {
            if (!preg_match('/<iframe[^>]+src="https:\/\/www\.google\.com\/maps\/embed[^"]+"[^>]*><\/iframe>/i', trim($data['maps_url']))) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'El iframe no es válido. Solo se permiten iframes de Google Maps.'
                ]);
            }
        }

        $first = $this->companyConctactModel->first();

        if (is_null($first)) {
            $this->companyConctactModel->insert($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Contacto creado correctamente'
            ]);
        }

        $this->companyConctactModel->update($first['id'], $data);

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
