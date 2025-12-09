<template>
  <div class="flex h-screen">
    <Sidebar />

    <div class="flex-1 flex flex-col">
      <Header />

      <main class="p-4 overflow-auto flex-1 bg-gray-100">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script>
import Header from './Header.vue';
import Sidebar from './Sidebar.vue';

export default {
  components: { Sidebar, Header }
}
</script>
