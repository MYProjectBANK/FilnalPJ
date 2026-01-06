<template>
  <section class="relative w-full overflow-hidden">
    <!-- HERO -->
    <div class="relative w-full min-h-[520px] sm:min-h-[560px] md:min-h-[640px]">
      <img :src="heroImg" alt="hero" class="absolute inset-0 w-full h-full object-cover" />
      <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/25 to-transparent"></div>

      <!-- ✅ ลด pb ลง เพราะไม่ต้องเผื่อ highlights ซ้อนแล้ว -->
      <div class="relative z-10 max-w-7xl mx-auto px-4 pt-20 sm:pt-24 md:pt-32 pb-20 sm:pb-24 md:pb-28">
        <div class="max-w-xl sm:max-w-2xl text-white">
          <p class="text-sm sm:text-base opacity-90">ค้นหาหอพักง่าย ๆ ใกล้คุณ</p>

          <h1 class="mt-3 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
            รวมอพาร์ทเม้นท์ หอพัก
            <span class="block text-white/85 font-semibold">สำหรับนักศึกษาและบุคลากร</span>
          </h1>

          <p class="mt-4 text-white/85 text-sm sm:text-base leading-relaxed">
            ค้นหาดอย่างสะดวก รวดเร็ว และตรงใจคุณที่สุด
          </p>

          <div class="mt-7">
            <button class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl
                     bg-white/20 hover:bg-white/30 border border-white/25
                     text-white font-semibold shadow-md backdrop-blur
                     transition active:scale-[0.99]" @click="scrollToTarget">
              เริ่มค้นหา
              <svg class="w-5 h-5 opacity-90" viewBox="0 0 24 24" fill="none">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- curve -->
      <svg class="absolute bottom-0 left-0 w-full h-16 sm:h-20 md:h-28 z-10" viewBox="0 0 1440 120"
        preserveAspectRatio="none">
        <path d="M0,32 C240,110 480,110 720,64 C960,18 1200,18 1440,72 L1440,120 L0,120 Z" fill="white" />
      </svg>

      <!-- ❌ ลบ highlights แบบ absolute ออกทั้งก้อน -->
    </div>

    <!-- ✅ HIGHLIGHTS (อยู่พื้นที่สีขาว ไม่ซ้อน) -->
    <div class="bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="pt-8 pb-10 md:pt-10 md:pb-12">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <button v-for="(item, i) in items" :key="i" type="button" class="group">
              <div class="flex flex-col items-center text-center">
                <div class="w-30 h-30 md:w-30 md:h-30 rounded-full
                         bg-white shadow-lg border border-gray-100
                         flex items-center justify-center
                         transition-all duration-300
                         group-hover:scale-110 group-hover:border-fuchsia-200">
                  <component :is="item.icon" class="w-9 h-9 md:w-10 md:h-10 text-gray-700 transition-colors duration-300
                           group-hover:text-fuchsia-900" />
                </div>

                <p
                  class="mt-3 text-sm md:text-base font-bold text-gray-900 group-hover:text-fuchsia-900 transition-colors">
                  {{ item.th }}
                </p>
                <p class="text-xs md:text-sm text-gray-500 group-hover:text-gray-700 transition-colors">
                  {{ item.en }}
                </p>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>



<script setup>
import {
  computed,
  defineComponent,
  h,
  markRaw,
} from 'vue';

/** ✅ ใส่รูป banner ใน component เลย */
import heroImg from '@/assets/Img/Banner.avif';

const props = defineProps({
  targetId: { type: String, default: "search-section" },
});

// helper: สร้าง svg component ที่รับ class/attrs จากภายนอกได้
const makeIcon = (children) =>
  defineComponent({
    name: "InlineIcon",
    inheritAttrs: true,
    setup(_, { attrs }) {
      return () =>
        h(
          "svg",
          {
            ...attrs,
            viewBox: "0 0 24 24",
            fill: "none",
            xmlns: "http://www.w3.org/2000/svg",
          },
          children
        );
    },
  });

const IconSearch = makeIcon([
  h("path", {
    d: "M21 21l-4.35-4.35",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M11 18a7 7 0 1 1 0-14a7 7 0 0 1 0 14Z",
    stroke: "currentColor",
    "stroke-width": "2",
  }),
]);

const IconRoute = makeIcon([
  h("path", {
    d: "M7 6a3 3 0 1 0 0 6",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M17 12a3 3 0 1 0 0 6",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M10 9c5 0 4 8 9 8",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M7 6h0",
    stroke: "currentColor",
    "stroke-width": "4",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M17 18h0",
    stroke: "currentColor",
    "stroke-width": "4",
    "stroke-linecap": "round",
  }),
]);

const IconSchool = makeIcon([
  h("path", {
    d: "M3 9l9-5 9 5-9 5-9-5Z",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linejoin": "round",
  }),
  h("path", {
    d: "M7 11v6c0 1 2 3 5 3s5-2 5-3v-6",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
  h("path", {
    d: "M21 10v6",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linecap": "round",
  }),
]);

const IconSpark = makeIcon([
  h("path", {
    d: "M12 2l1.2 5.2L18 9l-4.8 1.8L12 16l-1.2-5.2L6 9l4.8-1.8L12 2Z",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linejoin": "round",
  }),
  h("path", {
    d: "M5 14l.7 2.3L8 17l-2.3.7L5 20l-.7-2.3L2 17l2.3-.7L5 14Z",
    stroke: "currentColor",
    "stroke-width": "2",
    "stroke-linejoin": "round",
  }),
]);

const items = computed(() => [
  { th: "สะดวกในการค้นหา", en: "Easy Search", icon: markRaw(IconSearch) },
  { th: "เดินทางสะดวก", en: "Convenient Travel", icon: markRaw(IconRoute) },
  { th: "ใกล้สถานศึกษา", en: "Near Campus", icon: markRaw(IconSchool) },
  { th: "เลือกได้ตามสไตล์คุณ", en: "Match Your Style", icon: markRaw(IconSpark) },
]);

const scrollToTarget = () => {
  const el = document.getElementById(props.targetId);
  if (!el) return;
  const y = el.getBoundingClientRect().top + window.scrollY - 90;
  window.scrollTo({ top: y, behavior: "smooth" });
};
</script>
