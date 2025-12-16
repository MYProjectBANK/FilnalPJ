<template>
  <div class="relative inline-block w-full">
    <button
      @click="toggle"
      class="w-full flex justify-between items-center px-5 py-2 border rounded-full hover:bg-gray-100 transition bg-white"
    >
      <span class="text-gray-700 text-sm truncate">
        {{ label }}
      </span>
      <span class="text-gray-600 text-lg">≡</span>
    </button>

    <div
      v-if="open"
      class="absolute left-0 mt-2 p-3 bg-white border rounded-2xl shadow-md w-full z-50 max-h-64 overflow-auto"
    >
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  label: String,
});

const open = ref(false);
const toggle = () => (open.value = !open.value);
</script>
