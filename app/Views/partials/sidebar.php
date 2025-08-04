<aside class="w-64 h-screen bg-white border-r shadow-sm">
  <div class="p-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Mi Panel</h2>
  </div>
  <nav class="p-4" x-data="{ openSections: false }">
    <ul class="space-y-2 text-gray-700 font-medium">
      <li>
        <a href="/" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
          <i class="fas fa-tachometer-alt w-5 mr-3 text-gray-500"></i>
          Dashboard
        </a>
      </li>
      <li>
        <a href="/users" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
          <i class="fas fa-users w-5 mr-3 text-gray-500"></i>
          Usuarios
        </a>
      </li>

      <!-- Dropdown -->
      <li>
        <button @click="openSections = !openSections"
                class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-100 transition">
          <span class="flex items-center">
            <i class="fas fa-folder w-5 mr-3 text-gray-500"></i>
            Web
          </span>
          <i class="fas" :class="openSections ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </button>
        <ul x-show="openSections" class="ml-6 mt-2 space-y-1" x-cloak>
          <li>
            <a href="/services" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
              <i class="fas fa-star w-4 mr-3 text-gray-400"></i>
              Servicios
            </a>
          </li>
          <li>
            <a href="/slider" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
              <i class="fas fa-images w-4 mr-3 text-gray-400"></i>
              Slider
            </a>
          </li>
          <li>
            <a href="/about" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
              <i class="fas fa-user w-4 mr-3 text-gray-400"></i>
              Nosotros
            </a>
          </li>
        </ul>
      </li>

      <li>
        <a href="/settings" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 transition">
          <i class="fas fa-cogs w-5 mr-3 text-gray-500"></i>
          Configuración
        </a>
      </li>
    </ul>
  </nav>
</aside>
