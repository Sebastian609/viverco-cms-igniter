<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="edit-post">
    <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Editar post</h1>
    <div class="w-full bg-white border-2 rounded-md mx-auto grid grid-cols-1 md:grid-cols-2 p-8 gap-6"
        id="jquery-section">

        <div class="grid col-span-2">
            <div class="flex justify-between">

                <div class="space-x-2">
                    <button id="btn-show-modal" class="bg-blue-600 rounded-md text-white px-4 py-2">
                        Agregar item
                    </button>

                    <select class="text-blue-600 border-2 border-blue-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 
           transition-all duration-150 px-4 py-2 rounded-lg shadow-sm bg-white text-gray-700 
           font-medium outline-none" name="collection-key" id="collection-key">
                        <option value="faqs" <?= ($collection['key'] === 'faqs') ? 'selected' : '' ?>>FAQs</option>
                        <option value="services" <?= ($collection['key'] === 'services') ? 'selected' : '' ?>>Servicios
                        </option>
                        <option value="about" <?= ($collection['key'] === 'about') ? 'selected' : '' ?>>Nosotros</option>
                    </select>

                </div>

                <a href="/post" class="border-blue-600 text-blue-600 border-2 rounded-md px-4 py-2">
                    regresar
                </a>
            </div>
        </div>
        <?= $this->include('components/items/update-item') ?>
        <?= $this->include('components/items/list-item') ?>
    </div>
</div>

<!-- Modal -->
<div id="modal" style="display:none"
    class="fixed overflow-hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white w-full max-w-2xl rounded-md ">
        <div class="flex justify-between items-center w-full p-8">

            <div class="font-bold">
                Agregar Item
            </div>

            <button id="btn-close-modal"
                class="text-gray-500 w-5 h-5 p-2 flex justify-center items-center rounded-full bg-gray-200 ">
                <i class="fa-solid fa-xmark text-xs text-light"></i>
            </button>
        </div>
        <div class="px-8 pb-8">
            <?= $this->include('components/items/create-item') ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
    $(document).ready(function () {

        // Variables
        let items = <?= json_encode($items) ?> || [];
        let $modal = $('#modal');
        let collectionSelect = $("#collection-key");

        // Cambiar el key de la colección
        collectionSelect.on('change', function (e) {
            const newKey = e.target.value;
            const collectionId = <?= json_decode($collection['id']) ?>; // ID en data-id del select

            $.ajax({
                type: "POST",
                url: "/collection/updateKey", // Ruta a tu controlador
                data: {
                    key: newKey,
                    collectionId: collectionId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>' // CSRF si está habilitado
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon:'success',
                            title: 'Tipo Actualizado!'
                        })
                    } else {
                        Swal.fire({
                            icon:'error',
                            title: 'Error al actualizar el tipo!'
                        })
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert("Ocurrió un error al actualizar la clave");
                }
            });
        });

        // Mostrar modal
        $('#btn-show-modal').on('click', function () {
            $modal.show();
        });

        // Cerrar modal
        $('#btn-close-modal').on('click', function () {
            $modal.hide();
            resetForm();
        });

        // Función para resetear formulario
        function resetForm() {
            $modal.find('form')[0].reset();
        }

    });
</script>


<?= $this->endSection() ?>