<template>
  <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-3">
    <img
      :src="imageUrl(dorm?.images?.[0]?.image_path)"
      class="rounded-lg h-40 w-full object-cover"
    />

    <h3 class="font-bold mt-2">{{ dorm.name }}</h3>

    <p class="text-sm text-gray-500">
      ราคา {{ dorm.min_price }} - {{ dorm.max_price }} บาท/เดือน
    </p>

    <button
      @click="open"
      class="mt-3 w-full bg-blue-600 text-white py-1 rounded"
    >
      ดูรายละเอียด
    </button>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const props = defineProps({
  dorm: Object,
});

const router = useRouter();

const open = () => {
  router.push(`/dorms/${props.dorm.id}`);
};

const imageUrl = (path) => {
  if (!path) return "/assets/no-image.png";
  return `http://127.0.0.1:8000/storage/${path}`;
};
</script>
