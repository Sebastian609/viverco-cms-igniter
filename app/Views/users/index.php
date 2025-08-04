<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6">Lista de usuarios</h2>
<div class="mb-6">
    <p class="text-gray-600 mb-4">Complete el formulario para crear un nuevo usuario.</p>
    <a href="users/create" class="px-4 py-2 bg-blue-600 text-white rounded-md">Registar Usuario</a>
</div>
<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full table-auto text-sm text-gray-700">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-4 py-3 text-left font-medium">ID</th>
                <th class="px-4 py-3 text-left font-medium">Nombre</th>
                <th class="px-4 py-3 text-left font-medium">Email</th>
                <th class="px-4 py-3 text-left font-medium">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2"><?= esc($user['id']) ?></td>
                    <td class="px-4 py-2"><?= esc($user['name']) ?></td>
                    <td class="px-4 py-2"><?= esc($user['email']) ?></td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="/users/edit/<?= $user['id'] ?>"
                                class="text-blue-600 hover:underline text-sm">Editar</a>
                            <form action="/users/delete/<?= $user['id'] ?>" method="POST"
                                onsubmit="return confirm('¿Eliminar?')">
                                <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>