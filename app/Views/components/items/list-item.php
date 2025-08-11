<div class="bg-white gap-6">
    <div class="w-full">
        <div v-if="items.length === 0">
            <p class="text-gray-600">No hay contenido para este post.</p>
        </div>

        <!-- Lista con ref para Sortable -->
        <div class="w-full" ref="sortableList">
            <div 
                v-for="(item, index) in items" 
                :key="item.id"
                class="mb-2 p-2 border border-gray-200 flex justify-between items-center hover:bg-gray-50 transition-colors duration-150"
            >
                <!-- Handle para arrastrar -->
                <div class="bg-slate-800 px-2 py-4 flex justify-center items-center cursor-move">
                    <i class="fa-solid fa-grip-vertical w-8 h-8 text-white"></i>
                </div>

                <!-- Título -->
                <div class="flex-1 pl-4">
                    {{ item.title }}
                </div>

                <!-- Acciones -->
                <div class="flex items-center justify-center space-x-3">
                    <a :href="'/item/edit/' + item.id"
                        class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a href="javascript:void(0);" @click="confirmDelete(item.id)"
                        class="text-red-600 hover:text-red-800 font-medium transition-colors duration-150">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
