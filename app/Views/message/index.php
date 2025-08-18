<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="">
    <div class="mx-auto ">
        <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Mensajes recibidos</h1>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-gray-600 border-y-2 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left font-semibold">#</th>
                        <th class="py-3 px-6 text-left font-semibold">Nombre</th>
                        <th class="py-3 px-6 text-left font-semibold">Email</th>
                        <th class="py-3 px-6 text-left font-semibold">Mensaje</th>
                        <th class="py-3 px-6 text-left font-semibold">Fecha</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $msg): ?>
                            <tr
                                class="border-b border-gray-200 odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition-colors duration-150">
                                <td class="py-3 px-6 text-left whitespace-nowrap"><?= esc($msg['id']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($msg['name']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($msg['email']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($msg['message']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($msg['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No hay mensajes para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Links de paginación -->
        <div class="mt-4 flex justify-center">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                <?php if ($pager->getPreviousPageURI()): ?>
                    <a href="<?= $pager->getPreviousPageURI() ?>" class="px-4 py-2 text-sm font-medium rounded-l-lg border border-gray-300 bg-white text-gray-600 
                      hover:bg-gray-100 hover:text-gray-800 transition">
                        ← Anterior
                    </a>
                <?php else: ?>
                    <span
                        class="px-4 py-2 text-sm font-medium rounded-l-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        ← Anterior
                    </span>
                <?php endif; ?>

                <?php if ($pager->getNextPageURI()): ?>
                    <a href="<?= $pager->getNextPageURI() ?>" class="px-4 py-2 text-sm font-medium rounded-r-lg border border-gray-300 bg-white text-gray-600 
                      hover:bg-gray-100 hover:text-gray-800 transition">
                        Siguiente →
                    </a>
                <?php else: ?>
                    <span
                        class="px-4 py-2 text-sm font-medium rounded-r-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        Siguiente →
                    </span>
                <?php endif; ?>
            </nav>
        </div>

    </div>
</div>

<?= $this->endSection() ?>