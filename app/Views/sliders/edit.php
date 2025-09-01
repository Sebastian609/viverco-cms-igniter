<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl text-gray-800 mb-6 text-left">Editar Slider</h1>

        <form x-data="sliderForm()" class="bg-white p-8 rounded-xl shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6"
            action="/slider/update/<?= esc($slider['id']) ?>" method="post" enctype="multipart/form-data">
            <input type="hidden">
            <?= csrf_field() ?>

            <!-- Texto principal -->
            <div>
                <label for="main_text" class="block text-sm font-medium text-gray-700 mb-1">Texto principal</label>
                <input type="text" name="main_text" id="main_text" placeholder="Texto principal"
                    value="<?= esc($slider['main_text'] ?? '') ?>"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- Texto secundario -->
            <div>
                <label for="secondary_text" class="block text-sm font-medium text-gray-700 mb-1">Texto
                    secundario</label>
                <input type="text" name="secondary_text" id="secondary_text" placeholder="Texto secundario"
                    value="<?= esc($slider['secondary_text'] ?? '') ?>"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Imagen -->
            <!-- Imagen -->
            <div class="col-span-1 md:col-span-2">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" id="img_input" accept="image/*" class="w-full border border-gray-300 p-3 rounded-lg bg-white file:mr-4 file:py-2 file:px-4
               file:rounded-lg file:border-0 file:text-sm file:font-semibold
               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200">

                <!-- Imagen recortada -->
                <div class="mt-4 space-y-3">
                    <img id="cropper_preview" :src="existingImage"
                        class="max-h-64 w-auto mx-auto border border-gray-200 rounded-lg shadow-sm object-contain">
                    <button type="button" @click="removeImage"
                        class="text-red-600 hover:text-red-800 underline text-sm font-medium transition duration-200">
                        Quitar imagen
                    </button>
                </div>

                <!-- Imagen en base64 -->
                <input type="hidden" name="img" id="cropped_image_data">
            </div>


            <!-- Habilitar botón -->
            <div class="col-span-1 md:col-span-2 flex items-center space-x-2">
                <input type="checkbox" id="enableButton" x-model="showButton"
                    class="form-checkbox h-5 w-5 text-green-600 rounded focus:ring-green-500">
                <label for="enableButton" class="text-base font-medium text-gray-700 cursor-pointer">
                    Habilitar botón
                </label>
            </div>

            <!-- Texto botón -->
            <div x-show="showButton">
                <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Texto botón</label>
                <input type="text" name="button" id="button_text" placeholder="Texto botón"
                    value="<?= esc($slider['button'] ?? '') ?>" x-bind:required="showButton"
                    x-bind:disabled="!showButton"
                    x-bind:class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !showButton }"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
            </div>

            <!-- Redireccionar -->
            <div x-show="showButton">
                <label for="redirect_url" class="block text-sm font-medium text-gray-700 mb-1">Redireccionar
                    a...</label>
                <input type="text" name="redirect" id="redirect_url" placeholder="Redireccionar a..."
                    value="<?= esc($slider['redirect'] ?? '') ?>" x-bind:required="showButton"
                    x-bind:disabled="!showButton"
                    x-bind:class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !showButton }"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
            </div>

            <!-- CTA Personalización -->
            <div class="col-span-1 md:col-span-2 border-t border-gray-300 pt-4 mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Personalización de CTA</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Color del título -->
                    <div>
                        <label for="title_color" class="block text-sm font-medium text-gray-700 mb-1">Color del
                            título</label>
                        <input type="color" name="title_color" id="title_color"
                            value="<?= esc($slider['title_color'] ?? '#000000') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Color del contenido -->
                    <div>
                        <label for="content_color" class="block text-sm font-medium text-gray-700 mb-1">Color del
                            contenido</label>
                        <input type="color" name="content_color" id="content_color"
                            value="<?= esc($slider['content_color'] ?? '#000000') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Color de fondo -->
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-1">Color de
                            fondo</label>
                        <input type="color" name="background_color" id="background_color"
                            value="<?= esc($slider['background_color'] ?? '#ffffff') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Color del texto del botón -->
                    <div>
                        <label for="button_text_color" class="block text-sm font-medium text-gray-700 mb-1">Color del
                            texto del botón</label>
                        <input type="color" name="button_text_color" id="button_text_color"
                            value="<?= esc($slider['button_text_color'] ?? '#ffffff') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Color del botón -->
                    <div>
                        <label for="button_color" class="block text-sm font-medium text-gray-700 mb-1">Color del
                            botón</label>
                        <input type="color" name="button_color" id="button_color"
                            value="<?= esc($slider['button_color'] ?? '#10b981') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Color del borde del cuadro -->
                    <div>
                        <label for="border_color" class="block text-sm font-medium text-gray-700 mb-1">Color del borde
                            del cuadro</label>
                        <input type="color" name="border_color" id="border_color"
                            value="<?= esc($slider['border_color'] ?? '#d1d5db') ?>"
                            class="w-full h-10 p-1 rounded-lg border border-gray-300">
                    </div>

                    <!-- Posición -->
                    <div class="md:col-span-3">
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                        <select name="position" id="position"
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="left" <?= ($slider['position'] ?? '') === 'left' ? 'selected' : '' ?>>Izquierda
                            </option>
                            <option value="right" <?= ($slider['position'] ?? '') === 'right' ? 'selected' : '' ?>>Derecha
                            </option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-span-1 md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado del slider</label>
                <select id="status" name="status"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    <option value="active" <?= ($slider['status'] ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="disabled" <?= ($slider['status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Desactivado
                    </option>
                </select>
            </div>



            <!-- Botón enviar -->
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg col-span-1 md:col-span-2
                           shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                Guardar Slider
            </button>
        </form>
    </div>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Script Alpine personalizado -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sliderForm', () => ({
            previewUrl: null,
            existingImage: "<?= esc($slider['img'] ?? '') ? base_url($slider['img']) : '' ?>",
            showButton: <?= isset($slider['button']) && $slider['button'] && $slider['redirect'] ? 'true' : 'false' ?>,

            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            removeImage() {
                this.previewUrl = null;
                this.existingImage = null;
                document.getElementById('img').value = "";
            }
        }));
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