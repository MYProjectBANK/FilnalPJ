<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 font-sans py-10 px-4">

    <div class="flex w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden">

      <div class="hidden md:flex w-5/12 relative bg-gray-900">
        <div class="absolute inset-0 bg-cover bg-center opacity-60"
          style="background-image:url('/img/auth-register.jpg')"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/90 to-teal-800/90 mix-blend-multiply"></div>

        <div class="relative z-10 flex flex-col justify-center items-center text-white p-10 text-center h-full">
          <h2 class="text-3xl font-bold mb-4 drop-shadow-md">Join Us Today!</h2>
          <p class="text-sm opacity-90 drop-shadow leading-relaxed">
            เริ่มต้นประสบการณ์ใหม่ในการค้นหาหอพักที่ตอบโจทย์ไลฟ์สไตล์ของคุณ สมัครเลย ง่ายนิดเดียว
          </p>
        </div>
      </div>

      <div class="w-full md:w-7/12 flex flex-col justify-center p-8 md:p-12 bg-white">

        <div class="text-center md:text-left mb-8">
          <h1
            class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">
            Create Account
          </h1>
          <p class="text-gray-500 mt-1 text-sm">กรอกข้อมูลด้านล่างเพื่อสมัครสมาชิก</p>
        </div>

        <form @submit.prevent="register" class="space-y-4">

          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <input v-model="fullname" placeholder="ชื่อ - นามสกุล"
              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all"
              required />
          </div>

          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <input v-model="email" type="email" placeholder="อีเมล (Email)"
              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all"
              required />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="รหัสผ่าน"
                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                required />
              <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-emerald-600"
                @click="showPassword = !showPassword">
                <svg v-if="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-5.943 4.641" />
                </svg>
              </button>
            </div>

            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <input v-model="password_confirmation" type="password" placeholder="ยืนยันรหัสผ่าน"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                required />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <input v-model="phone" placeholder="เบอร์โทรศัพท์"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all" />
            </div>

            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path d="M12 14l9-5-9-5-9 5 9 5z" />
                  <path
                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
              </div>
              <input v-model.number="year_level" type="number" min="1" max="4" placeholder="ชั้นปี (1-4)"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all" />
            </div>
          </div>

          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <select v-model="faculty"
              class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none appearance-none bg-white transition-all text-gray-700">
              <option value="" disabled selected>เลือกคณะ/สาขา</option>
              <option value="">— ไม่ระบุ —</option>
              <option>สาขาวิชาวิศวกรรมไฟฟ้า</option>
              <option>สาขาวิชาวิศวกรรมเครื่องกล</option>
              <option>สาขาวิชาวิศวกรรมอุตสาหการ</option>
              <option>สาขาวิชาวิศวกรรมคอมพิวเตอร์</option>
              <option>สาขาวิชาวิศวกรรมเมคคาทรอนิกส์</option>
              <option>สาขาวิชาวิศวกรรมไฟฟ้าสื่อสารและระบบอัจฉริยะ</option>
              <option>สาขาวิชาวิศวกรรมโยธา</option>
              <option>สาขาวิชาวิศวกรรมเครื่องมือและแม่พิมพ์</option>
              <option>สาขาวิชาวิศวกรรมการผลิตเครื่องประดับ</option>
              <option>สาขาวิชาวิศวกรรมเทคโนโลยีนวัตกรรมเพื่อความยั่งยืน(ต่อเนื่อง)</option>
              <option>สาขาวิชาอัญมณีรังสรรค์</option>
              <option>สาขาวิชาวิทยาการคอมพิวเตอร์</option>
              <option>สาขาวิชาวิทยาศาสตร์และเทคโนโลยีสิ่งแวดล้อม</option>
              <option>สาขาวิชาวัสดุศาสตร์อุตสาหกรรม</option>
              <option>สาขาวิชาวิทยาการข้อมูลและเทคโนโลยีสารสนเทศ</option>
              <option>สาขาวิชาเทคโนโลยีสุขภาพ เครื่องสำอาง และการชะลอวัย</option>
              <option>สาขาวิชาสถิติสารสนเทศ</option>
              <option>สาขาวิชาการจัดการสภาพภูมิอากาศและสิ่งแวดล้อม</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>

          <button
            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-3 rounded-xl font-bold shadow-lg hover:shadow-emerald-500/40 hover:scale-[1.02] transition-all duration-300 transform mt-4">
            ลงทะเบียน (Register)
          </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-6">
          มีบัญชีอยู่แล้ว?
          <router-link to="/login" class="text-emerald-600 font-bold hover:underline ml-1">
            เข้าสู่ระบบ
          </router-link>
        </p>
      </div>
    </div>

    <transition enter-active-class="transform ease-out duration-300 transition"
      enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
      enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="toast.show"
        class="fixed bottom-6 right-6 flex items-center bg-red-50 text-red-700 px-6 py-4 rounded-lg shadow-xl border-l-4 border-red-500 z-50">
        <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
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

// Helper Functions
const showToast = (msg) => {
  toast.value.message = msg;
  toast.value.show = true;
  setTimeout(() => (toast.value.show = false), 3000);
};

// Main Logic
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