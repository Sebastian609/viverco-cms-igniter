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
        $sliders = $this->sliderModel->orderBy('orden', 'ASC')->findAll();
        return view('sliders/index', ['sliders' => $sliders]);
    }

    public function delete($id)
    {
        $slider = $this->sliderModel->find($id);
        if ($slider) {
            if (file_exists($slider['img'])) {
                unlink($slider['img']);
            }
            $this->sliderModel->delete($id);
        }
        return redirect()->to(base_url('slider'));
    }

    public function reorder()
    {
        $json = $this->request->getJSON(true);
        foreach ($json as $item) {
            $this->sliderModel->update($item['id'], [
                'orden' => $item['orden'],
            ]);
        }
        return $this->response->setJSON(['status' => 'success']);
    }

    public function create()
    {
        return view('sliders/create');
    }

    public function store()
    {
        $base64Image = $this->request->getPost('img');
        $imgPath = null;

        if (!$base64Image) {
            return redirect()->back()->withInput()->with('error', 'Debes seleccionar y recortar una imagen.');
        }

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        $fileName = uniqid('slider_') . '.jpg';
        $savePath = FCPATH . 'uploads/sliders/' . $fileName;
        file_put_contents($savePath, $imageData);
        $imgPath = 'uploads/sliders/' . $fileName;

        $maxOrden = $this->sliderModel->selectMax('orden')->first()['orden'] ?? 0;
        $order = $maxOrden + 1000.0;

        $this->sliderModel->save([
            'main_text'         => $this->request->getPost('main_text'),
            'secondary_text'    => $this->request->getPost('secondary_text'),
            'img'               => $imgPath,
            'orden'             => $order,
            'button'            => $this->request->getPost('button') ?? null,
            'redirect'          => $this->request->getPost('redirect') ?? null,
            'status'            => "active",
            'title_color'       => $this->request->getPost('title_color') ?? null,
            'content_color'     => $this->request->getPost('content_color') ?? null,
            'background_color'  => $this->request->getPost('background_color') ?? null,
            'button_text_color' => $this->request->getPost('button_text_color') ?? null,
            'button_color'      => $this->request->getPost('button_color') ?? null,
            'border_color'      => $this->request->getPost('border_color') ?? null,
            'position'          => $this->request->getPost('position') ?? 'left',
        ]);

        session()->setFlashdata('success', 'Slider creado correctamente.');
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
        if (!$slider) {
            return redirect()->to(base_url('slider'))->with('error', 'Slider no encontrado.');
        }

        $imgPath = $slider['img'];
        $base64Image = $this->request->getPost('img');

        if ($base64Image && str_starts_with($base64Image, 'data:image')) {
            if ($imgPath && file_exists(FCPATH . $imgPath)) {
                unlink(FCPATH . $imgPath);
            }
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $fileName = uniqid('slider_') . '.jpg';
            $savePath = FCPATH . 'uploads/sliders/' . $fileName;
            file_put_contents($savePath, $imageData);
            $imgPath = 'uploads/sliders/' . $fileName;
        }

        $updateData = [
            'main_text'         => $this->request->getPost('main_text'),
            'secondary_text'    => $this->request->getPost('secondary_text'),
            'img'               => $imgPath,
            'button'            => $this->request->getPost('button') ?? null,
            'redirect'          => $this->request->getPost('redirect') ?? null,
            'status'            => $this->request->getPost('status'),
            'title_color'       => $this->request->getPost('title_color') ?? null,
            'content_color'     => $this->request->getPost('content_color') ?? null,
            'background_color'  => $this->request->getPost('background_color') ?? null,
            'button_text_color' => $this->request->getPost('button_text_color') ?? null,
            'button_color'      => $this->request->getPost('button_color') ?? null,
            'border_color'      => $this->request->getPost('border_color') ?? null,
            'position'          => $this->request->getPost('position') ?? 'left',
        ];

        // Evitar sobrescribir imagen si no se subió nueva
        if (empty($base64Image)) {
            unset($updateData['img']);
        }

        $this->sliderModel->update($id, $updateData);

        return redirect()->to(base_url('slider'))->with('success', 'Slider actualizado correctamente.');
    }
}
