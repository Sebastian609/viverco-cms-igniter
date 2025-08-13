<form class="bg-white" action="/post/update/<?= esc($post['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Texto principal -->
        <div class="col-span-1 md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
            <input
                type="text"
                name="title"
                id="title"
                placeholder="Título"
                value="<?= esc($post['title'] ?? '') ?>"
                class="w-full border rounded-md border-gray-300 p-3"
                required
            >
        </div>

        <!-- Texto secundario -->
        <div class="col-span-1 md:col-span-2">
            <label for="copy" class="block text-sm font-medium text-gray-700 mb-1">Copy</label>
            <textarea
                name="copy"
                id="copy"
                placeholder="Ingresar copy"
                class="w-full border rounded-md border-gray-300 p-3"
            ><?= esc($post['copy'] ?? '') ?></textarea>
        </div>

        <!-- Estado del post -->
        <div class="col-span-1 md:col-span-2">
            <label for="status" class="block text-sm font-medium rounded-md text-gray-700 mb-1">Estado del post</label>
            <select
                id="status"
                name="status"
                class="w-full rounded-md border border-gray-300 p-3"
            >
                <option value="active" <?= (isset($post['status']) && $post['status'] === 'active') ? 'selected' : '' ?>>Activo</option>
                <option value="disabled" <?= (isset($post['status']) && $post['status'] === 'disabled') ? 'selected' : '' ?>>Desactivado</option>
                <option value="draft" <?= (isset($post['status']) && $post['status'] === 'draft') ? 'selected' : '' ?>>Borrador</option>
            </select>
        </div>
    </div>

    <!-- Botón enviar -->
    <button type="submit" class="bg-indigo-600 text-white rounded-md px-6 py-3">
        Actualizar
    </button>
</form>
