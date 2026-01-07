<template>
  <DashboardLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">

        <button @click="$router.push('/admin/dorms')"
          class="flex items-center text-gray-500 hover:text-gray-900 font-medium transition-colors group">
          <div
            class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm group-hover:border-gray-300">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
          </div>
          กลับไปหน้ารายการ
        </button>

        <div class="flex items-center gap-3" v-if="dorm">
          <button @click="openEditModal"
            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            แก้ไขข้อมูล
          </button>

          <button @click="deleteDorm"
            class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium rounded-lg shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            ลบหอพัก
          </button>
        </div>
      </div>

      <div v-if="loading"
        class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mb-4"></div>
        <p class="text-gray-500">กำลังโหลดข้อมูล...</p>
      </div>

      <div v-else-if="dorm">

        <DormDetailContent :dorm="dorm" :reviews="reviews" mode="admin" @approve-review="approveReview"
          @reject-review="rejectReview">

          <template #gallery>
            <div class="bg-gray-50 p-5 rounded-2xl border border-dashed border-gray-300 mb-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                  🖼️ รูปภาพในระบบ <span class="bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{
                    dorm.images.length }}</span>
                </h3>
              </div>

              <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div v-for="img in dorm.images" :key="img.id"
                  class="group relative aspect-[4/3] rounded-xl overflow-hidden bg-gray-200 shadow-sm border border-gray-200 cursor-pointer">

                  <img :src="imageUrl(img.image_path)"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />

                  <div
                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white text-xs font-medium border border-white/50 px-2 py-1 rounded">View</span>
                  </div>
                </div>

                <div v-if="!dorm.images.length"
                  class="col-span-full h-32 flex flex-col items-center justify-center text-gray-400 bg-white border border-gray-200 rounded-xl">
                  <span class="text-2xl mb-2">📷</span>
                  <span>ยังไม่มีรูปภาพ</span>
                </div>
              </div>
            </div>
          </template>

        </DormDetailContent>
      </div>

      <div v-else class="text-center py-20 bg-white rounded-xl shadow-sm">
        <p class="text-gray-500">ไม่พบข้อมูลหอพักนี้</p>
      </div>

    </div>

    <DormFormModal v-if="showModal" :show="showModal" mode="edit" :dormData="dorm" @close="showModal = false"
      @submit="handleUpdateDorm" />

  </DashboardLayout>
</template>

<script setup>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';
import {
  useRoute,
  useRouter,
} from 'vue-router';

import { imageUrl } from '@/utils/imageUrl';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';
import DormFormModal
  from '../../components/Admin/DormFormModal.vue'; // อย่าลืม Import Modal
import DormDetailContent from '../../components/Dorm/DormDetailContent.vue';

const route = useRoute();
const router = useRouter();

const dorm = ref(null);
const reviews = ref([]);
const loading = ref(true);

// Modal State
const showModal = ref(false);

const headers = {
  Authorization: `Bearer ${localStorage.getItem("token")}`,
};

// --- DATA FETCHING ---
const fetchDorm = async () => {
  try {
    const res = await axios.get(
      `/api/admin/dorms/${route.params.id}`,
      { headers }
    );
    dorm.value = res.data;
  } catch (e) {
    console.error(e);
  }
};

const fetchReviews = async () => {
  try {
    const res = await axios.get(
      `/api/reviews/${route.params.id}`,
      { headers }
    );
    reviews.value = res.data;
  } catch (e) {
    console.error(e);
  }
};

// --- ACTIONS ---
const approveReview = async (id) => {
  if (!confirm("ยืนยันอนุมัติรีวิว?")) return;
  await axios.put(`/api/admin/reviews/${id}/approve`, {}, { headers });
  await fetchReviews();
};

const rejectReview = async (id) => {
  if (!confirm("ยืนยันปฏิเสธรีวิว?")) return;
  await axios.put(`/api/admin/reviews/${id}/reject`, {}, { headers });
  await fetchReviews();
};

const deleteDorm = async () => {
  if (!confirm(`⚠️ คำเตือน: คุณต้องการลบ "${dorm.value.name}" ใช่หรือไม่?\nการกระทำนี้ไม่สามารถกู้คืนได้`)) return;

  try {
    await axios.delete(`/api/admin/dorms/${dorm.value.id}`, { headers });
    alert("ลบข้อมูลสำเร็จ");
    router.push('/admin/dorms');
  } catch (e) {
    alert("เกิดข้อผิดพลาดในการลบข้อมูล");
  }
};

// --- MODAL & EDIT LOGIC ---
const openEditModal = () => {
  showModal.value = true;
};

const handleUpdateDorm = async (form) => {
  // Logic การ Save เหมือนหน้า List แต่เปลี่ยน URL เป็น PUT
  const fd = new FormData();
  Object.keys(form).forEach(key => {
    if (key === "images") return;
    if (Array.isArray(form[key])) {
      form[key].forEach(v => fd.append(`${key}[]`, v));
    } else {
      fd.append(key, form[key] ?? "");
    }
  });

  if (form.images && form.images.length > 0) {
    form.images.forEach(file => fd.append("images[]", file));
  }

  try {
    const config = { headers: { ...headers, "Content-Type": "multipart/form-data" } };

    // ใช้ _method=PUT เพราะ FormData ส่ง PUT ตรงๆ ไม่ได้ในบาง Backend
    await axios.post(
      `/api/admin/dorms/${dorm.value.id}?_method=PUT`,
      fd,
      config
    );

    showModal.value = false;
    await fetchDorm(); // โหลดข้อมูลใหม่ทันที
    alert("แก้ไขข้อมูลสำเร็จ");
  } catch (e) {
    alert("บันทึกข้อมูลไม่สำเร็จ");
    console.error(e);
  }
};

// const imageUrl = (path) => {
//   if (!path) return "/no-image.jpg";
//   return `/storage/${path}`;
// };

onMounted(async () => {
  loading.value = true;
  await fetchDorm();
  await fetchReviews();
  loading.value = false;
});
</script>