<template>
  <DashboardLayout>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">
        Dorms
        <span class="text-gray-600 text-lg ml-2">(Total: {{ dorms.length }})</span>
      </h1>

      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow" @click="openCreateModal">
        + Add Dorm
      </button>
    </div>

    

    <!-- Table -->
    <div class="overflow-x-auto rounded shadow bg-white">
      <table class="min-w-full table-auto text-left">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="p-3 font-medium">Name</th>
            <th class="p-3 font-medium">Province</th>
            <th class="p-3 font-medium">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="d in dorms" :key="d.id" class="border-b hover:bg-gray-50">
            <td class="p-3">{{ d.name }}</td>
            <td class="p-3">{{ d.province }}</td>

            <td class="p-3 flex gap-2">
              <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700" @click="viewDorm(d.id)">
                View
              </button>

              <button class="px-3 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500" @click="openEditModal(d)">
                Edit
              </button>

              <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700" @click="deleteDorm(d.id)">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="dorms.length === 0" class="p-4 text-center text-gray-500">
        No dorms found.
      </div>
    </div>

    <!-- MODAL -->
    <DormFormModal v-if="showModal" :mode="modalMode" :dormData="selectedDorm" @close="closeModal"
      @submit="submitDorm" />

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
  router.push(`/admin/dorms/${dorm.id}/edit`);
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
