<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mx-auto w-full px-8">
    <h1 class="text-xl font-bold text-gray-800 text-left mb-8">Lista de Sliders</h1>

    <div class="bg-white">
        <div class="flex justify-between  p-8">

            <form class="flex justify-between">
                <input type="text" class="bg-gray-100 px-6 py-3 border-2 " placeholder="Buscar Por texto principal" />
                <button type="submit" class="bg-blue-600 text-white h-full aspect-square">
                   <i class="fa-solid fa-magnifying-glass text-white"></i>
                </button>
            </form>
 
            <a href="/slider/create" class="bg-blue-600 text-white px-6 py-3">
                Nuevo Slider
            </a>

        </div>

        <div class="bg-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-gray-700 border-y-2 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left font-semibold">#</th>
                            <th class="py-3 px-6 text-left font-semibold">Texto Principal</th>
                            <th class="py-3 px-6 text-center font-semibold">Imagen</th>
                            <th class="py-3 px-6 text-center font-semibold">Estado</th>
                            <th class="py-3 px-6 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="slider-table-body" class="text-gray-600 text-sm font-light">
                        <?php foreach ($sliders as $index => $slider): ?>
                            <tr class="draggable border-b border-gray-200 odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors duration-150"
                                data-id="<?= esc($slider['id']) ?>">
                                <td class="py-3 px-6 text-left whitespace-nowrap"><?= esc($slider['id']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($slider['main_text']) ?></td>
                                <td class="py-3 px-6 text-center">
                                    <?php if ($slider['img']): ?>
                                        <img src="/<?= esc($slider['img']) ?>" alt="Slider Image"
                                            class="h-12 w-12 object-cover rounded-md shadow-sm mx-auto">
                                    <?php else: ?>
                                        <span class="text-gray-400">No imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <?php if ($slider['status'] == 'active'): ?>
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Activo</span>
                                    <?php else: ?>
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-3">
                                        <a href="/slider/edit/<?= esc($slider['id']) ?>"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="confirmDelete(<?= esc($slider['id']) ?>)"
                                            class="text-red-600 hover:text-red-800 font-medium transition-colors duration-150">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>


                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($sliders)): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">No hay sliders para mostrar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Script para drag and drop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    const tableBody = document.getElementById('slider-table-body');

    Sortable.create(tableBody, {
        animation: 150,
        onEnd: function () {
            const rows = document.querySelectorAll('#slider-table-body tr');
            const orderData = [];

            rows.forEach((row, index) => {
                orderData.push({
                    id: row.dataset.id,
                    orden: (index + 1) * 1000 // mantiene separación
                });
            });

            fetch('<?= base_url("slider/reorder") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(orderData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Orden actualizado:", data);
                })
                .catch(error => {
                    console.error("Error al actualizar orden:", error);
                });
        }
    });
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer, la imagen asociada también se eliminará.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/slider/delete/${id}`;
            }
        });
    }
</script>

<?= $this->endSection() ?>