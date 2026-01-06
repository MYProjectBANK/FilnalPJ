<template>
  <div class="relative min-h-screen">
    <PaperBackground />
    <div>
      <Navbar />

      <div class="pt-20">
        <HeroBanner targetId="search-section" />
      </div>

      <PopularUniversitySection :universities="universities" :bannerImage="banner" @select="onSelectUniversity"
        @viewAll="goToAllUniversities" />

      <div class="py-12">
        <FeatureHighlights />
      </div>
            <ArticleSection :items="articles" />

      <!-- MAIN CONTENT -->
      <div class="px-4 max-w-7xl mx-auto space-y-14 py-10">

        <!-- <div>
          <DormCarousel :dorms="recommend" />
        </div>

        <div>
          <DormCarousel :dorms="nearby" />
        </div> -->

        <div id="search-section">
          <div class="my-10 px-4">
            <div class="max-w-5xl mx-auto rounded-3xl border border-gray-100 bg-white shadow-sm overflow-visible">
              <!-- soft background -->
              <div class="relative px-6 py-10 md:px-10 md:py-12">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50"></div>
                <div class="relative text-center">
                  <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mt-4 leading-tight">
                    รวมอพาร์ทเม้นท์ ที่พัก หอพัก
                    <span class="text-fuchsia-900">สำหรับนักศึกษาและบุคลากร</span>
                  </h1>
                  <p class="text-gray-500 mt-3 text-sm md:text-base">
                    ค้นหาด้วยชื่อหอพัก หมวดหมู่ สิ่งอำนวยความสะดวก การเดินทาง และช่วงราคา
                  </p>
                  <!-- Search Card -->
                  <div class="mt-7 flex justify-center">
                    <div class="w-full max-w-2xl">
                      <div
                        class="bg-white/80 backdrop-blur rounded-2xl border border-gray-200 shadow-sm px-4 py-4 md:px-6 md:py-5">
                        <SearchBar @search="onSearch" />
                        <div class="flex items-center justify-between mt-3 text-xs text-gray-500">
                          <span>พิมพ์ชื่อหอพัก หรือ 'เขต, แขวง, อำเภอ, ตำบล'</span>
                          <button v-if="hasFilter"
                            class="px-3 py-1.5 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-700 transition"
                            @click="clearAllFilters">
                            ล้างตัวกรอง
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="p-5 md:p-6 space-y-4">
          <div class="flex items-start justify-between gap-4">
            <div>
              <h3 class="text-lg md:text-xl font-bold text-gray-900">กรุณาเลือกหมวดหมู่ที่ต้องการ</h3>
              <p class="text-sm text-gray-500 mt-1">เลือกตัวกรองเพื่อค้นหาหอพักที่ตรงใจ</p>
            </div>

            <button v-if="hasFilter"
              class="text-xs md:text-sm px-3 py-1.5 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-700"
              @click="clearAllFilters">
              ล้างทั้งหมด
            </button>
          </div>

          <!-- TAGS ของฟิลเตอร์ที่เลือกอยู่ (ของเดิมใช้ได้) -->
          <div v-if="hasFilter" class="flex flex-wrap gap-2">
            <div v-if="hasFilter" class="flex flex-wrap gap-3">
              <!-- CATEGORY -->
              <span v-if="filters.category" class="px-3 py-1 bg-blue-100 rounded-full flex items-center gap-2 text-sm">
                หมวดหมู่: {{ selectedTexts.category }}
                <button @click="clearFilter('category')" class="text-red-500 font-bold">
                  ✕
                </button>
              </span>

              <!-- AMENITY -->
              <span v-for="id in filters.amenity" :key="id"
                class="px-3 py-1 bg-green-100 rounded-full flex items-center gap-2 text-sm">
                {{amenities.find(a => a.id === id)?.name}}
                <button @click="removeAmenity(id)" class="text-red-500 font-bold">
                  ✕
                </button>
              </span>

              <!-- BUS -->
              <span v-if="filters.bus" class="px-3 py-1 bg-yellow-100 rounded-full flex items-center gap-2 text-sm">
                การเดินทาง: {{ selectedTexts.bus }}
                <button @click="clearFilter('bus')" class="text-red-500 font-bold">
                  ✕
                </button>
              </span>

              <!-- PRICE -->
              <span v-if="filters.price_range"
                class="px-3 py-1 bg-purple-100 rounded-full flex items-center gap-2 text-sm">
                ช่วงราคา: {{ selectedTexts.price }}
                <button @click="clearFilter('price')" class="text-red-500 font-bold">
                  ✕
                </button>
              </span>

              <!-- ล้างทั้งหมด -->
              <button v-if="hasFilter"
                class="text-xs md:text-sm px-3 py-1.5 rounded-full border border-gray-200 hover:bg-gray-50 text-gray-700"
                @click="clearAllFilters">
                ล้างทั้งหมด
              </button>
            </div>
          </div>

          <!-- ปุ่มฟิลเตอร์ -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <CategoryFilter :categories="categories" :modelValue="filters.category" @select="selectCategory" />
            <AmenityFilter :amenities="amenities" :modelValue="filters.amenity" @select="selectAmenity" />
            <BusFilter :busRoutes="busRoutes" :modelValue="filters.bus" @select="selectBus" />
            <PriceFilter :modelValue="filters.price_range" @select="selectPrice" />
          </div>
        </div>


        <!-- SECTION 3 : DYNAMIC (ผลฟิลเตอร์ หรือ หมวดหมู่หอพัก) -->
        <div v-if="hasFilter">
          <SectionHeader title="ผลการค้นหา / ฟิลเตอร์" />

          <div v-if="filterLoading" class="text-center text-gray-500 py-10">
            กำลังค้นหา...
          </div>

          <DormCarousel v-else :dorms="filteredDorms" />

          <!-- ✅ Pagination Bar -->
          <div v-if="!filterLoading && pagination.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
            <button class="px-3 py-2 rounded-lg border bg-white hover:bg-gray-50 disabled:opacity-50"
              :disabled="pagination.current_page <= 1"
              @click="page = pagination.current_page - 1; fetchFilteredDorms();">
              ก่อนหน้า
            </button>

            <div class="text-sm text-gray-600 px-3">
              หน้า {{ pagination.current_page }} / {{ pagination.last_page }} • ทั้งหมด {{ pagination.total }} รายการ
            </div>

            <button class="px-3 py-2 rounded-lg border bg-white hover:bg-gray-50 disabled:opacity-50"
              :disabled="pagination.current_page >= pagination.last_page"
              @click="page = pagination.current_page + 1; fetchFilteredDorms();">
              ถัดไป
            </button>
          </div>

          <p v-if="!filterLoading && filteredDorms.length === 0" class="text-center text-gray-500 mt-6">
            ไม่พบหอพักตามตัวกรองที่เลือก
          </p>
        </div>

        <!-- ถ้าไม่มีฟิลเตอร์ -->
        <div v-else class="space-y-10">

          <div v-if="maleDorms?.length">
            <SectionHeader title="หอพัก ชายล้วน" showMore to="/dorms/category/male" />
            <DormCarousel :dorms="maleDorms" />
          </div>

          <div v-if="femaleDorms?.length">
            <SectionHeader title="หอพัก หญิงล้วน" showMore to="/dorms/category/female" />
            <DormCarousel :dorms="femaleDorms" />
          </div>

          <div v-if="sharedDorm?.length">
            <SectionHeader title="หอพัก รวม" showMore to="/dorms/category/shared" />
            <DormCarousel :dorms="sharedDorm" />
          </div>

          <div v-if="saveDorm?.length">
            <SectionHeader title="หอพัก ราคาประหยัด" showMore to="/dorms/category/save" />
            <DormCarousel :dorms="saveDorm" />
          </div>

          <div v-if="PremiumDorm?.length">
            <SectionHeader title="หอพัก พรีเมี่ยม" showMore to="/dorms/category/premium" />
            <DormCarousel :dorms="PremiumDorm" />
          </div>
        </div>
      </div>

          <!-- FAQ -->
    <section class="max-w-7xl mx-auto px-4 pb-16 md:pb-24">
      <div class="text-center">
        <p class="text-sm font-semibold text-zinc-600">FAQ</p>
        <h2 class="mt-3 text-4xl md:text-5xl font-extrabold text-zinc-900">
          Frequently asked questions
        </h2>
        <p class="mt-4 max-w-3xl mx-auto text-zinc-600 leading-relaxed">
          ใส่คำถามที่คนถามบ่อย ช่วยลดงานตอบแชทได้ครับ
        </p>
      </div>

      <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
          v-for="(q, idx) in faqs"
          :key="idx"
          class="bg-white rounded-2xl shadow-lg border border-zinc-100 p-6"
        >
          <h3 class="font-bold text-lg text-zinc-900">
            {{ q.q }}
          </h3>
          <p class="mt-2 text-sm text-zinc-600 leading-relaxed">
            {{ q.a }}
          </p>
        </div>
      </div>
    </section>

      <Footer />
    </div>
  </div>
