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
            // Eliminar la imagen del servidor si existe
            if (file_exists($slider['img'])) {
                unlink($slider['img']);
            }
            $this->sliderModel->delete($id);
        }
        return redirect()->to(base_url('slider'));
    }

    public function reorder()
    {
        $json = $this->request->getJSON(true); // Recibe array JSON con id y orden

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

        }   // Si no hay imagen, redireccionar con error
      // Limpiar el encabezado base64 (por ejemplo: "data:image/jpeg;base64,...")
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Generar nombre de archivo único
        $fileName = uniqid('slider_') . '.jpg';
        $savePath = FCPATH . 'uploads/sliders/' . $fileName;

        // Guardar imagen en el servidor
        file_put_contents($savePath, $imageData);

        // Ruta que se guarda en base de datos
        $imgPath = 'uploads/sliders/' . $fileName;

        // Calcular orden
        $maxOrden = $this->sliderModel->selectMax('orden')->first()['orden'] ?? 0;
        $order = $maxOrden + 1000.0;

        // Guardar en base de datos
        $this->sliderModel->save([
            'main_text' => $this->request->getPost('main_text'),
            'secondary_text' => $this->request->getPost('secondary_text'),
            'img' => $imgPath,
            'orden' => $order,
            'button' => $this->request->getPost('button') ?? null,
            'redirect' => $this->request->getPost('redirect') ?? null,
            'status' => "active",
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

    $imgPath = $slider['img']; // Mantener la imagen actual si no se cambia
    $base64Image = $this->request->getPost('img');

    // Si se recortó una nueva imagen (desde Cropper)
    if ($base64Image && str_starts_with($base64Image, 'data:image')) {
        // Eliminar la imagen anterior si existe físicamente
        if ($imgPath && file_exists(FCPATH . $imgPath)) {
            unlink(FCPATH . $imgPath);
        }

        // Decodificar y guardar nueva imagen
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $fileName = uniqid('slider_') . '.jpg';
        $savePath = FCPATH . 'uploads/sliders/' . $fileName;
        file_put_contents($savePath, $imageData);

        $imgPath = 'uploads/sliders/' . $fileName;
    }

    // Actualizar los datos del slider
    $this->sliderModel->update($id, [
        'main_text'      => $this->request->getPost('main_text'),
        'secondary_text' => $this->request->getPost('secondary_text'),
        'img'            => $imgPath,
        'button'         => $this->request->getPost('button') ?? null,
        'redirect'       => $this->request->getPost('redirect') ?? null,
        'status'         => $this->request->getPost('status'),
    ]);

    return redirect()->to(base_url('slider'))->with('success', 'Slider actualizado correctamente.');
}

}
