<template>
    <DashboardLayout>
        <div class="p-6 max-w-7xl mx-auto">

            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">จัดการสิ่งอำนวยความสะดวก</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        รายการสิ่งอำนวยความสะดวกภายในหอพัก (Total: <span class="font-semibold text-indigo-600">{{ amenities.length }}</span> items)
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button @click="openCreate"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        เพิ่มสิ่งอำนวยความสะดวก
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                
                <div v-if="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                    <p class="text-gray-500">กำลังโหลดข้อมูล...</p>
                </div>

                <div v-else-if="amenities.length === 0" class="text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">ไม่พบข้อมูลสิ่งอำนวยความสะดวก</h3>
                    <p class="text-gray-500 mt-1">กดปุ่มด้านบนเพื่อเพิ่มข้อมูลใหม่</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    ชื่อรายการ
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    จัดการ
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="a in amenities" :key="a.id" class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                    
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ a.name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ a.id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="edit(a)" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="แก้ไข">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="remove(a.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="ลบ">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all scale-100 relative z-10 animate-fade-in-up">
                    
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ mode === 'create' ? 'เพิ่มสิ่งอำนวยความสะดวก' : 'แก้ไขข้อมูล' }}
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อรายการ <span class="text-red-500">*</span></label>
                        <input v-model="form.name" 
                            type="text" 
                            class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition-all"
                            placeholder="เช่น เครื่องปรับอากาศ, เครื่องทำน้ำอุ่น..."
                            @keyup.enter="save"
                        >
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                        <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            ยกเลิก
                        </button>
                        <button @click="save" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">
                            {{ mode === 'create' ? 'บันทึกข้อมูล' : 'บันทึกการเปลี่ยนแปลง' }}
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

const amenities = ref([]);
const showModal = ref(false);
const mode = ref("create");
const form = ref({ id: null, name: "" });
const loading = ref(true);

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchAmenities = async () => {
    loading.value = true;
    try {
        const res = await axios.get("http://127.0.0.1:8000/api/admin/amenities", config);
        amenities.value = res.data.data || res.data;
    } catch (error) {
        console.error("Error fetching amenities:", error);
    } finally {
        loading.value = false;
    }
};

const openCreate = () => {
    mode.value = "create";
    form.value = { id: null, name: "" };
    showModal.value = true;
};

const edit = (a) => {
    mode.value = "edit";
    form.value = { id: a.id, name: a.name };
    showModal.value = true;
};

const save = async () => {
    if (!form.value.name.trim()) return alert("กรุณาระบุชื่อรายการ");
    
    try {
        if (mode.value === "create") {
            await axios.post("http://127.0.0.1:8000/api/admin/amenities", form.value, config);
        } else {
            await axios.put(`http://127.0.0.1:8000/api/admin/amenities/${form.value.id}`, form.value, config);
        }
        showModal.value = false;
        fetchAmenities();
    } catch (error) {
        alert("ไม่สามารถบันทึกข้อมูลได้");
    }
};

const remove = async (id) => {
    if (confirm("ยืนยันการลบรายการนี้?")) {
        try {
            await axios.delete(`http://127.0.0.1:8000/api/admin/amenities/${id}`, config);
            fetchAmenities();
        } catch (error) {
            alert("ไม่สามารถลบข้อมูลได้");
        }
    }
};

onMounted(fetchAmenities);
</script>

<style scoped>
    @reference "tailwindcss";

@keyframes fadeInUp {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.2s ease-out forwards;
}
</style>