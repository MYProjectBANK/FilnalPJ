<template>
  <div class="flex bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-2xl">
    <input
      v-model="keyword"
      placeholder="ค้นหาหอพัก..."
      class="flex-1 p-3 outline-none"
    />

    <button
      @click="emit('search', keyword)"
      class="bg-blue-600 text-white px-6"
    >
      ค้นหา
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const keyword = ref("");
const emit = defineEmits(["search"]);
</script>
