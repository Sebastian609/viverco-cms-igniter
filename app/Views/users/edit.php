<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6">Editar usuario</h2>

<form method="POST" action="/users/update/<?= $user['id'] ?>" class="bg-white p-6 rounded shadow-md max-w-md mx-auto space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= esc($user['name']) ?>"
            required
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
        >
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= esc($user['email']) ?>"
            required
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
        >
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="(opcional)"
            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
        >
    </div>

    <div class="text-right">
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
        >
            Actualizar
        </button>
    </div>
</form>

<?= $this->endSection() ?>
