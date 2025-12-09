<template>
    <div 
        class="fixed inset-0 bg-black/40 flex justify-center items-center z-50" 
        @click.self="close"
    >
        <div class="bg-white p-6 rounded shadow-xl w-[700px] max-h-[90vh] overflow-y-auto">

            <h2 class="text-2xl font-bold mb-4">
                {{ mode === "create" ? "Add New Dorm" : "Edit Dorm" }}
            </h2>

            <!-- FORM -->
            <div class="space-y-4">

                <!-- NAME -->
                <div>
                    <label class="font-semibold">ชื่อหอพัก</label>
                    <input v-model="form.name" class="input" type="text" />
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label class="font-semibold">รายละเอียด</label>
                    <textarea v-model="form.description" class="input h-24"></textarea>
                </div>

                <!-- CONTACT -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold">เบอร์โทร</label>
                        <input v-model="form.phone" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">อีเมล</label>
                        <input v-model="form.email" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">Facebook</label>
                        <input v-model="form.facebook" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">Line ID</label>
                        <input v-model="form.line_id" class="input" />
                    </div>
                </div>

                <!-- ADDRESS -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold">จังหวัด</label>
                        <input v-model="form.province" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">อำเภอ/เขต</label>
                        <input v-model="form.district" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">ตำบล/แขวง</label>
                        <input v-model="form.subdistrict" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">ถนน</label>
                        <input v-model="form.street" class="input" />
                    </div>
                    <div>
                        <label class="font-semibold">รหัสไปรษณีย์</label>
                        <input v-model="form.zipcode" class="input" />
                    </div>
                </div>

                <!-- PRICE -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold">ราคาเริ่มต้น</label>
                        <input v-model="form.price_min" class="input" type="number" />
                    </div>
                    <div>
                        <label class="font-semibold">ราคาสูงสุด</label>
                        <input v-model="form.price_max" class="input" type="number" />
                    </div>

                    <div>
                        <label class="font-semibold">ค่ามัดจำ</label>
                        <input v-model="form.deposit_price" class="input" type="number" />
                    </div>

                    <div>
                        <label class="font-semibold">ค่าไฟ (บาท/ยูนิต)</label>
                        <input v-model="form.electricity_rate" class="input" type="number" step="0.1" />
                    </div>

                    <div>
                        <label class="font-semibold">ค่าน้ำ (บาท/หน่วย)</label>
                        <input v-model="form.water_rate" class="input" type="number" />
                    </div>

                    <div>
                        <label class="font-semibold">ค่าอินเทอร์เน็ต</label>
                        <input v-model="form.internet_fee" class="input" type="number" />
                    </div>
                </div>

                <!-- MAP -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-semibold">Latitude</label>
                        <input v-model="form.latitude" class="input" type="number" step="0.000001" />
                    </div>
                    <div>
                        <label class="font-semibold">Longitude</label>
                        <input v-model="form.longitude" class="input" type="number" step="0.000001" />
                    </div>
                </div>

                <!-- MULTI-RELATIONS -->
                <div>
                    <label class="font-semibold">หมวดหมู่</label>
                    <div class="flex flex-wrap gap-3 mt-1">
                        <div v-for="c in categories" :key="c.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="c.id" v-model="form.categories" />
                            <span>{{ c.name }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="font-semibold">สิ่งอำนวยความสะดวก</label>
                    <div class="flex flex-wrap gap-3 mt-1">
                        <div v-for="a in amenities" :key="a.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="a.id" v-model="form.amenities" />
                            <span>{{ a.name }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="font-semibold">โซน</label>
                    <div class="flex flex-wrap gap-3 mt-1">
                        <div v-for="z in zones" :key="z.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="z.id" v-model="form.zones" />
                            <span>{{ z.name }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="font-semibold">สายรถเมล์</label>
                    <div class="flex flex-wrap gap-3 mt-1">
                        <div v-for="b in busRoutes" :key="b.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="b.id" v-model="form.bus_routes" />
                            <span>{{ b.route_number }} - {{ b.route_name }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="font-semibold">สายรถไฟฟ้า</label>
                    <div class="flex flex-wrap gap-3 mt-1">
                        <div v-for="t in trainLines" :key="t.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="t.id" v-model="form.train_lines" />
                            <span>{{ t.line_name }} - {{ t.station_name }}</span>
                        </div>
                    </div>
                </div>

                <!-- IMAGES -->
                <div>
                    <label class="font-semibold">รูปภาพหอพัก (Upload)</label>
                    <input type="file" multiple @change="onImageUpload" class="mt-2" />
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="mt-6 flex justify-end gap-3">
                <button @click="close" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button @click="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                    {{ mode === "create" ? "Create" : "Save Changes" }}
                </button>
            </div>

        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ["mode", "show", "dormData"],
    emits: ["close", "submit"],

    data() {
        return {
            form: {
                name: "",
                description: "",
                province: "",
                district: "",
                subdistrict: "",
                street: "",
                zipcode: "",
                phone: "",
                email: "",
                facebook: "",
                line_id: "",
                price_min: "",
                price_max: "",
                deposit_price: "",
                electricity_rate: "",
                water_rate: "",
                internet_fee: "",
                latitude: "",
                longitude: "",

                categories: [],
                amenities: [],
                zones: [],
                bus_routes: [],
                train_lines: [],

                images: [],
            },

            categories: [],
            amenities: [],
            zones: [],
            busRoutes: [],
            trainLines: [],
        };
    },

    async mounted() {
    const token = localStorage.getItem("token");

    const config = {
        headers: { Authorization: `Bearer ${token}` }
    };

    // FIX: ต้องใช้ .data.data
    this.categories = (await axios.get("http://127.0.0.1:8000/api/admin/categories", config)).data.data;
    this.amenities  = (await axios.get("http://127.0.0.1:8000/api/admin/amenities", config)).data.data;
    this.zones      = (await axios.get("http://127.0.0.1:8000/api/admin/zones", config)).data.data;
    this.busRoutes  = (await axios.get("http://127.0.0.1:8000/api/admin/bus-routes", config)).data.data;
    this.trainLines = (await axios.get("http://127.0.0.1:8000/api/admin/train-lines", config)).data.data;

    if (this.mode === "edit" && this.dormData) {
        this.form = {
            ...this.form,
            ...this.dormData,

            categories: this.dormData.categories?.map(c => c.id) ?? [],
            amenities: this.dormData.amenities?.map(a => a.id) ?? [],
            zones: this.dormData.zones?.map(z => z.id) ?? [],
            bus_routes: this.dormData.bus_routes?.map(b => b.id) ?? [],
            train_lines: this.dormData.train_lines?.map(t => t.id) ?? [],
        };
    }
},


    methods: {
        close() {
            this.$emit("close");
        },

        onImageUpload(e) {
            this.form.images = Array.from(e.target.files);
        },

        submit() {
            this.$emit("submit", this.form);
        },
    }
}
</script>


<style lang="postcss" scoped>
.input {
    @apply w-full p-2 rounded border border-gray-300;
}
</style>
