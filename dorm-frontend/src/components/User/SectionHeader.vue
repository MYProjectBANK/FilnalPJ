<template>
  <div class="my-4">
    <div class="flex items-end justify-between gap-4">
      <div class="min-w-0">
        <!-- small label (optional vibe) -->
        <div class="inline-flex items-center gap-2 text-xs text-gray-500 mb-1">
          <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
          <span class="tracking-wide">หมวดหมู่</span>
        </div>

        <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 leading-tight truncate">
          {{ title }}
        </h2>
      </div>

      <button
        v-if="showMore"
        @click="goTo"
        class="shrink-0 inline-flex items-center gap-2 rounded-full border border-gray-200
               bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm
               hover:bg-gray-50 hover:border-gray-300 active:scale-[0.99] transition"
      >
        ดูทั้งหมด
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
          <path
            d="M9 5l7 7-7 7"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>
    </div>

    <!-- subtle divider -->
    <div class="mt-4 flex items-center gap-3">
      <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const props = defineProps({
  title: { type: String, default: "" },
  showMore: { type: Boolean, default: false },
  to: { type: String, default: "" },
});

const router = useRouter();

const goTo = () => {
  if (props.to) router.push(props.to);
};
</script>
