<template>
  <FilterButton label="ช่วงราคา">
    <div class="space-y-1 text-sm">
      <button
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="select('0-3000')"
      >
        <span>ต่ำกว่า 3000</span>
        <span v-if="modelValue === '0-3000'" class="text-green-500 font-bold">✓</span>
      </button>

      <button
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="select('3000-5000')"
      >
        <span>3000 - 5000</span>
        <span v-if="modelValue === '3000-5000'" class="text-green-500 font-bold">✓</span>
      </button>

      <button
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="select('5000-8000')"
      >
        <span>5000 - 8000</span>
        <span v-if="modelValue === '5000-8000'" class="text-green-500 font-bold">✓</span>
      </button>

      <button
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="select('8000-999999')"
      >
        <span>มากกว่า 8000</span>
        <span v-if="modelValue === '8000-999999'" class="text-green-500 font-bold">✓</span>
      </button>

      <button
        class="mt-2 w-full text-left px-2 py-1 hover:bg-gray-50 rounded text-xs text-gray-500"
        @click="select(null)"
      >
        ล้างช่วงราคา
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import FilterButton from './FilterButton.vue';

defineProps({
  modelValue: String,
});

const emit = defineEmits(["select"]);

const select = (val) => {
  emit("select", val);
};
</script>
