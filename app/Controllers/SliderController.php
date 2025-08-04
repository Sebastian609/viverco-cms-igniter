<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class SliderController extends BaseController
{
    protected $sliderModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $data['sliders'] = $this->sliderModel->findAll();
        return view('sliders/index', $data);
    }

    public function create()
    {
        return view('sliders/create');
    }



    public function store()
    {
        $file = $this->request->getFile('img');
        $imgPath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $file->move('uploads/sliders/');
            $imgPath = 'uploads/sliders/' . $file->getName();
        }

        $maxOrden = $this->sliderModel->selectMax('orden')->first()['orden'] ?? 0;
        $order = $maxOrden + 1000.0; 

        $this->sliderModel->save([
            'main_text' => $this->request->getPost('main_text'),
            'secondary_text' => $this->request->getPost('secondary_text'),
            'img' => $imgPath,
            'orden' => $order,
            'button' => $this->request->getPost('button') ?? null,
            'redirect' => $this->request->getPost('redirect') ?? null,
            'status' => "active",
        ]);

       return redirect()->to(base_url('slider'));

    }

    public function edit($id)
    {
        $data['slider'] = $this->sliderModel->find($id);
        return view('sliders/edit', $data);
    }

    public function update($id)
    {
        $slider = $this->sliderModel->find($id);
        $file = $this->request->getFile('img');
        $imgPath = $slider['img'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $file->move('uploads/sliders/');
            $imgPath = 'uploads/sliders/' . $file->getName();
        }

        $this->sliderModel->update($id, [
            'main_text' => $this->request->getPost('main_text'),
            'secondary_text' => $this->request->getPost('secondary_text'),
            'img' => $imgPath,
            'button' => $this->request->getPost('button') ?? null,
            'redirect' => $this->request->getPost('redirect') ?? null,
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('slider'));

    }
}
