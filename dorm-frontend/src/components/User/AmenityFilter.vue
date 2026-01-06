<template>
  <FilterButton
    label="สิ่งอำนวยความสะดวก"
    icon="✨"
    :summary="summary"
    :badge="modelValue.length ? modelValue.length : ''"
  >
    <div class="space-y-1">
      <button
        v-for="a in amenities"
        :key="a.id"
        class="flex justify-between items-center w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition"
        @click="toggleAmenity(a.id)"
      >
        <span class="text-sm text-gray-800">{{ a.name }}</span>
        <span v-if="modelValue.includes(a.id)" class="text-green-600 font-bold">✓</span>
      </button>

      <button
        v-if="modelValue.length"
        class="mt-2 w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 text-xs text-gray-500 transition"
        @click="emit('select', [])"
      >
        ล้างสิ่งอำนวยความสะดวก
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import { computed } from 'vue';

import FilterButton from './FilterButton.vue';

const props = defineProps({
  amenities: { type: Array, default: () => [] },
  modelValue: { type: Array, default: () => [] },
});

const emit = defineEmits(["select"]);

const summary = computed(() => {
  if (!props.modelValue.length) return "";
  const first = props.amenities.find(a => a.id === props.modelValue[0])?.name;
  const extra = props.modelValue.length - 1;
  return extra > 0 ? `${first} +${extra}` : (first || `เลือก ${props.modelValue.length} รายการ`);
});

const toggleAmenity = (id) => {
  let next = [...props.modelValue];
  if (next.includes(id)) next = next.filter(x => x !== id);
  else next.push(id);
  emit("select", next);
};
</script>
