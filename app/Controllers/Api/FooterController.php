<?php

namespace App\Controllers\Api;
use App\Models\FooterModel;
use CodeIgniter\RESTful\ResourceController;

class FooterController extends ResourceController
{
    protected $modelName = FooterModel::class;
    protected $format    = 'json';

    public function index()
    {
        $footer = $this->model->first() ?? [];
        return $this->respond($footer);
    }
}
