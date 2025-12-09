<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Train Lines</h1>

            <button @click="openCreate" class="px-4 py-2 bg-blue-600 text-white rounded mb-4">
                + Add Train Line
            </button>

            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3">Train Line</th>
                        <th class="p-3">Station</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="t in list" :key="t.id" class="border-b">
                        <td class="p-3">{{ t.line_name }}</td>
                        <td class="p-3">{{ t.station_name }}</td>

                        <td class="p-3 text-right space-x-2">
                            <button @click="edit(t)" class="px-3 py-1 bg-yellow-400 rounded">Edit</button>

                            <button @click="remove(t.id)" class="px-3 py-1 bg-red-600 text-white rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- MODAL -->
            <div v-if="showModal"
                 class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded shadow w-96">
                    <h2 class="text-xl font-bold mb-3">
                        {{ mode === 'create' ? 'Add' : 'Edit' }} Train Line
                    </h2>

                    <input v-model="form.line_name" class="border p-2 rounded w-full" placeholder="Line name">
                    <input v-model="form.station_name" class="border p-2 rounded w-full mt-2" placeholder="Station name">

                    <button @click="save" class="w-full bg-blue-600 text-white py-2 rounded mt-3">
                        Save
                    </button>

                    <button @click="showModal = false" class="w-full mt-2 bg-gray-300 py-2 rounded">
                        Cancel
                    </button>
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

const form = ref({
    id: null,
    line_name: "",
    station_name: ""
});

const token = localStorage.getItem("token");
const config = { headers: { Authorization: `Bearer ${token}` } };

const fetchList = async () => {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/train-lines", config);
    list.value = res.data.data ?? res.data;
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
};

const remove = async (id) => {
    if (confirm("Delete this train line?")) {
        await axios.delete(`http://127.0.0.1:8000/api/admin/train-lines/${id}`, config);
        fetchList();
    }
};

onMounted(fetchList);
</script>
