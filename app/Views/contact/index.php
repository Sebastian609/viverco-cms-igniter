    <?= $this->extend('layouts/main') ?>
    <?= $this->section('content') ?>

    <div id="edit-contact">
        <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Datos de Contacto de la Empresa</h1>

        <div class="w-full bg-white border-2 rounded-md mx-auto p-8">
            <form id="form-contact" class="bg-white grid grid-cols-1 md:grid-cols-2 gap-6" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" id="email" placeholder="ejemplo@empresa.com"
                        value="<?= old('email', $contact['email'] ?? '') ?>"
                        class="w-full border rounded-md border-gray-300 p-3" required>
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="phone" id="phone" placeholder="+51 999 999 999"
                        value="<?= old('phone', $contact['phone'] ?? '') ?>"
                        class="w-full border rounded-md border-gray-300 p-3">
                </div>

                   <div >
                <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" id="img_input" accept="image/*" class="w-full border border-gray-300 p-3 rounded-lg bg-white file:mr-4 file:py-2 file:px-4
               file:rounded-lg file:border-0 file:text-sm file:font-semibold
               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200">

                <!-- Imagen recortada -->
                <div class="mt-4 space-y-3">
                    <img id="cropper_preview" :src="existingImage"
                     src="<?= isset($contact['img']) ? base_url($contact['img']) : '' ?>"
                        class="max-h-64  w-auto mx-auto border border-gray-200 rounded-lg shadow-sm object-contain">
          
                </div>

                <!-- Imagen en base64 -->
                <input type="hidden" name="img" id="cropped_image_data">
            </div>

                <!-- Dirección -->
                <div >
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <textarea name="address" id="address" rows="10" placeholder="Av. Ejemplo 123, Lima, Perú"
                        class="w-full border rounded-md border-gray-300 p-3"><?= old('address', $contact['address'] ?? '') ?></textarea>
                </div>

                <!-- Google Maps Iframe -->
                <div class="md:col-span-2">
                    <label for="maps_url" class="block text-sm font-medium text-gray-700 mb-1">Iframe de Google Maps</label>
                    <textarea name="maps_url" id="maps_url" rows="5"
                        placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>'
                        class="w-full border rounded-md border-gray-300 p-3"><?= old('maps_url', $contact['maps_url'] ?? '') ?></textarea>

                    <?php if (!empty($contact['maps_url'])): ?>
                        <div class="mt-4 border rounded-md overflow-hidden flex justify-center items-center bg-gray-50">
                            <?= $contact['maps_url'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Día de inicio -->
                <div>
                    <label for="start_day" class="block text-sm font-medium text-gray-700 mb-1">Día de inicio</label>
                    <select name="start_day" id="start_day" class="w-full border rounded-md border-gray-300 p-3">
                        <?php 
                        $dias = ['lunes','martes','miércoles','jueves','viernes','sábado','domingo'];
                        foreach ($dias as $dia): ?>
                            <option value="<?= $dia ?>" <?= (old('start_day', $contact['start_day'] ?? '') === $dia) ? 'selected' : '' ?>>
                                <?= ucfirst($dia) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Día de fin -->
                <div>
                    <label for="end_day" class="block text-sm font-medium text-gray-700 mb-1">Día de fin</label>
                    <select name="end_day" id="end_day" class="w-full border rounded-md border-gray-300 p-3">
                        <?php foreach ($dias as $dia): ?>
                            <option value="<?= $dia ?>" <?= (old('end_day', $contact['end_day'] ?? '') === $dia) ? 'selected' : '' ?>>
                                <?= ucfirst($dia) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hora de inicio -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio</label>
                    <input type="time" name="start_time" id="start_time"
                        value="<?= old('start_time', $contact['start_time'] ?? '') ?>"
                        class="w-full border rounded-md border-gray-300 p-3">
                </div>

                <!-- Hora de fin -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Hora de fin</label>
                    <input type="time" name="end_time" id="end_time"
                        value="<?= old('end_time', $contact['end_time'] ?? '') ?>"
                        class="w-full border rounded-md border-gray-300 p-3">
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status" class="w-full border rounded-md border-gray-300 p-3">
                        <option value="active" <?= (old('status', $contact['status'] ?? '') === 'active') ? 'selected' : '' ?>>Activo</option>
                        <option value="inactive" <?= (old('status', $contact['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <!-- Botón -->
                <div class="flex justify-end md:col-span-2">
                    <button type="submit" id="btn-submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-md px-6 py-3">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function () {
            $("#form-contact").on("submit", function (e) {
                e.preventDefault();

                let $btn = $("#btn-submit");
                $btn.prop("disabled", true).text("Guardando...");

                $.ajax({
                    url: "<?= site_url('/contact/update') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire("Éxito", response.message, "success").then(()=> location.reload());
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Hubo un problema al procesar la solicitud", "error");
                    },
                    complete: function () {
                        $btn.prop("disabled", false).text("Guardar cambios");
                    }
                });
            });
        });
    </script>

    <script>
    let cropper;
    const input = document.getElementById('img_input');
    const preview = document.getElementById('cropper_preview');
    const hiddenInput = document.getElementById('cropped_image_data');

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;

            if (cropper) cropper.destroy();

            cropper = new Cropper(preview, {
                aspectRatio: 1200 / 600,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                scalable: false,
                zoomable: true,
                movable: true,
            });
        };
        reader.readAsDataURL(file);
    });

    // Convertir recorte antes de enviar
    document.querySelector('form').addEventListener('submit', function (e) {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 1200,
                height: 600,
            });
            hiddenInput.value = canvas.toDataURL('image/jpeg');
        }
    });
</script>

    <?= $this->endSection() ?>
