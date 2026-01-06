<!-- src/views/Contact.vue -->
<template>
    <div class="pb-20">
        <Navbar />
    </div>
    <div class="bg-white">
        <!-- HERO -->
        <section class="relative overflow-hidden">
            <!-- background image -->
            <div class="absolute inset-0 bg-center bg-cover" :style="{ backgroundImage: `url(${heroBg})` }" />
            <!-- overlay -->
            <div class="absolute inset-0 bg-black/70" />

            <div class="relative max-w-7xl mx-auto px-4 py-24 text-center text-white">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">
                    Contact us
                </h1>
                <p class="mt-5 max-w-3xl mx-auto text-white/75 leading-relaxed">
                    มีคำถาม แจ้งปัญหา หรืออยากลงประกาศหอพัก? ส่งข้อความหาเราได้เลย

                </p>
            </div>

            <!-- TOP CARDS (overlap) -->
            <div class="relative max-w-7xl mx-auto px-4">
                <div class="-mt-10 md:-mt-14 pb-10 md:pb-16">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div v-for="(c, idx) in quickCards" :key="idx"
                            class="bg-white rounded-2xl shadow-lg px-6 pt-10 pb-8 text-center">
                            <div
                                class="-mt-16 mx-auto w-12 h-12 rounded-full bg-zinc-800 flex items-center justify-center shadow-md">
                                <span class="text-white">
                                    <component :is="c.icon" />
                                </span>
                            </div>

                            <h3 class="mt-6 font-bold text-lg text-zinc-900">
                                {{ c.title }}
                            </h3>
                            <p class="mt-3 text-sm text-zinc-500 leading-relaxed">
                                {{ c.desc }}
                            </p>

                            <a v-if="c.linkText" :href="c.href"
                                class="mt-5 inline-flex text-sm font-semibold text-zinc-800 hover:text-zinc-950 transition">
                                {{ c.linkText }} →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MAIN: Form + Info -->
        <section class="max-w-7xl mx-auto px-4 py-16 md:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <!-- LEFT: Contact Form -->
                <div class="bg-white rounded-2xl shadow-lg border border-zinc-100 p-6 md:p-8">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-zinc-900">
                        Send us a message
                    </h2>
                    <p class="mt-2 text-zinc-600">
                        กรอกข้อมูลด้านล่าง 
                    </p>

                    <form class="mt-6 space-y-4" @submit.prevent="onSubmit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-zinc-700">ชื่อ</label>
                                <input v-model="form.name" type="text"
                                    class="mt-2 w-full rounded-xl border border-zinc-200 px-4 py-3 outline-none focus:ring-2 focus:ring-zinc-900/20"
                                    placeholder="ชื่อของคุณ" />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-zinc-700">อีเมล</label>
                                <input v-model="form.email" type="email"
                                    class="mt-2 w-full rounded-xl border border-zinc-200 px-4 py-3 outline-none focus:ring-2 focus:ring-zinc-900/20"
                                    placeholder="you@email.com" />
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-zinc-700">หัวข้อ</label>
                            <select v-model="form.topic"
                                class="mt-2 w-full rounded-xl border border-zinc-200 px-4 py-3 outline-none focus:ring-2 focus:ring-zinc-900/20 bg-white">
                                <option value="general">สอบถามทั่วไป</option>
                                <option value="bug">แจ้งปัญหา / Bug</option>
                                <option value="suggest">เสนอแนะ</option>
                                <option value="partner">ลงประกาศหอพัก / Partner</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-zinc-700">รายละเอียด</label>
                            <textarea v-model="form.message" rows="5"
                                class="mt-2 w-full rounded-xl border border-zinc-200 px-4 py-3 outline-none focus:ring-2 focus:ring-zinc-900/20"
                                placeholder="พิมพ์รายละเอียดที่ต้องการให้ช่วย..." />
                        </div>

                        <button type="submit"
                            class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-zinc-800 text-white font-semibold hover:bg-zinc-900 transition">
                            Send message
                        </button>

                        <p v-if="sent" class="text-sm text-green-600 font-semibold mt-3">
                            ส่งข้อความเรียบร้อย 
                        </p>
                    </form>
                </div>

                <!-- RIGHT: Info / Map Card -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-zinc-100 p-6 md:p-8">
                        <h3 class="text-xl font-extrabold text-zinc-900">Contact details</h3>

                        <div class="mt-5 space-y-4 text-zinc-700">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center">
                                    <MailIcon />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">Email</p>
                                    <p class="text-sm text-zinc-600">witthawatkhotalut@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center">
                                    <PhoneIcon />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">Phone</p>
                                    <p class="text-sm text-zinc-600">+66 95-680-7304</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center">
                                    <PinIcon />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">Location</p>
                                    <p class="text-sm text-zinc-600">
                                        Bangkok, Thailand
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-zinc-100 flex items-center justify-center">
                                    <ClockIcon />
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-zinc-900">Support hours</p>
                                    <p class="text-sm text-zinc-600">Mon–Fri, 09:00–18:00</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/bank.vittavat.7/"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-zinc-200 text-zinc-800 font-semibold hover:bg-zinc-50 transition">
                                Facebook
                            </a>
                            <a href="https://www.instagram.com/klixban__/"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-zinc-200 text-zinc-800 font-semibold hover:bg-zinc-50 transition">
                                Instagram
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </section>


    </div>
