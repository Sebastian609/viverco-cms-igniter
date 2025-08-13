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

                        <div id="imageUploaded">

                            <img src="<?= "/" . esc($item['img']) ?>"
                                class="w-full h-64 bg-gray-50 border-2 p-2 rounded-md object-contain" alt="">
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
            const imageUploaded = $("#imageUploaded");
            const imgInput = $("#dropzone-container");
            const img = "<?= esc($item['img']) ?>";
            const imgExists = img.trim() !== "";
            const buttonText = "<?= esc($item['button']) ?>";
            let isChecked = buttonText.trim() !== "";
            const checkBox = $("#item-showButton");
            const redirectInput = $("#redirect-container");
            const textButtonInput = $("#button-text-container");

            if (imgExists) {
                imgInput.fadeOut(100);
                imageUploaded.fadeIn(100);
            } else {
                imgInput.fadeIn(100);
                imageUploaded.fadeOut(100);
            };

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

            // Validación del formulario con jQuery Validation
            $("#add-item-form").validate({
                rules: {
                    title_item: {
                        required: true,
                        minlength: 2,
                        noWhitespace: true
                    },
                    copy_item: {
                        required: true,
                        minlength: 10,
                        noWhitespace: true
                    },
                    button: {
                        required: function() {
                            return $("#item-showButton").is(":checked");
                        },
                        minlength: 2,
                        noWhitespace: true
                    },
                    redirect: {
                        required: function() {
                            return $("#item-showButton").is(":checked");
                        },
                        url: true,
                        noWhitespace: true
                    },
                    img_item: {
                        required: function() {
                            return !imgExists;
                        },
                        extension: "jpg|jpeg|png|gif"
                    }
                },
                messages: {
                    title_item: {
                        required: "El título es obligatorio",
                        minlength: "El título debe tener al menos 2 caracteres",
                        noWhitespace: "El título no puede contener solo espacios en blanco"
                    },
                    copy_item: {
                        required: "El copy es obligatorio",
                        minlength: "El copy debe tener al menos 10 caracteres",
                        noWhitespace: "El copy no puede contener solo espacios en blanco"
                    },
                    button: {
                        required: "El texto del botón es obligatorio cuando está habilitado",
                        minlength: "El texto del botón debe tener al menos 2 caracteres",
                        noWhitespace: "El texto del botón no puede contener solo espacios en blanco"
                    },
                    redirect: {
                        required: "La URL de redirección es obligatoria cuando está habilitado",
                        url: "Por favor ingresa una URL válida",
                        noWhitespace: "La URL no puede contener solo espacios en blanco"
                    },
                    img_item: {
                        required: "La imagen es obligatoria",
                        extension: "Solo se permiten archivos JPG, JPEG, PNG o GIF"
                    }
                },
                errorElement: 'span',
                errorClass: 'text-red-500 text-sm mt-1 block',
                highlight: function(element) {
                    $(element).addClass('border-red-500').removeClass('border-gray-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500').addClass('border-gray-300');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    // Validación adicional antes del envío
                    if ($("#item-showButton").is(":checked")) {
                        const buttonText = $("#button").val().trim();
                        const redirectUrl = $("#redirect").val().trim();
                        
                        if (!buttonText || !redirectUrl) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de validación',
                                text: 'Cuando el botón está habilitado, tanto el texto del botón como la URL de redirección son obligatorios'
                            });
                            return false;
                        }
                    }

                    // Validación final de espacios en blanco
                    const title = $("#item-title").val().trim();
                    const copy = $("#item-copy").val().trim();
                    
                    if (!title || !copy) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: 'El título y el copy son obligatorios y no pueden contener solo espacios en blanco'
                        });
                        return false;
                    }
                    
                    // Si todo está bien, enviar el formulario
                    return true;
                }
            });

            // Actualizar validación cuando cambie el checkbox
            checkBox.change(function() {
                if ($(this).is(":checked")) {
                    $("#button").rules("add", "required");
                    $("#redirect").rules("add", "required");
                } else {
                    $("#button").rules("remove", "required");
                    $("#redirect").rules("remove", "required");
                }
            });

            // Función personalizada para validar que no haya solo espacios en blanco
            $.validator.addMethod("noWhitespace", function(value, element) {
                // Verificar que el valor no esté vacío y no contenga solo espacios
                return this.optional(element) || (value.trim().length > 0);
            }, "Este campo no puede contener solo espacios en blanco");

            // Limpiar espacios en blanco al perder el foco
            $("input[type='text'], textarea").on('blur', function() {
                var $this = $(this);
                var trimmedValue = $this.val().trim();
                if ($this.val() !== trimmedValue) {
                    $this.val(trimmedValue);
                    // Trigger validation para mostrar errores si quedó vacío
                    $this.trigger('input');
                }
            });

            // Prevenir espacios al inicio mientras se escribe
            $("input[type='text'], textarea").on('input', function() {
                var $this = $(this);
                var value = $this.val();
                // Si el primer carácter es un espacio, eliminarlo
                if (value.length > 0 && value.charAt(0) === ' ') {
                    $this.val(value.substring(1));
                }
            });
        });
    </script>


    <style>
        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
        
        .border-red-500 {
            border-color: #ef4444;
        }
        
        .border-gray-300 {
            border-color: #d1d5db;
        }
    </style>

    <?= $this->endSection() ?>