</template>

<script setup>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import bangson from '@/assets/Img/bangson.jpg';
import jaran from '@/assets/Img/jaran.jpg';
import banner from '@/assets/Img/maxresdefault.jpg';
import stree from '@/assets/Img/stree.jpg';
import wong from '@/assets/Img/Wong.jpg';
import PaperBackground from '@/components/shared/PaperBackground.vue';

import axios from '../axios';
import AmenityFilter from '../components/User/AmenityFilter.vue';
import ArticleSection from '../components/User/ArticleSection.vue';
import BusFilter from '../components/User/BusFilter.vue';
import CategoryFilter from '../components/User/CategoryFilter.vue';
import DormCarousel from '../components/User/DormCarousel.vue';
import FeatureHighlights from '../components/User/FeatureHighlights.vue';
import Footer from '../components/User/Footer.vue';
import HeroBanner from '../components/User/HeroBanner.vue';
import Navbar from '../components/User/Navbar.vue';
import PopularUniversitySection
  from '../components/User/PopularUniversitySection.vue';
import PriceFilter from '../components/User/PriceFilter.vue';
import SearchBar from '../components/User/SearchBar.vue';
import SectionHeader from '../components/User/SectionHeader.vue';

/* ---------- MOCK DATA FOR UNIVERSITIES & ARTICLES ---------- */
const universities = ref([
  { id: 1, name: "โซนวงศ์สว่าง", img: wong },
  { id: 2, name: "โซนสตรีนนทบุรี", img: stree },
  { id: 3, name: "โซนบางซ่อน", img: bangson },
  { id: 4, name: "โซนจรัญ", img: jaran },
]);

