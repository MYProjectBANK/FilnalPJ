<template>
  <div class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Title -->
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center">
          <svg class="w-5 h-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
          </svg>
        </div>

        <div>
          <p class="text-sm text-gray-500 leading-none">Admin</p>
          <h1 class="text-lg font-bold text-gray-900 leading-tight">Dashboard Management</h1>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center gap-2">
        <!-- Home -->
        <button
          @click="goHome"
          class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold
                 rounded-xl border border-gray-200 bg-white text-gray-700
                 hover:bg-gray-50 hover:border-gray-300
                 active:scale-[0.98] transition
                 focus:outline-none focus:ring-2 focus:ring-gray-200"
          title="Back to Home"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m4 0h5a1 1 0 001-1V10" />
          </svg>
          <span class="hidden sm:inline">Home</span>
        </button>

        <!-- Logout -->
        <button
          @click="logout"
          class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold
                 rounded-xl border border-red-200 bg-red-50 text-red-700
                 hover:bg-red-100 hover:border-red-300
                 active:scale-[0.98] transition
                 focus:outline-none focus:ring-2 focus:ring-red-200"
          title="Logout"
        >
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
          </svg>
          <span class="hidden sm:inline">Logout</span>
        </button>
      </div>
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