</template>

<script setup>
import {
  h,
  reactive,
  ref,
} from 'vue';

import Navbar from '../components/User/Navbar.vue';

/** รูปพื้นหลัง + รูปการ์ดขวา */
const heroBg =
    "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=2000&q=80";

/** icons */
const MailIcon = () =>
    h("svg", { width: 20, height: 20, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M4 6h16v12H4V6Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
            "stroke-linejoin": "round",
        }),
        h("path", {
            d: "m4 7 8 6 8-6",
            stroke: "currentColor",
            "stroke-width": "1.8",
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
        }),
    ]);

const PhoneIcon = () =>
    h("svg", { width: 20, height: 20, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M7 4h3l2 5-2 1c1 3 3 5 6 6l1-2 5 2v3c0 1-1 2-2 2-9.4 0-17-7.6-17-17 0-1 1-2 2-2Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
        }),
    ]);

const PinIcon = () =>
    h("svg", { width: 20, height: 20, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
            "stroke-linejoin": "round",
        }),
        h("path", {
            d: "M12 12a2.2 2.2 0 1 0 0-4.4A2.2 2.2 0 0 0 12 12Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
        }),
    ]);

const ClockIcon = () =>
    h("svg", { width: 20, height: 20, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
        }),
        h("path", {
            d: "M12 7v5l3 2",
            stroke: "currentColor",
            "stroke-width": "1.8",
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
        }),
    ]);

/** การ์ด 3 ใบบนสุด */
const quickCards = [
    {
        title: "Customer Support",
        desc: "มีคำถามเกี่ยวกับการใช้งาน/ข้อมูลหอพัก ติดต่อเราได้เลย",
        linkText: "Email us",
        href: "mailto:witthawatkhotalut@gmail.com",
        icon: MailIcon,
    },
    {
        title: "Report a Problem",
        desc: "แจ้งปัญหาเว็บ/รูปไม่ขึ้น/ข้อมูลผิดพลาด เพื่อให้เราช่วยตรวจสอบ",
        linkText: "Email us",
        href: "mailto:witthawatkhotalut@gmail.com",
        icon: ClockIcon,
    },
    {
        title: "Partner with us",
        desc: "เจ้าของหอพักต้องการลงประกาศ/แก้ไขข้อมูล ติดต่อได้ที่นี่",
        linkText: "Email us",
        href: "mailto:witthawatkhotalut@gmail.com",
        icon: PinIcon,
    },
];


/** form state */
const form = reactive({
    name: "",
    email: "",
    topic: "general",
    message: "",
});

const sent = ref(false);

function onSubmit() {
    // โครงเฉย ๆ: คุณไปผูก API/Email เองทีหลัง
    sent.value = true;
    setTimeout(() => (sent.value = false), 2500);

    // clear
    form.name = "";
    form.email = "";
    form.topic = "general";
    form.message = "";
}
</script>
