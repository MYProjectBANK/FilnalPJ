<template>
    <DashboardLayout>
        <div class="p-6 max-w-7xl mx-auto">

            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">จัดการผู้ใช้งาน (Users)</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        รายชื่อสมาชิกและผู้ดูแลระบบทั้งหมด (Total: <span class="font-semibold text-blue-600">{{
                            users.length }}</span> accounts)
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button @click="openCreate"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        เพิ่มผู้ใช้งานใหม่
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div v-if="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-4"></div>
                    <p class="text-gray-500 font-medium">กำลังโหลดข้อมูลผู้ใช้...</p>
                </div>

                <div v-else-if="users.length === 0" class="text-center py-16">
                    <div
                        class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">ไม่พบข้อมูลผู้ใช้งาน</h3>
                    <p class="text-gray-500 mt-1">ยังไม่มีบัญชีผู้ใช้งานในระบบในขณะนี้</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    ข้อมูลชื่อ-นามสกุล</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    การติดต่อ</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    สถานะ (Role)</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="u in users" :key="u.id" class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold border border-blue-200 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                            {{ u.fullname?.charAt(0) || 'U' }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ u.fullname }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ u.id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ u.email }}</div>
                                    <div class="text-xs text-gray-500">{{ u.phone || 'ไม่มีเบอร์โทร' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="u.role === 'admin'
                                        ? 'bg-indigo-100 text-indigo-700 border-indigo-200'
                                        : 'bg-slate-100 text-slate-600 border-slate-200'"
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border">
                                        {{ u.role === 'admin' ? 'ADMIN' : 'USER' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="edit(u)"
                                            class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                            title="แก้ไข">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="remove(u.id)"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="ลบ">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                    @click="showModal = false"></div>

                <div
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative z-10 animate-fade-in-up">

                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ mode === 'create' ? '👤 เพิ่มผู้ใช้งาน' : '✏️ แก้ไขข้อมูลผู้ใช้' }}
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto max-h-[70vh] custom-scrollbar">
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Account
                                    Information</h4>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="label">ชื่อ-นามสกุล <span class="text-red-500">*</span></label>
                                        <input v-model="form.fullname" type="text" class="input-field"
                                            placeholder="Full Name">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="label">อีเมล <span class="text-red-500">*</span></label>
                                            <input v-model="form.email" type="email" class="input-field"
                                                placeholder="Email Address">
                                        </div>
                                        <div>
                                            <label class="label">ระดับสิทธิ์ (Role)</label>
                                            <select v-model="form.role" class="input-field">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="label">รหัสผ่าน {{ mode === 'edit' ?
                                            '(เว้นว่างหากไม่ต้องการเปลี่ยน)' : '*' }}</label>
                                        <input v-model="form.password" type="password" class="input-field"
                                            placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Contact &
                                    Academic</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label class="label">เบอร์โทรศัพท์</label>
                                        <input v-model="form.phone" type="text" class="input-field"
                                            placeholder="0xx-xxx-xxxx">
                                    </div>
                                    <div>
                                        <label class="label">ชั้นปี</label>
                                        <input v-model="form.year_level" type="text" class="input-field"
                                            placeholder="Year 1, 2...">
                                    </div>
                                    <div>
                                        <label class="label">คณะ / สาขา</label>
                                        <input v-model="form.faculty" type="text" class="input-field"
                                            placeholder="Faculty name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="showModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">ยกเลิก</button>
                        <button @click="save"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition-all">
                            {{ mode === 'create' ? 'สร้างบัญชี' : 'บันทึกการแก้ไข' }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </DashboardLayout>
</template>

<script setup>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';

const users = ref([]);
const showModal = ref(false);
const mode = ref("create");
const loading = ref(true);

const form = ref({
    id: null,
    fullname: "",
    email: "",
    phone: "",
    year_level: "",
    faculty: "",
    password: "",
    role: "user"
});

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchUsers = async () => {
    loading.value = true;
    try {
        const res = await axios.get("http://127.0.0.1:8000/api/admin/users", config);
        users.value = res.data.data || res.data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
};

const openCreate = () => {
    mode.value = "create";
    form.value = { id: null, fullname: "", email: "", phone: "", year_level: "", faculty: "", password: "", role: "user" };
    showModal.value = true;
};

const edit = (u) => {
    mode.value = "edit";
    form.value = { ...u, password: "" };
    showModal.value = true;
};

const save = async () => {
    if (!form.value.fullname || !form.value.email) return alert("กรุณากรอกชื่อและอีเมล");

    try {
        if (mode.value === "create") {
            await axios.post("http://127.0.0.1:8000/api/admin/users", form.value, config);
        } else {
            await axios.put(`http://127.0.0.1:8000/api/admin/users/${form.value.id}`, form.value, config);
        }
        showModal.value = false;
        fetchUsers();
    } catch (e) {
        alert("ไม่สามารถบันทึกข้อมูลได้");
    }
};

const remove = async (id) => {
    if (confirm("คุณต้องการลบบัญชีผู้ใช้งานนี้ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนคืนได้")) {
        try {
            await axios.delete(`http://127.0.0.1:8000/api/admin/users/${id}`, config);
            fetchUsers();
        } catch (e) {
            alert("ไม่สามารถลบข้อมูลได้");
        }
    }
};

onMounted(fetchUsers);
</script>

<style scoped>
@reference "tailwindcss";

.label {
    @apply block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide;
}

.input-field {
    @apply w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-sm;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.2s ease-out forwards;
}
</style>