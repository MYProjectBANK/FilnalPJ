<template>
    <div class="min-h-screen bg-gray-50/50 py-10 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">

            <div class="mb-6">
                <button @click="$router.back()"
                    class="inline-flex items-center text-gray-500 hover:text-gray-900 transition-colors font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    ย้อนกลับ
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <div class="lg:col-span-1 space-y-6">

                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-90">
                        </div>

                        <div class="relative mt-8 mb-4">
                            <div class="w-24 h-24 rounded-full bg-white p-1 shadow-md">
                                <div
                                    class="w-full h-full rounded-full bg-slate-200 flex items-center justify-center text-3xl font-bold text-slate-500 overflow-hidden">
                                    {{ userInitial }}
                                </div>
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800">{{ user?.fullname || 'Loading...' }}</h2>
                        <p class="text-gray-500 text-sm mb-4">{{ user?.email }}</p>

                        <div class="w-full border-t border-gray-100 pt-4 mt-2">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-500">ชั้นปี</span>
                                <span class="font-medium text-gray-800">{{ user?.year_level || '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">คณะ</span>
                                <span class="font-medium text-gray-800 text-right w-32 truncate">{{ user?.faculty || '-'
                                    }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <button @click="activeTab = 'profile'"
                            class="w-full text-left px-6 py-4 flex items-center gap-3 transition-all border-l-4"
                            :class="activeTab === 'profile' ? 'bg-blue-50 border-blue-500 text-blue-700 font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50'">
                            <span class="text-lg">👤</span> ข้อมูลส่วนตัว
                        </button>
                        <button @click="activeTab = 'favorites'"
                            class="w-full text-left px-6 py-4 flex items-center gap-3 transition-all border-l-4"
                            :class="activeTab === 'favorites' ? 'bg-pink-50 border-pink-500 text-pink-700 font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50'">
                            <span class="text-lg">❤️</span> รายการที่ถูกใจ
                            <span v-if="favorites.length"
                                class="ml-auto bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{
                                    favorites.length }}</span>
                        </button>
                    </div>

                </div>

                <div class="lg:col-span-3">

                    <div v-if="successMessage"
                        class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center gap-2 animate-fade-in-up">
                        <span class="bg-green-100 p-1 rounded-full">✓</span> {{ successMessage }}
                    </div>
                    <div v-if="errorMessage"
                        class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center gap-2 animate-fade-in-up">
                        <span class="bg-red-100 p-1 rounded-full">!</span> {{ errorMessage }}
                    </div>

                    <div v-if="activeTab === 'profile'"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 animate-fade-in-up">
                        <div class="flex justify-between items-center mb-6 border-b pb-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">แก้ไขข้อมูลส่วนตัว</h2>
                                <p class="text-gray-500 text-sm">จัดการข้อมูลบัญชีของคุณ</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="label">ชื่อ-นามสกุล</label>
                                <div class="relative">
                                    <input v-model="profileForm.fullname" type="text" class="input-field pl-10"
                                        placeholder="ระบุชื่อ-นามสกุล" />
                                </div>
                            </div>

                            <div>
                                <label class="label">อีเมล <span
                                        class="text-xs font-normal text-gray-400">(แก้ไขไม่ได้)</span></label>
                                <div class="relative">
                                    <input v-model="profileForm.email" type="email"
                                        class="input-field pl-10 bg-gray-100 text-gray-500 cursor-not-allowed"
                                        disabled />
                                </div>
                            </div>

                            <div>
                                <label class="label">เบอร์โทรศัพท์</label>
                                <div class="relative">
                                    <input v-model="profileForm.phone" type="text" class="input-field pl-10"
                                        placeholder="0xx-xxx-xxxx" />
                                </div>
                            </div>

                            <div>
                                <label class="label">ชั้นปีการศึกษา</label>
                                <div class="relative">
                                    <select v-model="profileForm.year_level" class="input-field appearance-none">
                                        <option value="">-- เลือกชั้นปี --</option>
                                        <option v-for="y in yearLevels" :key="y" :value="y">{{ y }}</option>
                                    </select>
                                    <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">▼</span>
                                </div>
                            </div>

                            <div>
                                <label class="label">คณะ / สาขาวิชา</label>
                                <div class="relative">
                                    <select v-model="profileForm.faculty" class="input-field appearance-none">
                                        <option value="">-- เลือกสาขาวิชา --</option>

                                        <option>สาขาวิชาวิศวกรรมไฟฟ้า</option>
                                        <option>สาขาวิชาวิศวกรรมเครื่องกล</option>
                                        <option>สาขาวิชาวิศวกรรมอุตสาหการ</option>
                                        <option>สาขาวิชาวิศวกรรมคอมพิวเตอร์</option>
                                        <option>สาขาวิชาวิศวกรรมเมคคาทรอนิกส์</option>
                                        <option>สาขาวิชาวิศวกรรมไฟฟ้าสื่อสารและระบบอัจฉริยะ</option>
                                        <option>สาขาวิชาวิศวกรรมโยธา</option>
                                        <option>สาขาวิชาวิศวกรรมเครื่องมือและแม่พิมพ์</option>
                                        <option>สาขาวิชาวิศวกรรมการผลิตเครื่องประดับ</option>
                                        <option>สาขาวิชาวิศวกรรมเทคโนโลยีนวัตกรรมเพื่อความยั่งยืน(ต่อเนื่อง)</option>
                                        <option>สาขาวิชาอัญมณีรังสรรค์</option>

                                        <option>สาขาวิชาวิทยาการคอมพิวเตอร์</option>
                                        <option>สาขาวิชาวิทยาศาสตร์และเทคโนโลยีสิ่งแวดล้อม</option>
                                        <option>สาขาวิชาวัสดุศาสตร์อุตสาหกรรม</option>
                                        <option>สาขาวิชาวิทยาการข้อมูลและเทคโนโลยีสารสนเทศ</option>
                                        <option>สาขาวิชาเทคโนโลยีสุขภาพ เครื่องสำอาง และการชะลอวัย</option>
                                        <option>สาขาวิชาสถิติสารสนเทศ</option>
                                        <option>สาขาวิชาการจัดการสภาพภูมิอากาศและสิ่งแวดล้อม</option>
                                    </select>

                                    <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">▼</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                                @click="updateProfile" :disabled="savingProfile">
                                <span v-if="savingProfile"
                                    class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                                {{ savingProfile ? "กำลังบันทึก..." : "บันทึกการเปลี่ยนแปลง" }}
                            </button>
                        </div>
                    </div>

                    <div v-if="activeTab === 'favorites'" class="animate-fade-in-up">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">หอพักที่บันทึกไว้ ({{ favorites.length }})</h2>

                        <div v-if="favoritesLoading" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-for="i in 2" :key="i" class="bg-white rounded-xl h-40 animate-pulse"></div>
                            <div class="p-4 space-y-3">
                                <div class="h-5 bg-gray-200 rounded w-3/4 animate-pulse"></div>
                                <div class="h-3 bg-gray-100 rounded w-1/2 animate-pulse"></div>
                                <div class="flex gap-2 mt-2">
                                    <div class="h-4 bg-gray-100 rounded w-10 animate-pulse"></div>
                                    <div class="h-4 bg-gray-100 rounded w-16 animate-pulse"></div>
                                </div>
                            </div>
                        </div>



                        <div v-else-if="favorites.length === 0"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <div class="text-4xl mb-3">💔</div>
                            <h3 class="text-gray-800 font-medium text-lg">ยังไม่มีรายการโปรด</h3>
                            <p class="text-gray-500 mb-6">คุณยังไม่ได้กดถูกใจหอพักไหนเลย ลองไปค้นหาดูสิ!</p>
                            <button @click="$router.push('/dorms')"
                                class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 font-medium transition">
                                ค้นหาหอพัก
                            </button>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <template v-for="fav in favorites" :key="fav.id">
                                <div v-if="fav && fav.dorm"
                                    class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group cursor-pointer"
                                    @click="$router.push(`/dorms/${fav.dorm.id}`)">

                                    <div class="h-48 overflow-hidden relative">
                                        <img v-if="fav.dorm.images?.length"
                                            :src="imageUrl(fav.dorm.images[0].image_path)"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                        <img v-else src="/no-image.jpg"
                                            class="w-full h-full object-cover bg-gray-100" />

                                        <div
                                            class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-blue-700 font-bold text-sm shadow-sm">
                                            ฿{{ fav.dorm.price_min }}
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-bold text-gray-900 text-lg truncate mb-1">{{ fav.dorm.name }}
                                        </h3>
                                        <div class="flex items-center text-gray-500 text-xs mb-3">
                                            <span class="mr-1">📍</span> {{ fav.dorm.subdistrict }}, {{
                                                fav.dorm.district }}
                                        </div>

                                        <div class="flex items-center gap-2 mt-2">
                                            <span v-for="(cat, idx) in fav.dorm.categories?.slice(0, 2)" :key="idx"
                                                class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] rounded-md">
                                                {{ cat.name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
  computed,
  onMounted,
  ref,
} from 'vue';

import { useRouter } from 'vue-router';

import api from '../axios';

const router = useRouter();
const token = localStorage.getItem("token");
if (!token) router.push("/login");

/* ---------------- STATE ---------------- */
const user = ref(null);

const profileForm = ref({
    fullname: "",
    email: "",
    phone: "",
    faculty: "",
    year_level: "",
});

const favorites = ref([]);
const favoritesLoading = ref(true);

const faculties = ref([]);
const yearLevels = ref([]);

const activeTab = ref("profile");
const savingProfile = ref(false);

const errorMessage = ref("");
const successMessage = ref("");

/* ---------------- COMPUTED ---------------- */
const userInitial = computed(() =>
    user.value?.fullname?.charAt(0).toUpperCase() || "U"
);

const imageUrl = (path) =>
    path ? `http://127.0.0.1:8000/storage/${path}` : "/no-image.jpg";

/* ---------------- API ---------------- */
const loadUser = async () => {
    try {
        const res = await api.get("/api/user", {
            headers: { Authorization: `Bearer ${token}` },
        });
        user.value = res.data;

        profileForm.value = {
            fullname: res.data.fullname || "",
            email: res.data.email || "",
            phone: res.data.phone || "",
            faculty: res.data.faculty || "",
            year_level: res.data.year_level || "",
        };
    } catch (e) {
        console.error(e);
    }
};

const loadMetadata = async () => {
    try {
        const [f, y] = await Promise.all([
            api.get("/api/metadata/faculties"),
            api.get("/api/metadata/year-levels"),
        ]);
        faculties.value = f.data;
        yearLevels.value = y.data;
    } catch (e) { console.error(e); }
};

const loadFavorites = async () => {
    favoritesLoading.value = true;
    try {
        const res = await api.get("/api/favorites", {
            headers: { Authorization: `Bearer ${token}` },
        });
        favorites.value = (res.data || []).filter(f => f && f.dorm);
    } catch (e) {
        console.error("โหลด favorites ไม่สำเร็จ", e);
        favorites.value = [];
    } finally {
        favoritesLoading.value = false;
    }
};

const updateProfile = async () => {
    savingProfile.value = true;
    errorMessage.value = "";
    successMessage.value = "";

    try {
        const payload = {
            ...profileForm.value,
            faculty: profileForm.value.faculty === "" ? null : profileForm.value.faculty,
            year_level: profileForm.value.year_level === "" ? null : profileForm.value.year_level,
        };

        await api.put("/api/user/update", payload, {
            headers: { Authorization: `Bearer ${token}` },
        });

        successMessage.value = "อัปเดตข้อมูลเรียบร้อยแล้ว";
        setTimeout(() => successMessage.value = "", 3000);
        await loadUser();
    } catch {
        errorMessage.value = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    } finally {
        savingProfile.value = false;
    }
};


/* ---------------- INIT ---------------- */
onMounted(() => {
    loadUser();
    loadMetadata();
    loadFavorites();
});
</script>

<style scoped>
@reference "tailwindcss";

.label {
    @apply block text-sm font-semibold text-gray-700 mb-1.5;
}

.input-field {
    @apply w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-gray-800 placeholder-gray-400;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.4s ease-out forwards;
}
</style>