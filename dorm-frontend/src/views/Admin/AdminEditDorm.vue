<template>
    <DashboardLayout>
        <div class="p-6">

            <button @click="$router.push('/admin/dorms')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded mb-4">←
                Back</button>

            <h1 class="text-3xl font-bold mb-6">Edit Dorm: {{ form.name }}</h1>

            <div v-if="loading" class="text-center py-10 text-lg">Loading...</div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- LEFT SIDE FORM -->
                <div class="space-y-6">

                    <h2 class="text-xl font-semibold">Basic Info</h2>

                    <div class="space-y-3">

                        <label class="block">Name:
                            <input v-model="form.name" class="input" />
                        </label>

                        <label class="block">Description:
                            <textarea v-model="form.description" class="input h-24"></textarea>
                        </label>

                        <label class="block">Phone:
                            <input v-model="form.phone" class="input" />
                        </label>

                        <label class="block">Email:
                            <input v-model="form.email" class="input" />
                        </label>

                        <label class="block">Facebook:
                            <input v-model="form.facebook" class="input" />
                        </label>

                        <label class="block">Line ID:
                            <input v-model="form.line_id" class="input" />
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Location</h2>

                    <div class="grid grid-cols-2 gap-3">

                        <label class="block">Province:
                            <input v-model="form.province" class="input" />
                        </label>

                        <label class="block">District:
                            <input v-model="form.district" class="input" />
                        </label>

                        <label class="block">Subdistrict:
                            <input v-model="form.subdistrict" class="input" />
                        </label>

                        <label class="block">Street:
                            <input v-model="form.street" class="input" />
                        </label>

                        <label class="block col-span-2">Zipcode:
                            <input v-model="form.zipcode" class="input" />
                        </label>

                        <label class="block">Latitude:
                            <input type="number" step="0.000001" v-model="form.latitude" class="input" />
                        </label>

                        <label class="block">Longitude:
                            <input type="number" step="0.000001" v-model="form.longitude" class="input" />
                        </label>

                    </div>

                    <h2 class="text-xl font-semibold mt-6">Pricing</h2>

                    <div class="grid grid-cols-2 gap-3">

                        <label class="block">Price Min:
                            <input type="number" v-model="form.price_min" class="input" />
                        </label>

                        <label class="block">Price Max:
                            <input type="number" v-model="form.price_max" class="input" />
                        </label>

                        <label class="block">Deposit:
                            <input type="number" v-model="form.deposit_price" class="input" />
                        </label>

                        <label class="block">Electricity Rate:
                            <input type="number" step="0.1" v-model="form.electricity_rate" class="input" />
                        </label>

                        <label class="block">Water Rate:
                            <input type="number" v-model="form.water_rate" class="input" />
                        </label>

                        <label class="block">Internet Fee:
                            <input type="number" v-model="form.internet_fee" class="input" />
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Categories</h2>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="c in categories" :key="c.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="c.id" v-model="form.categories" />
                            {{ c.name }}
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Amenities</h2>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="a in amenities" :key="a.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="a.id" v-model="form.amenities" />
                            {{ a.name }}
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Zones</h2>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="z in zones" :key="z.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="z.id" v-model="form.zones" /> {{ z.name }}
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Bus Routes</h2>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="b in busRoutes" :key="b.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="b.id" v-model="form.bus_routes" />
                            {{ b.route_number }} - {{ b.route_name }}
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-6">Train Lines</h2>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="t in trainLines" :key="t.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="t.id" v-model="form.train_lines" />
                            {{ t.line_name }} - {{ t.station_name }}
                        </label>
                    </div>

                    <button @click="updateDorm" class="mt-8 px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Changes
                    </button>

                </div>

                <!-- RIGHT SIDE (IMAGE MANAGEMENT) -->
                <div>

                    <h2 class="text-xl font-semibold mb-3">Images</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div v-for="img in dorm.images" :key="img.id" class="relative border rounded overflow-hidden">

                            <img :src="imageUrl(img.image_path)" class="w-full h-36 object-cover" />

                            <button @click="deleteImage(img.id)"
                                class="absolute top-1 right-1 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                X
                            </button>

                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mt-6">Upload New Images</h3>
                    <input type="file" multiple @change="selectNewImages" class="mt-2" />

                    <button @click="uploadNewImages"
                        class="px-4 py-2 mt-3 bg-green-600 text-white rounded hover:bg-green-700">
                        Upload Images
                    </button>

                </div>

            </div>
        </div>
    </DashboardLayout>
