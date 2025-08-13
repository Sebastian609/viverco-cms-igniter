<div class="w-full" id="sortable-item-list">
    <?php if (empty($items)): ?>
        <div class="w-full text-center">
            <i class="fa-solid fa-face-sad-tear text-4xl mb-4 text-gray-500"></i>
            <p class="text-gray-600 w-full text-center">No hay items disponibles.</p>
            <p class="text-gray-600 w-full text-center mb-6">¡Crea tu primer item!</p>
        </div>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="group flex mb-4 items-center justify-between border border-gray-200 overflow-hidden bg-white" data-id="<?= esc($item['id']) ?>">
                <div class="bg-blue-600 item px-3 py-4 rounded-l-md flex justify-center items-center cursor-move">
                    <i class="fa-solid fa-grip-vertical text-white text-lg"></i>
                </div>
                <div class="flex-1 pl-4 text-gray-800 font-medium truncate">
                    <?= esc($item['title']) ?>
                </div>
                <div class="flex items-center space-x-3 pr-4 opacity-70 group-hover:opacity-100 transition-opacity duration-200">
                    <a href="/item/edit/<?= esc($item['id']) ?>" class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <button class="btn-delete-item text-red-500 hover:text-red-700" data-id="<?= esc($item['id']) ?>">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
$(document).ready(function () {
    // Evento para eliminar con confirmación
    $(document).on('click', '.btn-delete-item', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/item/delete/' + id;
            }
        });
    });

    // Inicializar SortableJS y guardar orden en servidor
    new Sortable(document.getElementById('sortable-item-list'), {
        animation: 150,
        handle: '.item',
        onEnd: function () {
            let order = [];
            $("#sortable-item-list .group").each(function (index) {
                order.push({
                    id: $(this).data('id'),
                    orden: (index + 1) * 1000 // Mantener espaciado como en tu create()
                });
            });

            // Mostrar indicador de guardando
            Swal.fire({
                title: 'Guardando orden...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enviar nuevo orden por AJAX
            $.ajax({
                url: '/item/reorder',
                method: 'POST',
                data: {
                    order: order,
                    csrf_test_name: '<?= csrf_hash() ?>'
                },
                success: function (response) {
                    // Cerrar el indicador de guardando
                    Swal.close();
                    
                    if (response.status === 'success') {
                        // Mostrar notificación de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Orden actualizado!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        console.error('Error en respuesta:', response);
                    }
                },
                error: function (xhr) {
                    // Cerrar el indicador de guardando
                    Swal.close();
                    
                    console.error('Error al guardar orden', xhr.responseText);
                    // Mostrar notificación de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar el nuevo orden. Inténtalo de nuevo.',
                    });
                }
            });
        }
    });
});
</script>
