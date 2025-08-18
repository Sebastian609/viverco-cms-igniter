<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="edit-footer">
    <h1 class="text-gray-800 font-bold text-left mb-4 text-xl">Configuración del Footer</h1>

    <div class="w-full bg-white border-2 rounded-md mx-auto p-8">
        <form id="form-footer" class="bg-white grid grid-cols-1 md:grid-cols-2 gap-6" method="post">
            <?= csrf_field() ?>

            <!-- Texto principal -->
            <div class="md:col-span-2">
                <label for="main_text" class="block text-sm font-medium text-gray-700 mb-1">Texto principal</label>
                <textarea name="main_text" id="main_text" rows="3"
                    placeholder="Texto que aparecerá en el footer"
                    class="w-full border rounded-md border-gray-300 p-3"><?= old('main_text', $footer['main_text'] ?? '') ?></textarea>
            </div>

            <!-- Texto del botón -->
            <div>
                <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Texto del botón</label>
                <input type="text" name="button_text" id="button_text"
                    value="<?= old('button_text', $footer['button_text'] ?? '') ?>"
                    placeholder="Ej: Contáctanos"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- Redirección -->
            <div>
                <label for="redirect" class="block text-sm font-medium text-gray-700 mb-1">Redirección</label>
                <input type="text" name="redirect" id="redirect"
                    value="<?= old('redirect', $footer['redirect'] ?? '') ?>"
                    placeholder="https://ejemplo.com"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- Facebook -->
            <div>
                <label for="facebook_link" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                <input type="url" name="facebook_link" id="facebook_link"
                    value="<?= old('facebook_link', $footer['facebook_link'] ?? '') ?>"
                    placeholder="https://facebook.com/empresa"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- Instagram -->
            <div>
                <label for="instagram_link" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                <input type="url" name="instagram_link" id="instagram_link"
                    value="<?= old('instagram_link', $footer['instagram_link'] ?? '') ?>"
                    placeholder="https://instagram.com/empresa"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- TikTok -->
            <div>
                <label for="tiktok_link" class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                <input type="url" name="tiktok_link" id="tiktok_link"
                    value="<?= old('tiktok_link', $footer['tiktok_link'] ?? '') ?>"
                    placeholder="https://tiktok.com/@empresa"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- LinkedIn -->
            <div>
                <label for="linkedin_link" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                <input type="url" name="linkedin_link" id="linkedin_link"
                    value="<?= old('linkedin_link', $footer['linkedin_link'] ?? '') ?>"
                    placeholder="https://linkedin.com/company/empresa"
                    class="w-full border rounded-md border-gray-300 p-3">
            </div>

            <!-- Términos -->
            <div class="md:col-span-2">
                <label for="terms" class="block text-sm font-medium text-gray-700 mb-1">Términos y Condiciones</label>
                <textarea name="terms" id="terms" rows="3"
                    placeholder="Texto o enlace de los términos"
                    class="w-full border rounded-md border-gray-300 p-3"><?= old('terms', $footer['terms'] ?? '') ?></textarea>
            </div>

            <!-- Privacidad -->
            <div class="md:col-span-2">
                <label for="privacy" class="block text-sm font-medium text-gray-700 mb-1">Política de Privacidad</label>
                <textarea name="privacy" id="privacy" rows="3"
                    placeholder="Texto o enlace de privacidad"
                    class="w-full border rounded-md border-gray-300 p-3"><?= old('privacy', $footer['privacy'] ?? '') ?></textarea>
            </div>

            <!-- Botón -->
            <div class="flex justify-end md:col-span-2">
                <button type="submit" id="btn-submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-md px-6 py-3">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function () {
        $("#form-footer").on("submit", function (e) {
            e.preventDefault();

            let $btn = $("#btn-submit");
            $btn.prop("disabled", true).text("Guardando...");

            $.ajax({
                url: "<?= site_url('/footer/update') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire("Éxito", response.message, "success").then(()=> location.reload());
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Hubo un problema al procesar la solicitud", "error");
                },
                complete: function () {
                    $btn.prop("disabled", false).text("Guardar cambios");
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
