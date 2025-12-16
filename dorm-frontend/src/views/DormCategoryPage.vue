<template>
  <div class="min-h-screen bg-gray-50">

    <div class="max-w-7xl mx-auto px-4 py-8">

      <!-- HEADER -->
      <div class="bg-white rounded-xl shadow-sm p-6 mb-8">

        <!-- 🔙 Back -->
        <button
          @click="$router.back()"
          class="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition mb-4"
        >
          <span class="text-lg">←</span>
          <span>ย้อนกลับ</span>
        </button>

        <!-- TITLE -->
        <h1 class="text-3xl font-bold text-gray-800">
          {{ pageTitle }}
        </h1>

        <p class="text-gray-500 mt-1">
          แสดงรายการหอพักทั้งหมดในหมวดหมู่นี้
        </p>
      </div>

      <!-- CONTENT -->
      <div class="space-y-6">

        <!-- มีข้อมูล -->
        <DormCarousel
          v-if="dorms.length > 0"
          :dorms="dorms"
        />

        <!-- ไม่มีข้อมูล -->
        <div
          v-else
          class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-500"
        >
          😔 ไม่พบหอพักในหมวดหมู่นี้
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import {
  onMounted,
  ref,
} from 'vue';

import { useRoute } from 'vue-router';

import axios from '../axios';
import DormCarousel from '../components/User/DormCarousel.vue';

const route = useRoute();
const type = route.params.type;

const dorms = ref([]);
const pageTitle = ref("");

// map หมวด → API ID + ชื่อหมวด
const typeMap = {
  male: { id: 1, title: "หอพักชายล้วน" },
  female: { id: 2, title: "หอพักหญิงล้วน" },
  shared: { id: 3, title: "หอพักรวม" },
  save: { id: 4, title: "หอพักราคาประหยัด" },
  premium: { id: 5, title: "หอพักพรีเมี่ยม" },
};

onMounted(async () => {
  const info = typeMap[type];

  if (!info) return;

  pageTitle.value = info.title;

  const res = await axios.get(`/api/dorms/by-category/${info.id}`);
  dorms.value = res.data;
});
</script>
