<template>
  <swiper :slides-per-view="1.2" :space-between="16" :breakpoints="{
    640: { slidesPerView: 2.2 },
    1024: { slidesPerView: 3.3 }
  }" class="pb-6">
    <swiper-slide v-for="d in dorms" :key="d.id">
      <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden 
               cursor-pointer transition hover:shadow-xl" @click="goDetail(d.id)">
        <!-- รูป -->
        <div class="overflow-hidden h-40">
          <img :src="getImageUrl(d)" class="w-full h-full object-cover transition duration-300 hover:scale-110" />
        </div>

        <!-- ข้อมูล -->
        <div class="p-4 space-y-1">
          <h3 class="font-semibold text-lg text-gray-800 truncate">
            {{ d.name }}
          </h3>

          <p class="text-blue-600 font-semibold text-sm">
            {{ d.price_range || "ไม่ระบุราคา" }}
          </p>

          <p class="text-xs text-gray-500">
            โซน: {{ d.zones?.[0]?.name || "ไม่ระบุ" }}
          </p>
        </div>
      </div>
    </swiper-slide>


  </swiper>
</template>

<script setup>
import 'swiper/css';

import {
  Swiper,
  SwiperSlide,
} from 'swiper/vue';
import { useRouter } from 'vue-router';

defineProps({
  dorms: Array,
});

const router = useRouter();

const goDetail = (id) => {
  router.push(`/dorms/${id}`);
};

const getImageUrl = (dorm) => {
  if (dorm.images?.length) {
    return `http://127.0.0.1:8000/storage/${dorm.images[0].image_path}`;
  }
  return "/no-image.jpg";
};
</script>
