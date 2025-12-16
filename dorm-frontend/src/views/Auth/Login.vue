<template>
  <div class="min-h-screen flex">

    <!-- LEFT : FORM -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-50">
      <div class="w-full max-w-md bg-white rounded-xl shadow p-8 space-y-6">

        <div class="text-center">
          <h1 class="text-3xl font-bold text-blue-600">DORMFINDER</h1>
          <p class="text-gray-500 mt-1">เข้าสู่ระบบ</p>
        </div>

        <form @submit.prevent="login" class="space-y-4">

          <input
            v-model="email"
            type="email"
            placeholder="Email"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
            required
          />

          <div class="relative">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model="password"
              placeholder="Password"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
              required
            />
            <button
              type="button"
              class="absolute right-3 top-3 text-sm text-gray-500"
              @click="showPassword = !showPassword"
            >
              {{ showPassword ? 'Hide' : 'Show' }}
            </button>
          </div>

          <button
            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
          >
            Login
          </button>
        </form>

        <p class="text-center text-gray-600 text-sm">
          ยังไม่มีบัญชี?
          <router-link to="/register" class="text-blue-600 font-semibold hover:underline">
            สมัครสมาชิก
          </router-link>
        </p>
      </div>
    </div>

    <!-- RIGHT : IMAGE -->
    <div
      class="hidden md:flex w-1/2 items-center justify-center bg-cover bg-center"
      style="background-image:url('/img/auth-login.jpg')"
    >
      <div class="bg-black/50 text-white p-8 rounded-xl text-center">
        <h2 class="text-3xl font-bold mb-2">Welcome Back</h2>
        <p class="text-sm opacity-90">
          ค้นหาหอพักที่ใช่ สำหรับคุณ
        </p>
      </div>
    </div>

    <!-- TOAST -->
    <div
      v-if="toast.show"
      class="fixed bottom-6 right-6 bg-red-500 text-white px-4 py-3 rounded-lg shadow"
    >
      {{ toast.message }}
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

import axios from 'axios';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const showPassword = ref(false);
const router = useRouter();

const toast = ref({ show: false, message: '' });

const showToast = (msg) => {
  toast.value.message = msg;
  toast.value.show = true;
  setTimeout(() => (toast.value.show = false), 3000);
};

const login = async () => {
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem('token', res.data.token);
    localStorage.setItem('role', res.data.user.role);

    router.push(res.data.user.role === 'admin' ? '/admin/dorms' : '/');
  } catch (err) {
    showToast(err.response?.data?.message || 'Login failed');
  }
};
</script>
