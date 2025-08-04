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
    <?= $this->include('partials/header') ?>

    <!-- Contenedor principal con Sidebar y Contenido -->
    <div class="flex flex-1">
        
        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Área de contenido -->
        <main class="flex-1 p-6">

            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>

</body>

</html>
