<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Mi Aplicación') ?></title>

    <!-- ===== CSS primero ===== -->
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Cropper CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- FontAwesome (CSS) -->
    <link href="https://unpkg.com/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .monospace {
            font-family: 'Roboto Mono', monospace;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-white text-gray-800">
    <div class="flex flex-1" id="app">
        <div class="flex h-screen bg-white">
            <?= $this->include('partials/sidebar') ?>
        </div>
        <div class="flex-1 ml-20">
            <!-- Navbar superior -->
            <div class="bg-white w-full border-b border-2 p-6 flex items-center gap-4 justify-end">
                <p class="font-bold">¡Hola Usuario!</p>
                <i class="fa-solid fa-gear text-xl text-gray-400"></i>
            </div>

            <!-- Breadcrumb dinámico -->
            <?php
            $uri = service('uri');
            $totalSegments = $uri->getTotalSegments();
            ?>
            <nav class="bg-gray-50 px-6 py-3 text-sm text-gray-600 border-b">
                <ol class="list-reset flex">
                    <li>
                        <a href="<?= base_url() ?>" class="text-blue-600 hover:underline">Inicio</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalSegments; $i++): ?>
                        <li><span class="mx-2">/</span></li>
                        <?php if ($i < $totalSegments): ?>
                            <li>
                                <a href="<?= base_url(implode('/', array_slice($uri->getSegments(), 0, $i))) ?>"
                                    class="text-blue-600 hover:underline">
                                    <?= ucfirst(str_replace('-', ' ', $uri->getSegment($i))) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="text-gray-500">
                                <?= ucfirst(str_replace('-', ' ', $uri->getSegment($i))) ?>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                </ol>
            </nav>

            <main class="flex-1 p-6 w-full">
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <!-- 2. Plugins de jQuery -->
                <script
                    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
                <script
                    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

                <!-- 3. Librerías sin dependencia de jQuery -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
                <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- ===== JS al final para cargar más rápido ===== -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- Librerías sin dependencia de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <!-- Aquí puedes poner tus scripts personalizados -->
    <?= $this->renderSection('scripts') ?>
</body>

</html>