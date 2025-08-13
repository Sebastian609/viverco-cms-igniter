<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div>
    <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Editar Item</h1>
    <div class="w-full bg-white border-2 rounded-md mx-auto grid grid-cols-1 md:grid-cols-2 p-8 gap-6"
        id="jquery-section">

        <div class="grid col-span-2">
            <form method="POST" action="/item/create/<?= esc($item['id']) ?>" class="bg-white"
                enctype="multipart/form-data" id="add-item-form">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <!-- Columna izquierda -->
                    <div class="space-y-4">
                        <!-- Título -->
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Título</label>
                            <input type="text" name="title_item" placeholder="Título" id="item-title"
                                class="w-full border border-gray-300 p-2 rounded-md" value="<?= esc($item['title']) ?>"
                                required>
                        </div>

                        <!-- Copy -->
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Copy</label>
                            <textarea name="copy_item" placeholder="Ingresar copy" id="item-copy"
                                class="w-full border border-gray-300 p-2 rounded-md"><?= esc($item['copy']) ?></textarea>
                        </div>

                        <!-- Checkbox -->
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="item-showButton"
                                class="form-checkbox h-5 w-5 text-blue-600 rounded-md">
                            <label for="item-showButton" class="text-gray-700 cursor-pointer">Habilitar botón</label>
                        </div>

                        <!-- Contenedor conjunto -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Texto botón -->
                            <div id="button-text-container" style="display:none;">
                                <label class="block text-sm text-gray-700 mb-1">Texto botón</label>
                                <input type="text" name="button" id="button" placeholder="Texto botón"
                                    class="w-full border border-gray-300 p-2 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                                    value="<?= esc($item['copy']) ?>"
                                    disabled>
                            </div>

                            <!-- Redireccionar -->
                            <div id="redirect-container" style="display:none;">
                                <label class="block text-sm text-gray-700 mb-1">Redireccionar a...</label>
                                <input type="text" name="redirect" id="redirect" placeholder="Redireccionar a..."
                                    class="w-full border border-gray-300 p-2 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                                    value=<?= esc($item['redirect']) ?>
                                    disabled>
                            </div>
                        </div>

                        <!-- Selector de aspecto -->
                        <div>
                            <label for="aspectRatio" class="block text-sm font-medium text-gray-700 mb-1">
                                Proporción
                            </label>
                            <select id="aspectRatio" class="border border-gray-300 rounded-md p-2 w-full relative z-10">
                                <option value="1.7777777778">16:9</option>
                                <option value="1.3333333333">4:3</option>
                                <option value="1">1:1</option>
                                <option value="0.6666666667">2:3</option>
                            </select>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="space-y-4">
                        <!-- Dropzone -->
                        <div id="dropzone-container" class="relative">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div id="upload-instructions"
                                    class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0l-3 3m3-3l3 3M21 8v12m0 0l-3-3m3 3l3-3" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Haz clic para subir</span> o arrastra aquí
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG o GIF (MAX. 5MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="img_item" class="hidden" accept="image/*">
                            </label>
                        </div>

                        <!-- Área separada para el Cropper -->
                        <div id="cropper-container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Editor de imagen</label>
                            <div class="border border-gray-300 rounded-md overflow-hidden w-full max-h-96">
                                <img id="cropper-image" class="w-full" alt="Imagen para recortar">
                            </div>
                            <button type="button" id="btn-cancel-crop"
                                class="mt-3 border-red-600 text-red-600 border-2 px-3 py-2 rounded-md">
                                Cancelar recorte
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botón submit -->
                <div class="flex justify-end gap-3 mt-4">

                    </button>
                    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md">
                        Actualizar
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        $(document).ready(function () {

            const buttonText = "<?= esc($item['button']) ?>";
            let isChecked = buttonText.trim() !== "";
            const checkBox = $("#item-showButton");
            const redirectInput = $("#redirect-container");
            const textButtonInput = $("#button-text-container");

            const toggleVisibility = (checked) => {
                if (checked) {
                    redirectInput.fadeIn(100);
                    textButtonInput.fadeIn(100);
                    redirectInput.find("input").prop('disabled', false)
                        .removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                    textButtonInput.find("input").prop('disabled', false)
                        .removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                } else {
                    redirectInput.fadeOut(100);
                    textButtonInput.fadeOut(100);
                    redirectInput.find("input").prop('disabled', true)
                        .addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                    textButtonInput.find("input").prop('disabled', true)
                        .addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                }
            };

            // Estado inicial
            checkBox.prop("checked", isChecked);
            toggleVisibility(isChecked);

            // Cambios del usuario
            checkBox.change((e) => {
                toggleVisibility(e.target.checked);
            });

        });
    </script>


    <?= $this->endSection() ?>