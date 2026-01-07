<template>
    <DashboardLayout>
        <div class="p-6 max-w-5xl mx-auto">

            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        จัดการรีวิวที่รออนุมัติ
                        <span v-if="reviews.length > 0" class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full border border-amber-200 animate-pulse">
                            มีรายการค้าง
                        </span>
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        ตรวจสอบและอนุมัติความคิดเห็นจากผู้ใช้งาน (Total: <span class="font-semibold text-indigo-600">{{ reviews.length }}</span> items)
                    </p>
                </div>
            </div>

            <div v-if="loading" class="space-y-4">
                <div v-for="i in 3" :key="i" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm animate-pulse">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                        <div class="space-y-2 flex-1">
                            <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                            <div class="h-3 bg-gray-100 rounded w-1/2"></div>
                        </div>
                    </div>
                    <div class="h-20 bg-gray-50 rounded-xl"></div>
                </div>
            </div>

            <div v-else class="space-y-6">
                <div v-for="r in reviews" :key="r.id" 
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md animate-fade-in-up">
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                    {{ r.user?.fullname?.charAt(0) || 'U' }}
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-900 leading-none mb-1">
                                        {{ r.user?.fullname ?? "ไม่ทราบชื่อผู้ใช้" }}
                                    </h2>
                                    <p class="text-xs text-gray-500">
                                        รีวิวหอพัก: <span class="text-indigo-600 font-semibold underline">{{ r.dorm?.name ?? "ไม่ทราบชื่อหอพัก" }}</span>
                                    </p>
                                </div>
                            </div>
                            <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded border">
                                Pending
                            </span>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                            <p class="text-gray-700 text-sm leading-relaxed italic whitespace-pre-line">
                                "{{ r.comment }}"
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-gray-50 pt-4">
                            <div class="flex items-center text-gray-400 text-xs">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                ส่งเมื่อ: {{ new Date(r.created_at).toLocaleString('th-TH') }}
                            </div>

                            <div class="flex items-center gap-2">
                                <button @click="reject(r.id)" 
                                    class="flex-1 sm:flex-none px-4 py-2 text-sm font-semibold text-rose-600 bg-white border border-rose-200 rounded-lg hover:bg-rose-50 transition-colors">
                                    ปฏิเสธ (Reject)
                                </button>
                                <button @click="approve(r.id)" 
                                    class="flex-1 sm:flex-none px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm hover:shadow-emerald-200 transition-all">
                                    อนุมัติรีวิว
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="reviews.length === 0" class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <h3 class="text-xl font-bold text-gray-900">ไม่มีรีวิวค้างตรวจสอบ</h3>
                    <p class="text-gray-500 mt-2">คุณจัดการรีวิวทั้งหมดในระบบเรียบร้อยแล้ว</p>
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

const reviews = ref([]);
const loading = ref(true);

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchReviews = async () => {
    loading.value = true;
    try {
        const res = await axios.get("/api/admin/reviews/pending", config);
        reviews.value = res.data.data ?? res.data;
    } catch (e) {
        console.error("Fetch reviews error:", e);
    } finally {
        loading.value = false;
    }
};

const approve = async (id) => {
    if (!confirm("ต้องการอนุมัติรีวิวนี้ให้แสดงผลบนหน้าเว็บไซต์ใช่หรือไม่?")) return;
    try {
        await axios.put(`/api/admin/reviews/${id}/approve`, {}, config);
        fetchReviews();
    } catch (e) {
        alert("ไม่สามารถอนุมัติได้");
    }
};

const reject = async (id) => {
    if (!confirm("ยืนยันการปฏิเสธรีวิวนี้? ข้อมูลจะถูกเก็บไว้ในระบบแต่ไม่แสดงผลต่อสาธารณะ")) return;
    try {
        await axios.put(`/api/admin/reviews/${id}/reject`, {}, config);
        fetchReviews();
    } catch (e) {
        alert("ไม่สามารถปฏิเสธได้");
    }
};

onMounted(fetchReviews);
</script>

<style scoped>
    @reference "tailwindcss";

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.3s ease-out forwards;
}
</style>