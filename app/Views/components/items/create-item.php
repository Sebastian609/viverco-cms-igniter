<div>
    <form method="POST" action="/item/create/<?= esc($collection['id']) ?>" class="bg-white"
        enctype="multipart/form-data" id="add-item-form">
        <?= csrf_field() ?>

        <!-- Campo oculto para collection_id -->
        <input type="hidden" name="collection_id" value="<?= esc($collection['id']) ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <!-- Columna izquierda -->
            <div class="space-y-4">
                <!-- Título -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Título</label>
                    <input type="text" name="title_item" placeholder="Título" id="item-title"
                        class="w-full border border-gray-300 p-2 rounded-md" required>
                </div>

                <!-- Copy -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Copy</label>
                    <textarea name="copy_item" placeholder="Ingresar copy" id="item-copy"
                        class="w-full border border-gray-300 p-2 rounded-md"></textarea>
                </div>

                <!-- Checkbox -->
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="item-showButton" class="form-checkbox h-5 w-5 text-blue-600 rounded-md">
                    <label for="item-showButton" class="text-gray-700 cursor-pointer">Habilitar botón</label>
                </div>

                <!-- Texto botón -->
                <div id="button-text-container" style="display:none;">
                    <label class="block text-sm text-gray-700 mb-1">Texto botón</label>
                    <input type="text" name="button_item" id="item-button" placeholder="Texto botón"
                        class="w-full border border-gray-300 p-2 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                        disabled>
                </div>

                <!-- Redireccionar -->
                <div id="redirect-container" style="display:none;">
                    <label class="block text-sm text-gray-700 mb-1">Redireccionar a...</label>
                    <input type="text" name="redirect_item" id="item-redirect" placeholder="Redireccionar a..."
                        class="w-full border border-gray-300 p-2 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed"
                        disabled>
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
                        <div id="upload-instructions" class="flex flex-col items-center justify-center pt-5 pb-6">
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
            <button type="button" id="btn-cancel" class="border-blue-700 text-blue-700 border-2 px-3 py-2 rounded-md">
                Cancelar
            </button>
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md">
                Guardar
            </button>
        </div>
    </form>
</div>

<!-- CDN para jQuery Validate -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<style>
    /* Estilo para los mensajes de error de jQuery Validate */
    .error {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>

<script>
    $(function () {
        let cropper = null;

        function createCropper(aspectRatio) {
            if (cropper) cropper.destroy();
            const image = document.getElementById('cropper-image');
            cropper = new Cropper(image, {
                aspectRatio: aspectRatio,
                viewMode: 1,
                autoCropArea: 1
            });
        }

        $('#item-showButton').on('change', function () {
            if ($(this).is(':checked')) {
                $('#button-text-container, #redirect-container').show();
                $('#button-text-container input, #redirect-container input')
                    .prop('disabled', false)
                    .removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
            } else {
                $('#button-text-container, #redirect-container').hide();
                $('#button-text-container input, #redirect-container input')
                    .prop('disabled', true)
                    .addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
            }
        });

        $('#btn-cancel-crop').on('click', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            $('#cropper-container').hide();
            $('#dropzone-container').show();
            $('#dropzone-file').val('');
            $('#dropzone-file-error').remove();
        });

        $('#dropzone-file').on('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                $('#dropzone-container').hide();
                $('#cropper-container').show();
                $('#cropper-image').attr('src', event.target.result);
                const aspectRatio = parseFloat($('#aspectRatio').val());
                createCropper(aspectRatio);
            };
            reader.readAsDataURL(file);
        });

        $('#aspectRatio').on('change', function () {
            if (!cropper) return;
            const aspectRatio = parseFloat($(this).val());
            createCropper(aspectRatio);
        });

        $('#btn-cancel').on('click', function () {
            $('#add-item-form')[0].reset();
            $('#cropper-container').hide();
            $('#dropzone-container').show();
            if (cropper) { cropper.destroy(); cropper = null; }
            $('#add-item-form').validate().resetForm();
        });

        $.validator.addMethod("noSpace", function (value, element) {
            return value.trim().length > 0;
        }, "Este campo no puede estar vacío o solo con espacios.");

        // jQuery Validate + AJAX
        $("#add-item-form").validate({
            rules: {
                title_item: { required: true, noSpace: true, minlength: 5, maxlength: 1000 },
                img_item: { required: true },
                button_item: { required: '#item-showButton:checked', noSpace: true, minlength: 5, maxlength: 1000 },
                redirect_item: { required: '#item-showButton:checked', url: true, noSpace: true, minlength: 5, maxlength: 1000 },
                copy_item: { required: true, noSpace: true, minlength: 5, maxlength: 1000 }
            },
            messages: {
                title_item: { required: "El título es obligatorio." },
                img_item: { required: "Por favor, selecciona una imagen." },
                button_item: { required: "El texto del botón es obligatorio." },
                redirect_item: { required: "La URL de redirección es obligatoria.", url: "Introduce una URL válida." },
                copy_item: { required: "El texto de copia es obligatorio." }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "img_item") {
                    error.insertAfter("#dropzone-container");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                const fileInput = $('#dropzone-file')[0];

                Swal.fire({
                    title: 'Guardando item...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                function enviarAjax(fileInput) {
                    const formData = new FormData(form);
                    formData.set("img_item", fileInput.files[0]); // reemplaza el input de imagen con la recortada

                    $.ajax({
                        url: $(form).attr("action"),
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            Swal.fire({
                                icon: "success",
                                title: "Guardado correctamente",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Opcional: resetear formulario
                            $('#btn-cancel').click();
                            window.location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error al guardar",
                                text: xhr.responseText || "Ocurrió un error inesperado"
                            });
                        }
                    });
                }

                // Procesar imagen con cropper si existe
                if (cropper && fileInput.files.length > 0) {
                    cropper.getCroppedCanvas().toBlob(function (blob) {
                        const croppedFile = new File([blob], 'cropped.png', { type: 'image/png' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(croppedFile);
                        fileInput.files = dataTransfer.files;
                        enviarAjax(fileInput);
                    }, 'image/png');
                } else {
                    enviarAjax(fileInput);
                }
            }
        });
    });
</script>
