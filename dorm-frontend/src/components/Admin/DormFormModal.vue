<template>
    <div v-if="show"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex justify-center items-center z-50 transition-all duration-300">

        <div
            class="bg-white w-full max-w-5xl h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-fade-in-up mx-4">

            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white z-20 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                        <span v-if="mode === 'create'" class="text-xl">🏠</span>
                        <span v-else class="text-xl">✏️</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 leading-tight">
                            {{ mode === "create" ? "เพิ่มหอพักใหม่" : "แก้ไขข้อมูลหอพัก" }}
                        </h2>
                        <p class="text-xs text-gray-500">กรอกข้อมูลให้ครบถ้วนเพื่อประสิทธิภาพในการค้นหา</p>
                    </div>
                </div>
                <button @click="close"
                    class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full transition text-gray-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8 bg-gray-50/50 custom-scrollbar">

                <form @submit.prevent="submit" class="space-y-8">

                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                            📝 ข้อมูลทั่วไป
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="label">ชื่อหอพัก <span class="text-red-500">*</span></label>
                                <input v-model="form.name" class="input-field text-lg font-medium" type="text"
                                    placeholder="เช่น หอพักบ้านแสนสุข" required />
                            </div>
                            <div class="md:col-span-2">
                                <label class="label">รายละเอียด</label>
                                <textarea v-model="form.description" class="input-field min-h-[100px]"
                                    placeholder="บรรยายจุดเด่นของหอพัก..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                            📍 ที่อยู่และตำแหน่ง
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                            <div class="col-span-2 md:col-span-3">
                                <label class="label">ถนน / ซอย</label>
                                <input v-model="form.street" class="input-field" placeholder="ระบุถนน หรือ ซอย" />
                            </div>
                            <div class="col-span-2 md:col-span-3">
                                <label class="label">ตำบล/แขวง</label>
                                <input v-model="form.subdistrict" class="input-field" />
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="label">อำเภอ/เขต</label>
                                <input v-model="form.district" class="input-field" />
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="label">จังหวัด</label>
                                <input v-model="form.province" class="input-field" />
                            </div>
                            <div class="col-span-2 md:col-span-2">
                                <label class="label">รหัสไปรษณีย์</label>
                                <input v-model="form.zipcode" class="input-field" />
                            </div>

                            <div class="col-span-1 md:col-span-3 relative">
                                <label class="label text-blue-600">Latitude</label>
                                <input v-model="form.latitude" class="input-field font-mono text-xs" type="number"
                                    step="0.000001" />
                            </div>
                            <div class="col-span-1 md:col-span-3 relative">
                                <label class="label text-blue-600">Longitude</label>
                                <input v-model="form.longitude" class="input-field font-mono text-xs" type="number"
                                    step="0.000001" />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <h3
                                class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                💰 ราคาและค่าบริการ
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="label">ราคาต่ำสุด</label>
                                    <div class="relative">
                                        <input v-model="form.price_min" class="input-field pr-8" type="number"
                                            placeholder="0" />
                                        <span class="absolute right-3 top-2.5 text-gray-400 text-xs">฿</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="label">ราคาสูงสุด</label>
                                    <div class="relative">
                                        <input v-model="form.price_max" class="input-field pr-8" type="number"
                                            placeholder="0" />
                                        <span class="absolute right-3 top-2.5 text-gray-400 text-xs">฿</span>
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label class="label">เงินมัดจำ</label>
                                    <input v-model="form.deposit_price" class="input-field" type="number"
                                        placeholder="0" />
                                </div>
                                <div>
                                    <label class="label">ค่าไฟ (ต่อยูนิต)</label>
                                    <input v-model="form.electricity_rate" class="input-field" type="number"
                                        step="0.1" />
                                </div>
                                <div>
                                    <label class="label">ค่าน้ำ (เหมา/ยูนิต)</label>
                                    <input v-model="form.water_rate" class="input-field" type="number" />
                                </div>
                                <div class="col-span-2">
                                    <label class="label">ค่าอินเทอร์เน็ต (ต่อเดือน)</label>
                                    <input v-model="form.internet_fee" class="input-field" type="number"
                                        placeholder="0 (ฟรีใส่ 0)" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <h3
                                class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                📞 ช่องทางติดต่อ
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 flex justify-center text-gray-400">📱</div>
                                    <div class="flex-1">
                                        <label class="label">เบอร์โทรศัพท์</label>
                                        <input v-model="form.phone" class="input-field" placeholder="08x-xxx-xxxx" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 flex justify-center text-gray-400">📧</div>
                                    <div class="flex-1">
                                        <label class="label">อีเมล</label>
                                        <input v-model="form.email" class="input-field"
                                            placeholder="email@example.com" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 flex justify-center text-blue-600 font-bold">f</div>
                                    <div class="flex-1">
                                        <label class="label">Facebook</label>
                                        <input v-model="form.facebook" class="input-field"
                                            placeholder="Link หรือ ชื่อเพจ" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 flex justify-center text-green-500 font-bold text-lg">L</div>
                                    <div class="flex-1">
                                        <label class="label">Line ID</label>
                                        <input v-model="form.line_id" class="input-field" placeholder="@lineid" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-6">

                        <div>
                            <label class="label mb-3 block">ประเภทหอพัก</label>
                            <div class="flex flex-wrap gap-2">
                                <label v-for="c in categories" :key="c.id" class="cursor-pointer">
                                    <input type="checkbox" :value="c.id" v-model="form.categories" class="hidden" />

                                    <div class="px-4 py-1.5 rounded-full border text-sm transition-all hover:shadow-sm"
                                        :class="form.categories.includes(c.id)
                                            ? 'bg-blue-600 text-white border-blue-600'
                                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                                        {{ c.name }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="label mb-3 block">สิ่งอำนวยความสะดวก</label>
                            <div class="flex flex-wrap gap-2">
                                <label v-for="a in amenities" :key="a.id" class="cursor-pointer">
                                    <input type="checkbox" :value="a.id" v-model="form.amenities" class="hidden" />

                                    <div class="px-3 py-1.5 rounded-lg border text-sm transition-all hover:shadow-sm"
                                        :class="form.amenities.includes(a.id)
                                            ? 'bg-green-600 text-white border-green-600'
                                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                                        + {{ a.name }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="label mb-3 block">โซนที่ตั้ง</label>
                            <div class="flex flex-wrap gap-2">
                                <label v-for="z in zones" :key="z.id" class="cursor-pointer">
                                    <input type="checkbox" :value="z.id" v-model="form.zones" class="hidden" />

                                    <div class="px-4 py-1.5 rounded-full border text-sm transition-all hover:shadow-sm"
                                        :class="form.zones.includes(z.id)
                                            ? 'bg-purple-600 text-white border-purple-600'
                                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                                        {{ z.name }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="label mb-3 block">การเดินทางใกล้เคียง</label>
                            <div
                                class="p-4 bg-gray-50 rounded-lg border border-gray-200 max-h-40 overflow-y-auto custom-scrollbar">
                                <div class="flex flex-wrap gap-2">
                                    <label v-for="b in busRoutes" :key="b.id" class="cursor-pointer">
                                        <input type="checkbox" :value="b.id" v-model="form.bus_routes" class="hidden" />

                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded text-xs font-medium border transition-colors"
                                            :class="form.bus_routes.includes(b.id)
                                                ? 'bg-yellow-400 text-yellow-900 border-yellow-400'
                                                : 'bg-white text-gray-600 border-gray-200'">
                                            🚌 {{ b.route_number }}
                                        </span>
                                    </label>

                                    <div class="w-full h-0 basis-full my-1"></div> <label v-for="t in trainLines"
                                        :key="t.id" class="cursor-pointer">
                                        <input type="checkbox" :value="t.id" v-model="form.train_lines"
                                            class="hidden" />

                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded text-xs font-medium border transition-colors"
                                            :class="form.train_lines.includes(t.id)
                                                ? 'bg-pink-500 text-white border-pink-500'
                                                : 'bg-white text-gray-600 border-gray-200'">
                                            🚆 {{ t.station_name }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                        <label class="label mb-3 block">รูปภาพหอพัก</label>

                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-xl hover:bg-gray-50 transition-colors p-8 text-center cursor-pointer group">
                            <input type="file" multiple @change="onImageUpload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

                            <div class="space-y-2 pointer-events-none">
                                <div
                                    class="w-12 h-12 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 font-medium">คลิกเพื่อเลือกรูปภาพ หรือ ลากไฟล์มาวางที่นี่</p>
                                <p class="text-xs text-gray-400">รองรับไฟล์ JPG, PNG (สูงสุด 10 รูป)</p>
                            </div>
                        </div>

                        <div v-if="previewImages.length" class="mt-4 grid grid-cols-3 md:grid-cols-5 gap-3">
                            <div v-for="(img, index) in previewImages" :key="index"
                                class="relative aspect-square rounded-lg overflow-hidden border border-gray-200">
                                <img :src="img" class="w-full h-full object-cover" />
                                <button @click.prevent="removeImage(index)"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-100 bg-white z-20 flex justify-end gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <button @click="close"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    ยกเลิก
                </button>
                <button @click="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium shadow-md hover:bg-blue-700 hover:shadow-lg transition-all flex items-center gap-2">
                    <span v-if="loading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                    {{ mode === "create" ? "ยืนยันการเพิ่มข้อมูล" : "บันทึกการแก้ไข" }}
                </button>
            </div>

        </div>
    </div>
</template>

<script setup>
import {
  onMounted,
  onUnmounted,
  ref,
} from 'vue';

import axios from 'axios';

const props = defineProps(["mode", "show", "dormData"]);
const emit = defineEmits(["close", "submit"]);

// State
const loading = ref(false);
const previewImages = ref([]); // เก็บ URL สำหรับ Preview

const form = ref({
    name: "", description: "",
    province: "", district: "", subdistrict: "", street: "", zipcode: "",
    phone: "", email: "", facebook: "", line_id: "",
    price_min: "", price_max: "", deposit_price: "",
    electricity_rate: "", water_rate: "", internet_fee: "",
    latitude: "", longitude: "",
    categories: [], amenities: [], zones: [], bus_routes: [], train_lines: [],
    images: [],
});

// Master Data
const categories = ref([]);
const amenities = ref([]);
const zones = ref([]);
const busRoutes = ref([]);
const trainLines = ref([]);

// Functions
const onImageUpload = (e) => {
    const files = Array.from(e.target.files);
    form.value.images = [...form.value.images, ...files]; // Append files

    // Create Preview URLs
    files.forEach(file => {
        const url = URL.createObjectURL(file);
        previewImages.value.push(url);
    });
};

const removeImage = (index) => {
    form.value.images.splice(index, 1);
    previewImages.value.splice(index, 1);
};

const submit = () => {
    loading.value = true;
    emit("submit", form.value);
    // Loading จะถูกจัดการโดย Parent หรือปิดเมื่อเสร็จ
    setTimeout(() => loading.value = false, 1000);
};

const close = () => {
    previewImages.value = []; // Clear preview
    emit("close");
};

// Lifecycle
onMounted(async () => {
    document.body.style.overflow = 'hidden';

    const token = localStorage.getItem("token");
    const config = { headers: { Authorization: `Bearer ${token}` } };

    try {
        // Load Master Data
        const [catRes, amRes, zoneRes, busRes, trainRes] = await Promise.all([
            axios.get("http://127.0.0.1:8000/api/admin/categories", config),
            axios.get("http://127.0.0.1:8000/api/admin/amenities", config),
            axios.get("http://127.0.0.1:8000/api/admin/zones", config),
            axios.get("http://127.0.0.1:8000/api/admin/bus-routes", config),
            axios.get("http://127.0.0.1:8000/api/admin/train-lines", config)
        ]);

        categories.value = catRes.data.data;
        amenities.value = amRes.data.data;
        zones.value = zoneRes.data.data;
        busRoutes.value = busRes.data.data;
        trainLines.value = trainRes.data.data;

        // Map Data for Edit Mode
        if (props.mode === "edit" && props.dormData) {
            const d = props.dormData;
            Object.keys(form.value).forEach(key => {
                if (Array.isArray(form.value[key]) && key !== 'images') {
                    // Map arrays (categories, amenities, etc.)
                    form.value[key] = d[key] ? d[key].map(item => item.id) : [];
                } else if (key !== 'images') {
                    form.value[key] = d[key] || "";
                }
            });

        }
    } catch (error) {
        console.error("Error loading data:", error);
    }
});

onUnmounted(() => {
    document.body.style.overflow = '';
});
</script>

<style scoped>
@reference "tailwindcss";

.input-field {
    @apply w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-sm text-gray-800 placeholder-gray-400;
}

.label {
    @apply block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide;
}

.select-pill {
    @apply px-4 py-1.5 rounded-full border border-gray-200 bg-white text-gray-600 text-sm transition-all hover:bg-gray-50 hover:shadow-sm;
}

.transport-pill {
    @apply inline-flex items-center px-3 py-1 rounded text-xs font-medium bg-white text-gray-600 border border-gray-200 transition-colors;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>