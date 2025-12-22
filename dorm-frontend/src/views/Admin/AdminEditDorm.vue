<template>
    <DashboardLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <button @click="$router.push('/admin/dorms')"
                        class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Dormitory</h1>
                        <p class="text-sm text-gray-500" v-if="form.name">Updating: <span
                                class="font-medium text-indigo-600">{{ form.name }}</span></p>
                    </div>
                </div>

                <button @click="updateDorm"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Changes
                </button>
            </div>

            <div v-if="loading" class="flex justify-center items-center py-20">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="ml-3 text-gray-600 font-medium">Loading dorm data...</span>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Basic Information</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Dorm Name</label>
                                <input v-model="form.name" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border"
                                    placeholder="Enter dorm name" />
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea v-model="form.description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border"></textarea>
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input v-model="form.phone" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input v-model="form.email" type="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Facebook</label>
                                <input v-model="form.facebook" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Line ID</label>
                                <input v-model="form.line_id" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Location</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Province</label>
                                <input v-model="form.province" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">District</label>
                                <input v-model="form.district" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Subdistrict</label>
                                <input v-model="form.subdistrict" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Street</label>
                                <input v-model="form.street" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Zipcode</label>
                                <input v-model="form.zipcode" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input v-model="form.latitude" type="number" step="0.000001"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input v-model="form.longitude" type="number" step="0.000001"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Pricing & Fees</h2>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Price Min (THB)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">฿</span>
                                    </div>
                                    <input v-model="form.price_min" type="number"
                                        class="block w-full pl-7 rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 border" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Price Max (THB)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">฿</span>
                                    </div>
                                    <input v-model="form.price_max" type="number"
                                        class="block w-full pl-7 rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 border" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Deposit</label>
                                <input v-model="form.deposit_price" type="number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Electricity (Unit)</label>
                                <input v-model="form.electricity_rate" type="number" step="0.1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Water (Unit)</label>
                                <input v-model="form.water_rate" type="number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Internet Fee</label>
                                <input v-model="form.internet_fee" type="number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-10 px-3 border" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Categories</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <label v-for="c in categories" :key="c.id"
                                    class="inline-flex items-center p-2 border rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" :value="c.id" v-model="form.categories"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-700">{{ c.name }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Amenities</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label v-for="a in amenities" :key="a.id" class="inline-flex items-center">
                                    <input type="checkbox" :value="a.id" v-model="form.amenities"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-700">{{ a.name }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Zones</h3>
                            <div class="flex flex-wrap gap-2">
                                <label v-for="z in zones" :key="z.id"
                                    class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full border">
                                    <input type="checkbox" :value="z.id" v-model="form.zones"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                    <span class="ml-2 text-sm text-gray-700">{{ z.name }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Transportation</h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase">Bus Routes</span>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <label v-for="b in busRoutes" :key="b.id"
                                            class="inline-flex items-center text-sm">
                                            <input type="checkbox" :value="b.id" v-model="form.bus_routes"
                                                class="rounded border-gray-300 text-indigo-600" />
                                            <span class="ml-1 text-gray-600">{{ b.route_number }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase">Train Lines</span>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <label v-for="t in trainLines" :key="t.id"
                                            class="inline-flex items-center text-sm">
                                            <input type="checkbox" :value="t.id" v-model="form.train_lines"
                                                class="rounded border-gray-300 text-indigo-600" />
                                            <span class="ml-1 text-gray-600">{{ t.line_name }} ({{ t.station_name
                                                }})</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 sticky top-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Dorm Images</h2>

                        <div v-if="dorm.images && dorm.images.length > 0" class="grid grid-cols-2 gap-2 mb-6">
                            <div v-for="img in dorm.images" :key="img.id"
                                class="relative group rounded-lg overflow-hidden bg-gray-100 aspect-[4/3]">
                                <img :src="imageUrl(img.image_path)" class="w-full h-full object-cover" />
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center pointer-events-none">
                                    <button @click="deleteImage(img)"
                                        class="pointer-events-auto opacity-0 group-hover:opacity-100 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition-all transform scale-90 group-hover:scale-100"
                                        title="Delete Image">
                                        Delete
                                    </button>
                                </div>

                            </div>
                        </div>
                        <p v-else class="text-sm text-gray-500 italic mb-4">No images uploaded yet.</p>

                        <div class="border-t pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Images</label>
                            <div class="flex items-center justify-center w-full">
                                <label
                                    class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-8 h-8 text-gray-400 group-hover:text-indigo-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="pt-1 text-xs tracking-wider text-gray-400 group-hover:text-gray-600">
                                            Select photos</p>
                                    </div>
                                    <input type="file" multiple @change="selectNewImages" class="opacity-0" />
                                </label>
                            </div>

                            <div v-if="newImages.length > 0" class="mt-3">
                                <p class="text-xs text-green-600 font-medium">{{ newImages.length }} files selected</p>
                                <button @click="uploadNewImages"
                                    class="mt-2 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                    Confirm Upload
                                </button>
                            </div>
                        </div>

                    </div>
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
        const route = useRoute();
        const dorm = ref({}); // Initialize as empty obj to prevent null errors
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

        // Helper: Base URL for images
        const imageUrl = (path) => `http://127.0.0.1:8000/storage/${path}`;

        // Load dorm + all related lists
        const fetchDorm = async () => {
            loading.value = true;
            try {
                const [dormRes, catRes, amenRes, zoneRes, busRes, trainRes] = await Promise.all([
                    axios.get(`http://127.0.0.1:8000/api/admin/dorms/${route.params.id}`, { headers }),
                    axios.get("http://127.0.0.1:8000/api/admin/categories", { headers }),
                    axios.get("http://127.0.0.1:8000/api/admin/amenities", { headers }),
                    axios.get("http://127.0.0.1:8000/api/admin/zones", { headers }),
                    axios.get("http://127.0.0.1:8000/api/admin/bus-routes", { headers }),
                    axios.get("http://127.0.0.1:8000/api/admin/train-lines", { headers }),
                ]);

                dorm.value = dormRes.data;

                // Map data to form
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
            } catch (error) {
                console.error("Error fetching data:", error);
                alert("Failed to load dorm data.");
            } finally {
                loading.value = false;
            }
        };

        // Update dorm main data
        const updateDorm = async () => {
            const fd = new FormData();

            Object.keys(form.value).forEach(key => {
                if (key === "images") return; // Skip images in main update

                if (Array.isArray(form.value[key])) {
                    form.value[key].forEach(v => fd.append(`${key}[]`, v));
                } else {
                    fd.append(key, form.value[key] ?? "");
                }
            });

            try {
                await axios.post(
                    `http://127.0.0.1:8000/api/admin/dorms/${dorm.value.id}?_method=PUT`,
                    fd,
                    { headers }
                );
                alert("Dorm updated successfully!");
                fetchDorm();
            } catch (error) {
                console.error("Update failed:", error);
                alert("Failed to update dorm.");
            }
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

            try {
                await axios.post(
                    `http://127.0.0.1:8000/api/admin/dorms/${dorm.value.id}?_method=PUT`,
                    fd,
                    { headers }
                );
                newImages.value = [];
                alert("Images uploaded successfully!");
                fetchDorm();
            } catch (error) {
                console.error("Upload failed:", error);
                alert("Failed to upload images.");
            }
        };

        const deleteImage = async (img) => {
            if (!confirm("Are you sure you want to delete this image?")) return;

            const deleteId = img?.pivot?.id ?? img?.dorm_image_id ?? img?.id;
            if (!deleteId) return alert("ไม่พบ id ของรูปที่จะลบ");

            try {
                await axios.delete(
                    `http://127.0.0.1:8000/api/admin/dorm-images/${deleteId}`,
                    { headers }
                );
                await fetchDorm();
            } catch (error) {
                console.error("Delete failed:", error);
                alert("Failed to delete image.");
            }
        };



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