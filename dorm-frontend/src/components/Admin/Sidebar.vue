<template>
  <div class="h-screen bg-gray-900 text-white p-4 w-64">
    <h1 class="text-lg font-bold mb-6">Admin Dashboard</h1>

    <nav class="flex flex-col gap-3">

      <!-- DORM SECTION -->
      <div>
        <router-link
  to="/admin/dashboard"
  class="block p-2 rounded hover:bg-gray-700"
>
  Dashboard
</router-link>

        <button 
          @click="toggleDormMenu" 
          class="w-full text-left font-semibold flex justify-between items-center"
        >
          Dorm Management
          <span>{{ dormOpen ? "−" : "+" }}</span>
        </button>
        

        <div v-if="dormOpen" class="ml-4 mt-2 flex flex-col gap-2 text-sm">
          <router-link to="/admin/dorms">Dorms</router-link>
          <router-link to="/admin/categories">Categories</router-link>
          <router-link to="/admin/amenities">Amenities</router-link>
          <router-link to="/admin/zones">Zones</router-link>
          <router-link to="/admin/reviews">Reviews</router-link>
          <router-link to="/admin/bus-routes">Bus Routes</router-link>
          <router-link to="/admin/train-lines">Train Lines</router-link>
        </div>
      </div>

      <!-- USER SECTION -->
      <div class="mt-4">
        <button 
          @click="toggleUserMenu" 
          class="w-full text-left font-semibold flex justify-between items-center"
        >
          User Management
          <span>{{ userOpen ? "−" : "+" }}</span>
        </button>

        <div v-if="userOpen" class="ml-4 mt-2 flex flex-col gap-2 text-sm">
          <router-link to="/admin/users">Users</router-link>
        </div>
      </div>

    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const dormOpen = ref(true);
const userOpen = ref(false);

const toggleDormMenu = () => {
  dormOpen.value = !dormOpen.value;
};

const toggleUserMenu = () => {
  userOpen.value = !userOpen.value;
};
</script>

<style scoped>
a.router-link-active {
  color: #60a5fa; /* text-blue-400 */
  font-weight: bold;
}
</style>
