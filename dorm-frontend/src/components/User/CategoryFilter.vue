<template>
  <FilterButton
    label="หมวดหมู่"
    icon="🏷️"
    :summary="selectedName"
    :badge="modelValue ? 'เลือกแล้ว' : ''"
  >
    <div class="space-y-1">
      <button
        v-for="c in categories"
        :key="c.id"
        class="flex justify-between items-center w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition"
        @click="choose(c.id)"
      >
        <span class="text-sm text-gray-800">{{ c.name }}</span>
        <span v-if="modelValue === c.id" class="text-green-600 font-bold">✓</span>
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import { computed } from 'vue';

import FilterButton from './FilterButton.vue';

const props = defineProps({
  categories: Array,
  modelValue: Number,
});

const emit = defineEmits(["select"]);

const selectedName = computed(() => {
  const c = props.categories?.find(x => x.id === props.modelValue);
  return c ? c.name : "";
});

const choose = (id) => {
  emit("select", id);

};
</script>
