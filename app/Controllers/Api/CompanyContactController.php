<?php

namespace App\Controllers\Api;

use App\Models\CompanyContactModel;
use CodeIgniter\RESTful\ResourceController;

class CompanyContactController extends ResourceController
{
    protected $modelName = CompanyContactModel::class;
    protected $format    = 'json';

    public function index()
    {
        $contact = $this->model->first() ?? [];
        return $this->respond($contact);
    }
}
