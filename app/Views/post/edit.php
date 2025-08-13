<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="edit-post">
    <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Editar post</h1>
    <div class="w-full bg-white border-2 rounded-md mx-auto grid grid-cols-1 md:grid-cols-2 p-8 gap-6" id="jquery-section">

        <div class="grid col-span-2">
            <div class="flex justify-between">
                <button id="btn-show-modal" class="bg-blue-600 rounded-md text-white px-4 py-2">
                    Agregar item
                </button>
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
$(document).ready(function() {

    // Variables
    let items = <?= json_encode($items) ?> || [];
    let $modal = $('#modal');

    // Mostrar modal
    $('#btn-show-modal').on('click', function() {
        $modal.show();
    });

    // Cerrar modal
    $('#btn-close-modal').on('click', function() {
        $modal.hide();
        resetForm();
    });

});
</script>

<?= $this->endSection() ?>
