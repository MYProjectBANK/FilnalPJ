<template>
  <div ref="root" class="w-full relative">
    <form @submit.prevent="submitNow" class="flex items-center gap-2 w-full">
      <div class="flex items-center w-full rounded-2xl border border-gray-200 bg-white shadow-sm
               focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-300 transition">
        <div class="pl-4 pr-2 text-gray-400">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>

        <input v-model="q" type="text"
          class="w-full py-3 text-sm md:text-base bg-transparent outline-none placeholder:text-gray-400"
          placeholder="ค้นหาชื่อหอพัก " @input="onInput" @focus="openIfHaveSuggestions" @keydown.down.prevent="move(1)"
          @keydown.up.prevent="move(-1)" @keydown.enter.prevent="enterPick" @keydown.esc="close" />

        <button v-if="q" type="button" class="px-3 text-gray-400 hover:text-gray-700 transition" @click="clear"
          aria-label="clear">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <button type="submit" class="m-1.5 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold
                 hover:bg-blue-700 active:scale-[0.99] transition">
          ค้นหา
        </button>
      </div>
    </form>

    <!-- Dropdown suggestions -->
    <div v-if="open && (loading || suggestions.length)"
      class="absolute z-40 mt-2 w-full rounded-2xl border border-gray-200 bg-white shadow-lg overflow-hidden">
      <div class="max-h-72 overflow-auto p-2">
        <div v-if="loading" class="px-3 py-2 text-sm text-gray-500">
          กำลังค้นหา...
        </div>

        <button v-for="(item, idx) in suggestions" :key="item.id" type="button"
          class="w-full text-left px-3 py-2 rounded-xl transition flex items-start justify-between gap-3"
          :class="idx === activeIndex ? 'bg-blue-50' : 'hover:bg-gray-50'" @mousedown.prevent="pick(item)">
          <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-900 truncate">
              {{ item.name }}
            </p>
            <p class="text-xs text-gray-500 truncate">
              {{ item.subdistrict }}, {{ item.district }}, {{ item.province }}
            </p>

          </div>
          <div class="text-xs font-semibold text-blue-700 whitespace-nowrap">
            ฿{{ item.price_min }}
          </div>
        </button>

        <button v-if="q && suggestions.length" type="button"
          class="w-full text-left px-3 py-2 rounded-xl hover:bg-gray-50 text-xs text-gray-500 mt-1"
          @mousedown.prevent="submitNow">
          ดูผลค้นหาทั้งหมดสำหรับ "{{ q }}"
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  onBeforeUnmount,
  onMounted,
  ref,
} from 'vue';

import api from '../../axios';

const emit = defineEmits(["search", "choose"]);

const q = ref("");
const suggestions = ref([]);
const loading = ref(false);
const open = ref(false);
const activeIndex = ref(-1);
const root = ref(null);

// ✅ cache suggest
const cache = new Map();
const MAX_CACHE = 30;
const setCache = (key, value) => {
  cache.set(key, value);
  if (cache.size > MAX_CACHE) {
    const firstKey = cache.keys().next().value;
    cache.delete(firstKey);
  }
};

// ✅ แยก debounce คนละตัว
let tSuggest = null;
let tSearch = null;

const SEARCH_DELAY = 350;
const SUGGEST_DELAY = 250;

let lastKeyword = ""; // กัน response เก่าตีกัน

const fetchSuggest = async (keywordRaw) => {
  const keyword = keywordRaw.trim().toLowerCase();
  lastKeyword = keyword;

  if (!keyword) {
    suggestions.value = [];
    open.value = false;
    activeIndex.value = -1;
    return;
  }

  // ✅ cache
  if (cache.has(keyword)) {
    suggestions.value = cache.get(keyword) || [];
    open.value = true;
    activeIndex.value = suggestions.value.length ? 0 : -1;
    return;
  }

  loading.value = true;
  try {
    const res = await api.get("/api/dorms/suggest", { params: { q: keywordRaw } });

    // ✅ กันผลเก่า
    if (lastKeyword !== keyword) return;

    const data = res.data || [];
    suggestions.value = data;
    setCache(keyword, data);

    open.value = true;
    activeIndex.value = data.length ? 0 : -1;
  } catch (e) {
    console.error(e);
    suggestions.value = [];
    open.value = false;
  } finally {
    loading.value = false;
  }
};

const onInput = () => {
  const keyword = q.value.trim();

  // ✅ debounce search (ไปอัปเดต ผลการค้นหา / ฟิลเตอร์)
  if (tSearch) clearTimeout(tSearch);
  tSearch = setTimeout(() => {
    emit("search", keyword);
  }, SEARCH_DELAY);

  // ✅ debounce suggest (dropdown)
  if (tSuggest) clearTimeout(tSuggest);
  tSuggest = setTimeout(() => {
    fetchSuggest(q.value);
  }, SUGGEST_DELAY);
};

const submitNow = () => {
  if (tSearch) clearTimeout(tSearch);
  if (tSuggest) clearTimeout(tSuggest);

  emit("search", q.value.trim());
  open.value = false;
};

const pick = (item) => {
  q.value = item.name;

  // ✅ เลือกแล้วให้ผลฟิลเตอร์ขึ้นทันที
  emit("search", item.name);

  emit("choose", item);
  open.value = false;
};

const openIfHaveSuggestions = () => {
  if (suggestions.value.length) open.value = true;
};

const close = () => (open.value = false);

const move = (dir) => {
  if (!open.value || !suggestions.value.length) return;
  const n = suggestions.value.length;
  activeIndex.value = (activeIndex.value + dir + n) % n;
};

const enterPick = () => {
  if (open.value && suggestions.value.length && activeIndex.value >= 0) {
    pick(suggestions.value[activeIndex.value]);
  } else {
    submitNow();
  }
};

const clear = () => {
  q.value = "";
  suggestions.value = [];
  open.value = false;
  activeIndex.value = -1;
  emit("search", ""); // ✅ เคลียร์ผลลัพธ์
};

// click outside -> close
const onDocClick = (e) => {
  const el = root.value;
  if (!el) return;
  if (!el.contains(e.target)) open.value = false;
};

onMounted(() => document.addEventListener("mousedown", onDocClick));
onBeforeUnmount(() => {
  document.removeEventListener("mousedown", onDocClick);
  if (tSearch) clearTimeout(tSearch);
  if (tSuggest) clearTimeout(tSuggest);
});
</script>
