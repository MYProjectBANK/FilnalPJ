<template>
  <nav class="w-full bg-white shadow fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

      <!-- Logo -->
      <h1
        class="text-xl font-bold text-blue-600 cursor-pointer"
        @click="$router.push('/')"
      >
        DORMFINDER
      </h1>

      <!-- MENU -->
      <div class="flex items-center space-x-6">

        <!-- PUBLIC MENU -->
        <RouterLink
          to="/"
          class="nav-item"
        >
          Home
        </RouterLink>

        <RouterLink
          to="/about"
          class="nav-item"
        >
          About
        </RouterLink>

        <RouterLink
          to="/contact"
          class="nav-item"
        >
          Contact
        </RouterLink>

        <!-- USER MENU -->
        <template v-if="token">
          <RouterLink
            to="/profile"
            class="nav-item"
          >
            Profile
          </RouterLink>

          <!-- ADMIN ONLY -->
          <button
            v-if="role === 'admin'"
            @click="$router.push('/admin/dorms')"
            class="px-3 py-1 bg-purple-600 text-white rounded"
          >
            Admin
          </button>

          <button
            @click="logout"
            class="px-3 py-1 bg-red-600 text-white rounded"
          >
            Logout
          </button>
        </template>

        <!-- NOT LOGGED-IN -->
        <template v-else>
          <button
            @click="$router.push('/login')"
            class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Login
          </button>

          <button
            @click="$router.push('/register')"
            class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-50"
          >
            Register
          </button>
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
.nav-item {
  position: relative;
  padding-bottom: 3px;
  font-size: 15px;
}

.nav-item.router-link-active {
  color: #1e90ff; /* blue */
}

.nav-item.router-link-active::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100%;
  height: 2px;
  background: #1e90ff;
}
</style>
