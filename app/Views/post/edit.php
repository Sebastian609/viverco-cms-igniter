<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="edit-post">
    <h1 class=" text-gray-800 font-bold text-left mb-4">Editar post</h1>
    <div class="w-full bg-white mx-auto grid grid-cols-1 md:grid-cols-2 p-8 gap-6" id="vue-section">

        <div class="grid col-span-2">
            <div>
                <button @click="showModal = true" class="bg-blue-600 text-white px-4 py-2">
                    Agregar item
                </button>
            </div>
        </div>
        <?= $this->include('components/items/update-item') ?>
        <?= $this->include('components/items/list-item') ?>
    </div>

    <!-- Modal -->
    <div v-show="showModal" style="display:none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white w-full max-w-lg p-6 relative">
            <button @click="showModal = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">
                &times;
            </button>
            <?= $this->include('components/items/create-item') ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script type="module">
    const { createApp } = Vue
    const createPost = createApp({
        data() {
            return {
                showModal: false,

                // Datos del post
                post: {
                    id: <?= json_encode($post['id']) ?>,
                    title: <?= json_encode($post['title'] ?? '') ?>,
                    copy: <?= json_encode($post['copy'] ?? '') ?>,
                    status: <?= json_encode($post['status'] ?? 'active') ?>
                },

                collection: {
                    id: <?= json_encode($collection['id']) ?>
                },

                items: <?= json_encode($items) ?> || [],

                item: {
                    title: '',
                    copy: '',
                    button: <?= json_encode($item['button'] ?? '') ?>,
                    redirect: <?= json_encode($item['redirect'] ?? '') ?>,
                    showButton: <?= !empty($item['button']) ? 'true' : 'false' ?>
                }
            }
        },

        mounted() {
            const el = this.$refs.sortableList;
            Sortable.create(el, {
                animation: 150,
                handle: '.fa-grip-vertical', // <-- handle para mover
                ghostClass: 'bg-gray-100',
                onEnd: (evt) => {
                    const movedItem = this.items.splice(evt.oldIndex, 1)[0];
                    this.items.splice(evt.newIndex, 0, movedItem);
                    this.saveOrder(); // Guarda en backend
                }
            });
        },

        methods: {
            saveOrder() {
                const data = this.items.map((item, index) => ({
                    id: item.id,
                    orden: index + 1
                }));

                fetch('/item/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            console.log('Orden guardado');
                        } else {
                            Swal.fire('Error', 'No se pudo guardar el orden', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Hubo un problema de conexión', 'error');
                    });
            },
            confirmDelete(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/post/delete/' + id;
                    }
                });
            },

            addItem() {
                if (!this.item.title) {
                    Swal.fire('Error', 'El título es obligatorio', 'error');
                    return;
                }
                this.items.push({ ...this.item });
                this.item = { title: '', copy: '', button: '', redirect: '', showButton: false };
                this.showModal = false;
            },

            removeItem(index) {
                this.items.splice(index, 1);
            }
        }
    })
    createPost.mount('#edit-post');
</script>

<?= $this->endSection() ?>