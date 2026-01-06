<template>
  <nav class="w-full bg-white shadow fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

      <!-- Logo -->
      <h1 class="text-xl font-bold text-fuchsia-900 cursor-pointer" @click="$router.push('/')">
        DORMFINDER
      </h1>

      <!-- MENU -->
      <div class="flex items-center space-x-6 font-medium">

        <!-- PUBLIC MENU -->
        <RouterLink to="/" class="nav-item">
          Home
        </RouterLink>

        <RouterLink to="/about" class="nav-item">
          About
        </RouterLink>

        <RouterLink to="/contact" class="nav-item">
          Contact
        </RouterLink>

        <!-- USER MENU -->
        <template v-if="token">
          <RouterLink to="/profile" class="nav-item">
            Profile
          </RouterLink>

          <!-- ADMIN ONLY -->
          <button v-if="role === 'admin'" @click="$router.push('/admin/dashboard')" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold
           rounded-xl border border-purple-200 bg-purple-50 text-purple-700
           hover:bg-purple-100 hover:border-purple-300
           active:scale-[0.98] transition
           focus:outline-none focus:ring-2 focus:ring-purple-200" title="Admin Dashboard">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Management
          </button>

          <button @click="logout" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold
           rounded-xl border border-red-200 bg-red-50 text-red-700
           hover:bg-red-100 hover:border-red-300
           active:scale-[0.98] transition
           focus:outline-none focus:ring-2 focus:ring-red-200" title="Logout">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
            </svg>
            Logout
          </button>
        </template>

        <!-- NOT LOGGED-IN -->
        <template v-else>
          <div class="flex items-center gap-2">
            <!-- Login (Primary) -->
            <button @click="$router.push('/login')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold
           rounded-xl bg-blue-600 text-white shadow-sm
           hover:bg-blue-700 hover:shadow
           active:scale-[0.98] transition
           focus:outline-none focus:ring-2 focus:ring-blue-200">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4m-7-4l-4-4m0 0l4-4m-4 4h12" />
              </svg>
              Login
            </button>

            <!-- Register (Secondary / Outline) -->
            <button @click="$router.push('/register')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold
           rounded-xl border border-blue-200 text-blue-700 bg-white
           hover:bg-blue-50 hover:border-blue-300
           active:scale-[0.98] transition
           focus:outline-none focus:ring-2 focus:ring-blue-200">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 7a4 4 0 110 8a4 4 0 010-8z" />
              </svg>
              Register
            </button>
          </div>
        </template>

      </div>
    </div>
  </nav>
</template>

<script setup>
const token = localStorage.getItem("token");
const role = localStorage.getItem("role");

const logout = () => {
  localStorage.removeItem("token");
  localStorage.removeItem("role");
  window.location.href = "/login";
};
</script>

<style scoped>
@reference "tailwindcss";

.nav-item {
  position: relative;
  padding-bottom: 3px;
  font-size: 15px;
}

.nav-item.router-link-active {
  color: #9d1bc5;
  /* blue */
}

.nav-item.router-link-active::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100%;
  height: 2px;
  background: #ce5ec4;
}
</style>
