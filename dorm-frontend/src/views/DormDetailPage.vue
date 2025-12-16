<template>
  <div class="p-4 max-w-5xl mx-auto">

    <!-- BACK BUTTON -->
    <button
      @click="$router.back()"
      class="mb-4 px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded"
    >
      ← กลับ
    </button>

    <!-- LOADING -->
    <div v-if="loading" class="text-center py-10">กำลังโหลดข้อมูล...</div>

    <!-- CONTENT -->
    <div v-else-if="dorm">

      <!-- HEADER -->
      <div class="flex justify-between items-start mb-6">
        <div>
          <h1 class="text-3xl font-bold mb-1">{{ dorm.name }}</h1>
          <p class="text-xl text-blue-600 font-semibold">{{ priceText }}</p>
        </div>

        <!-- FAVORITE -->
        <button
          v-if="isLoggedIn"
          @click="toggleFavorite"
          class="px-4 py-2 rounded-full border bg-white hover:bg-pink-50 flex items-center gap-2"
        >
          <span :class="isFavorite ? 'text-pink-600' : 'text-gray-400'">❤️</span>
          <span class="text-sm">
            {{ isFavorite ? "ลบออกจากรายการโปรด" : "เพิ่มในรายการโปรด" }}
          </span>
        </button>
      </div>

      <!-- TAGS -->
      <div class="flex flex-wrap gap-2 mb-6">
        <span
          v-for="c in dorm.categories"
          :key="'cat-'+c.id"
          class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm"
        >
          {{ c.name }}
        </span>

        <span
          v-for="z in dorm.zones"
          :key="'zone-'+z.id"
          class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm"
        >
          โซน: {{ z.name }}
        </span>
      </div>

      <!-- GALLERY -->
      <swiper :slides-per-view="1" :space-between="10" class="mb-8">
        <swiper-slide v-for="img in dorm.images" :key="img.id">
          <img :src="imageUrl(img.image_path)" class="w-full h-72 object-cover rounded-lg" />
        </swiper-slide>

        <swiper-slide v-if="!dorm.images.length">
          <img src="/no-image.jpg" class="w-full h-72 object-cover rounded-lg" />
        </swiper-slide>
      </swiper>

      <!-- DETAILS -->
      <div class="space-y-6">

        <!-- Description -->
        <section>
          <h2 class="text-xl font-semibold mb-2">รายละเอียด</h2>
          <p class="text-gray-700 whitespace-pre-line">{{ dorm.description || "ไม่มีข้อมูล" }}</p>
        </section>

        <!-- Address -->
        <section>
          <h2 class="text-xl font-semibold mb-2">ที่อยู่</h2>
          <p class="text-gray-700">
            {{ dorm.street }}, {{ dorm.subdistrict }}, {{ dorm.district }},
            {{ dorm.province }} {{ dorm.zipcode }}
          </p>
        </section>

        <!-- Amenities -->
        <section v-if="dorm.amenities?.length">
          <h2 class="text-xl font-semibold mb-2">สิ่งอำนวยความสะดวก</h2>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="a in dorm.amenities"
              :key="a.id"
              class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm"
            >
              ✔ {{ a.name }}
            </span>
          </div>
        </section>

        <!-- Price Info -->
        <section>
          <h2 class="text-xl font-semibold mb-2">ราคาและค่าบริการ</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded">
              <p><strong>ราคา:</strong> ฿{{ dorm.price_min }} - ฿{{ dorm.price_max }}</p>
              <p><strong>เงินมัดจำ:</strong> ฿{{ dorm.deposit_price }}</p>
            </div>

            <div class="bg-blue-50 p-4 rounded">
              <p><strong>ค่าไฟ:</strong> {{ dorm.electricity_rate }} บาท/ยูนิต</p>
              <p><strong>ค่าน้ำ:</strong> {{ dorm.water_rate }} บาท</p>
              <p><strong>อินเทอร์เน็ต:</strong> {{ dorm.internet_fee }} บาท</p>
            </div>
          </div>
        </section>

        <!-- Contact -->
        <section>
          <h2 class="text-xl font-semibold mb-2">ข้อมูลติดต่อ</h2>
          <p><strong>โทร:</strong> {{ dorm.phone }}</p>
          <p><strong>Email:</strong> {{ dorm.email }}</p>
          <p><strong>Facebook:</strong> {{ dorm.facebook }}</p>
          <p><strong>Line:</strong> {{ dorm.line_id }}</p>
        </section>

        <!-- MAP -->
        <section v-if="dorm.latitude && dorm.longitude">
          <h2 class="text-xl font-semibold mb-2">แผนที่</h2>
          <iframe
            class="w-full h-64 rounded"
            :src="mapUrl"
          ></iframe>
        </section>

        <!-- ----------------- REVIEWS ----------------- -->
        <section class="pt-6 border-t">
          <h2 class="text-xl font-semibold mb-4">รีวิว</h2>

          <!-- Write Review -->
          <div v-if="isLoggedIn" class="bg-gray-50 p-4 rounded mb-6">
            <textarea
              v-model="reviewForm.comment"
              rows="3"
              class="w-full border rounded px-3 py-2 text-sm"
              placeholder="เขียนรีวิว..."
            ></textarea>

            <button
              class="mt-2 px-4 py-2 bg-blue-600 text-white rounded"
              @click="submitReview"
              :disabled="submittingReview || !reviewForm.comment"
            >
              {{ submittingReview ? "กำลังส่ง..." : "ส่งรีวิว" }}
            </button>

            <p class="text-xs text-gray-500 mt-2">* รีวิวต้องรอการอนุมัติจากผู้ดูแลระบบ</p>
          </div>

          <p v-else class="text-sm text-gray-500 mb-6">
            ต้องเข้าสู่ระบบก่อนจึงจะเขียนรีวิวได้
          </p>

          <!-- Review List -->
          <div v-if="approvedReviews.length">
            <div
              v-for="r in approvedReviews"
              :key="r.id"
              class="border p-3 rounded mb-3"
            >
              <div class="flex justify-between items-center mb-1">
                <span class="font-medium">{{ r.user.fullname }}</span>
                <span class="text-green-600 text-xs">✔ รีวิวผ่านการอนุมัติ</span>
              </div>
              <p class="text-sm text-gray-700 whitespace-pre-line">{{ r.comment }}</p>
            </div>
          </div>

          <p v-else class="text-gray-500 text-sm">ยังไม่มีรีวิวที่ได้รับการอนุมัติ</p>
        </section>
      </div>
    </div>

    <div v-else class="text-center text-gray-500 py-10">
      ไม่พบข้อมูลหอพักนี้
    </div>

  </div>
