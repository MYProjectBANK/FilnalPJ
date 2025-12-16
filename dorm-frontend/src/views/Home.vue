<template>
  <div>
    <Navbar />

    <!-- HERO BANNER -->
    <div class="pt-20">
      <HeroBanner />
    </div>

    <!-- SECTION: สถานศึกษายอดนิยม -->
    <PopularUniversitySection :universities="universities" bannerImage="/img/university-banner.jpg"
      @select="onSelectUniversity" @viewAll="goToAllUniversities" />

    <!-- HEADLINE + SEARCH -->
    <div class="text-center items-center my-10 px-4">
      <h1 class="text-3xl md:text-4xl font-medium mb-6">
        รวมอพาร์ทเม้นท์ ที่พัก หอพัก สำหรับนักศึกษาและบุคลากร
      </h1>
      <div class="flex justify-center my-8">
        <SearchBar @search="onSearch" />
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="px-4 max-w-7xl mx-auto space-y-14 pb-10">

      <!-- SECTION 1 : แนะนำ + ใกล้สถานศึกษา -->
      <div>
        <!-- <SectionHeader title="หอพักแนะนำ" showMore to="/dorms?type=recommend" /> -->
        <DormCarousel :dorms="recommend" />

      </div>

      <div>
        <!-- <SectionHeader title="หอพักใกล้สถานศึกษา" showMore to="/dorms?type=nearby" /> -->
        <DormCarousel :dorms="nearby" />

      </div>

      <!-- SECTION 2 : FILTERS -->
      <div class="space-y-4">
        <SectionHeader title="กรุณาเลือกหมวดหมู่ที่ต้องการ" />

        <!-- TAGS ของฟิลเตอร์ที่เลือกอยู่ -->
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
          <span v-if="filters.price_range" class="px-3 py-1 bg-purple-100 rounded-full flex items-center gap-2 text-sm">
            ช่วงราคา: {{ selectedTexts.price }}
            <button @click="clearFilter('price')" class="text-red-500 font-bold">
              ✕
            </button>
          </span>

          <!-- ล้างทั้งหมด -->
          <button class="px-3 py-1 border rounded-full text-xs text-gray-600 hover:bg-gray-100"
            @click="clearAllFilters">
            ล้างตัวกรองทั้งหมด
          </button>
        </div>

        <!-- ปุ่มฟิลเตอร์ 4 ตัว -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <CategoryFilter :categories="categories" :modelValue="filters.category" @select="selectCategory" />
          <AmenityFilter :amenities="amenities" :modelValue="filters.amenity" @select="selectAmenity" />
          <BusFilter :busRoutes="busRoutes" :modelValue="filters.bus" @select="selectBus" />
          <PriceFilter :modelValue="filters.price_range" @select="selectPrice" />
        </div>
      </div>

      <!-- SECTION 3 : DYNAMIC (ผลฟิลเตอร์ หรือ หมวดหมู่หอพัก) -->

      <!-- ถ้ามีฟิลเตอร์ -->
      <div v-if="hasFilter">
        <SectionHeader title="ผลการค้นหา / ฟิลเตอร์" />
        <DormCarousel :dorms="filteredDorms" />

        <p v-if="filteredDorms.length === 0" class="text-center text-gray-500 mt-6">
          ไม่พบหอพักตามตัวกรองที่เลือก
        </p>
      </div>

      <!-- ถ้าไม่มีฟิลเตอร์ -->
  <div v-else class="space-y-10">

  <div>
    <SectionHeader
      title="หอพัก ชายล้วน"
      showMore
      to="/dorms/category/male"
    />
    <DormCarousel :dorms="maleDorms" />
  </div>

  <div>
    <SectionHeader
      title="หอพัก หญิงล้วน"
      showMore
      to="/dorms/category/female"
    />
    <DormCarousel :dorms="femaleDorms" />
  </div>

  <div>
    <SectionHeader
      title="หอพัก รวม"
      showMore
      to="/dorms/category/shared"
    />
    <DormCarousel :dorms="sharedDorm" />
  </div>

  <div>
    <SectionHeader
      title="หอพัก ราคาประหยัด"
      showMore
      to="/dorms/category/save"
    />
    <DormCarousel :dorms="saveDorm" />
  </div>

  <div>
    <SectionHeader
      title="หอพัก พรีเมี่ยม"
      showMore
      to="/dorms/category/premium"
    />
    <DormCarousel :dorms="PremiumDorm" />
  </div>

