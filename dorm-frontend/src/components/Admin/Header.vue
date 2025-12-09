<template>
  <div class="bg-white shadow p-4 flex justify-between items-center">
    <span class="font-medium text-lg">Admin Dashboard</span>

    <div class="flex gap-3">
      <!-- Back to Home -->
      <button
        @click="goHome"
        class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700"
      >
        Home
      </button>

      <!-- Logout -->
      <button 
        @click="logout"
        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
      >
        Logout
      </button>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();

    const goHome = () => {
      router.push("/");
    };

    const logout = () => {
      localStorage.removeItem("token");
      localStorage.removeItem("role");
      router.push("/login");
    };

    return { logout, goHome };
  }
};
</script>
