<template>
  <DashboardLayout>
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Dormitory Management</h1>
        <p class="mt-2 text-sm text-gray-600">
          จัดการข้อมูลหอพักทั้งหมด (Total: <span class="font-semibold text-indigo-600">{{ dorms.length }}</span> Places)
        </p>
      </div>
      <div class="mt-4 sm:mt-0">
        <button 
          @click="openCreateModal"
          class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Add New Dorm
        </button>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Dorm Info
              </th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Location
              </th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="d in dorms" :key="d.id" class="hover:bg-gray-50 transition-colors">
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ d.name }}</div>
                    <div class="text-xs text-gray-500">ID: {{ d.id }}</div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-800 border border-blue-100">
                  {{ d.province }}
                </span>
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end space-x-2">
                  
                  <button 
                    @click="viewDorm(d.id)" 
                    class="text-gray-400 hover:text-indigo-600 p-1 rounded-md hover:bg-indigo-50 transition-colors tooltip"
                    title="View Details"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>

                  <button 
                    @click="openEditModal(d)" 
                    class="text-gray-400 hover:text-amber-600 p-1 rounded-md hover:bg-amber-50 transition-colors"
                    title="Edit"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <button 
                    @click="deleteDorm(d.id)" 
                    class="text-gray-400 hover:text-red-600 p-1 rounded-md hover:bg-red-50 transition-colors"
                    title="Delete"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>

                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="dorms.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No dorms found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new dormitory.</p>
        <div class="mt-6">
          <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Add Dorm
          </button>
        </div>
      </div>
    </div>

<DormFormModal 
      v-if="showModal" 
      :show="showModal" 
      :mode="modalMode" 
      :dormData="selectedDorm" 
      @close="closeModal"
      @submit="submitDorm" 
    />

  </DashboardLayout>
</template>

<script>
import {
  onMounted,
  ref,
} from 'vue';

import axios from 'axios';
import { useRouter } from 'vue-router';

import DashboardLayout from '../../components/Admin/DashboardLayout.vue';
import DormFormModal from '../../components/Admin/DormFormModal.vue';

export default {
  components: { DashboardLayout, DormFormModal },

  setup() {
    const router = useRouter();
    const dorms = ref([]);

    const showModal = ref(false);
    const modalMode = ref("create");
    const selectedDorm = ref(null);

    // Fetch all dorms
    const fetchDorms = async () => {
      const res = await axios.get("http://127.0.0.1:8000/api/admin/dorms", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });

      dorms.value = res.data;
    };

    // Open Create Modal
    const openCreateModal = () => {
      modalMode.value = "create";
      selectedDorm.value = null;
      showModal.value = true;
    };

    // Open Edit Modal
    const openEditModal = (dorm) => {
      // Logic เดิม: redirect ไปหน้า edit
      router.push(`/admin/dorms/${dorm.id}/edit`);
      // หมายเหตุ: ถ้าต้องการใช้ Modal แทน Redirect ให้คอมเมนต์บรรทัดบน แล้วใช้โค้ดด้านล่างแทน:
      // modalMode.value = "edit";
      // selectedDorm.value = dorm;
      // showModal.value = true;
    };


    // Close Modal
    const closeModal = () => {
      showModal.value = false;
    };

    // Submit Form
    const submitDorm = async (form) => {
      const token = localStorage.getItem("token");

      const fd = new FormData();

      // ใส่ข้อมูลฟอร์มทั้งหมด
      Object.keys(form).forEach(key => {
        if (key === "images") return;

        if (Array.isArray(form[key])) {
          form[key].forEach(v => fd.append(`${key}[]`, v));
        } else {
          fd.append(key, form[key] ?? "");
        }
      });

      // files
      if (form.images && form.images.length > 0) {
        form.images.forEach(file => {
          fd.append("images[]", file);
        });
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "multipart/form-data"
        }
      };

      if (modalMode.value === "create") {
        await axios.post("http://127.0.0.1:8000/api/admin/dorms", fd, config);
      } else {
        await axios.post(
          `http://127.0.0.1:8000/api/admin/dorms/${selectedDorm.value.id}?_method=PUT`,
          fd,
          config
        );
      }

      showModal.value = false;
      fetchDorms();
    };

    // Delete dorm
    const deleteDorm = async (id) => {
      if (!confirm(`ต้องการลบหอพัก ID ${id} จริงหรือไม่?`)) return;

      await axios.delete(`http://127.0.0.1:8000/api/admin/dorms/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });

      fetchDorms();
    };

    const viewDorm = (id) => {
      router.push(`/admin/dorms/${id}`);
    };

    onMounted(fetchDorms);

    return {
      dorms,
      showModal,
      modalMode,
      selectedDorm,
      openCreateModal,
      openEditModal,
      closeModal,
      submitDorm,
      deleteDorm,
      viewDorm,
    };

  },
};
</script>