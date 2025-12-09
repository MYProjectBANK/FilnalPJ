<template>
    <DashboardLayout>
        <div class="p-6">

            <!-- BACK BUTTON -->
            <button @click="$router.push('/admin/dorms')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded mb-4">
                ← Back
            </button>

            <div v-if="loading" class="text-center py-10">
                Loading...
            </div>

            <div v-else-if="dorm" class="space-y-6">

                <!-- TITLE -->
                <h1 class="text-3xl font-bold">{{ dorm.name }}</h1>

                <!-- IMAGE GALLERY -->
                <div>
                    <h2 class="text-xl font-semibold mb-2">Gallery</h2>

                    <div class="grid grid-cols-3 gap-3">
                        <div v-for="img in dorm.images" :key="img.id"
                            class="w-full h-40 rounded overflow-hidden border">
                            <img :src="imageUrl(img.image_path)" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>

                <!-- CONTACT -->
                <div>
                    <h2 class="text-xl font-semibold mb-2">Contact</h2>
                    <p><strong>Phone:</strong> {{ dorm.phone }}</p>
                    <p><strong>Email:</strong> {{ dorm.email }}</p>
                    <p><strong>Facebook:</strong> {{ dorm.facebook }}</p>
                    <p><strong>Line ID:</strong> {{ dorm.line_id }}</p>
                </div>

                <!-- ADDRESS -->
                <div>
                    <h2 class="text-xl font-semibold mb-2">Address</h2>
                    <p>{{ dorm.street }}, {{ dorm.subdistrict }}, {{ dorm.district }}, {{ dorm.province }} {{
                        dorm.zipcode }}</p>
                </div>

                <!-- PRICE -->
                <div>
                    <h2 class="text-xl font-semibold mb-2">Prices</h2>
                    <p>ราคา: {{ dorm.price_min }} - {{ dorm.price_max }} บาท</p>
                    <p>มัดจำ: {{ dorm.deposit_price }} บาท</p>
                    <p>ค่าไฟ: {{ dorm.electricity_rate }} บาท/ยูนิต</p>
                    <p>ค่าน้ำ: {{ dorm.water_rate }} บาท</p>
                    <p>อินเทอร์เน็ต: {{ dorm.internet_fee }} บาท</p>
                </div>

                <!-- TAGS / RELATIONS -->
                <div>
                    <h2 class="text-xl font-semibold mb-2">Categories</h2>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="c in dorm.categories" :key="c.id" class="px-3 py-1 bg-blue-200 rounded">
                            {{ c.name }}
                        </span>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-2">Amenities</h2>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="a in dorm.amenities" :key="a.id" class="px-3 py-1 bg-green-200 rounded">
                            {{ a.name }}
                        </span>
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
        const dorm = ref(null);
        const loading = ref(true);

        const route = useRoute();  // ✔ ได้ค่า param แล้ว

        const fetchDorm = async () => {
            loading.value = true;

            const res = await axios.get(
                `http://127.0.0.1:8000/api/admin/dorms/${route.params.id}`,
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                }
            );

            dorm.value = res.data;
            loading.value = false;
        };

        const imageUrl = (path) => {
            return `http://127.0.0.1:8000/storage/${path}`;
        };

        onMounted(fetchDorm);

        return { dorm, loading, imageUrl };
    },
};
</script>

