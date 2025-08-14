<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Editar Item</h1>
    <div class="w-full bg-white border-2 rounded-md mx-auto grid grid-cols-1 md:grid-cols-2 p-8 gap-6"
        id="jquery-section">

        <div class="grid col-span-2">
            <form method="POST" action="/item/update/<?= esc($item['id']) ?>" class="bg-white"
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
                                    value="<?= esc($item['button']) ?>" disabled>
                            </div>

                            <!-- Redireccionar -->
                            <div id="redirect-container" style="display:none;">
                                <label class="block text-sm text-gray-700 mb-1">Redireccionar a...</label>
                                <input type="text" name="redirect" id="redirect" placeholder="Redireccionar a..."
                                    class="w-full border border-gray-300 p-2 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                                    value="<?= esc($item['redirect']) ?>" disabled>
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
                        <p>Imagen actual</p>
                        <div class="w-full border-2 bg-gray-50 rounded-md" id="preview-container"></div>

                        <div id="dropzone-container" class="w-full border-2 rounded-md overflow-hidden">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-4 border-dashed border-blue-400 rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 transition-colors duration-200 relative overflow-hidden">

                                <!-- Icono y texto -->
                                <div id="upload-instructions"
                                    class="flex flex-col items-center justify-center text-center p-4">
                                    <svg class="w-12 h-12 mb-3 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0l-3 3m3-3l3 3M21 8v12m0 0l-3-3m3 3l3-3" />
                                    </svg>
                                    <p class="text-sm font-medium text-blue-700 mb-1">
                                        <span class="font-bold">Haz clic o arrastra</span> tu imagen aquí
                                    </p>
                                    <p class="text-xs text-blue-600">PNG, JPG o GIF (MAX. 5MB)</p>
                                </div>

                                <!-- Input oculto -->
                                <input id="dropzone-file" type="file" name="img_item" class="hidden" accept="image/*">
                            </label>
                        </div>

                        <div id="cropper-container" style="display:none;">
                            <img id="cropper-image" class="h-64 w-full object-cover " alt="Imagen para recortar">
                            <div class="flex gap-2 mt-2">
                                <button type="button" id="btn-apply-crop"
                                    class="bg-blue-600 text-white px-3 py-2 rounded-md">Aplicar recorte</button>
                                <button type="button" id="btn-cancel-crop"
                                    class="border-red-600 text-red-600 px-3 border-2 py-2 rounded-md">Cancelar</button>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- Botón submit -->
                <div class="flex justify-end gap-3 mt-4">
                    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md">Actualizar</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Agrega jQuery Validate antes de tu script -->
 
    <script>
        $(document).ready(function () {

            // ---- VALIDACIÓN ----
            $("#add-item-form").validate({
                ignore: [], // Para validar también campos ocultos si es necesario
                rules: {
                    title_item: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    copy_item: {
                        required: true,
                        minlength: 3,
                        maxlength: 1000
                    },
                    button: {
                        required: function () {
                            return $("#item-showButton").is(":checked");
                        },
                        minlength: 2
                    },
                    redirect: {
                        required: function () {
                            return $("#item-showButton").is(":checked");
                        },
                        url: true
                    },
                    img_item: {
                        extension: "jpg|jpeg|png|gif",
                        filesize: 5 * 1024 * 1024 // 5 MB
                    }
                },
                messages: {
                    title_item: {
                        required: "El título es obligatorio",
                        minlength: "Debe tener al menos 2 caracteres",
                        maxlength: "No puede superar los 255 caracteres"
                    },
                    copy_item: {
                        required: "El copy es obligatorio",
                        minlength: "Debe tener al menos 3 caracteres",
                        maxlength: "No puede superar los 1000 caracteres"
                    },
                    button: {
                        required: "El texto del botón es obligatorio cuando está habilitado",
                        minlength: "Debe tener al menos 2 caracteres"
                    },
                    redirect: {
                        required: "La URL es obligatoria cuando el botón está habilitado",
                        url: "Debe ser una URL válida (ej: https://...)"
                    },
                    img_item: {
                        extension: "Solo se permiten imágenes JPG, PNG o GIF",
                        filesize: "La imagen no puede superar los 5MB"
                    }
                },
                errorPlacement: function (error, element) {
                    error.addClass("text-red-500 text-sm mt-1 block");
                    error.insertAfter(element);
                }
            });

            // ---- FUNCIÓN PARA VALIDAR PESO DEL ARCHIVO ----
            $.validator.addMethod('filesize', function (value, element, param) {
                if (element.files.length === 0) return true; // No valida si no hay archivo
                return element.files[0].size <= param;
            }, 'El archivo es demasiado grande.');

            // --- Resto de tu código existente ---
            let cropper = null;
            const existingImg = "<?= esc($item['img']) ?>";
            const fileInput = $("#dropzone-file");
            const imgInput = $("#dropzone-container");
            const cropperContainer = $("#cropper-container");
            const cropperImage = $("#cropper-image");
            const btnApply = $("#btn-apply-crop");
            const btnCancel = $("#btn-cancel-crop");
            const previewContainer = $("#preview-container");

            previewContainer.html('');
            if (existingImg.trim() !== "") {
                const imgPreview = $('<img>', {
                    src: existingImg.startsWith('/') ? existingImg : '/' + existingImg,
                    class: 'w-full h-64 object-contain mt-2',
                    alt: 'Imagen actual'
                });
                previewContainer.append(imgPreview);
            } else {
                imgInput.fadeIn();
            }

            function destroyCropper() { if (cropper) cropper.destroy(); cropper = null; }
            function resetState() {
                destroyCropper();
                cropperImage.attr('src', '');
                fileInput.val('');
                imgInput.show();
                cropperContainer.hide();
                $("#upload-instructions").show();
            }

            fileInput.on('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;
                destroyCropper();
                const reader = new FileReader();
                reader.onload = function (ev) {
                    cropperImage.attr('src', ev.target.result);
                    cropperImage.off('load').on('load', function () {
                        imgInput.hide();
                        cropperContainer.fadeIn(100);
                        cropper = new Cropper(cropperImage[0], {
                            aspectRatio: parseFloat($("#aspectRatio").val()),
                            viewMode: 2,
                            dragMode: 'move',
                            autoCropArea: 0.8,
                            responsive: true
                        });
                    });
                };
                reader.readAsDataURL(file);
            });

            btnApply.click(function () {
                if (!cropper) return;
                const canvas = cropper.getCroppedCanvas();
                if (!canvas) return;
                canvas.toBlob(function (blob) {
                    const croppedFile = new File([blob], 'cropped.jpg', { type: 'image/jpeg' });
                    const dt = new DataTransfer();
                    dt.items.add(croppedFile);
                    fileInput[0].files = dt.files;
                    previewContainer.html('');
                    const url = URL.createObjectURL(blob);
                    $('<img>', {
                        src: url,
                        class: 'w-full h-64 object-contain mt-2',
                        alt: 'Imagen recortada'
                    }).appendTo(previewContainer);
                    cropperContainer.fadeOut(100, () => imgInput.fadeIn(100));
                    destroyCropper();
                }, 'image/jpeg', 0.9);
            });

            btnCancel.click(resetState);
            $("#aspectRatio").on('change', function () {
                if (cropper) cropper.setAspectRatio(parseFloat($(this).val()));
            });

            const checkBox = $("#item-showButton");
            const redirectInput = $("#redirect-container");
            const textButtonInput = $("#button-text-container");
            const buttonText = "<?= esc($item['button']) ?>";
            let isChecked = buttonText.trim() !== "";

            function toggleVisibility(checked) {
                if (checked) {
                    redirectInput.show().find('input').prop('disabled', false).removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                    textButtonInput.show().find('input').prop('disabled', false).removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                } else {
                    redirectInput.hide().find('input').prop('disabled', true).addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                    textButtonInput.hide().find('input').prop('disabled', true).addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                }
            }

            checkBox.prop('checked', isChecked);
            toggleVisibility(isChecked);
            checkBox.change(function () { toggleVisibility($(this).is(':checked')); });

        });
    </script>

    <?= $this->endSection() ?>