</div>


    </div>

    <!-- ARTICLE SECTION -->
    <ArticleSection title="Interesting" highlight="article" subtitle="บทความที่น่าสนใจ อพาร์ทเม้นท์น่ารู้"
      :items="articles" @select="goToArticle" />

    <Footer />
  </div>
</template>

<script setup>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import axios from '../axios';
import AmenityFilter from '../components/User/AmenityFilter.vue';
import ArticleSection from '../components/User/ArticleSection.vue';
import BusFilter from '../components/User/BusFilter.vue';
import CategoryFilter from '../components/User/CategoryFilter.vue';
import DormCarousel from '../components/User/DormCarousel.vue';
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
  { id: 1, name: "ม.เกษตรศาสตร์", img: "/img/uni-kaset.jpg" },
  { id: 2, name: "ม.รามคำแหง", img: "/img/uni-ram.jpg" },
  { id: 3, name: "จุฬาลงกรณ์มหาวิทยาลัย", img: "/img/uni-chula.jpg" },
  { id: 4, name: "ม.ศรีปทุม", img: "/img/uni-spu.jpg" },
]);

const articles = ref([
  { id: 1, title: "วิธีเลือกหอพักให้เหมาะกับนักศึกษา", image: "/img/article1.jpg" },
  { id: 2, title: "เคล็ดลับประหยัดค่าใช้จ่ายในหอพัก", image: "/img/article2.jpg" },
  { id: 3, title: "สิ่งที่ควรรู้ก่อนทำสัญญาเช่าหอ", image: "/img/article3.jpg" },
]);

const goToArticle = (article) => {
  console.log("เลือกบทความ:", article);
  // TODO: router.push(`/articles/${article.id}`)
};

const onSelectUniversity = (u) => {
  console.log("เลือกมหาวิทยาลัย:", u);
  // TODO: ใช้ u เพื่อ filter เพิ่มเติมได้ในอนาคต
};

const goToAllUniversities = () => {
  console.log("กดดูสถานศึกษาทั้งหมด");
  // TODO: router.push('/universities')
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
  price_range: "", // เก็บ string ไว้ใช้โชว์ + ติ๊กถูก
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
  const cat = categories.value.find((c) => c.id === filters.value.category);
  const amen = amenities.value.find((a) => a.id === filters.value.amenity);
  const bus = busRoutes.value.find((b) => b.id === filters.value.bus);

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
    amenity: amen?.name || "",
    bus: bus ? `สาย ${bus.route_number} - ${bus.route_name}` : "",
    price: priceLabel,
  };
});


const removeAmenity = (id) => {
  filters.value.amenity = filters.value.amenity.filter(a => a !== id);
  fetchFilteredDorms();
};


/* ---------- API CALL FOR FILTERED RESULT ---------- */
const fetchFilteredDorms = async () => {
  try {
    const res = await axios.get("/api/dorms/filter", {
      params: filters.value,
    });
    filteredDorms.value = res.data;
  } catch (e) {
    console.error("Filter error:", e);
  }
};

/* ---------- FILTER HANDLERS ---------- */
const onSearch = (keyword) => {
  filters.value.search = keyword;
  fetchFilteredDorms();
};

const selectCategory = (id) => {
  filters.value.category = id;
  fetchFilteredDorms();
};

const selectAmenity = (ids) => {
  filters.value.amenity = ids;
  fetchFilteredDorms();
};


const selectBus = (id) => {
  filters.value.bus = id;
  fetchFilteredDorms();
};

const selectPrice = (value) => {
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

  fetchFilteredDorms();
};

const clearFilter = (key) => {
  if (key === "price") {
    filters.value.price_min = null;
    filters.value.price_max = null;
    filters.value.price_range = "";
  } else {
    filters.value[key] = null;
  }
  if (hasFilter.value) {
    fetchFilteredDorms();
  } else {
    filteredDorms.value = [];
  }
};

const clearAllFilters = () => {
  filters.value = {
    search: "",
    category: null,
    amenity: null,
    bus: null,
    price_min: null,
    price_max: null,
    price_range: "",
  };
  filteredDorms.value = [];
};

/* ---------- LOAD INITIAL DATA ---------- */
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
