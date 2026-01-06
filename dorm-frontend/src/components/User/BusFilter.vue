<template>
  <FilterButton
    label="การเดินทาง"
    icon="🚌"
    :summary="selectedLabel"
    :badge="modelValue ? 'เลือกแล้ว' : ''"
  >
    <div class="space-y-1">
      <button
        v-for="b in busRoutes"
        :key="b.id"
        class="flex justify-between items-center w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition"
        @click="emit('select', b.id)"
      >
        <span class="text-sm text-gray-800">สาย {{ b.route_number }} - {{ b.route_name }}</span>
        <span v-if="modelValue === b.id" class="text-green-600 font-bold">✓</span>
      </button>

      <button
        v-if="modelValue"
        class="mt-2 w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 text-xs text-gray-500 transition"
        @click="emit('select', null)"
      >
        ล้างการเดินทาง
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import { computed } from 'vue';

import FilterButton from './FilterButton.vue';

const props = defineProps({
  busRoutes: { type: Array, default: () => [] },
  modelValue: { type: Number, default: null },
});

const emit = defineEmits(["select"]);

const selectedLabel = computed(() => {
  const b = props.busRoutes.find(x => x.id === props.modelValue);
  return b ? `สาย ${b.route_number} - ${b.route_name}` : "";
});
</script>
