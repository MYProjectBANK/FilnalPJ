<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <button @click="$router.back()"
        class="group mb-6 flex items-center text-gray-500 hover:text-blue-600 transition font-medium">
        <span class="bg-white p-2 rounded-full shadow-sm mr-2 group-hover:bg-blue-50">←</span>
        ย้อนกลับไปหน้าค้นหา
      </button>

      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
        <p class="text-gray-500">กำลังโหลดข้อมูลหอพัก...</p>
      </div>

      <div v-else-if="dorm">

        <DormDetailContent :dorm="dorm" :reviews="approvedReviews" mode="user">

          <template #favorite>
            <button v-if="isLoggedIn" @click="toggleFavorite"
              class="flex items-center gap-2 px-5 py-2.5 rounded-full font-medium transition-all shadow-sm border"
              :class="isFavorite
                ? 'bg-pink-50 text-pink-600 border-pink-200 hover:bg-pink-100'
                : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
              <span :class="isFavorite ? 'scale-110' : ''" class="transition-transform duration-200">
                {{ isFavorite ? "❤️" : "🤍" }}
              </span>
              <span>{{ isFavorite ? "บันทึกแล้ว" : "บันทึกรายการโปรด" }}</span>
            </button>
          </template>

          <template #gallery>
            <swiper :slides-per-view="1" :space-between="0" :pagination="{ clickable: true }" :navigation="true"
              :modules="[Pagination, Navigation]" class="w-full h-[300px] md:h-[450px] bg-gray-200 group">
              <swiper-slide v-for="img in dorm.images" :key="img.id">
                <img :src="imageUrl(img.image_path)" class="w-full h-full object-cover" />
              </swiper-slide>

              <swiper-slide v-if="!dorm.images.length">
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                  <span class="text-4xl mb-2">📷</span>
                  <span>ไม่มีรูปภาพ</span>
                </div>
              </swiper-slide>

            </swiper>
          </template>

          <template #review-form>
            <div v-if="isLoggedIn" class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
              <h3 class="font-semibold text-gray-800 mb-3">เขียนรีวิวของคุณ</h3>
              <div class="relative">
                <textarea v-model="reviewForm.comment" rows="3"
                  class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition resize-none"
                  placeholder="เล่าประสบการณ์การพักที่นี่..."></textarea>

                <div class="flex justify-between items-center mt-3">
                  <span class="text-xs text-gray-400">* รีวิวจะแสดงหลังจากได้รับการอนุมัติ</span>
                  <button
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    @click="submitReview" :disabled="submittingReview || !reviewForm.comment">
                    {{ submittingReview ? "กำลังส่ง..." : "โพสต์รีวิว" }}
                  </button>
                </div>
              </div>
            </div>

            <div v-else class="bg-blue-50 p-4 rounded-lg flex items-center justify-between">
              <span class="text-blue-800 text-sm">เข้าสู่ระบบเพื่อเขียนรีวิวแบ่งปันประสบการณ์</span>
              <router-link to="/login"
                class="text-blue-600 font-semibold text-sm hover:underline">เข้าสู่ระบบ</router-link>
            </div>
          </template>

        </DormDetailContent>
      </div>

      <div v-else class="text-center py-20">
        <div class="text-6xl mb-4">🏠❓</div>
        <h2 class="text-2xl font-bold text-gray-700">ไม่พบข้อมูลหอพัก</h2>
        <p class="text-gray-500 mt-2">หอพักที่คุณค้นหาอาจถูกลบหรือไม่มีอยู่จริง</p>
        <button @click="$router.push('/dorms')"
          class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
          ดูหอพักทั้งหมด
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation'; // อย่าลืม import css ของ module

import {
  computed,
  onMounted,
  ref,
} from 'vue';

// เพิ่ม Modules ของ Swiper
import {
  Navigation,
  Pagination,
} from 'swiper/modules';
import {
  Swiper,
  SwiperSlide,
} from 'swiper/vue';
import {
  useRoute,
  useRouter,
} from 'vue-router';

import api from '../axios';
import DormDetailContent from '../components/Dorm/DormDetailContent.vue';

const route = useRoute();
const router = useRouter(); // เพิ่ม router เพื่อใช้ push

const dorm = ref(null);
const reviews = ref([]);
const loading = ref(true);
const submittingReview = ref(false);

const isLoggedIn = !!localStorage.getItem("token");
const isFavorite = ref(false);

const reviewForm = ref({ comment: "" });

const approvedReviews = computed(() =>
  reviews.value.filter((r) => r.status === "approved")
);

const fetchDorm = async () => {
  try {
    const res = await api.get(`/api/dorms/${route.params.id}`);
    dorm.value = res.data;
  } catch (e) {
    console.error(e);
    dorm.value = null;
  }
};

const fetchReviews = async () => {
  try {
    const res = await api.get(`/api/reviews/${route.params.id}`);
    reviews.value = res.data;
  } catch (e) {
    console.error(e);
  }
};

const imageUrl = (path) => {
  if (!path) return "/no-image.jpg"; // แก้ path ตามจริง
  return `http://127.0.0.1:8000/storage/${path}`;
};

// FAVORITE
const fetchFavoriteStatus = async () => {
  if (!isLoggedIn) return;
  try {
    const res = await api.get(`/api/favorites`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });
    const id = Number(route.params.id);
    isFavorite.value = res.data.some((f) => f.dorm_id === id);
  } catch (e) {
    console.error(e);
  }
};

const toggleFavorite = async () => {
  const id = route.params.id;
  const headers = { Authorization: `Bearer ${localStorage.getItem("token")}` };

  try {
    if (!isFavorite.value) {
      await api.post(`/api/favorites/add/${id}`, {}, { headers });
      isFavorite.value = true;
    } else {
      await api.delete(`/api/favorites/remove/${id}`, { headers });
      isFavorite.value = false;
    }
  } catch (e) {
    alert("เกิดข้อผิดพลาดในการบันทึกรายการโปรด");
  }
};

// REVIEW
const submitReview = async () => {
  submittingReview.value = true;
  try {
    await api.post(
      `/api/reviews`,
      { dorm_id: route.params.id, comment: reviewForm.value.comment },
      { headers: { Authorization: `Bearer ${localStorage.getItem("token")}` } }
    );
    reviewForm.value.comment = "";
    await fetchReviews();
  } catch (e) {
    alert("ไม่สามารถส่งรีวิวได้");
  } finally {
    submittingReview.value = false;
  }
};

onMounted(async () => {
  loading.value = true;
  await fetchDorm();
  if (dorm.value) {
    await fetchReviews();
    await fetchFavoriteStatus();
  }
  loading.value = false;
});
</script>