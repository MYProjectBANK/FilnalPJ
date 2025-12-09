<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Pending Reviews</h1>

            <div v-if="loading" class="text-center py-6">Loading...</div>

            <div v-else>
                <div v-for="r in reviews" :key="r.id" class="bg-white p-4 rounded shadow mb-4 border">
<h2 class="text-lg font-semibold">
    {{ r.user?.fullname ?? "Unknown User" }} 
    reviewed 
    <span class="text-blue-600">
        {{ r.dorm?.name ?? "Unknown Dorm" }}
    </span>
</h2>

<p class="text-gray-700 my-2">{{ r.comment }}</p>

<p class="text-sm text-gray-500">
    Created at: {{ new Date(r.created_at).toLocaleString() }}
</p>


                    <div class="flex gap-2 mt-3">
                        <button @click="approve(r.id)"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Approve
                        </button>

                        <button @click="reject(r.id)" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Reject
                        </button>
                    </div>
                </div>

                <div v-if="reviews.length === 0" class="text-center text-gray-500 py-6">
                    No pending reviews.
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';

const reviews = ref([]);
const loading = ref(true);

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchReviews = async () => {
    loading.value = true;
    const res = await axios.get("http://127.0.0.1:8000/api/admin/reviews/pending", config);
    reviews.value = res.data.data ?? res.data;
    loading.value = false;
};

const approve = async (id) => {
    await axios.put(`http://127.0.0.1:8000/api/admin/reviews/${id}/approve`, {}, config);
    fetchReviews();
};

const reject = async (id) => {
    await axios.put(`http://127.0.0.1:8000/api/admin/reviews/${id}/reject`, {}, config);
    fetchReviews();
};

onMounted(fetchReviews);
</script>
