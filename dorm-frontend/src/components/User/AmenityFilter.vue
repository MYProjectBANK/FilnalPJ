<template>
  <FilterButton label="สิ่งอำนวยความสะดวก">
    <div class="space-y-1">
      <button
        v-for="a in amenities"
        :key="a.id"
        class="flex justify-between items-center w-full text-left px-2 py-1 hover:bg-gray-100 rounded"
        @click="toggleAmenity(a.id)"
      >
        <span>{{ a.name }}</span>

        <!-- ✓ ถ้าเลือกอยู่ -->
        <span
          v-if="modelValue.includes(a.id)"
          class="text-green-500 font-bold"
        >
          ✓
        </span>
      </button>
    </div>
  </FilterButton>
</template>

<script setup>
import FilterButton from './FilterButton.vue';

const props = defineProps({
  amenities: Array,
  modelValue: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["select"]);

const toggleAmenity = (id) => {
  let next = [...props.modelValue];

  if (next.includes(id)) {
    // เอาออก
    next = next.filter((x) => x !== id);
  } else {
    // เพิ่ม
    next.push(id);
  }

  emit("select", next);
};
</script>
