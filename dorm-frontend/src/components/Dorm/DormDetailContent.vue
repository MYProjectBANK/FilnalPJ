<template>
    <div class="font-sans text-gray-800">

        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">{{ dorm.name }}</h1>
                    <p class="text-gray-500 mt-1 flex items-center gap-1">
                        📍 {{ dorm.subdistrict }}, {{ dorm.district }}, {{ dorm.province }}
                    </p>
                </div>
                <div class="shrink-0">
                    <slot name="favorite" v-if="mode === 'user'" />
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <span v-for="c in dorm.categories" :key="'c' + c.id"
                    class="px-3 py-1 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-sm font-medium">
                    {{ c.name }}
                </span>
                <span v-for="z in dorm.zones" :key="'z' + z.id"
                    class="px-3 py-1 bg-purple-50 text-purple-600 border border-purple-100 rounded-lg text-sm font-medium">
                    โซน: {{ z.name }}
                </span>
            </div>
        </div>

        <div class="mb-8 rounded-2xl overflow-hidden shadow-sm">
            <slot name="gallery" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

            <div class="lg:col-span-2 space-y-10">

                <section>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 border-b pb-2">รายละเอียด</h2>
                    <p class="text-gray-600 whitespace-pre-line leading-relaxed text-lg">
                        {{ dorm.description || 'ไม่มีข้อมูลรายละเอียดเพิ่มเติม' }}
                    </p>
                </section>

                <section v-if="dorm.amenities?.length">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 border-b pb-2">สิ่งอำนวยความสะดวก</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div v-for="a in dorm.amenities" :key="a.id"
                            class="flex items-center gap-3 text-gray-700 bg-gray-50 p-3 rounded-lg hover:bg-gray-100 transition">
                            <span class="text-green-500 bg-green-100 p-1 rounded-full text-xs">✔</span>
                            <span>{{ a.name }}</span>
                        </div>
                    </div>
                </section>

                <section v-if="dorm.bus_routes?.length || dorm.train_lines?.length">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 border-b pb-2">การเดินทาง</h2>
                    <div class="space-y-4">
                        <div v-if="dorm.bus_routes?.length">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">🚌 รถเมล์</h3>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="b in dorm.bus_routes" :key="b.id"
                                    class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-md text-sm">
                                    สาย {{ b.route_number }} : {{ b.route_name }}
                                </span>
                            </div>
                        </div>
                        <div v-if="dorm.train_lines?.length">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">🚆 รถไฟฟ้า</h3>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="t in dorm.train_lines" :key="t.id"
                                    class="px-3 py-1 bg-red-50 text-red-700 border border-red-200 rounded-md text-sm">
                                    {{ t.line_name }} - {{ t.station_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <section v-if="dorm.latitude && dorm.longitude">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 border-b pb-2">ตำแหน่งที่ตั้ง</h2>
                    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                        <iframe class="w-full h-80"
                            :src="`https://maps.google.com/maps?q=${dorm.latitude},${dorm.longitude}&z=16&output=embed&hl=th`"
                            frameborder="0" style="border:0;" allowfullscreen></iframe>
                    </div>
                    <p class="mt-3 text-gray-500 text-sm">
                        {{ dorm.street }}, {{ dorm.subdistrict }}, {{ dorm.district }}, {{ dorm.province }} {{ dorm.zipcode }}
                    </p>
                </section>

                <section class="pt-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900 flex items-center gap-2">
                        ⭐ รีวิวจากผู้พักจริง
                        <span class="text-sm font-normal text-gray-500">({{ reviews.length }} รีวิว)</span>
                    </h2>

                    <div class="mb-8">
                        <slot name="review-form" v-if="mode === 'user'" />
                    </div>

                    <div v-if="reviews.length" class="space-y-6">
                        <div v-for="r in reviews" :key="r.id" class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">
                                        {{ r.user?.fullname?.charAt(0) || 'U' }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ r.user?.fullname }}</p>
                                        <p class="text-xs text-gray-400">สมาชิก</p>
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded bg-gray-100" :class="{
                                    'text-green-600 bg-green-50': r.status === 'approved',
                                    'text-red-600 bg-red-50': r.status === 'rejected',
                                    'text-yellow-600 bg-yellow-50': r.status === 'pending'
                                }">
                                    {{ r.status }}
                                </span>
                            </div>

                            <p class="text-gray-700 mt-2 pl-13 ml-12">{{ r.comment }}</p>

                            <div v-if="mode === 'admin' && r.status === 'pending'" class="flex gap-3 mt-3 ml-12">
                                <button class="px-4 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm transition"
                                    @click="$emit('approve-review', r.id)">
                                    อนุมัติ
                                </button>
                                <button class="px-4 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-md text-sm transition"
                                    @click="$emit('reject-review', r.id)">
                                    ไม่อนุมัติ
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500">ยังไม่มีรีวิว เป็นคนแรกที่รีวิวเลย!</p>
                    </div>
                </section>

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white text-center">
                            <p class="text-sm opacity-90 mb-1">ราคาเช่าเริ่มต้น</p>
                            <h3 class="text-3xl font-bold">฿{{ dorm.price_min }} <span class="text-lg font-normal opacity-80">- {{ dorm.price_max }}</span></h3>
                            <p class="text-sm opacity-80">ต่อเดือน</p>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between text-sm border-b pb-2">
                                <span class="text-gray-500">เงินมัดจำ</span>
                                <span class="font-semibold text-gray-900">฿{{ dorm.deposit_price }}</span>
                            </div>
                            <div class="flex justify-between text-sm border-b pb-2">
                                <span class="text-gray-500">ค่าไฟ</span>
                                <span class="font-semibold text-gray-900">{{ dorm.electricity_rate }} บ./ยูนิต</span>
                            </div>
                            <div class="flex justify-between text-sm border-b pb-2">
                                <span class="text-gray-500">ค่าน้ำ</span>
                                <span class="font-semibold text-gray-900">{{ dorm.water_rate }} บ.</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">อินเทอร์เน็ต</span>
                                <span class="font-semibold text-green-600">{{ dorm.internet_fee == 0 ? 'ฟรี' : dorm.internet_fee + ' บ.' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4 text-lg">ช่องทางติดต่อ</h3>
                        <div class="space-y-4">
                            <a :href="'tel:' + dorm.phone" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition group cursor-pointer">
                                <span class="bg-white p-2 rounded-full shadow-sm text-lg">📞</span>
                                <div>
                                    <p class="text-xs text-gray-500">เบอร์โทรศัพท์</p>
                                    <p class="font-semibold text-blue-600 group-hover:underline">{{ dorm.phone }}</p>
                                </div>
                            </a>

                            <div v-if="dorm.line_id" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <span class="bg-green-100 p-2 rounded-full shadow-sm text-green-600 font-bold text-lg">L</span>
                                <div>
                                    <p class="text-xs text-gray-500">Line ID</p>
                                    <p class="font-semibold text-gray-900">{{ dorm.line_id }}</p>
                                </div>
                            </div>
                            
                            <div v-if="dorm.facebook" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <span class="bg-blue-100 p-2 rounded-full shadow-sm text-blue-600 font-bold text-lg">f</span>
                                <div class="overflow-hidden">
                                    <p class="text-xs text-gray-500">Facebook</p>
                                    <p class="font-semibold text-gray-900 truncate">{{ dorm.facebook }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
defineProps({
    dorm: Object,
    reviews: Array,
    mode: {
        type: String,
        default: 'user', // user | admin
    },
});
</script>