/** FAQ */
const faqs = [
  {
    q: "ทำไมราคาหอพักไม่ตรงกับหน้าหอ?",
    a: "ราคาอาจมีการเปลี่ยนแปลงตามช่วงเวลา กรุณาตรวจสอบกับหอพักอีกครั้ง",
  },
  {
    q: "อยากให้เพิ่มหอพัก/แก้ไขข้อมูล ต้องทำยังไง?",
    a: "ติดต่อเราทางอีเมลหรือฟอร์ม พร้อมส่งรายละเอียด/รูปภาพเพื่อให้ทีมงานอัปเดต",
  },
  {
    q: "ตอบกลับภายในกี่วัน?",
    a: "โดยทั่วไปเราตอบกลับภายใน 24–48 ชั่วโมงในวันทำการ ",
  },
  {
    q: "ลงประกาศมีค่าใช้จ่ายไหม?",
    a: "ฟรี",
  },
];

const onSelectUniversity = (u) => {
  console.log("เลือกมหาวิทยาลัย:", u);
  // ใช้ u เพื่อ filter เพิ่มเติมได้ในอนาคต
};

const goToAllUniversities = () => {
  console.log("กดดูสถานศึกษาทั้งหมด");
  // router.push('/universities')
};

const goToArticle = (article) => {
  console.log("เลือกบทความ:", article);
  //  router.push(`/articles/${article.id}`)
};

/* ---------- DATA ---------- */
const recommend = ref([]);
const nearby = ref([]);
const categories = ref([]);
const amenities = ref([]);
const busRoutes = ref([]);
const maleDorms = ref([]);
const femaleDorms = ref([]);
const sharedDorm = ref([]);
const saveDorm = ref([]);
const PremiumDorm = ref([]);
const filteredDorms = ref([]);

/* ---------- FILTER STATE ---------- */
const filters = ref({
  search: "",
  category: null,
  amenity: [],
  bus: null,
  price_min: null,
  price_max: null,
  price_range: "",
});

/* ---------- COMPUTED ---------- */
const hasFilter = computed(() => {
  return (
    filters.value.search ||
    filters.value.category ||
    filters.value.amenity.length > 0 ||
    filters.value.bus ||
    filters.value.price_range
  );
});

