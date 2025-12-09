<template>
  <div>

    <!-- ⭐ TOP NAVBAR -->
   <!-- ⭐ TOP NAVBAR -->
<nav class="w-full bg-white shadow fixed top-0 left-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

    <!-- Logo -->
    <h1 class="text-xl font-bold text-blue-600 cursor-pointer" @click="goHome">
      DORMFINDER
    </h1>

    <!-- Right menu -->
    <div class="flex items-center space-x-4">

      <!-- 🔹 If NOT logged in -->
      <template v-if="!token">
        <button
          @click="goLogin"
          class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Login
        </button>

        <button
          @click="goRegister"
          class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-50"
        >
          Register
        </button>
      </template>

      <!-- 🔹 If logged in -->
      <template v-else>

        <!-- ⭐ Show Admin Dashboard button ONLY for admin -->
        <button
          v-if="role === 'admin'"
          @click="goAdmin"
          class="px-4 py-1 bg-purple-600 text-white rounded hover:bg-purple-700"
        >
          Admin Dashboard
        </button>

        <span class="text-gray-600">Welcome!</span>

        <button
          @click="logout"
          class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700"
        >
          Logout
        </button>

      </template>

    </div>
  </div>
</nav>


    <!-- Hero needs margin because navbar is fixed -->
    <div class="pt-20">
      <HeroBanner>
        <SearchBar @search="onSearch" />
      </HeroBanner>
    </div>


    <div class="p-4 max-w-7xl mx-auto">

      <SectionHeader title="หอพักแนะนำ" />
      <DormCarousel :dorms="recommend" />

      <SectionHeader title="หอพักใกล้สถานศึกษา" />
      <DormCarousel :dorms="nearby" />

      <SectionHeader title="กรุณาเลือกหมวดหมู่ที่ต้องการ" />
      <CategoryFilter :categories="categories" @select="selectCategory" />

      <SectionHeader title="หอพัก ชายล้วน" showMore />
      <DormCarousel :dorms="maleDorms" />

      <SectionHeader title="หอพัก หญิงล้วน" showMore />
      <DormCarousel :dorms="femaleDorms" />

    </div>

  </div>
</template>

<script setup>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';

import CategoryFilter from '../components/User/CategoryFilter.vue';
import DormCarousel from '../components/User/DormCarousel.vue';
import HeroBanner from '../components/User/HeroBanner.vue';
import SearchBar from '../components/User/SearchBar.vue';
import SectionHeader from '../components/User/SectionHeader.vue';

const token = localStorage.getItem("token");
const role = localStorage.getItem("role");

const recommend = ref([]);
const nearby = ref([]);
const categories = ref([]);
const maleDorms = ref([]);
const femaleDorms = ref([]);

onMounted(async () => {
  const [rec, near, cats, male, female] = await Promise.all([
    axios.get("/api/dorms/recommend"),
    axios.get("/api/dorms/nearby"),
    axios.get("/api/categories"),
    axios.get("/api/dorms/by-category/1"),
    axios.get("/api/dorms/by-category/2"),
  ]);

  recommend.value = rec.data;
  nearby.value = near.data;
  categories.value = cats.data;
  maleDorms.value = male.data;
  femaleDorms.value = female.data;
});

// Actions
const onSearch = (keyword) => console.log("SEARCH:", keyword);

const selectCategory = (id) => console.log("CATEGORY:", id);

const logout = () => {
  localStorage.removeItem("token");
  localStorage.removeItem("role");
  window.location.href = "/login";
};

const goAdmin = () => {
  window.location.href = "/admin/dorms"; 
};

const goHome = () => (window.location.href = "/");
const goLogin = () => (window.location.href = "/login");
const goRegister = () => (window.location.href = "/register");
</script>
