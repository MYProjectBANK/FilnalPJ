<template>
  <div class="flex min-h-screen">
    <!-- Left Side: Login Form -->
    <div class="flex-1 flex items-center justify-center bg-gray-50">
      <div class="w-full max-w-md p-8 bg-white rounded shadow space-y-6">
        <h1 class="text-3xl font-bold text-center">Welcome Back</h1>
        <p class="text-center text-gray-500">Sign in to your account</p>

        <form @submit.prevent="login" class="space-y-4">
          <input v-model="email" type="email" placeholder="Email" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
          <input v-model="password" type="password" placeholder="Password" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
          <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">Login</button>
        </form>

        <p class="text-center text-gray-600">
          Don’t have an account?
          <router-link to="/register" class="text-blue-600 font-semibold hover:underline">Sign up for free!</router-link>
        </p>
      </div>
    </div>

    <!-- Right Side: Image -->
    <div class="flex-1 hidden md:flex items-center justify-center bg-blue-100">
      <!-- <img src="/login-illustration.svg" alt="Login Illustration" class="max-w-sm" /> -->
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const email = ref('');
    const password = ref('');
    const router = useRouter();

    const login = async () => {
      try {
        const res = await axios.post('http://127.0.0.1:8000/api/login', {
          email: email.value,
          password: password.value
        });

        // เก็บ token และ role
        localStorage.setItem('token', res.data.token);
        localStorage.setItem('role', res.data.user.role);

        if (res.data.user.role === 'admin') {
          router.push('/admin/dorms');
        } else {
          router.push('/');
        }
      } catch (err) {
        alert(err.response?.data?.message || 'Login failed');
      }
    };

    return { email, password, login };
  }
};
</script>

<style>
</style>