</template>


<script>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';
import { useRoute } from 'vue-router';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';

export default {
    components: { DashboardLayout },

    setup() {
        const route = useRoute();   // ✅ useRoute() ถูกต้อง

        const dorm = ref(null);
        const form = ref({});
        const loading = ref(true);
        const newImages = ref([]);

        const categories = ref([]);
        const amenities = ref([]);
        const zones = ref([]);
        const busRoutes = ref([]);
        const trainLines = ref([]);

        const token = localStorage.getItem("token");
        const headers = { Authorization: `Bearer ${token}` };

        // Load dorm + all related lists
        const fetchDorm = async () => {
            loading.value = true;

            const [dormRes, catRes, amenRes, zoneRes, busRes, trainRes] = await Promise.all([
                axios.get(`http://127.0.0.1:8000/api/admin/dorms/${route.params.id}`, { headers }),
                axios.get("http://127.0.0.1:8000/api/admin/categories", { headers }),
                axios.get("http://127.0.0.1:8000/api/admin/amenities", { headers }),
                axios.get("http://127.0.0.1:8000/api/admin/zones", { headers }),
                axios.get("http://127.0.0.1:8000/api/admin/bus-routes", { headers }),
                axios.get("http://127.0.0.1:8000/api/admin/train-lines", { headers }),
            ]);

            dorm.value = dormRes.data;

            form.value = {
                ...dorm.value,
                categories: dorm.value.categories?.map(c => c.id) ?? [],
                amenities: dorm.value.amenities?.map(a => a.id) ?? [],
                zones: dorm.value.zones?.map(z => z.id) ?? [],
                bus_routes: dorm.value.bus_routes?.map(b => b.id) ?? [],
                train_lines: dorm.value.train_lines?.map(t => t.id) ?? [],
            };

categories.value = catRes.data.data;
amenities.value = amenRes.data.data;
zones.value = zoneRes.data.data;
busRoutes.value = busRes.data.data;
trainLines.value = trainRes.data.data;

            loading.value = false;
        };

        // Update dorm main data
        const updateDorm = async () => {
            const fd = new FormData();

            Object.keys(form.value).forEach(key => {
                if (key === "images") return;

                if (Array.isArray(form.value[key])) {
                    form.value[key].forEach(v => fd.append(`${key}[]`, v));
                } else {
                    fd.append(key, form.value[key] ?? "");
                }
            });

            await axios.post(
                `http://127.0.0.1:8000/api/admin/dorms/${dorm.value.id}?_method=PUT`,
                fd,
                { headers }
            );

            alert("Dorm updated!");
            fetchDorm();
        };

        // Select images
        const selectNewImages = (e) => {
            newImages.value = Array.from(e.target.files);
        };

        // Upload new images
        const uploadNewImages = async () => {
            if (newImages.value.length === 0) return alert("Please select images.");

            const fd = new FormData();
            newImages.value.forEach(img => fd.append("images[]", img));

            await axios.post(
                `http://127.0.0.1:8000/api/admin/dorms/${dorm.value.id}?_method=PUT`,
                fd,
                { headers }
            );

            newImages.value = [];
            alert("Images uploaded!");
            fetchDorm();
        };

        // Delete image
        const deleteImage = async (imgId) => {
            if (!confirm("Delete this image?")) return;

            await axios.delete(
                `http://127.0.0.1:8000/api/admin/dorm-images/${imgId}`,
                { headers }
            );

            fetchDorm();
        };

        const imageUrl = (path) => `http://127.0.0.1:8000/storage/${path}`;

        onMounted(fetchDorm);

        return {
            dorm,
            form,
            loading,
            categories,
            amenities,
            zones,
            busRoutes,
            trainLines,
            newImages,
            updateDorm,
            selectNewImages,
            uploadNewImages,
            deleteImage,
            imageUrl,
        };
    }
};
</script>

