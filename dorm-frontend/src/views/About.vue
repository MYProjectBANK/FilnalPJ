<!-- src/views/About.vue -->
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
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                    About Us.
                </h1>
                <p class="mt-5 max-w-3xl mx-auto text-white/75 leading-relaxed">
                    Discover dorms by location, price, and amenities — all in one place.
                </p>
            </div>


            <!-- FEATURE CARDS (overlap) -->
            <div class="relative max-w-7xl mx-auto px-4">
                <div class="-mt-10 md:-mt-14 pb-10 md:pb-16">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div v-for="(f, idx) in features" :key="idx"
                            class="bg-white rounded-2xl shadow-lg px-6 pt-10 pb-8 text-center">
                            <div
                                class="-mt-16 mx-auto w-12 h-12 rounded-full bg-zinc-800 flex items-center justify-center shadow-md">
                                <span class="text-white">
                                    <!-- simple icon -->
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M7 8h10M7 12h6M21 12c0 4.418-4.03 8-9 8a9.7 9.7 0 0 1-4-.844L3 20l1.122-3.367A7.76 7.76 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z"
                                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>

                            <h3 class="mt-6 font-bold text-lg text-zinc-900">
                                {{ f.title }}
                            </h3>
                            <p class="mt-3 text-sm text-zinc-500 leading-relaxed">
                                {{ f.desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION: text + image card -->
        <section class="max-w-7xl mx-auto px-4 py-16 md:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <!-- left -->
                <div>
                    <div
                        class="w-14 h-14 rounded-full bg-zinc-800 text-white flex items-center justify-center shadow-md">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="1.8" />
                            <path d="M19 21a7 7 0 1 0-14 0" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                    </div>

                    <h2 class="mt-6 text-3xl md:text-4xl font-extrabold text-zinc-900">
                        ทำไม DormFinder ถึงช่วยให้หาหอพักง่ายขึ้น
                    </h2>

                    <p class="mt-4 text-zinc-600 leading-relaxed">
                        DormFinder คือแพลตฟอร์มค้นหาหอพัก/อพาร์ทเม้นท์ที่ออกแบบให้ใช้งานง่าย
                        ช่วยให้คุณเจอที่พักที่เหมาะกับงบและไลฟ์สไตล์ได้เร็วขึ้น
                        ไม่ต้องไล่เปิดหลายเว็บหรือเลื่อนหานาน ๆ
                    </p>

                    <ul class="mt-6 space-y-3 text-zinc-700">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 w-2 h-2 rounded-full bg-blue-600"></span>
                            <span><b>ค้นหาไว</b> รองรับคำค้นจากชื่อหอพัก + พื้นที่ (จังหวัด/อำเภอ/ตำบล)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 w-2 h-2 rounded-full bg-blue-600"></span>
                            <span><b>กรองตรงใจ</b> เลือกหมวดหมู่ สิ่งอำนวยความสะดวก การเดินทาง และช่วงราคา</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 w-2 h-2 rounded-full bg-blue-600"></span>
                            <span><b>ข้อมูลครบ</b> มีรูป รีวิว แผนที่ และช่องทางติดต่อ ช่วยตัดสินใจง่ายขึ้น</span>
                        </li>
                    </ul>

                    <p class="mt-6 text-zinc-600 leading-relaxed">
                        เป้าหมายของเราคือทำให้การหา “ที่พักที่ใช่” เป็นเรื่องง่ายและชัดเจน
                        เพื่อให้คุณโฟกัสกับการเรียนและการใช้ชีวิตได้เต็มที่
                    </p>


                    <button
                        class="mt-8 inline-flex items-center justify-center px-6 py-3 rounded-xl bg-zinc-800 text-white font-semibold hover:bg-zinc-900 transition">
                        READ MORE
                    </button>
                </div>

                <!-- right: image + card -->
                <div class="lg:justify-self-end w-full">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-zinc-100">
                        <img :src="sectionImage" alt="About" class="w-full h-56 object-cover" />
                        <div class="p-6">
                            <p class="text-xs text-zinc-500 uppercase tracking-wider">
                                Features
                            </p>
                            <h3 class="mt-2 font-bold text-lg text-zinc-900">
                                ค้นหาหอพักง่ายขึ้น
                            </h3>
                            <p class="mt-3 text-sm text-zinc-600 leading-relaxed">
                                เลือกหอพัก/อพาร์ทเม้นท์ที่ตรงใจคุณได้ง่าย ๆ
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TEAM -->
        <section class="max-w-7xl mx-auto px-4 pb-16 md:pb-24">
            <div class="text-center">
                <p class="text-sm font-semibold text-zinc-600">Our Team</p>
                <h2 class="mt-3 text-4xl md:text-5xl font-extrabold text-zinc-900">
                    Here are our heroes
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-zinc-600 leading-relaxed">
                    นักศึกษาที่พัฒนาเว็บไซต์
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
                <div v-for="(m, idx) in team" :key="idx" class="text-center w-full max-w-xs">
                    <div class="rounded-2xl overflow-hidden shadow-md bg-white">
                        <img :src="m.avatar" :alt="m.name" class="w-full h-56 object-cover" />
                    </div>

                    <h3 class="mt-5 font-bold text-lg text-zinc-900">
                        {{ m.name }}
                    </h3>
                    <p class="text-sm text-zinc-500 font-semibold">
                        {{ m.role }}
                    </p>

                    <!-- socials -->
                    <div class="mt-4 flex items-center justify-center gap-4 text-zinc-500">
                        <a v-for="(s, i) in m.socials" :key="i" :href="s.href" target="_blank" rel="noreferrer"
                            class="hover:text-zinc-900 transition" :aria-label="s.label">
                            <component :is="s.icon" />
                        </a>
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script setup>
import { h } from 'vue';

import Navbar from '../components/User/Navbar.vue';

/** ✅ เปลี่ยนรูปได้ตามต้องการ */
const heroBg =
    "https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=2000&q=80";
const sectionImage =
    "https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1600&q=80";

const features = [
    {
        title: "Smart Search",
        th: "ค้นหาง่าย",
        desc: "พิมพ์ชื่อหอพัก/จังหวัด/อำเภอ/ตำบล ระบบช่วยแนะนำและแสดงผลลัพธ์ทันที",
    },
    {
        title: "Filter Your Style",
        th: "กรองตามสไตล์คุณ",
        desc: "เลือกหมวดหมู่ สิ่งอำนวยความสะดวก การเดินทาง และช่วงราคาได้ในไม่กี่คลิก",
    },
    {
        title: "Trusted Listings",
        th: "ข้อมูลน่าเชื่อถือ",
        desc: "รวมข้อมูลสำคัญ รูปภาพ รีวิว และช่องทางติดต่อ ช่วยตัดสินใจได้มั่นใจขึ้น",
    },
];


/** Facebook + Instagram (SVG) */
const FacebookIcon = () =>
    h("svg", { width: 22, height: 22, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M14 9h2V6h-2c-2.2 0-4 1.8-4 4v2H8v3h2v6h3v-6h2.5l.5-3H13v-2c0-.6.4-1 1-1Z",
            fill: "currentColor",
        }),
    ]);

