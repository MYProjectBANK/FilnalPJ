<template>
  <DashboardLayout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">

      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">แผงควบคุมระบบ</h1>
          <p class="text-gray-500 mt-1 text-sm">
            ภาพรวมข้อมูลระบบและงานที่ต้องดำเนินการ, ข้อมูลอัปเดตล่าสุด ณ วันนี้
          </p>
        </div>

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-white text-sm text-gray-600">
          <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span>{{ currentDate }}</span>
        </div>
      </div>

      <!-- Main Stats -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="stat-label">หอพักทั้งหมด</p>
              <p class="stat-value">{{ stats.dorms || 0 }}</p>
              <p class="stat-help">รายการหอพักที่อยู่ในระบบ</p>
            </div>

            <div class="stat-icon bg-blue-50 text-blue-700 border-blue-100">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1V10z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="stat-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="stat-label">ผู้ใช้งานทั้งหมด</p>
              <p class="stat-value">{{ stats.users || 0 }}</p>
              <p class="stat-help">สมาชิกที่ลงทะเบียนทั้งหมด</p>
            </div>

            <div class="stat-icon bg-emerald-50 text-emerald-700 border-emerald-100">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-4a4 4 0 10-8 0 4 4 0 008 0z" />
              </svg>
            </div>
          </div>
        </div>

        <div class="stat-card border-amber-200 bg-amber-50/30">
          <div class="flex items-start justify-between">
            <div>
              <p class="stat-label">รีวิวรออนุมัติ</p>
              <p class="stat-value">{{ stats.reviews_pending || 0 }}</p>
              <p class="stat-help">รายการที่ต้องตรวจสอบ</p>
            </div>

            <div class="stat-icon bg-amber-50 text-amber-700 border-amber-100">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
              </svg>
            </div>
          </div>

          <div v-if="(stats.reviews_pending || 0) > 0" class="mt-4">
            <button
              @click="$router.push('/admin/reviews')"
              class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                     bg-amber-600 text-white hover:bg-amber-700 transition
                     focus:outline-none focus:ring-2 focus:ring-amber-200"
            >
              ไปตรวจสอบรีวิว
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- System Config -->
      <div>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-base font-bold text-gray-900">ข้อมูลตั้งค่าระบบ</h2>
          <p class="text-xs text-gray-500">จำนวนข้อมูลที่เกี่ยวข้องกับระบบ</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
          <div class="mini-card">
            <p class="mini-label">หมวดหมู่</p>
            <p class="mini-value">{{ stats.categories || 0 }}</p>
          </div>
          <div class="mini-card">
            <p class="mini-label">สิ่งอำนวยความสะดวก</p>
            <p class="mini-value">{{ stats.amenities || 0 }}</p>
          </div>
          <div class="mini-card">
            <p class="mini-label">โซนพื้นที่</p>
            <p class="mini-value">{{ stats.zones || 0 }}</p>
          </div>
          <div class="mini-card">
            <p class="mini-label">สายรถเมล์</p>
            <p class="mini-value">{{ stats.bus_routes || 0 }}</p>
          </div>
          <div class="mini-card">
            <p class="mini-label">เส้นทางรถไฟฟ้า</p>
            <p class="mini-value">{{ stats.train_lines || 0 }}</p>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900">จัดการข้อมูลหอพัก</h3>
          <p class="text-sm text-gray-500 mt-1">
            เพิ่ม / แก้ไข / อัปโหลดรูปภาพ และจัดการรายละเอียดหอพักในระบบ
          </p>
        </div>

        <div class="flex gap-2">
          <button
            @click="$router.push('/admin/dorms')"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                   bg-indigo-600 text-white hover:bg-indigo-700 transition
                   focus:outline-none focus:ring-2 focus:ring-indigo-200"
          >
            ไปหน้าจัดการหอพัก
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

    </div>
  </DashboardLayout>
</template>

<script setup>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';

const stats = ref({});
const loading = ref(true);

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchStats = async () => {
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/dashboard/stats", config);
    stats.value = res.data;
  } catch (error) {
    console.error("Failed to fetch stats", error);
  } finally {
    loading.value = false;
  }
};

const currentDate = computed(() => {
  return new Date().toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});

onMounted(fetchStats);
</script>

<style scoped>
@reference "tailwindcss";

.stat-card {
  @apply bg-white rounded-2xl border border-gray-200 p-6 shadow-sm;
}
.stat-label {
  @apply text-xs font-semibold text-gray-500 uppercase tracking-wider;
}
.stat-value {
  @apply text-3xl font-bold text-gray-900 mt-2;
}
.stat-help {
  @apply text-sm text-gray-500 mt-1;
}
.stat-icon {
  @apply w-11 h-11 rounded-2xl border flex items-center justify-center;
}

.mini-card {
  @apply bg-white rounded-2xl border border-gray-200 p-4 shadow-sm;
}
.mini-label {
  @apply text-xs font-semibold text-gray-500;
}
.mini-value {
  @apply text-2xl font-bold text-gray-900 mt-2;
}
</style>
