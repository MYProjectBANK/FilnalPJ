<template>
    <DashboardLayout>
        <div class="p-6 max-w-7xl mx-auto">

            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">จัดการเส้นทางรถเมล์</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        ข้อมูลเลขสายและเส้นทางรถเมล์ผ่านหอพัก (Total: <span class="font-semibold text-amber-600">{{ list.length }}</span> routes)
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button @click="openCreate"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        เพิ่มสายรถเมล์
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                
                <div v-if="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-amber-500 mx-auto mb-4"></div>
                    <p class="text-gray-500 font-medium">กำลังโหลดข้อมูล...</p>
                </div>

                <div v-else-if="list.length === 0" class="text-center py-16">
                    <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 text-amber-300">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">ยังไม่มีข้อมูลสายรถเมล์</h3>
                    <p class="text-gray-500 mt-1">เพิ่มข้อมูลรถเมล์เพื่อช่วยให้ผู้พักตัดสินใจเลือกหอพักได้ง่ายขึ้น</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    เลขสาย
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    เส้นทาง / รายละเอียด
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    จัดการ
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="b in list" :key="b.id" class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <span class="text-sm font-black text-gray-900  px-3 py-1 ">
                                                สาย {{ b.route_number }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 leading-relaxed max-w-md truncate md:whitespace-normal">
                                        {{ b.route_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="edit(b)" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="แก้ไข">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="remove(b.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="ลบ">
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

                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all relative z-10 animate-fade-in-up">
                    
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">
                            {{ mode === 'create' ? '🚌 เพิ่มสายรถเมล์' : '✏️ แก้ไขข้อมูล' }}
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">เลขสายรถเมล์ <span class="text-red-500">*</span></label>
                            <input v-model="form.route_number" 
                                type="text" 
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-100 focus:border-amber-400 outline-none transition-all"
                                placeholder="เช่น 140, 511, ปอ.8..."
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">เส้นทาง / รายละเอียดเพิ่มเติม</label>
                            <textarea v-model="form.route_name" 
                                rows="3"
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-100 focus:border-amber-400 outline-none transition-all resize-none"
                                placeholder="เช่น เคหะธนบุรี - อนุสาวรีย์ชัยฯ"
                                @keyup.enter.ctrl="save"
                            ></textarea>
                            <p class="text-[10px] text-gray-400 mt-1">กด Ctrl + Enter เพื่อบันทึกด่วน</p>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                            ยกเลิก
                        </button>
                        <button @click="save" class="px-4 py-2 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 shadow-md transition-all">
                            {{ mode === 'create' ? 'เพิ่มข้อมูล' : 'บันทึกการแก้ไข' }}
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

const list = ref([]);
const showModal = ref(false);
const mode = ref("create");
const loading = ref(true);

const form = ref({
    id: null,
    route_number: "",
    route_name: ""
});

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchList = async () => {
    loading.value = true;
    try {
        const res = await axios.get("/api/admin/bus-routes", config);
        list.value = res.data.data ?? res.data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
};

const openCreate = () => {
    mode.value = "create";
    form.value = { id: null, route_number: "", route_name: "" };
    showModal.value = true;
};

const edit = (b) => {
    mode.value = "edit";
    form.value = { id: b.id, route_number: b.route_number, route_name: b.route_name };
    showModal.value = true;
};

const save = async () => {
    if (!form.value.route_number.trim()) return alert("กรุณาระบุเลขสายรถเมล์");

    try {
        const payload = {
            route_number: form.value.route_number,
            route_name: form.value.route_name
        };

        if (mode.value === "create") {
            await axios.post("/api/admin/bus-routes", payload, config);
        } else {
            await axios.put(`/api/admin/bus-routes/${form.value.id}`, payload, config);
        }
        showModal.value = false;
        fetchList();
    } catch (e) {
        alert("ไม่สามารถบันทึกข้อมูลได้");
    }
};

const remove = async (id) => {
    if (confirm("คุณต้องการลบสายรถเมล์นี้ใช่หรือไม่?")) {
        try {
            await axios.delete(`/api/admin/bus-routes/${id}`, config);
            fetchList();
        } catch (e) {
            alert("ไม่สามารถลบข้อมูลได้");
        }
    }
};

onMounted(fetchList);
</script>

<style scoped>
    @reference "tailwindcss";

@keyframes fadeInUp {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.25s ease-out forwards;
}
</style>