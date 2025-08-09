<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class SliderController extends ResourceController
{
    protected $modelName = 'App\Models\SliderModel';
    protected $format = 'json';

    public function index()
    {
        $sliders = $this->model
            ->where('status', 'active')
            ->orderBy('orden', 'ASC')
            ->findAll();
        return $this->respond($sliders);
    }

    public function show($id = null)
    {
        $slider = $this->model->find($id);
        if (!$slider) {
            return $this->failNotFound('Slider no encontrado.');
        }
        return $this->respond($slider);
    }

}
