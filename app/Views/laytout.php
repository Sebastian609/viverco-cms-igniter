<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Mi Aplicación') ?></title>
</head>
<body>
    <header>
        <h1></h1>
        <nav>
            <a href="/users">Usuarios</a> |
            <a href="/users/create">Nuevo Usuario</a>
        </nav>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
