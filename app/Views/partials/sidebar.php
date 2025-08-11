<aside id="sidebar" class="fixed inset-y-0 left-0 w-20 bg-gray-900 border-r border-gray-800 shadow-xl flex flex-col 
                  transform transition-transform duration-300 ease-in-out md:translate-x-0">
  <div class="p-3 border-b border-gray-800 bg-gray-950">
    <div class="aspect-square flex items-center justify-center">
      <i class="fa-solid fa-v text-white w-5 h-5"></i>
    </div>
  </div>

  <nav class="p-2 flex-1">
    <ul class="space-y-1 text-gray-300 font-medium">
      <li class="aspect-square">
        <a href="/"
           class="flex items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-tachometer-alt w-5 h-5"
             :class="{'text-white': url === '', 'text-gray-500': url !== ''}"></i>
        </a>
      </li>
    </ul>

    <ul class="space-y-1 text-gray-300 font-medium">
      <li class="aspect-square">
        <a href="/users"
           class="flex items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-user-alt w-5 h-5"
             :class="{'text-white': url === 'users', 'text-gray-500': url !== 'users'}"></i>
        </a>
      </li>
    </ul>

    <ul class="space-y-1 text-gray-300 font-medium">
      <li class="aspect-square">
        <a href="/slider"
           class="flex items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-images w-5 h-5"
             :class="{'text-white': url === 'slider', 'text-gray-500': url !== 'slider'}"></i>
        </a>
      </li>
    </ul>

    <ul class="space-y-1 text-gray-300 font-medium">
      <li class="aspect-square">
        <a href="/post"
           class="flex items-center justify-center p-4 rounded-lg hover:bg-gray-800 transition-colors duration-200 hover:text-white">
          <i class="fas fa-folder w-5 h-5"
             :class="{'text-white': url === 'post', 'text-gray-500': url !== 'post'}"></i>
        </a>
      </li>
    </ul>
  </nav>
</aside>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;

const sidebar = createApp({
    data() {
      return {
        url: "<?= service('uri')->getSegment(1) ?>"
      }
    }
});

sidebar.mount('#sidebar');
</script>
