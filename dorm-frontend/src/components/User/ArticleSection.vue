<template>
  <div class="max-w-7xl mx-auto px-4 py-16">

    <!-- TITLE -->
    <div class="text-center mb-10">
      <h2 class="text-3xl font-bold">
        {{ title }}
        <span class="text-red-500">{{ highlight }}</span>
      </h2>
      <p class="text-gray-600 mt-2">{{ subtitle }}</p>
    </div>

    <!-- ARTICLE CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div
        v-for="item in items"
        :key="item.id"
        class="bg-gray-200 h-56 rounded-xl shadow cursor-pointer hover:scale-[1.02] hover:shadow-lg transition"
        @click="$emit('select', item)"
      >
        <img
          v-if="item.image"
          :src="item.image"
          class="w-full h-full object-cover rounded-xl"
        />
      </div>
    </div>

  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: "Interesting" },
  highlight: { type: String, default: "article" },
  subtitle: { type: String, default: "บทความที่น่าสนใจ อพาร์ทเม้นท์น่ารู้" },

  items: {
    type: Array,
    default: () => [
      { id: 1, image: null },
      { id: 2, image: null },
      { id: 3, image: null },
    ]
  }
});

defineEmits(["select"]);
</script>
