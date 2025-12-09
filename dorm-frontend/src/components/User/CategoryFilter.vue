<template>
  <div class="flex gap-2 flex-wrap my-4">
    <button
      v-for="c in categories"
      :key="c.id"
      @click="emit('select', c.id)"
      class="px-4 py-2 bg-gray-100 rounded hover:bg-blue-600 hover:text-white"
    >
      {{ c.name }}
    </button>
  </div>
</template>

<script setup>
defineProps({ categories: Array });
const emit = defineEmits(["select"]);
</script>
