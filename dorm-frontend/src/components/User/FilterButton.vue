<template>
  <div ref="root" class="relative">
    <!-- Button -->
    <button
      type="button"
      @click="open = !open"
      class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl border bg-white shadow-sm
             hover:shadow-md hover:-translate-y-[1px] transition
             focus:outline-none focus:ring-2 focus:ring-blue-500/30"
      :class="open ? 'border-blue-300 ring-2 ring-blue-500/10' : 'border-gray-200'"
    >
      <div class="flex items-center gap-3 min-w-0">
        <span class="text-lg">{{ icon }}</span>
        <div class="text-left min-w-0">
          <p class="text-sm font-semibold text-gray-900">{{ label }}</p>
          <p class="text-xs text-gray-500 truncate">
            {{ summary || 'เลือกตัวกรอง' }}
          </p>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <span
          v-if="badge"
          class="text-[11px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100"
        >
          {{ badge }}
        </span>

        <svg
          class="w-4 h-4 text-gray-400 transition-transform"
          :class="open ? 'rotate-180' : ''"
          fill="none" viewBox="0 0 24 24" stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </button>

    <!-- Dropdown -->
    <transition
      enter-active-class="transition ease-out duration-150"
      enter-from-class="opacity-0 translate-y-1 scale-95"
      enter-to-class="opacity-100 translate-y-0 scale-100"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100 translate-y-0 scale-100"
      leave-to-class="opacity-0 translate-y-1 scale-95"
    >
      <div
        v-if="open"
        class="absolute z-30 mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-lg overflow-hidden"
      >
        <div class="max-h-64 overflow-auto p-2">
          <slot />
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import {
  onBeforeUnmount,
  onMounted,
  ref,
} from 'vue';

const props = defineProps({
  label: { type: String, default: "" },
  icon: { type: String, default: "⚙️" },
  summary: { type: String, default: "" },
  badge: { type: [String, Number], default: "" },
});

const open = ref(false);
const root = ref(null);

const onDocClick = (e) => {
  if (!open.value) return;
  const el = root.value;
  if (!el) return;
  if (!el.contains(e.target)) open.value = false; // ✅ click outside ปิด
};

onMounted(() => document.addEventListener("mousedown", onDocClick));
onBeforeUnmount(() => document.removeEventListener("mousedown", onDocClick));
</script>
