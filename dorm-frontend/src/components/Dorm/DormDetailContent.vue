<template>
    <div class="font-sans text-gray-800">

        <div >
            <!-- Header row -->
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div class="min-w-0">
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-900 tracking-tight leading-tight truncate">
                        {{ dorm.name }}
                    </h1>

                    <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">
                            <!-- location icon -->
                            <svg viewBox="0 0 24 24" class="w-4 h-4 text-gray-500" fill="none">
                                <path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z" stroke="currentColor"
                                    stroke-width="2" stroke-linejoin="round" />
                                <path d="M12 10.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                            <span class="truncate">
                                {{ dorm.subdistrict }}, {{ dorm.district }}, {{ dorm.province }}
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Favorite (right) -->
                <div class="shrink-0 md:pt-1">
                    <slot name="favorite" v-if="mode === 'user'" />
                </div>
            </div>

            <!-- Chips -->
            <div class="mt-4 flex flex-wrap gap-2">
                <span v-for="c in dorm.categories" :key="'c' + c.id"
                    class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs md:text-sm font-semibold text-blue-700">
                    {{ c.name }}
                </span>

                <span v-for="z in dorm.zones" :key="'z' + z.id"
                    class="inline-flex items-center rounded-full border border-purple-100 bg-purple-50 px-3 py-1 text-xs md:text-sm font-semibold text-purple-700">
                    โซน: {{ z.name }}
                </span>
            </div>

            <!-- Divider -->
            <div class="mt-6 h-px w-full bg-gray-100"></div>
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

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <div v-for="a in dorm.amenities" :key="a.id"
                            class="flex items-center gap-3 rounded-xl border border-gray-100 bg-white p-3 shadow-sm hover:shadow transition">
                            <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                                <AmenityIcon :name="a.name" class="w-5 h-5 text-zinc-900" />
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ a.name }}</p>
                                <p class="text-xs text-gray-500">Amenity</p>
                            </div>
                        </div>
                    </div>
                </section>


                <section v-if="dorm.bus_routes?.length || dorm.train_lines?.length" class="pt-2">
                    <div class="flex items-end justify-between gap-4 border-b pb-3 mb-5">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">การเดินทาง</h2>
                            <p class="text-sm text-gray-500 mt-1">ข้อมูลเส้นทางที่ผ่านและสถานีใกล้เคียง</p>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span v-if="dorm.bus_routes?.length" class="px-2 py-1 rounded-full bg-gray-100">
                                รถเมล์ {{ dorm.bus_routes.length }} สาย
                            </span>
                            <span v-if="dorm.train_lines?.length" class="px-2 py-1 rounded-full bg-gray-100">
                                รถไฟฟ้า {{ dorm.train_lines.length }} สถานี
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- BUS CARD -->
                        <div v-if="dorm.bus_routes?.length"
                            class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="px-5 py-4 bg-gradient-to-r from-yellow-50 to-white border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="w-10 h-10 rounded-xl bg-yellow-100 text-yellow-700 flex items-center justify-center">
                                            <!-- Bus SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path d="M6 16h12" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M7 16v3M17 16v3" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M6.5 4h11A2.5 2.5 0 0 1 20 6.5V16H4V6.5A2.5 2.5 0 0 1 6.5 4Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                <path d="M7.5 8h9" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M8 13h.01M16 13h.01" stroke="currentColor" stroke-width="4"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </span>

                                        <div>
                                            <h3 class="font-bold text-gray-900 leading-tight">รถเมล์ที่ผ่าน</h3>
                                            <p class="text-xs text-gray-500 mt-0.5">Bus routes</p>
                                        </div>
                                    </div>

                                    <span
                                        class="text-xs font-semibold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">
                                        {{ dorm.bus_routes.length }} สาย
                                    </span>
                                </div>
                            </div>

                            <ul class="p-4 space-y-2">
                                <li v-for="b in dorm.bus_routes" :key="b.id"
                                    class="group rounded-xl border border-gray-100 bg-white hover:bg-gray-50 transition p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">
                                                สาย {{ b.route_number }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ b.route_name }}
                                            </p>
                                        </div>

                                        <span
                                            class="shrink-0 text-[11px] font-semibold text-yellow-700 bg-yellow-50 border border-yellow-200 px-2 py-1 rounded-lg">
                                            BUS
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- TRAIN CARD -->
                        <div v-if="dorm.train_lines?.length"
                            class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="px-5 py-4 bg-gradient-to-r from-rose-50 to-white border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                                            <!-- Train SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path
                                                    d="M7 3h10a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                <path d="M6 8h12" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M8 14h.01M16 14h.01" stroke="currentColor" stroke-width="4"
                                                    stroke-linecap="round" />
                                                <path d="M8 18l-2 3M16 18l2 3" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </span>

                                        <div>
                                            <h3 class="font-bold text-gray-900 leading-tight">รถไฟฟ้าใกล้เคียง</h3>
                                            <p class="text-xs text-gray-500 mt-0.5">Train lines</p>
                                        </div>
                                    </div>

                                    <span
                                        class="text-xs font-semibold text-rose-700 bg-rose-100 px-2.5 py-1 rounded-full">
                                        {{ dorm.train_lines.length }} สถานี
                                    </span>
                                </div>
                            </div>

                            <ul class="p-4 space-y-2">
                                <li v-for="t in dorm.train_lines" :key="t.id"
                                    class="group rounded-xl border border-gray-100 bg-white hover:bg-gray-50 transition p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ t.line_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">
                                                สถานี {{ t.station_name }}
                                            </p>
                                        </div>

                                        <span
                                            class="shrink-0 text-[11px] font-semibold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-1 rounded-lg">
                                            RAIL
                                        </span>
                                    </div>
                                </li>
                            </ul>
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
                        {{ dorm.street }}, {{ dorm.subdistrict }}, {{ dorm.district }}, {{ dorm.province }} {{
                            dorm.zipcode }}
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
                                    <div
                                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">
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
                                <button
                                    class="px-4 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm transition"
                                    @click="$emit('approve-review', r.id)">
                                    อนุมัติ
                                </button>
                                <button
                                    class="px-4 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-md text-sm transition"
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

                    <!-- PRICE CARD -->
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                        <div class="px-6 py-5 bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-600 text-white">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs uppercase tracking-widest text-white/80">ราคาเช่า</p>
                                    <div class="mt-2 flex items-end gap-2">
                                        <h3 class="text-3xl font-bold leading-none">
                                            ฿{{ dorm.price_min }}
                                        </h3>
                                        <span class="text-white/80 text-sm pb-0.5">– ฿{{ dorm.price_max }}</span>
                                    </div>
                                    <p class="text-xs text-white/80 mt-2">ต่อเดือน</p>
                                </div>

                                <div
                                    class="w-11 h-11 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                                    <!-- Wallet SVG -->
                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                        <path
                                            d="M4 7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7Z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                        <path d="M20 9h-5a2 2 0 0 0 0 4h5" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M16 11h.01" stroke="currentColor" stroke-width="4"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-5">
                            <div class="space-y-3">
                                <!-- Deposit -->
                                <div class="flex items-center justify-between gap-3 rounded-xl bg-gray-50 px-4 py-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-600">
                                            <!-- Coin SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path d="M12 3c4.418 0 8 1.79 8 4s-3.582 4-8 4-8-1.79-8-4 3.582-4 8-4Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                <path d="M4 7v5c0 2.21 3.582 4 8 4s8-1.79 8-4V7" stroke="currentColor"
                                                    stroke-width="2" />
                                                <path d="M4 12v5c0 2.21 3.582 4 8 4s8-1.79 8-4v-5" stroke="currentColor"
                                                    stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">เงินมัดจำ</p>
                                            <p class="text-xs text-gray-500 truncate">ชำระก่อนเข้าพัก</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-gray-900">฿{{ dorm.deposit_price }}</div>
                                </div>

                                <!-- Electricity -->
                                <div class="flex items-center justify-between gap-3 rounded-xl bg-gray-50 px-4 py-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-600">
                                            <!-- Bolt SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path d="M13 2L3 14h7l-1 8 10-12h-7l1-8Z" stroke="currentColor"
                                                    stroke-width="2" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">ค่าไฟ</p>
                                            <p class="text-xs text-gray-500 truncate">ต่อยูนิต</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-gray-900">{{ dorm.electricity_rate }} บ./ยูนิต
                                    </div>
                                </div>

                                <!-- Water -->
                                <div class="flex items-center justify-between gap-3 rounded-xl bg-gray-50 px-4 py-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-600">
                                            <!-- Droplet SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path d="M12 2s7 7.2 7 12.2A7 7 0 0 1 5 14.2C5 9.2 12 2 12 2Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">ค่าน้ำ</p>
                                            <p class="text-xs text-gray-500 truncate">ตามเงื่อนไขหอ</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold text-gray-900">{{ dorm.water_rate }} บ.</div>
                                </div>

                                <!-- Internet -->
                                <div class="flex items-center justify-between gap-3 rounded-xl bg-gray-50 px-4 py-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-600">
                                            <!-- Wifi SVG -->
                                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                                <path d="M2 8.5C7.5 3.5 16.5 3.5 22 8.5" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <path d="M5 12c4-3.5 10-3.5 14 0" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" />
                                                <path d="M8.5 15.5c2-1.8 5-1.8 7 0" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" />
                                                <path d="M12 19h.01" stroke="currentColor" stroke-width="4"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">อินเทอร์เน็ต</p>
                                            <p class="text-xs text-gray-500 truncate">รายเดือน</p>
                                        </div>
                                    </div>
                                    <div class="text-sm font-bold"
                                        :class="dorm.internet_fee == 0 ? 'text-emerald-600' : 'text-gray-900'">
                                        {{ dorm.internet_fee == 0 ? 'ฟรี' : dorm.internet_fee + ' บ.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT CARD -->
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900">ช่องทางติดต่อ</h3>
                                <span class="text-xs text-gray-500">Contact</span>
                            </div>
                        </div>

                        <div class="p-5 space-y-3">
                            <!-- Phone -->
                            <a
                                class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3  transition">
                                <span
                                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-blue-600">
                                    <!-- Phone SVG -->
                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                        <path
                                            d="M6.5 3h2.2c.6 0 1.1.4 1.2 1l.6 2.6c.1.5-.1 1.1-.6 1.4l-1.4.9a13.5 13.5 0 0 0 6.6 6.6l.9-1.4c.3-.5.9-.7 1.4-.6l2.6.6c.6.1 1 .6 1 1.2v2.2c0 .7-.5 1.2-1.2 1.3C12.2 21.2 2.8 11.8 5.2 4.2 5.3 3.5 5.8 3 6.5 3Z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                </span>

                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">โทรศัพท์</p>
                                    <p class="text-sm font-semibold text-gray-900  ">
                                        {{ dorm.phone }}
                                    </p>
                                </div>
                            </a>

                            <!-- Line -->
                            <div v-if="dorm.line_id"
                                class="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                                <span
                                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-emerald-600">
                                    <!-- Chat SVG -->
                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                        <path
                                            d="M5 6a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v7a4 4 0 0 1-4 4H10l-4 3v-3a4 4 0 0 1-1-3V6Z"
                                            stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                        <path d="M8 9h8M8 12h6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">Line ID</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ dorm.line_id }}</p>
                                </div>
                            </div>

                            <!-- Facebook -->
                            <div v-if="dorm.facebook"
                                class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 transition">
                                <span
                                    class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-indigo-600">
                                    <!-- Link SVG -->
                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                        <path d="M10 13a5 5 0 0 0 7.07 0l1.41-1.41a5 5 0 0 0-7.07-7.07L10 4.88"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M14 11a5 5 0 0 0-7.07 0L5.52 12.4a5 5 0 0 0 7.07 7.07L14 19.12"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500">Facebook</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate ">
                                        {{ dorm.facebook }}
                                    </p>
                                </div>

                            </div>

                            <!-- Fallback -->
                            <div v-if="!dorm.phone && !dorm.line_id && !dorm.facebook"
                                class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-5 text-center">
                                <p class="text-sm text-gray-500">ยังไม่มีข้อมูลการติดต่อ</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</template>

<script setup>
import AmenityIcon from '@/components/shared/AmenityIcon.vue';

defineProps({
    dorm: Object,
    reviews: Array,
    mode: {
        type: String,
        default: 'user', // user | admin
    },
});
</script>