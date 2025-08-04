<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<ul>
    <li>CI_ENVIRONMENT: <?= env('CI_ENVIRONMENT') ?></li>
    <li>Base URL: <?= env('app.baseURL') ?></li>
    <li>DB Nombre: <?= env('database.default.database') ?></li>
    <li>DB Usuario: <?= env('database.default.username') ?></li>
</ul>

<?= $this->endSection() ?>