<div id="add">
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
                // Mostrar y habilitar campos
                $('#button-text-container, #redirect-container').show();
                $('#button-text-container input, #redirect-container input')
                    .prop('disabled', false)
                    .removeClass('bg-gray-100 text-gray-400 cursor-not-allowed');
            } else {
                // Ocultar y deshabilitar campos
                $('#button-text-container, #redirect-container').hide();
                $('#button-text-container input, #redirect-container input')
                    .prop('disabled', true)
                    .addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
            }
        });

        $('#btn-cancel-crop').on('click', function () {
            // Destruir el cropper y volver a mostrar la dropzone
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            $('#cropper-container').hide();
            $('#dropzone-container').show();

            // Limpiar el input file
            $('#dropzone-file').val('');
        });


        $('#dropzone-file').on('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                // Ocultar dropzone y mostrar cropper
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
            // Reset form y vista
            $('#add-item-form')[0].reset();
            $('#cropper-container').hide();
            $('#dropzone-container').show();
            if (cropper) { cropper.destroy(); cropper = null; }
        });

        $('#add-item-form').on('submit', function (e) {
            console.log('Formulario enviándose...');
            console.log('Título:', $('#item-title').val());
            console.log('Archivo:', $('#dropzone-file')[0].files[0]);
            
            // Validar campos requeridos
            const title = $('#item-title').val().trim();
            if (!title) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campo requerido',
                    text: 'El título es obligatorio'
                });
                return;
            }

            // Validar que haya imagen
            const fileInput = $('#dropzone-file')[0];
            if (fileInput.files.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Imagen requerida',
                    text: 'Debes seleccionar una imagen para el item'
                });
                return;
            }

            // Si hay cropper, procesar imagen antes de enviar
            if (cropper) {
                e.preventDefault();
                console.log('Procesando imagen con cropper...');
                
                cropper.getCroppedCanvas().toBlob(function (blob) {
                    // Crear un nuevo archivo con el blob recortado
                    const croppedFile = new File([blob], 'cropped.png', { type: 'image/png' });
                    
                    // Reemplazar el archivo en el input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(croppedFile);
                    fileInput.files = dataTransfer.files;
                    
                    console.log('Archivo procesado:', fileInput.files[0]);
                    
                    // Mostrar indicador de envío
                    Swal.fire({
                        title: 'Guardando item...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar el formulario
                    $('#add-item-form')[0].submit();
                }, 'image/png');
            } else {
                console.log('Enviando formulario sin cropper...');
                // Si no hay cropper, mostrar indicador de envío
                Swal.fire({
                    title: 'Guardando item...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });

    });

</script>