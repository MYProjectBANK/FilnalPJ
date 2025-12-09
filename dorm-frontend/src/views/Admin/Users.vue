<template>
    <DashboardLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Users</h1>

            <button @click="openCreate" class="px-4 py-2 bg-blue-600 text-white rounded mb-4">
                + Add User
            </button>

            <table class="w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3">Full Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="u in users" :key="u.id" class="border-b">
                        <td class="p-3">{{ u.fullname }}</td>
                        <td class="p-3">{{ u.email }}</td>
                        <td class="p-3">{{ u.role }}</td>

                        <td class="p-3 text-right space-x-2">
                            <button @click="edit(u)" class="px-3 py-1 bg-yellow-400 rounded">Edit</button>
                            <button @click="remove(u.id)" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-white p-6 rounded shadow w-96">
                    <h2 class="text-xl font-bold mb-3">
                        {{ mode === 'create' ? 'Add' : 'Edit' }} User
                    </h2>

                    <input v-model="form.fullname" class="border p-2 rounded w-full mb-2" placeholder="Full Name" />
                    <input v-model="form.email" class="border p-2 rounded w-full mb-2" placeholder="Email" />
                    <input v-model="form.phone" class="border p-2 rounded w-full mb-2" placeholder="Phone" />
                    <input v-model="form.year_level" class="border p-2 rounded w-full mb-2" placeholder="Year Level" />
                    <input v-model="form.faculty" class="border p-2 rounded w-full mb-2" placeholder="Faculty" />

                    <input
                        v-model="form.password"
                        type="password"
                        class="border p-2 rounded w-full mb-2"
                        placeholder="Password (fill only if change)"
                    />

                    <select v-model="form.role" class="border p-2 rounded w-full mb-2">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>

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

const users = ref([]);
const showModal = ref(false);
const mode = ref("create");

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
    const res = await axios.get("http://127.0.0.1:8000/api/admin/users", config);
    users.value = res.data.data;
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
    if (mode.value === "create") {
        await axios.post("http://127.0.0.1:8000/api/admin/users", form.value, config);
    } else {
        await axios.put(`http://127.0.0.1:8000/api/admin/users/${form.value.id}`, form.value, config);
    }
    showModal.value = false;
    fetchUsers();
};

const remove = async (id) => {
    if (confirm("Delete this user?")) {
        await axios.delete(`http://127.0.0.1:8000/api/admin/users/${id}`, config);
        fetchUsers();
    }
};

onMounted(fetchUsers);
</script>
