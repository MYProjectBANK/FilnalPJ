<template>
  <DashboardLayout>
    <div class="p-6">

      <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

      <div v-if="loading" class="text-center py-10">Loading...</div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <Card title="Total Dorms" :value="stats.dorms" color="blue" />
        <Card title="Total Users" :value="stats.users" color="green" />
        <Card title="Pending Reviews" :value="stats.reviews_pending" color="yellow" />
        <Card title="Categories" :value="stats.categories" color="purple" />
        <Card title="Amenities" :value="stats.amenities" color="teal" />
        <Card title="Zones" :value="stats.zones" color="pink" />
        <Card title="Bus Routes" :value="stats.bus_routes" color="red" />
        <Card title="Train Lines" :value="stats.train_lines" color="indigo" />

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
import Card from '../../components/Admin/StatCard.vue';

const stats = ref({});
const loading = ref(true);

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` }};

const fetchStats = async () => {
  const res = await axios.get("http://127.0.0.1:8000/api/admin/dashboard/stats", config);
  stats.value = res.data;
  loading.value = false;
};

onMounted(fetchStats);
</script>