</template>

<script setup>
import 'swiper/css';

import {
  computed,
  onMounted,
  ref,
} from 'vue';

import {
  Swiper,
  SwiperSlide,
} from 'swiper/vue';
import { useRoute } from 'vue-router';

import api from '../axios';

const route = useRoute();

const dorm = ref(null);
const reviews = ref([]);
const loading = ref(true);
const submittingReview = ref(false);

// login
const isLoggedIn = !!localStorage.getItem("token");

// favorite
const isFavorite = ref(false);

// Review Form
const reviewForm = ref({
  comment: "",
});

// MAP URL
const mapUrl = computed(() => {
  if (!dorm.value) return "";
  return `https://www.google.com/maps?q=${dorm.value.latitude},${dorm.value.longitude}&z=16&output=embed`;
});

// PRICE TEXT
const priceText = computed(() => {
  if (!dorm.value) return "";
  return `฿${dorm.value.price_min} - ฿${dorm.value.price_max}`;
});

// Only show APPROVED reviews
const approvedReviews = computed(() =>
  reviews.value.filter((r) => r.status === "approved")
);

// LOAD DORM
const fetchDorm = async () => {
  const res = await api.get(`/api/dorms/${route.params.id}`);
  dorm.value = res.data;
};

// LOAD REVIEWS
const fetchReviews = async () => {
  const res = await api.get(`/api/reviews/${route.params.id}`);
  reviews.value = res.data;
};

const imageUrl = (path) => {
  if (!path) return "/no-image.jpg";
  return `http://127.0.0.1:8000/storage/${path}`;
};

// CHECK FAVORITE
const fetchFavoriteStatus = async () => {
  if (!isLoggedIn) return;

  const res = await api.get(`/api/favorites`, {
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  });

  const id = Number(route.params.id);
  isFavorite.value = res.data.some((f) => f.dorm_id === id);
};

// TOGGLE FAVORITE
const toggleFavorite = async () => {
  const id = route.params.id;

  if (!isFavorite.value) {
    await api.post(`/api/favorites/add/${id}`, {}, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    isFavorite.value = true;
  } else {
    await api.delete(`/api/favorites/remove/${id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    isFavorite.value = false;
  }
};

// SUBMIT REVIEW
const submitReview = async () => {
  submittingReview.value = true;

  await api.post(
    `/api/reviews`,
    {
      dorm_id: route.params.id,
      comment: reviewForm.value.comment,
    },
    {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );

  reviewForm.value.comment = "";
  submittingReview.value = false;

  await fetchReviews();
};

onMounted(async () => {
  loading.value = true;
  await fetchDorm();
  await fetchReviews();
  await fetchFavoriteStatus();
  loading.value = false;
});
</script>
