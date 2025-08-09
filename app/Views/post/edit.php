<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl text-gray-800 mb-6 text-left">Editar post</h1>

        <form x-data="postForm()" class="bg-white p-8 rounded-xl shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6"
            action="/post/update/<?= esc($post['id']) ?>" method="post" enctype="multipart/form-data">
            <input type="hidden">
            <?= csrf_field() ?>

            <!-- Texto principal -->
            <div class="col-span-1 md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" id="title" placeholder="Título"
                    value="<?= esc($post['title'] ?? '') ?>"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <!-- Texto secundario -->
            <!-- Texto secundario -->
            <div class="col-span-1 md:col-span-2">
                <label for="copy" class="block text-sm font-medium text-gray-700 mb-1">Copy</label>
                <textarea name="copy" id="copy" placeholder="Ingresar copy"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= esc($post['copy'] ?? '') ?></textarea>
            </div>





            <div class="col-span-1 md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado del post</label>
                <select id="status" name="status"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                    <option value="active" <?= ($post['status'] ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="disabled" <?= ($post['status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Desactivado
                    </option>
                    <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Borrador
                    </option>
                </select>
            </div>



            <!-- Botón enviar -->
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg col-span-1 md:col-span-2
                           shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                actualizar post
            </button>
        </form>
    </div>
</div>

<div class="container mt-8 mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Bloque 1 -->
    <div class="bg-white p-8 rounded-xl shadow-lg grid grid-cols-1 gap-6">
        <div class="bg-slate-800 text-white p-4  col-span-2 rounded-lg mb-4 h-14">
            <i class="fa-solid fa-list text-white"></i> Contenido del post
        </div>
        <div class="col-span-1 md:col-span-2">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Tipo de visualizacion</label>
            <select id="status" name="status"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                <option value="active" <?= ($post['status'] ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                <option value="disabled" <?= ($post['status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Desactivado
                </option>
                <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Borrador
                </option>
            </select>
        </div>
    </div>


    <!-- Bloque 2 -->
    <form class="bg-white p-8 rounded-xl shadow-lg grid grid-cols-1 gap-6"
        x-data="{ showButton2: <?= !empty($post['button']) ? 'true' : 'false' ?> }">

        <div class="bg-slate-800 col-span-2 text-white p-4 rounded-lg">
            <i class="fa-solid fa-plus text-white"></i> Agregar contenido
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
            <input type="text" name="title" id="title" placeholder="Título"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="copy" class="block text-sm font-medium text-gray-700 mb-1">Copy</label>
            <textarea name="copy" id="copy" placeholder="Ingresar copy"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>


        <!-- Checkbox -->
        <div class="col-span-2 flex items-center space-x-2">
            <input type="checkbox" id="enableButton2" x-model="showButton2"
                class="form-checkbox h-5 w-5 text-green-600 rounded focus:ring-green-500">
            <label for="enableButton2" class="text-base font-medium text-gray-700 cursor-pointer">
                Habilitar botón
            </label>
        </div>

        <!-- Texto botón -->
        <div x-show="showButton2" x-transition>
            <label for="button_text2" class="block text-sm font-medium text-gray-700 mb-1">Texto botón</label>
            <input type="text" name="button" id="button_text2" placeholder="Texto botón"
                value="<?= esc($post['button'] ?? '') ?>" :required="showButton2" :disabled="!showButton2"
                :class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !showButton2 }"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
        </div>



        <!-- Redireccionar -->
        <div x-show="showButton2" x-transition>
            <label for="redirect_url2" class="block text-sm font-medium text-gray-700 mb-1">Redireccionar a...</label>
            <input type="text" name="redirect" id="redirect_url2" placeholder="Redireccionar a..."
                value="<?= esc($post['redirect'] ?? '') ?>" :required="showButton2" :disabled="!showButton2"
                :class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !showButton2 }"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
        </div>

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-lg col-span-1 md:col-span-2
                           shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
            Agregar contenido
        </button>
    </form>
</div>


<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



<?= $this->endSection() ?>