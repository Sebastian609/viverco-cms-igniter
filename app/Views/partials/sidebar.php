
<aside class="fixed inset-y-0 left-0 w-72 bg-gray-900 border-r border-gray-800 shadow-xl flex flex-col z-50
                  transform transition-transform duration-300 ease-in-out md:translate-x-0"
  :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-show="isSidebarOpen || window.innerWidth >= 768" {{--
  Muestra en escritorio o cuando está abierto en móvil --}}
  @click.away="if (window.innerWidth < 768) isSidebarOpen = false">

  <div class="p-6 border-b border-gray-800 bg-gray-950">
    <h2 class="text-2xl font-extrabold text-white tracking-wide">Mi Panel</h2>
  </div>
  <nav class="p-6 flex-1">
    <ul class="space-y-1 text-gray-300 font-medium">
      <li>
        <a href="/"
          class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-gray-500"></i>
          Dashboard
        </a>
      </li>
      <li>
        <a href="/users"
          class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-users w-5 h-5 mr-3 text-gray-500"></i>
          Usuarios
        </a>
      </li>
      <!-- Dropdown -->
      <li>
        <button @click="openSections = !openSections"
          class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white"
          :aria-expanded="openSections ? 'true' : 'false'">
          <span class="flex items-center">
            <i class="fas fa-folder w-5 h-5 mr-3 text-gray-500"></i>
            Web
          </span>
          <i class="fas fa-chevron-down w-4 h-4 text-gray-500 transform transition-transform duration-200"
            :class="openSections ? 'rotate-180' : ''"></i>
        </button>
        <ul x-show="openSections" class="ml-8 mt-2 space-y-1" x-cloak>

          <li>
            <a href="/slider"
              class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition-colors duration-200 hover:text-white">
              <i class="fas fa-images w-4 h-4 mr-3 text-gray-600"></i>
              Slider
            </a>
          </li>
          <li>
            <a href="/post"
              class="flex items-center px-3 py-2 rounded-md hover:bg-gray-800 transition-colors duration-200 hover:text-white">
              <i class="fa-solid fa-pager w-4 h-4 mr-3 text-gray-600"></i>
              Publicaciones
            </a>
          </li>
        </ul>
      </li>
     
    </ul>
  </nav>
</aside>