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
            <div class="col-span-1 md:col-span-2">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" name="img" id="img" @change="previewImage($event)" class="w-full border border-gray-300 p-3 rounded-lg bg-white file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200">

                <!-- Vista previa -->
                <div class="mt-4 space-y-3" x-show="previewUrl || existingImage">
                    <img :src="previewUrl || existingImage" alt="Vista previa"
                        class="max-h-48 w-auto border border-gray-200 rounded-lg shadow-sm object-contain">
                    <button type="button" @click="removeImage"
                        class="text-red-600 hover:text-red-800 underline text-sm font-medium transition duration-200">
                        Quitar imagen
                    </button>
                </div>
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
<?= $this->endSection() ?>