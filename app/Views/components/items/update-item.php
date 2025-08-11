<form class="bg-white  grid grid-cols-1 md:grid-cols-2 gap-4" :action="'/post/update/' + post.id" method="post"
    enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Texto principal -->
    <div class="col-span-1 md:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
        <input type="text" name="title" id="title" placeholder="Título" v-model="post.title"
            class="w-full border border-gray-300 p-3" required>
    </div>

    <!-- Texto secundario -->
    <div class="col-span-1 md:col-span-2">
        <label for="copy" class="block text-sm font-medium text-gray-700 mb-1">Copy</label>
        <textarea name="copy" id="copy" placeholder="Ingresar copy" v-model="post.copy"
            class="w-full border border-gray-300 p-3"></textarea>
    </div>

    <!-- Estado del post -->
    <div class="col-span-1 md:col-span-2">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado del post</label>
        <select id="status" name="status" v-model="post.status" class="w-full border border-gray-300 p-3">
            <option value="active">Activo</option>
            <option value="disabled">Desactivado</option>
            <option value="draft">Borrador</option>
        </select>
    </div>

    <!-- Botón enviar -->
    <button type="submit" class="bg-green-600 text-white  px-6 py-3 col-span-1 md:col-span-2">
        Actualizar post
    </button>
</form>