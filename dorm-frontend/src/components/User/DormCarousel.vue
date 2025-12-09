<template>
    <swiper :slides-per-view="1.3" :space-between="16" :breakpoints="{
        640: { slidesPerView: 2.3 },
        1024: { slidesPerView: 3.3 }
    }">
        <swiper-slide v-for="d in dorms" :key="d.id">
            <div class="bg-white shadow rounded overflow-hidden">
                <img :src="d.thumbnail" class="h-40 w-full object-cover" />

                <div class="p-3">
                    <h3 class="font-semibold">{{ d.name }}</h3>
                    <p class="text-sm text-gray-500">{{ d.price_range }}</p>
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

defineProps({
    dorms: Array,
});
</script>
