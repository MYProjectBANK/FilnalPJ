<template>
  <div class="max-w-7xl mx-auto px-4 mt-20 grid grid-cols-1 md:grid-cols-2 gap-10">

    <!-- LEFT IMAGE BANNER -->
    <div class="relative group rounded-xl overflow-hidden shadow-lg">
      <img
        :src="bannerImage"
        class="w-full h-80 object-cover transform group-hover:scale-105 transition duration-500"
      />

      <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 text-white">
        <p class="text-sm opacity-90">สถานศึกษา</p>

        <h2 class="text-3xl font-bold mt-1 leading-tight">
          รวมอพาร์ทเม้นท์ใกล้สถานศึกษา<br>ชั้นนำในไทย
        </h2>

        <button
          class="mt-6 bg-white/20 hover:bg-white/30 backdrop-blur px-5 py-2 rounded-lg text-white font-medium w-fit transition"
          @click="$emit('viewAll')"
        >
          ดูสถานศึกษาทั้งหมด →
        </button>
      </div>
    </div>

    <!-- RIGHT CONTENT -->
    <div class="flex flex-col justify-center">
      <h2 class="text-2xl font-bold mb-3">
        รวมอพาร์ทเม้นท์ใกล้สถานศึกษายอดนิยมในไทย
      </h2>

      <div class="h-1 w-12 bg-gray-800 rounded mb-6"></div>

      <div class="flex gap-4 overflow-x-auto pb-3">
        <div
          v-for="u in universities"
          :key="u.id"
          class="w-32 flex-shrink-0 cursor-pointer"
          @click="$emit('select', u)"
        >
          <img
            :src="u.img"
            class="w-full h-24 object-cover rounded-lg shadow"
          />
          <p class="mt-2 text-sm text-center truncate font-medium">{{ u.name }}</p>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
const props = defineProps({
  universities: {
    type: Array,
    default: () => []
  },
  bannerImage: {
    type: String,
    default: "/img/university-banner.jpg"
  }
});

defineEmits(["select", "viewAll"]);
</script>
