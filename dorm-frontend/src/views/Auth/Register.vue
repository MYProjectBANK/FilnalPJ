<template>
  <div class="flex min-h-screen">
    <!-- Left Side: Image -->
    <div class="flex-1 hidden md:flex items-center justify-center bg-green-100">
      <!-- <img src="/register-illustration.svg" alt="Register Illustration" class="max-w-sm" /> -->
    </div>

    <!-- Right Side: Register Form -->
    <div class="flex-1 flex items-center justify-center bg-gray-50 ">
      <div class="w-full max-w-md p-8 bg-white rounded shadow space-y-6">
        <h1 class="text-3xl font-bold text-center">Create Account</h1>
        <p class="text-center text-gray-500">Sign up for a new account</p>

        <form @submit.prevent="register" class="space-y-4">
          <input v-model="fullname" type="text" placeholder="Full Name" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required />
          <input v-model="email" type="email" placeholder="Email" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required />
          <input v-model="password" type="password" placeholder="Password" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required />
          <input v-model="password_confirmation" type="password" placeholder="Confirm Password" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required />
          <input v-model="phone" type="text" placeholder="Phone" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" />

          <!-- Year Level: input number 1-4 -->
          <input 
            v-model.number="year_level"
            type="number"
            placeholder="Year Level (1-4)"
            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
            min="1"
            max="4"
            required
          />

          <!-- Faculty: hardcoded enum -->
          <select v-model="faculty" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
            <option value="" disabled selected>Select Faculty</option>
            <option value="Engineering">Engineering</option>
            <option value="IT">IT</option>
            <option value="Science">Science</option>
            <option value="Humanities">Humanities</option>
          </select>

          <button type="submit" class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">
            Register
          </button>
        </form>

        <p class="text-center text-gray-600">
          Already have an account?
          <router-link to="/login" class="text-green-600 font-semibold hover:underline">Login</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const fullname = ref('');
    const email = ref('');
    const password = ref('');
    const password_confirmation = ref('');
    const phone = ref('');
    const year_level = ref(null);
    const faculty = ref('');
    const router = useRouter();

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

        alert('Registration successful! Please login.');
        router.push('/login');
      } catch (err) {
        alert(err.response?.data?.message || 'Registration failed');
      }
    };

    return {
      fullname, email, password, password_confirmation,
      phone, year_level, faculty,
      register
    };
  }
};
</script>