const selectedTexts = computed(() => {
  const cat = categories.value.find(c => c.id === filters.value.category);
  const bus = busRoutes.value.find(b => b.id === filters.value.bus);

  const amenityNames = (filters.value.amenity || [])
    .map(id => amenities.value.find(a => a.id === id)?.name)
    .filter(Boolean);

  let priceLabel = "";
  if (filters.value.price_range) {
    const map = {
      "0-3000": "ต่ำกว่า 3000",
      "3000-5000": "3000 - 5000",
      "5000-8000": "5000 - 8000",
      "8000-999999": "มากกว่า 8000",
    };
    priceLabel = map[filters.value.price_range] || filters.value.price_range;
  }

  return {
    category: cat?.name || "",
    amenity: amenityNames.join(", "),
    bus: bus ? `สาย ${bus.route_number} - ${bus.route_name}` : "",
    price: priceLabel,
  };
});

const filterLoading = ref(false);

const page = ref(1);
const perPage = ref(12);
const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0,
  per_page: 12,
});

const removeAmenity = (id) => {
  filters.value.amenity = filters.value.amenity.filter(a => a !== id);
  fetchFilteredDorms();
};

/* ---------- API CALL FOR FILTERED RESULT ---------- */
let filterReqId = 0;

const fetchFilteredDorms = async (goPage = 1) => {
  const reqId = ++filterReqId;
  filterLoading.value = true;
  page.value = goPage;

  try {
    const res = await axios.get("/api/dorms/filter", {
      params: { ...filters.value, page: goPage, per_page: perPage.value },
    });

    if (reqId !== filterReqId) return; // ✅ ข้ามผลเก่า

    filteredDorms.value = res.data.data || [];
    pagination.value = {
      current_page: res.data.current_page,
      last_page: res.data.last_page,
      total: res.data.total,
      per_page: res.data.per_page,
    };
  } catch (e) {
    if (reqId !== filterReqId) return;
    console.error("Filter error:", e);
    filteredDorms.value = [];
  } finally {
    if (reqId === filterReqId) filterLoading.value = false;
  }
};


/* ---------- FILTER HANDLERS ---------- */
const onSearch = (keyword) => {
  filters.value.search = keyword;
  page.value = 1;
  fetchFilteredDorms(1);
};

const selectCategory = (id) => {
  filters.value.category = id;
  page.value = 1;
  fetchFilteredDorms(1);
};

const selectAmenity = (ids) => {
  filters.value.amenity = ids;
  page.value = 1;
  fetchFilteredDorms(1);
};

const selectBus = (id) => {
  filters.value.bus = id;
  page.value = 1;
  fetchFilteredDorms(1);
};

const selectPrice = (value) => {
  page.value = 1;

  if (!value) {
    filters.value.price_min = null;
    filters.value.price_max = null;
    filters.value.price_range = "";
    filteredDorms.value = [];
    return;
  }

  const [min, max] = value.split("-").map(Number);
  filters.value.price_min = min;
  filters.value.price_max = max;
  filters.value.price_range = value;

  fetchFilteredDorms(1);
};

const clearFilter = (key) => {
  page.value = 1;
  if (key === "price") {
    filters.value.price_min = null;
    filters.value.price_max = null;
    filters.value.price_range = "";
  } else if (key === "category") {
    filters.value.category = null;
  } else if (key === "bus") {
    filters.value.bus = null;
  }

  if (hasFilter.value) fetchFilteredDorms();
  else filteredDorms.value = [];
};

const clearAllFilters = () => {
  page.value = 1;
  filters.value = {
    search: "",
    category: null,
    amenity: [],
    bus: null,
    price_min: null,
    price_max: null,
    price_range: "",
  };
  filteredDorms.value = [];
  filterLoading.value = false;
};

onMounted(async () => {
  const [
    rec,
    near,
    cats,
    amens,
    buses,
    male,
    female,
    shared,
    save,
    premium,
  ] = await Promise.all([
    axios.get("/api/dorms/recommend"),
    axios.get("/api/dorms/nearby"),
    axios.get("/api/categories"),
    axios.get("/api/amenities"),
    axios.get("/api/bus-routes"),
    axios.get("/api/dorms/by-category/1"),
    axios.get("/api/dorms/by-category/2"),
    axios.get("/api/dorms/by-category/3"),
    axios.get("/api/dorms/by-category/4"),
    axios.get("/api/dorms/by-category/5"),
  ]);

  recommend.value = rec.data;
  nearby.value = near.data;
  categories.value = cats.data;
  amenities.value = amens.data;
  busRoutes.value = buses.data;
  maleDorms.value = male.data;
  femaleDorms.value = female.data;
  sharedDorm.value = shared.data;
  saveDorm.value = save.data;
  PremiumDorm.value = premium.data;
});

</script>
