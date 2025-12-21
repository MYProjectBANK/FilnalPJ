<template>
  <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-screen transition-all duration-300 font-sans shadow-lg z-20">
    
    <div class="h-20 flex items-center justify-center border-b border-gray-100">
      <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 tracking-wide cursor-pointer">
        DORMFINDER
      </h1>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2 custom-scrollbar">
      
      <router-link
        to="/admin/dashboard"
        class="nav-item"
        active-class="active-link"
      >
        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
        <span class="font-medium">Dashboard</span>
      </router-link>

      <div>
        <button 
          @click="toggleDormMenu" 
          class="w-full flex items-center justify-between px-4 py-3 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors duration-200 group"
          :class="{ 'bg-blue-50 text-blue-700': dormOpen }"
        >
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-3 group-hover:text-blue-600" :class="dormOpen ? 'text-blue-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            <span class="font-medium">Dorm Management</span>
          </div>
          <svg 
            class="w-4 h-4 transition-transform duration-300"
            :class="dormOpen ? 'rotate-180 text-blue-600' : 'text-gray-400'"
            fill="none" viewBox="0 0 24 24" stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <transition
          enter-active-class="transition-all duration-300 ease-out overflow-hidden"
          enter-from-class="max-h-0 opacity-0"
          enter-to-class="max-h-[500px] opacity-100"
          leave-active-class="transition-all duration-200 ease-in overflow-hidden"
          leave-from-class="max-h-[500px] opacity-100"
          leave-to-class="max-h-0 opacity-0"
        >
          <div v-if="dormOpen" class="mt-1 space-y-1 pl-4">
            <router-link to="/admin/dorms" class="sub-nav-item" active-class="sub-active">
               <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Dorms
            </router-link>
            <router-link to="/admin/categories" class="sub-nav-item" active-class="sub-active">
               <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Categories
            </router-link>
            <router-link to="/admin/amenities" class="sub-nav-item" active-class="sub-active">
               <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Amenities
            </router-link>
            <router-link to="/admin/zones" class="sub-nav-item" active-class="sub-active">
               <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Zones
            </router-link>
            <router-link to="/admin/bus-routes" class="sub-nav-item" active-class="sub-active">
              <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Bus Routes
            </router-link>
            <router-link to="/admin/train-lines" class="sub-nav-item" active-class="sub-active">
              <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Train Lines
            </router-link>
            <router-link to="/admin/reviews" class="sub-nav-item" active-class="sub-active">
               <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Reviews
            </router-link>
          </div>
        </transition>
      </div>

      <div class="mt-2">
        <button 
          @click="toggleUserMenu" 
          class="w-full flex items-center justify-between px-4 py-3 text-gray-600 rounded-xl hover:bg-gray-50 transition-colors duration-200 group"
          :class="{ 'bg-blue-50 text-blue-700': userOpen }"
        >
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-3 group-hover:text-blue-600" :class="userOpen ? 'text-blue-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span class="font-medium">User Management</span>
          </div>
          <svg 
            class="w-4 h-4 transition-transform duration-300"
            :class="userOpen ? 'rotate-180 text-blue-600' : 'text-gray-400'"
            fill="none" viewBox="0 0 24 24" stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <transition
          enter-active-class="transition-all duration-300 ease-out overflow-hidden"
          enter-from-class="max-h-0 opacity-0"
          enter-to-class="max-h-[200px] opacity-100"
          leave-active-class="transition-all duration-200 ease-in overflow-hidden"
          leave-from-class="max-h-[200px] opacity-100"
          leave-to-class="max-h-0 opacity-0"
        >
          <div v-if="userOpen" class="mt-1 space-y-1 pl-4">
            <router-link to="/admin/users" class="sub-nav-item" active-class="sub-active">
              <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-3 transition-colors dot"></span> Users List
            </router-link>
             </div>
        </transition>
      </div>

    </nav>

  </aside>
</template>

<script setup>
import {
  ref,
  watch,
} from 'vue';

import { useRoute } from 'vue-router';

const route = useRoute()

// ✅ เข้า admin มาแล้ว “ยังไม่เปิด” ตามที่ต้องการ
const dormOpen = ref(false)
const userOpen = ref(false)

const toggleDormMenu = () => {
  dormOpen.value = !dormOpen.value
}

const toggleUserMenu = () => {
  userOpen.value = !userOpen.value
}

// ✅ ฟังก์ชันเช็คว่า route อยู่ในกลุ่มเมนูไหน
const isDormRoute = (path) => {
  return [
    '/admin/dorms',
    '/admin/categories',
    '/admin/amenities',
    '/admin/zones',
    '/admin/bus-routes',
    '/admin/train-lines',
    '/admin/reviews',
  ].some((prefix) => path.startsWith(prefix))
}

const isUserRoute = (path) => path.startsWith('/admin/users')

// ✅ เวลาเปลี่ยนหน้าแล้วให้เมนู “เปิดค้าง” ตาม route (แก้ user ปิดเอง)
watch(
  () => route.path,
  (path) => {
    // ถ้าอยู่ในหน้ากลุ่ม Dorm Management ให้เปิดอัตโนมัติ
    if (isDormRoute(path)) dormOpen.value = true

    // ถ้าอยู่ใน Users List ให้ User Management เปิดค้าง
    if (isUserRoute(path)) userOpen.value = true
  },
  { immediate: true }
)
</script>


<style scoped>
@reference "tailwindcss";

/* Main Navigation Item Style */
.nav-item {
  @apply flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-gray-50 hover:text-blue-600 transition-all duration-200;
}

/* Active State for Main Nav */
.active-link {
  @apply bg-blue-50 text-blue-700 font-semibold shadow-sm;
}

/* Sub Navigation Item Style */
.sub-nav-item {
  @apply flex items-center px-4 py-2.5 text-sm text-gray-500 rounded-lg hover:text-blue-600 hover:bg-gray-50 transition-colors;
}

/* Active State for Sub Nav */
.sub-active {
  @apply text-blue-600 font-medium bg-blue-50/50;
}
.sub-active .dot {
  @apply bg-blue-500;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #e5e7eb; 
  border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #d1d5db; 
}
</style>