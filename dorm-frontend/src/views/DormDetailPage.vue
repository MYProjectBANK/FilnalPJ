<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <button type="button" @click="$router.back()" class="group mb-6 inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2
         text-sm font-semibold text-gray-700 shadow-sm transition
         hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700
         focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <span class="grid h-9 w-9 place-items-center rounded-lg bg-gray-50 text-gray-600 transition
           group-hover:bg-white group-hover:text-blue-700" aria-hidden="true">
          <!-- Arrow Left (SVG) -->
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </span>

        <span>ย้อนกลับไปหน้าค้นหา</span>
      </button>


      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
        <p class="text-gray-500">กำลังโหลดข้อมูลหอพัก...</p>
      </div>

      <div v-else-if="dorm">

        <DormDetailContent :dorm="dorm" :reviews="approvedReviews" mode="user">

          <template #favorite>
            <button v-if="isLoggedIn" @click="toggleFavorite" type="button" class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition
           shadow-sm border focus:outline-none focus:ring-2 focus:ring-offset-2" :class="isFavorite
            ? 'bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-700 focus:ring-indigo-600'
            : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 focus:ring-gray-300'">
              <!-- Bookmark icon -->
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M7 3h10a2 2 0 0 1 2 2v16l-7-4-7 4V5a2 2 0 0 1 2-2Z"
                  :stroke="isFavorite ? 'white' : 'currentColor'" stroke-width="2" stroke-linejoin="round" />
                <path v-if="isFavorite" d="M9 11l2 2 4-5" stroke="white" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>

              <span class="whitespace-nowrap">
                {{ isFavorite ? "บันทึกแล้ว" : "บันทึกรายการโปรด" }}
              </span>
            </button>
          </template>


          <template #gallery>
            <div>
              <swiper :slides-per-view="1" :space-between="0" :pagination="{ clickable: true }" :navigation="true"
                :modules="[Pagination, Navigation]" class="w-full h-[300px] md:h-[450px] bg-gray-200 group">
                <swiper-slide v-for="(img, idx) in dorm.images" :key="img.id">
                  <button type="button" class="w-full h-full relative focus:outline-none" @click="openLightbox(idx)"
                    title="คลิกเพื่อดูรูปขยาย">
                    <img :src="imageUrl(img.image_path)" class="w-full h-full object-cover" />

                    <!-- hover hint -->
                    <div
                      class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-end justify-end p-4">
                      <div
                        class="opacity-0 group-hover:opacity-100 transition bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-800">
                        ดูรูปขยาย
                      </div>
                    </div>
                  </button>
                </swiper-slide>

                <swiper-slide v-if="!dorm.images?.length">
                  <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100">
                    <span class="text-sm font-medium">ไม่มีรูปภาพ</span>
                  </div>
                </swiper-slide>
              </swiper>

              <!-- Lightbox Modal -->
              <div v-if="lightboxOpen"
                class="fixed inset-0 z-[9999] bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
                @click.self="closeLightbox">
                <!-- Close button -->
                <button
                  class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center"
                  @click="closeLightbox" aria-label="Close">
                  <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none">
                    <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  </svg>
                </button>

                <!-- Counter -->
                <div class="absolute top-4 left-4 text-white/90 text-sm">
                  {{ activeIndex + 1 }} / {{ dorm.images.length }}
                </div>

                <!-- Prev -->
                <button v-if="dorm.images.length > 1"
                  class="absolute left-4 md:left-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center"
                  @click.stop="prevImage" aria-label="Previous">
                  <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none">
                    <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>

                <!-- Image -->
                <div class="max-w-6xl w-full flex items-center justify-center">
                  <img v-if="dorm.images?.length" :src="imageUrl(dorm.images[activeIndex].image_path)"
                    class="max-h-[82vh] w-auto max-w-full rounded-xl shadow-2xl select-none" draggable="false" />
                </div>

                <!-- Next -->
                <button v-if="dorm.images.length > 1"
                  class="absolute right-4 md:right-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center"
                  @click.stop="nextImage" aria-label="Next">
                  <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none">
                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
              </div>
            </div>
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
import 'swiper/css/navigation';

import {
  computed,
  onBeforeUnmount,
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

import { imageUrl } from '@/utils/imageUrl';

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

const lightboxOpen = ref(false);
const activeIndex = ref(0);

const openLightbox = (idx) => {
  activeIndex.value = idx;
  lightboxOpen.value = true;
  document.body.style.overflow = "hidden"; // กัน scroll
};

const closeLightbox = () => {
  lightboxOpen.value = false;
  document.body.style.overflow = "";
};

const nextImage = () => {
  if (!dorm.value?.images?.length) return;
  activeIndex.value = (activeIndex.value + 1) % dorm.value.images.length;
};

const prevImage = () => {
  if (!dorm.value?.images?.length) return;
  activeIndex.value =
    (activeIndex.value - 1 + dorm.value.images.length) % dorm.value.images.length;
};

const onKeydown = (e) => {
  if (!lightboxOpen.value) return;
  if (e.key === "Escape") closeLightbox();
  if (e.key === "ArrowRight") nextImage();
  if (e.key === "ArrowLeft") prevImage();
};

window.addEventListener("keydown", onKeydown);

onBeforeUnmount(() => {
  window.removeEventListener("keydown", onKeydown);
  document.body.style.overflow = "";
});

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

// const imageUrl = (path) => {
//   if (!path) return "/no-image.jpg"; // แก้ path ตามจริง
//   return `/storage/${path}`;
// };

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