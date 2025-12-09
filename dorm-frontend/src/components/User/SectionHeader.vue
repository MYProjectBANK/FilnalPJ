<template>
  <div class="flex justify-between items-center my-6">
    <h2 class="text-xl font-bold">{{ title }}</h2>

    <button
      v-if="showMore"
      class="text-blue-600 hover:underline"
    >
      ดูทั้งหมด >
    </button>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  showMore: Boolean,
});
</script>
