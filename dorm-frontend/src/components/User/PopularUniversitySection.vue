<template>
  <div class="max-w-7xl mx-auto px-4 mt-20 grid grid-cols-1 md:grid-cols-2 gap-10">

    <!-- LEFT IMAGE BANNER -->
    <div class="relative group rounded-xl overflow-hidden shadow-lg">
      <img :src="bannerImage"
        class="w-full h-80 object-cover transform group-hover:scale-105 transition duration-500" />

      <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-6 text-white">
        <p class="text-sm opacity-90">มหาวิทยาลัยเทคโนโลยีราชมงคลพระนคร</p>

        <h2 class="text-3xl font-bold mt-1 leading-tight">
          รวมอพาร์ทเม้นท์ใกล้สถานศึกษา<br>ที่ดีที่สุด
        </h2>


      </div>
    </div>

    <!-- RIGHT CONTENT -->
    <div class="flex flex-col justify-center">
      <h2 class="text-2xl font-bold mb-3">
        รวมอพาร์ทเม้นท์ใกล้สถานศึกษายอดนิยมในไทย
      </h2>

      <div class="h-1 w-12 bg-gray-800 rounded mb-6"></div>

      <div class="flex gap-4 overflow-x-auto pb-3">
        <div v-for="u in universities" :key="u.id" class="w-32 shrink-0 cursor-pointer group"
          @click="$emit('select', u)">
          <!-- รูป + overlay -->
          <div class="relative h-24 rounded-lg overflow-hidden shadow">
            <img :src="u.img" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              alt="" />
            <!-- ทำให้รูปทึบขึ้น -->
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
          </div>

          <p class="mt-2 text-sm text-center truncate font-medium text-gray-800 group-hover:text-blue-700 transition">
            {{ u.name }}
          </p>
        </div>
      </div>

    </div>

  </div>
</template>

<script setup>
import defaultBanner from '@/assets/Img/maxresdefault.jpg';

const props = defineProps({
  universities: {
    type: Array,
    default: () => []
  },
  bannerImage: {
    type: String,
    default: defaultBanner
  }
});


defineEmits(["select", "viewAll"]);
</script>
