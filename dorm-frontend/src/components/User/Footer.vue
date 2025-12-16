<template>
  <footer class="bg-gray-900 text-gray-300 py-12 mt-20">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">

      <!-- LOGO + DESCRIPTION -->
      <div>
        <h1 class="text-2xl font-bold text-white">DORMFINDER</h1>
        <p class="text-gray-400 mt-3 leading-relaxed">
          แพลตฟอร์มค้นหาหอพักสำหรับนักศึกษาและบุคลากร  
          ช่วยให้คุณค้นหาที่พักได้ง่ายและสะดวกขึ้น
        </p>
      </div>

      <!-- QUICK LINKS -->
      <div>
        <h2 class="text-lg font-semibold text-white mb-4">เมนูหลัก</h2>
        <ul class="space-y-2">
          <li><button @click="go('/')" class="hover:text-white">หน้าแรก</button></li>
          <li><button @click="go('/dorms/category/shared')" class="hover:text-white">หอพักทั้งหมด</button></li>
          <li><button @click="go('/login')" class="hover:text-white">เข้าสู่ระบบ</button></li>
          <li><button @click="go('/register')" class="hover:text-white">สมัครสมาชิก</button></li>
        </ul>
      </div>

      <!-- CONTACT -->
      <div>
        <h2 class="text-lg font-semibold text-white mb-4">ติดต่อเรา</h2>
        <ul class="space-y-2 text-gray-400">
          <li>📍 กรุงเทพมหานคร ประเทศไทย</li>
          <li>📞 090-000-0000</li>
          <li>✉️ support@dormfinder.com</li>
        </ul>
      </div>

      <!-- SOCIAL MEDIA -->
      <div>
        <h2 class="text-lg font-semibold text-white mb-4">ติดตามเรา</h2>

        <div class="flex space-x-4">
          <a href="#" class="text-gray-400 hover:text-white text-2xl">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white text-2xl">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="text-gray-400 hover:text-white text-2xl">
            <i class="fab fa-twitter"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- COPYRIGHT -->
    <div class="border-t border-gray-700 text-center text-gray-500 pt-6 mt-10">
      © 2025 DormFinder. All rights reserved.
    </div>
  </footer>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();
const go = (path) => router.push(path);
</script>
