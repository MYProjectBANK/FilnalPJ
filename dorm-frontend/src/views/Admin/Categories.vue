<template>
    <DashboardLayout>
        <div class="p-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">
                    Category
                    <span class="text-gray-600 text-lg ml-2">(Total: {{ categories.length }})</span>
                </h1>

                <button @click="openCreate" class="px-4 py-2 bg-blue-600 text-white rounded mb-4">
                    + Add Category
                </button>
            </div>

            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3">Name</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="c in categories" :key="c.id" class="border-b">
                        <td class="p-3">{{ c.name }}</td>
                        <td class="p-3 text-right space-x-2">

                            <button @click="edit(c)" class="px-3 py-1 bg-yellow-400 rounded">Edit</button>

                            <button @click="remove(c.id)"
                                class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="categories.length === 0" class="text-center py-5 text-gray-500">
                No categories found.
            </div>

            <!-- Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded shadow w-96">
                    <h2 class="text-xl font-bold mb-3">{{ mode === 'create' ? 'Add' : 'Edit' }} Category</h2>

                    <input v-model="form.name" class="border p-2 rounded w-full" placeholder="Category name">

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

const categories = ref([]);
const showModal = ref(false);
const mode = ref("create");
const form = ref({ id: null, name: "" });

const token = localStorage.getItem("token");
const config = {
    headers: { Authorization: `Bearer ${token}` }
};

const fetchCategories = async () => {
    const res = await axios.get("http://127.0.0.1:8000/api/admin/categories", config);
    categories.value = res.data.data;
};

const openCreate = () => {
    mode.value = "create";
    form.value = { id: null, name: "" };
    showModal.value = true;
};

const edit = (c) => {
    mode.value = "edit";
    form.value = { id: c.id, name: c.name };
    showModal.value = true;
};

const save = async () => {
    if (mode.value === "create") {
        await axios.post("http://127.0.0.1:8000/api/admin/categories", form.value, config);
    } else {
        await axios.put(`http://127.0.0.1:8000/api/admin/categories/${form.value.id}`, form.value, config);
    }

    showModal.value = false;
    fetchCategories();
};

const remove = async (id) => {
    if (confirm("Delete this category?")) {
        await axios.delete(`http://127.0.0.1:8000/api/admin/categories/${id}`, config);
        fetchCategories();
    }
};

onMounted(fetchCategories);
</script>
