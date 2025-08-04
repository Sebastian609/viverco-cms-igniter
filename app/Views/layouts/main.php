<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Mi Aplicación') ?></title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Font Awesome (opcional para íconos) -->
    <link href="https://unpkg.com/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-gray-100 text-gray-800">

    <!-- Header -->

    <!-- Contenedor principal con Sidebar y Contenido -->
    <div class="flex flex-1">

        <!-- Sidebar -->
        <div x-data="{ isSidebarOpen: false, openSections: false }" class="flex h-screen bg-gray-100">

            <!-- Botón de hamburguesa para móvil -->
            <button @click="isSidebarOpen = !isSidebarOpen"
                class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-gray-900 text-white shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas" :class="isSidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                <span class="sr-only" x-text="isSidebarOpen ? 'Cerrar menú' : 'Abrir menú'"></span>
            </button>

            <!-- Overlay para el sidebar en móvil -->
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>
            <?= $this->include('partials/sidebar') ?>
            <div class="flex-1 flex flex-col overflow-hidden">


            </div>
        </div>

        <!-- Área de contenido -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:ml-72">
            <?= $this->renderSection('content') ?>
        </main>
    </div>


</body>

</html>