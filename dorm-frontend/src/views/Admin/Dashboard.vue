<template>
  <DashboardLayout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">แผงควบคุมระบบ</h1>
          <p class="text-gray-500 mt-1 flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
            ยินดีต้อนรับกลับมา, ข้อมูลอัปเดตล่าสุด ณ วันนี้
          </p>
        </div>
        <div class="px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-100 text-sm font-medium text-gray-600 flex items-center gap-2">
          📅 {{ currentDate }}
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card-premium bg-gradient-to-br from-blue-600 to-indigo-700">
          <div class="flex justify-between items-start text-white">
            <div>
              <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">หอพักทั้งหมด</p>
              <h3 class="text-4xl font-bold mt-1">{{ stats.dorms || 0 }}</h3>
            </div>
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md text-2xl">🏠</div>
          </div>
          <div class="mt-4 text-blue-100 text-xs flex items-center gap-1">
            <span>จัดการข้อมูลหอพักในระบบ</span>
          </div>
        </div>

        <div class="stat-card-premium bg-gradient-to-br from-emerald-500 to-teal-600">
          <div class="flex justify-between items-start text-white">
            <div>
              <p class="text-emerald-50 text-sm font-medium uppercase tracking-wider">ผู้ใช้งานทั้งหมด</p>
              <h3 class="text-4xl font-bold mt-1">{{ stats.users || 0 }}</h3>
            </div>
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md text-2xl">👥</div>
          </div>
          <div class="mt-4 text-emerald-50 text-xs flex items-center gap-1">
            <span>สมาชิกที่ลงทะเบียนแล้ว</span>
          </div>
        </div>

        <div class="stat-card-premium bg-gradient-to-br from-rose-500 to-pink-600">
          <div class="flex justify-between items-start text-white">
            <div>
              <p class="text-rose-50 text-sm font-medium uppercase tracking-wider">รีวิวที่รออนุมัติ</p>
              <h3 class="text-4xl font-bold mt-1">{{ stats.reviews_pending || 0 }}</h3>
            </div>
            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md text-2xl">🔔</div>
          </div>
          <div class="mt-4 text-rose-50 text-xs flex items-center gap-1 font-bold">
            <span class="animate-pulse">●</span> ต้องดำเนินการตรวจสอบ
          </div>
        </div>
      </div>

      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
          📊 ข้อมูลตั้งค่าระบบ
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
          <div class="sub-stat-card border-purple-100 hover:border-purple-300">
            <span class="text-2xl mb-2">📂</span>
            <div class="text-2xl font-bold text-purple-700">{{ stats.categories || 0 }}</div>
            <div class="text-xs text-gray-500 font-semibold uppercase">หมวดหมู่</div>
          </div>
          <div class="sub-stat-card border-cyan-100 hover:border-cyan-300">
            <span class="text-2xl mb-2">✨</span>
            <div class="text-2xl font-bold text-cyan-700">{{ stats.amenities || 0 }}</div>
            <div class="text-xs text-gray-500 font-semibold uppercase">สิ่งอำนวยความสะดวก</div>
          </div>
          <div class="sub-stat-card border-amber-100 hover:border-amber-300">
            <span class="text-2xl mb-2">📍</span>
            <div class="text-2xl font-bold text-amber-700">{{ stats.zones || 0 }}</div>
            <div class="text-xs text-gray-500 font-semibold uppercase">โซนพื้นที่</div>
          </div>
          <div class="sub-stat-card border-orange-100 hover:border-orange-300">
            <span class="text-2xl mb-2">🚌</span>
            <div class="text-2xl font-bold text-orange-700">{{ stats.bus_routes || 0 }}</div>
            <div class="text-xs text-gray-500 font-semibold uppercase">สายรถเมล์</div>
          </div>
          <div class="sub-stat-card border-indigo-100 hover:border-indigo-300">
            <span class="text-2xl mb-2">🚆</span>
            <div class="text-2xl font-bold text-indigo-700">{{ stats.train_lines || 0 }}</div>
            <div class="text-xs text-gray-500 font-semibold uppercase">เส้นทางรถไฟฟ้า</div>
          </div>
        </div>
      </div>

      <div class="bg-indigo-900 rounded-2xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden">
        <div class="relative z-10">
          <h2 class="text-xl font-bold mb-2">ต้องการเพิ่มหอพักใหม่หรือไม่?</h2>
          <p class="text-indigo-200 text-sm">คุณสามารถเพิ่มข้อมูลหอพักและอัปโหลดรูปภาพได้ทันทีที่นี่</p>
        </div>
        <button @click="$router.push('/admin/dorms')" class="relative z-10 px-6 py-3 bg-white text-indigo-900 font-bold rounded-xl hover:bg-indigo-50 transition shadow-lg">
          + จัดการหอพัก
        </button>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
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
const config = { headers: { Authorization: `Bearer ${token}` }};

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

/* การ์ดสถิติหลัก */
.stat-card-premium {
  @apply p-6 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 cursor-default relative overflow-hidden;
}

/* การ์ดสถิติย่อย */
.sub-stat-card {
  @apply bg-white p-5 rounded-2xl shadow-sm border flex flex-col items-center justify-center transition-all duration-200 hover:shadow-md hover:bg-gray-50 cursor-pointer;
}

/* Animation */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.grid {
  animation: fadeInUp 0.5s ease-out forwards;
}
</style>