const InstagramIcon = () =>
    h("svg", { width: 22, height: 22, viewBox: "0 0 24 24", fill: "none" }, [
        h("path", {
            d: "M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
        }),
        h("path", {
            d: "M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z",
            stroke: "currentColor",
            "stroke-width": "1.8",
        }),
        h("path", {
            d: "M17.5 6.5h.01",
            stroke: "currentColor",
            "stroke-width": "2.4",
            "stroke-linecap": "round",
        }),
    ]);


const team = [

    {
        name: "Witthawat Khotalut",
        role: "Full Stack Developer",
        avatar:
            "/Profile/IMG_20230222_192711.jpg",
        socials: [
            { label: "Facebook", href: "https://www.facebook.com/bank.vittavat.7", icon: FacebookIcon },
            { label: "Instagram", href: "https://www.instagram.com/klixban__/", icon: InstagramIcon },
        ],
    },
    {
        name: "Ratchadaporn",
        role: "UI/UX Designer",
        avatar:
            "/Profile/IMG_4701.jpg",
        socials: [
            { label: "Facebook", href: "https://www.facebook.com/ratchadapron.krongngam", icon: FacebookIcon },
            { label: "Instagram", href: "https://www.instagram.com/pelapraew", icon: InstagramIcon },
        ],
    },
    {
        name: "Naphaphassorn",
        role: "UI/UX Designer",
        avatar:
            "/Profile/IMG_7940.jpg",
        socials: [
            { label: "Facebook", href: "https://www.facebook.com/profile.php?id=100082296648411", icon: FacebookIcon },
            { label: "Instagram", href: "https://www.instagram.com/bublumx.i", icon: InstagramIcon },
        ],
    },
];
</script>
