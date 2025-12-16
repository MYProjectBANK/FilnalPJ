<template>
  <div class="min-h-screen flex">

    <!-- LEFT : IMAGE -->
    <div
      class="hidden md:flex w-1/2 items-center justify-center bg-cover bg-center"
      style="background-image:url('/img/auth-register.jpg')"
    >
      <div class="bg-black/50 text-white p-8 rounded-xl text-center">
        <h2 class="text-3xl font-bold mb-2">Create Account</h2>
        <p class="text-sm opacity-90">
          สมัครสมาชิกเพื่อค้นหาหอพักที่ดีที่สุด
        </p>
      </div>
    </div>

    <!-- RIGHT : FORM -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-50">
      <div class="w-full max-w-md bg-white rounded-xl shadow p-8 space-y-6">

        <div class="text-center">
          <h1 class="text-3xl font-bold text-green-600">Register</h1>
          <p class="text-gray-500 mt-1">สมัครสมาชิกใหม่</p>
        </div>

        <form @submit.prevent="register" class="space-y-4">

          <input v-model="fullname" placeholder="Full Name"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none" />

          <input v-model="email" type="email" placeholder="Email"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none" />

          <div class="relative">
            <input
              :type="showPassword ? 'text' : 'password'"
              v-model="password"
              placeholder="Password"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
            />
            <button
              type="button"
              class="absolute right-3 top-3 text-sm text-gray-500"
              @click="showPassword = !showPassword"
            >
              {{ showPassword ? 'Hide' : 'Show' }}
            </button>
          </div>

          <input v-model="password_confirmation" type="password" placeholder="Confirm Password"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none" />

          <input v-model="phone" placeholder="Phone"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none" />

          <input v-model.number="year_level" type="number" min="1" max="4" placeholder="Year Level (1-4)"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none" />

          <select v-model="faculty"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            <option value="">Select Faculty</option>
            <option>Engineering</option>
            <option>IT</option>
            <option>Science</option>
            <option>Humanities</option>
          </select>

          <button
            class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition"
          >
            Register
          </button>
        </form>

        <p class="text-center text-gray-600 text-sm">
          มีบัญชีแล้ว?
          <router-link to="/login" class="text-green-600 font-semibold hover:underline">
            Login
          </router-link>
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

const fullname = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const phone = ref('');
const year_level = ref(null);
const faculty = ref('');
const showPassword = ref(false);

const toast = ref({ show: false, message: '' });
const router = useRouter();

const showToast = (msg) => {
  toast.value.message = msg;
  toast.value.show = true;
  setTimeout(() => (toast.value.show = false), 3000);
};

const register = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/register', {
      fullname: fullname.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
      phone: phone.value,
      year_level: year_level.value,
      faculty: faculty.value,
      role: 'user',
    });

    router.push('/login');
  } catch (err) {
    showToast(err.response?.data?.message || 'Register failed');
  }
};
</script>
