<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 font-sans">

    <div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden mx-4 h-[600px]">
      
      <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-12 relative">
        
        <div class="mb-8 text-center md:text-left">
          <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
            DORMFINDER
          </h1>
          <p class="text-gray-500 mt-2 text-sm">ยินดีต้อนรับเข้าสู่ระบบค้นหาหอพัก</p>
        </div>

        <form @submit.prevent="login" class="space-y-5">
          
          <div>
            <label class="block text-gray-700 text-sm font-semibold mb-2 ml-1">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
              </div>
              <input
                v-model="email"
                type="email"
                placeholder="example@mail.com"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                required
              />
            </div>
          </div>

          <div>
            <label class="block text-gray-700 text-sm font-semibold mb-2 ml-1">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
              </div>
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                placeholder="••••••••"
                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
                required
              />
              <button
                type="button"
                class="absolute right-3 top-3 text-gray-400 hover:text-blue-600 transition"
                @click="showPassword = !showPassword"
              >
                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-5.943 4.641" /></svg>
              </button>
            </div>
          </div>

          <button
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-blue-500/40 hover:scale-[1.02] transition-all duration-300 transform"
          >
            เข้าสู่ระบบ
          </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-600">
          ยังไม่มีบัญชีใช่ไหม?
          <router-link to="/register" class="text-blue-600 font-bold hover:underline ml-1">
            สมัครสมาชิกใหม่
          </router-link>
        </div>
      </div>

      <div class="hidden md:flex w-1/2 relative bg-gray-900">
        <div 
          class="absolute inset-0 bg-cover bg-center opacity-60"
          style="background-image:url('/img/auth-login.jpg')"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/80 to-purple-800/80 mix-blend-multiply"></div>
        
        <div class="relative z-10 flex flex-col justify-center items-center text-white p-10 text-center">
          <h2 class="text-4xl font-bold mb-4 drop-shadow-md">Welcome Back!</h2>
          <p class="text-lg opacity-90 max-w-sm drop-shadow">
            "ค้นหาพื้นที่ที่ใช่ ในสไตล์ที่เป็นคุณ กับระบบค้นหาหอพักที่ดีที่สุด"
          </p>
        </div>
      </div>
    </div>

    <transition
      enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
        <div v-if="toast.show" class="fixed bottom-6 right-6 flex items-center bg-red-50 text-red-700 px-6 py-4 rounded-lg shadow-xl border-l-4 border-red-500 z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="font-medium">{{ toast.message }}</span>
        </div>
    </transition>

  </div>
</template>

<script setup>
import { ref } from 'vue';

import axios from 'axios';
import { useRouter } from 'vue-router';

// State Variables
const email = ref('');
const password = ref('');
const showPassword = ref(false);
const router = useRouter();
const toast = ref({ show: false, message: '' });

// Toast Helper
const showToast = (msg) => {
  toast.value.message = msg;
  toast.value.show = true;
  setTimeout(() => (toast.value.show = false), 3000);
};

// Login Function
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
    showToast(err.response?.data?.message || 'Login failed. Please check your credentials.');
  }
};
</script>