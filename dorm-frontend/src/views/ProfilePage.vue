<template>
    <div class="pt-20 p-4 max-w-5xl mx-auto">
        <!-- BACK BUTTON -->
        <button @click="$router.back()"
            class="mb-4 px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm flex items-center gap-1">
            ← กลับ
        </button>

        <!-- HEADER -->
        <div class="flex items-center gap-4 mb-6">
            <div
                class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center text-2xl font-bold">
                {{ userInitial }}
            </div>
            <div>
                <h1 class="text-2xl font-bold">โปรไฟล์ผู้ใช้</h1>

                <p class="text-gray-600 text-sm" v-if="user">
                    {{ user.fullname }} — {{ user.email }}
                </p>

                <p class="text-gray-500 text-sm" v-if="user">
                    ปีการศึกษา: {{ user.year_level || "—" }} / สาขา: {{ user.faculty || "—" }}
                </p>
            </div>
        </div>

        <!-- TABS -->
        <div class="border-b mb-6 flex gap-6 text-sm">
            <button class="pb-2 relative"
                :class="activeTab === 'profile' ? 'text-blue-600 font-semibold' : 'text-gray-600'"
                @click="activeTab = 'profile'">
                ข้อมูลส่วนตัว
                <span v-if="activeTab === 'profile'" class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600" />
            </button>

            <button class="pb-2 relative"
                :class="activeTab === 'favorites' ? 'text-blue-600 font-semibold' : 'text-gray-600'"
                @click="activeTab = 'favorites'">
                รายการที่ถูกใจ
                <span v-if="activeTab === 'favorites'" class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600" />
            </button>
        </div>

        <!-- ALERT -->
        <p v-if="errorMessage" class="mb-4 text-sm text-red-600">
            {{ errorMessage }}
        </p>
        <p v-if="successMessage" class="mb-4 text-sm text-green-600">
            {{ successMessage }}
        </p>

        <!-- TAB: PROFILE -->
        <div v-if="activeTab === 'profile'" class="space-y-4">
            <h2 class="text-lg font-semibold mb-2">แก้ไขข้อมูลส่วนตัว</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">ชื่อ-นามสกุล</label>
                    <input v-model="profileForm.fullname" type="text" class="w-full border rounded px-3 py-2 text-sm" />
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">อีเมล</label>
                    <input v-model="profileForm.email" type="email" class="w-full border rounded px-3 py-2 text-sm" />
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">เบอร์โทร</label>
                    <input v-model="profileForm.phone" type="text" class="w-full border rounded px-3 py-2 text-sm" />
                </div>

                <!-- YEAR LEVEL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">ชั้นปี</label>
                    <select v-model="profileForm.year_level" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- เลือกชั้นปี --</option>
                        <option v-for="y in yearLevels" :key="y" :value="y">
                            {{ y }}
                        </option>
                    </select>
                </div>

                <!-- FACULTY -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">สาขา / คณะ</label>
                    <select v-model="profileForm.faculty" class="w-full border rounded px-3 py-2 text-sm">
                        <option value="">-- เลือกสาขา --</option>
                        <option v-for="f in faculties" :key="f" :value="f">
                            {{ f }}
                        </option>
                    </select>
                </div>
            </div>

            <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded text-sm" @click="updateProfile"
                :disabled="savingProfile">
                {{ savingProfile ? 'กำลังบันทึก...' : 'บันทึกข้อมูล' }}
            </button>
        </div>

        <!-- TAB: FAVORITES -->
        <div v-if="activeTab === 'favorites'" class="space-y-4">
            <h2 class="text-lg font-semibold mb-2">หอพักที่คุณถูกใจ ❤️</h2>

            <div v-if="favoritesLoading" class="text-gray-500 text-sm">กำลังโหลดรายการ...</div>

            <div v-else-if="favorites.length === 0" class="text-gray-500 text-sm">
                ยังไม่มีหอพักในรายการโปรดของคุณ
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="fav in favorites" :key="fav.id"
                    class="border rounded-lg overflow-hidden bg-white shadow-sm cursor-pointer hover:shadow-md transition"
                    @click="$router.push(`/dorms/${fav.dorm.id}`)">
                    <img v-if="fav.dorm.images?.length" :src="imageUrl(fav.dorm.images[0].image_path)"
                        class="w-full h-40 object-cover" />
                    <img v-else src="/no-image.jpg" class="w-full h-40 object-cover" />

                    <div class="p-3 space-y-1">
                        <h3 class="font-semibold truncate">{{ fav.dorm.name }}</h3>
                        <p class="text-sm text-blue-600">
                            ฿{{ fav.dorm.price_min }} - ฿{{ fav.dorm.price_max }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ fav.dorm.province }} • {{ fav.dorm.district }}
                        </p>
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

// Avatar initial
const userInitial = computed(() => {
    if (!user.value) return "U";
    return user.value.fullname?.charAt(0).toUpperCase() || "U";
});

const imageUrl = (path) =>
    path ? `http://127.0.0.1:8000/storage/${path}` : "/no-image.jpg";

const loadUser = async () => {
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
};

const loadMetadata = async () => {
    const f = await api.get("/api/metadata/faculties");
    const y = await api.get("/api/metadata/year-levels");

    faculties.value = f.data;
    yearLevels.value = y.data;
};

const loadFavorites = async () => {
    favoritesLoading.value = true;

    const res = await api.get("/api/favorites", {
        headers: { Authorization: `Bearer ${token}` },
    });

    favorites.value = res.data;
    favoritesLoading.value = false;
};

// UPDATE PROFILE
const updateProfile = async () => {
    savingProfile.value = true;
    errorMessage.value = "";
    successMessage.value = "";

    try {
        await api.put(
            "/api/user/update",
            profileForm.value,
            { headers: { Authorization: `Bearer ${token}` } }
        );

        successMessage.value = "อัปเดตข้อมูลเรียบร้อยแล้ว";
        loadUser();
    } catch (e) {
        errorMessage.value = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }

    savingProfile.value = false;
};

onMounted(() => {
    loadUser();
    loadMetadata();
    loadFavorites();
});
</script>
