<template>
  <FilterButton
    label="ช่วงราคา"
    icon="💸"
    :summary="selectedLabel"
    :badge="modelValue ? 'เลือกแล้ว' : ''"
  >
    <div class="space-y-1 text-sm">
      <button
        v-for="p in priceOptions"
        :key="p.value"
        class="flex justify-between items-center w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition"
        @click="select(p.value)"
      >
        <span class="text-sm text-gray-800">{{ p.label }}</span>
        <span v-if="modelValue === p.value" class="text-green-600 font-bold">✓</span>
      </button>

      <button
        v-if="modelValue"
        class="mt-2 w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 text-xs text-gray-500 transition"
        @click="select('')"
      >
        ล้างช่วงราคา
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import { computed } from 'vue';

import FilterButton from './FilterButton.vue';

const props = defineProps({
  modelValue: { type: String, default: "" },
});

const emit = defineEmits(["select"]);

const priceOptions = [
  { value: "0-3000", label: "ต่ำกว่า 3000" },
  { value: "3000-5000", label: "3000 - 5000" },
  { value: "5000-8000", label: "5000 - 8000" },
  { value: "8000-999999", label: "มากกว่า 8000" },
];

const selectedLabel = computed(() => {
  const found = priceOptions.find(x => x.value === props.modelValue);
  return found ? found.label : "";
});

const select = (val) => emit("select", val);
</script>
