<template>
  <section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        <!-- 1 -->
        <div class="flex flex-col items-center text-center">
          <div class="w-12 h-12 rounded-2xl  text-blue-700 flex items-center justify-center">
            <!-- Search icon -->
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
              <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2"/>
            </svg>
          </div>

          <p class="mt-4 text-sm font-semibold text-gray-900">
            สะดวกในการค้นหาหอพัก
          </p>
          <p class="text-xs font-medium text-gray-500 tracking-wide uppercase">
            Easy Dorm Search
          </p>
          <p class="mt-2 text-xs text-gray-500 max-w-[16rem]">
            ค้นหาด้วยชื่อหอพัก / เขต / แขวง / อำเภอ / ตำบล พร้อมตัวช่วยแนะนำ
          </p>
        </div>

        <!-- 2 -->
        <div class="flex flex-col items-center text-center">
          <div class="w-12 h-12 rounded-2xl  text-amber-700 flex items-center justify-center">
            <!-- Route icon -->
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
              <path d="M6 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="2"/>
              <path d="M18 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="2"/>
              <path d="M6 16c0-4 6-2 6-6s6-2 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M10 10h3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>

          <p class="mt-4 text-sm font-semibold text-gray-900">
            เดินทางสะดวก
          </p>
          <p class="text-xs font-medium text-gray-500 tracking-wide uppercase">
            Convenient Travel
          </p>
          <p class="mt-2 text-xs text-gray-500 max-w-[16rem]">
            ดูรถเมล์/รถไฟฟ้าใกล้เคียง ช่วยเลือกหอพักที่ไปเรียนหรือทำงานง่าย
          </p>
        </div>

        <!-- 3 -->
        <div class="flex flex-col items-center text-center">
          <div class="w-12 h-12 rounded-2xl  text-emerald-700 flex items-center justify-center">
            <!-- School/Location icon -->
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
              <path d="M12 3l9 5-9 5-9-5 9-5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
              <path d="M5 10v6c0 1 3 3 7 3s7-2 7-3v-6" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
              <path d="M3 8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>

          <p class="mt-4 text-sm font-semibold text-gray-900">
            ใกล้สถานศึกษา
          </p>
          <p class="text-xs font-medium text-gray-500 tracking-wide uppercase">
            Near University
          </p>
          <p class="mt-2 text-xs text-gray-500 max-w-[16rem]">
            คัดหอพักตามโซนยอดนิยมรอบมหาวิทยาลัย ลดเวลาเดินทางในแต่ละวัน
          </p>
        </div>

        <!-- 4 -->
        <div class="flex flex-col items-center text-center">
          <div class="w-12 h-12 rounded-2xl  text-fuchsia-700 flex items-center justify-center">
            <!-- Sliders/Filter icon -->
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
              <path d="M4 6h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M18 6h2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M14 6a2 2 0 1 1 4 0a2 2 0 0 1-4 0Z" stroke="currentColor" stroke-width="2"/>
              <path d="M4 12h2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M10 12h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M6 12a2 2 0 1 1 4 0a2 2 0 0 1-4 0Z" stroke="currentColor" stroke-width="2"/>
              <path d="M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M18 18h2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M14 18a2 2 0 1 1 4 0a2 2 0 0 1-4 0Z" stroke="currentColor" stroke-width="2"/>
            </svg>
          </div>

          <p class="mt-4 text-sm font-semibold text-gray-900">
            เลือกได้ตามสไตล์ในตัวคุณ
          </p>
          <p class="text-xs font-medium text-gray-500 tracking-wide uppercase">
            Match Your Style
          </p>
          <p class="mt-2 text-xs text-gray-500 max-w-[16rem]">
            เลือกหมวดหมู่ สิ่งอำนวยความสะดวก การเดินทาง และช่วงราคาได้ตามใจ
          </p>
        </div>
      </div>

      <!-- divider line (optional) -->
      <div class="mt-12 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    </div>
  </section>
</template>
