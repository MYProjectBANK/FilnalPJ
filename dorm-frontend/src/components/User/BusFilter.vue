<template>
  <FilterButton label="การเดินทาง">
    <div class="space-y-1">
      <button
        v-for="b in busRoutes"
        :key="b.id"
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="emit('select', b.id)"
      >
        <span>สาย {{ b.route_number }} - {{ b.route_name }}</span>
        <span v-if="modelValue === b.id" class="text-green-500 font-bold">✓</span>
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import FilterButton from './FilterButton.vue';

defineProps({
  busRoutes: Array,
  modelValue: Number,
});

const emit = defineEmits(["select"]);
</script>
