<template>
    <DashboardLayout>
        <div class="p-6 max-w-7xl mx-auto">

            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">จัดการเส้นทางรถไฟฟ้า</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        ข้อมูลรถไฟฟ้าและสถานีใกล้เคียง (Total: <span class="font-semibold text-rose-600">{{ list.length }}</span> stations)
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button @click="openCreate"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        เพิ่มสถานีรถไฟฟ้า
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                
                <div v-if="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-rose-600 mx-auto mb-4"></div>
                    <p class="text-gray-500 font-medium">กำลังโหลดข้อมูลสถานี...</p>
                </div>

                <div v-else-if="list.length === 0" class="text-center py-16">
                    <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4 text-rose-300 border border-rose-100">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">ยังไม่มีข้อมูลสถานีรถไฟฟ้า</h3>
                    <p class="text-gray-500 mt-1">เพิ่มข้อมูลเพื่อให้ผู้พักคำนวณการเดินทางได้ง่ายขึ้น</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    สายรถไฟฟ้า
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    ชื่อสถานี
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">
                                    จัดการ
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="t in list" :key="t.id" class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-4 font-bold text-gray-900">
                                            {{ t.line_name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                        {{ t.station_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="edit(t)" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="แก้ไข">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="remove(t.id)" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="ลบ">
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
                        <h3 class="text-lg font-bold text-gray-800 leading-none">
                            {{ mode === 'create' ? '🚆 เพิ่มข้อมูลรถไฟฟ้า' : '✏️ แก้ไขข้อมูลรถไฟฟ้า' }}
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อสายรถไฟฟ้า <span class="text-red-500">*</span></label>
                            <input v-model="form.line_name" 
                                type="text" 
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-100 focus:border-rose-500 outline-none transition-all"
                                placeholder="เช่น สายสีเขียว, MRT, BTS..."
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อสถานี <span class="text-red-500">*</span></label>
                            <input v-model="form.station_name" 
                                type="text" 
                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-100 focus:border-rose-500 outline-none transition-all"
                                placeholder="เช่น พญาไท, สยาม..."
                                @keyup.enter="save"
                            >
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="showModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                            ยกเลิก
                        </button>
                        <button @click="save" class="px-4 py-2 text-sm font-medium text-white bg-rose-600 rounded-lg hover:bg-rose-700 shadow-md transition-all">
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

const list = ref([]);
const showModal = ref(false);
const mode = ref("create");
const loading = ref(true);

const form = ref({
    id: null,
    line_name: "",
    station_name: ""
});

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchList = async () => {
    loading.value = true;
    try {
        const res = await axios.get("http://127.0.0.1:8000/api/admin/train-lines", config);
        list.value = res.data.data ?? res.data;
    } catch (error) {
        console.error("Error fetching train lines:", error);
    } finally {
        loading.value = false;
    }
};

const openCreate = () => {
    mode.value = "create";
    form.value = { id: null, line_name: "", station_name: "" };
    showModal.value = true;
};

const edit = (t) => {
    mode.value = "edit";
    form.value = {
        id: t.id,
        line_name: t.line_name,
        station_name: t.station_name
    };
    showModal.value = true;
};

const save = async () => {
    if (!form.value.line_name.trim() || !form.value.station_name.trim()) {
        return alert("กรุณาระบุข้อมูลให้ครบถ้วน");
    }

    try {
        if (mode.value === "create") {
            await axios.post("http://127.0.0.1:8000/api/admin/train-lines", {
                line_name: form.value.line_name,
                station_name: form.value.station_name
            }, config);
        } else {
            await axios.put(`http://127.0.0.1:8000/api/admin/train-lines/${form.value.id}`, {
                line_name: form.value.line_name,
                station_name: form.value.station_name
            }, config);
        }
        showModal.value = false;
        fetchList();
    } catch (error) {
        alert("ไม่สามารถบันทึกข้อมูลได้");
    }
};

const remove = async (id) => {
    if (confirm("ยืนยันการลบสถานีรถไฟฟ้า? ข้อมูลการเดินทางที่เกี่ยวข้องจะถูกลบออกด้วย")) {
        try {
            await axios.delete(`http://127.0.0.1:8000/api/admin/train-lines/${id}`, config);
            fetchList();
        } catch (error) {
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