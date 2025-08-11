<!-- Bloque 2 -->
<form method="POST" :action="'/item/create/' + collection.id"
    class="bg-white p-8 grid grid-cols-1 gap-6" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="bg-slate-800 col-span-2 text-white p-4">
        <i class="fa-solid fa-plus text-white"></i> Agregar contenido
    </div>

    <!-- Título -->
    <div class="col-span-1 md:col-span-2">
        <label for="title_item" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
        <input type="text" name="title_item" id="title_item" placeholder="Título" v-model="item.title"
            class="w-full border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required>
    </div>

    <!-- Copy -->
    <div class="col-span-1 md:col-span-2">
        <label for="copy_item" class="block text-sm font-medium text-gray-700 mb-1">Copy</label>
        <textarea name="copy_item" id="copy_item" placeholder="Ingresar copy" v-model="item.copy"
            class="w-full border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    <!-- Checkbox -->
    <div class="col-span-2 flex items-center space-x-2">
        <input type="checkbox" id="enableButton2" v-model="item.showButton"
            class="form-checkbox h-5 w-5 text-green-600 focus:ring-green-500">
        <label for="enableButton2" class="text-base font-medium text-gray-700 cursor-pointer">
            Habilitar botón
        </label>
    </div>

    <!-- Texto botón -->
    <div v-show="item.showButton">
        <label for="button_text2" class="block text-sm font-medium text-gray-700 mb-1">Texto botón</label>
        <input type="text" name="button" id="button_text2" placeholder="Texto botón" v-model="item.button"
            :required="item.showButton" :disabled="!item.showButton"
            :class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !item.showButton }"
            class="w-full border border-gray-300 p-3  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
    </div>

    <!-- Redireccionar -->
    <div v-show="item.showButton">
        <label for="redirect_url2" class="block text-sm font-medium text-gray-700 mb-1">Redireccionar a...</label>
        <input type="text" name="redirect" id="redirect_url2" placeholder="Redireccionar a..." v-model="item.redirect"
            :required="item.showButton" :disabled="!item.showButton"
            :class="{ 'bg-gray-100 text-gray-400 cursor-not-allowed': !item.showButton }"
            class="w-full border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
    </div>

    <!-- Botón submit -->
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3  col-span-1 md:col-span-2
                   shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
        Agregar contenido
    </button>
</form>