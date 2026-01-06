<template>
  <section class="pb-14 md:pb-16">
    <div class="max-w-7xl mx-auto px-4">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
          <p class="text-xs md:text-sm font-semibold tracking-wider text-gray-500 uppercase">
            {{ eyebrow }}
          </p>

          <h2 class="mt-1 text-2xl md:text-3xl font-extrabold text-gray-900">
            {{ title }} <span v-if="highlight" class="text-fuchsia-900">{{ highlight }}</span>
          </h2>

          <p v-if="subtitle" class="mt-2 text-sm md:text-base text-gray-500">
            {{ subtitle }}
          </p>
        </div>

        <div class="hidden md:flex items-center gap-2 text-xs text-gray-400">
          <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
          <span>Updated weekly</span>
        </div>
      </div>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
        <article v-for="item in normalizedItems" :key="item.id"
          class="group rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden cursor-pointer"
          @click="openArticle(item)">
          <!-- image -->
          <div class="relative h-52 md:h-56 overflow-hidden bg-gray-100">
            <img v-if="item.image" :src="item.image" :alt="item.title || 'article'"
              class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy" />
            <div v-else class="w-full h-full flex items-center justify-center text-gray-400">
              <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor"
                  stroke-width="2" />
                <path d="M8 13l2-2 3 3 2-2 3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>

            <div
              class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition">
            </div>

            <div class="absolute left-4 top-4">
              <span
                class="inline-flex items-center gap-1.5 rounded-full bg-white/90 backdrop-blur px-3 py-1 text-xs font-semibold text-gray-700 shadow-sm border border-white/60">
                <span class="w-1.5 h-1.5 rounded-full bg-fuchsia-900"></span>
                {{ item.tag }}
              </span>
            </div>
          </div>

          <!-- body -->
          <div class="p-5">
            <h3 class="text-base md:text-lg font-bold text-gray-900 leading-snug line-clamp-2">
              {{ item.title }}
            </h3>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed line-clamp-2">
              {{ item.excerpt }}
            </p>

            <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
              <span>{{ item.dateText }}</span>
              <span class="inline-flex items-center gap-1 text-gray-500">
                <span class="opacity-70">อ่าน</span>
                <span class="font-semibold text-gray-700">{{ item.readTime }}</span>
              </span>
            </div>
          </div>
        </article>
      </div>

      <p v-if="note" class="mt-8 text-center text-xs md:text-sm text-gray-400">
        {{ note }}
      </p>
    </div>

    <!-- MODAL -->
    <teleport to="body">
      <transition name="fade">
        <div v-if="isOpen"
          class="fixed inset-0 z-[999] bg-black/40 backdrop-blur-[1px] flex items-center justify-center p-4"
          @mousedown.self="close">
          <transition name="pop">
            <div v-if="isOpen"
              class="w-full max-w-3xl rounded-3xl bg-white shadow-2xl overflow-hidden border border-gray-100"
              role="dialog" aria-modal="true">
              <!-- header image -->
              <div class="relative h-56 md:h-72 bg-gray-100 overflow-hidden">
                <img v-if="active?.image" :src="active.image" :alt="active.title" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/15 to-transparent"></div>

                <!-- close -->
                <button
                  class="absolute right-4 top-4 w-10 h-10 rounded-full bg-white/90 hover:bg-white shadow flex items-center justify-center text-gray-700 transition"
                  @click="close" aria-label="close">
                  <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  </svg>
                </button>

                <!-- meta -->
                <div class="absolute left-6 bottom-5 right-6 text-white">
                  <div class="flex items-center gap-2 mb-2">
                    <span
                      class="inline-flex items-center gap-1.5 rounded-full bg-white/15 backdrop-blur px-3 py-1 text-xs font-semibold">
                      {{ active?.tag || "Article" }}
                    </span>
                    <span class="text-xs opacity-90">{{ active?.dateText }}</span>
                    <span class="text-xs opacity-90">•</span>
                    <span class="text-xs opacity-90">{{ active?.readTime }}</span>
                  </div>
                  <h3 class="text-xl md:text-2xl font-extrabold leading-snug">
                    {{ active?.title }}
                  </h3>
                </div>
              </div>

              <!-- content -->
              <div class="p-6 md:p-8">
                <!-- ✅ render markdown -->
                <div class="article prose" v-html="activeHtml"></div>

                <div class="mt-8 flex justify-end">
                  <button
                    class="px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold transition"
                    @click="close">
                    ปิดหน้าต่าง
                  </button>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </transition>
    </teleport>
  </section>
</template>

<script setup>
import {
  computed,
  onBeforeUnmount,
  ref,
} from 'vue';

import ban01 from '@/assets/Img/bann01.png';
import ban02 from '@/assets/Img/bann02.png';
import ban03 from '@/assets/Img/bann03.png';

const props = defineProps({
  eyebrow: { type: String, default: "Articles" },
  title: { type: String, default: "บทความ" },
  highlight: { type: String, default: "ที่น่าสนใจ" },
  subtitle: { type: String, default: "บทความที่น่าสนใจ อพาร์ทเม้นท์น่ารู้" },
  note: { type: String, default: "" },
  items: { type: Array, default: () => [] },
});

const isOpen = ref(false);
const active = ref(null);


const escapeHtml = (s = "") =>
  String(s)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");

const renderInline = (s = "") => {
  // escape first (important for safety)
  let out = escapeHtml(s);

  // inline code
  out = out.replace(/`([^`]+)`/g, "<code>$1</code>");

  // bold **text**
  out = out.replace(/\*\*([^*]+)\*\*/g, "<strong>$1</strong>");

  // italic *text*
  out = out.replace(/(^|[^*])\*([^*\n]+)\*(?!\*)/g, "$1<em>$2</em>");

  // links [text](url) — allow only http/https
  out = out.replace(/\[([^\]]+)\]\(([^)]+)\)/g, (m, text, url) => {
    const safe = String(url).trim();
    if (!/^https?:\/\//i.test(safe)) return text; // drop unsafe url
    return `<a href="${safe}" target="_blank" rel="noopener noreferrer">${text}</a>`;
  });

  return out;
};

const renderMd = (md = "") => {
  const lines = String(md || "").replace(/\r\n/g, "\n").split("\n");

  let html = "";
  let inUl = false;
  let inOl = false;

  const closeLists = () => {
    if (inUl) { html += "</ul>"; inUl = false; }
    if (inOl) { html += "</ol>"; inOl = false; }
  };

  for (const raw of lines) {
    const line = raw.trimEnd();
    const t = line.trim();

    // empty line => break paragraph / close lists
    if (!t) {
      closeLists();
      html += `<div class="spacer"></div>`;
      continue;
    }

    // headings
    if (/^###\s+/.test(t)) { closeLists(); html += `<h3>${renderInline(t.replace(/^###\s+/, ""))}</h3>`; continue; }
    if (/^##\s+/.test(t)) { closeLists(); html += `<h2>${renderInline(t.replace(/^##\s+/, ""))}</h2>`; continue; }
    if (/^#\s+/.test(t)) { closeLists(); html += `<h1>${renderInline(t.replace(/^#\s+/, ""))}</h1>`; continue; }

    // unordered list "- " or "* "
    if (/^[-*]\s+/.test(t)) {
      if (inOl) { html += "</ol>"; inOl = false; }
      if (!inUl) { html += "<ul>"; inUl = true; }
      html += `<li>${renderInline(t.replace(/^[-*]\s+/, ""))}</li>`;
      continue;
    }

    // ordered list "1. "
    if (/^\d+\.\s+/.test(t)) {
      if (inUl) { html += "</ul>"; inUl = false; }
      if (!inOl) { html += "<ol>"; inOl = true; }
      html += `<li>${renderInline(t.replace(/^\d+\.\s+/, ""))}</li>`;
      continue;
    }

    // normal paragraph
    closeLists();
    html += `<p>${renderInline(t)}</p>`;
  }

  closeLists();
  // remove extra spacers at end
  html = html.replace(/(<div class="spacer"><\/div>)+$/g, "");
  return html;
};

const activeHtml = computed(() => {
  const text = active.value?.content || active.value?.excerpt || "";
  return renderMd(text);
});

// -------------------------

const normalizedItems = computed(() => {
  const src = props.items?.length
    ? props.items
    : [
      {
        id: 1,
        title: "วิธีเลือกหอพักให้เหมาะกับนักศึกษา",
        excerpt: "รวมเช็กลิสต์สำคัญก่อนตัดสินใจเลือกหอพัก",
        content: `# เช็กลิสต์ก่อนเลือกหอพัก
- ราคาและค่าใช้จ่ายแฝง
- ความปลอดภัย
- การเดินทาง
- สิ่งอำนวยความสะดวก

## Tips
ลองเทียบ 3–5 ที่ แล้วจดข้อดีข้อเสียไว้`,
        image: ban02,
        tag: "Tips",
        dateText: "อัปเดตล่าสุด",
        readTime: "3 นาที",
      },
      {
        id: 2,
        title: "เคล็ดลับประหยัดค่าใช้จ่ายในหอพัก",
        excerpt: "ลดค่าไฟค่าน้ำ และวางแผนงบรายเดือนแบบง่ายๆ",
        content: `## ประหยัดแบบทำได้จริง
1. ปรับแอร์ 26–27°C
2. ใช้ปลั๊กพ่วงมีสวิตช์
3. วางแผนมื้ออาหาร

> จำไว้: ค่าเล็ก ๆ รวมกันเป็นก้อนใหญ่`,
        image: ban03,
        tag: "Saving",
        dateText: "อัปเดตล่าสุด",
        readTime: "4 นาที",
      },
      {
        id: 3,
        title: "สิ่งที่ควรรู้ก่อนทำสัญญาเช่าหอ",
        excerpt: "อ่านสัญญาให้ครบ รู้สิทธิผู้เช่า และข้อควรระวัง",
        content: `## ก่อนเซ็นสัญญา
- ตรวจเงินประกัน/ค่าส่วนกลาง
- เงื่อนไขย้ายออก/คืนเงิน
- เงื่อนไขซ่อมแซม

\`ทริค:\` ขอถ่ายรูปมิเตอร์ก่อนเข้าอยู่`,
        image: ban01,
        tag: "Guide",
        dateText: "อัปเดตล่าสุด",
        readTime: "5 นาที",
      },
    ];

  return src.slice(0, 6).map((x, idx) => ({
    id: x.id ?? idx + 1,
    title: x.title ?? "บทความที่น่าสนใจ",
    excerpt: x.excerpt ?? "คำอธิบายสั้น ๆ ของบทความ",
    content: x.content ?? "",
    image: x.image ?? null,
    tag: x.tag ?? "Article",
    dateText: x.dateText ?? "อัปเดตล่าสุด",
    readTime: x.readTime ?? "3 นาที",
  }));
});

const openArticle = (item) => {
  active.value = item;
  isOpen.value = true;
  document.body.style.overflow = "hidden";
};

const close = () => {
  isOpen.value = false;
  active.value = null;
  document.body.style.overflow = "";
};

const onEsc = (e) => {
  if (e.key === "Escape") close();
};

window.addEventListener("keydown", onEsc);
onBeforeUnmount(() => {
  window.removeEventListener("keydown", onEsc);
  document.body.style.overflow = "";
});
</script>

<style scoped>
@reference "tailwindcss";

/* clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.18s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.pop-enter-active {
  transition: transform 0.18s ease, opacity 0.18s ease;
}

.pop-enter-from {
  transform: translateY(8px) scale(0.98);
  opacity: 0;
}

.pop-leave-active {
  transition: transform 0.15s ease, opacity 0.15s ease;
}

.pop-leave-to {
  transform: translateY(8px) scale(0.98);
  opacity: 0;
}

/* ✅ simple prose styles (แทน prose ของ tailwind typography) */
.article :deep(h1) {
  font-size: 1.35rem;
  font-weight: 800;
  color: #111827;
  margin: 0.25rem 0 0.75rem;
}

.article :deep(h2) {
  font-size: 1.1rem;
  font-weight: 800;
  color: #111827;
  margin: 1rem 0 0.5rem;
}

.article :deep(h3) {
  font-size: 1rem;
  font-weight: 800;
  color: #111827;
  margin: 0.85rem 0 0.4rem;
}

.article :deep(p) {
  color: #374151;
  line-height: 1.85;
  margin: 0.55rem 0;
}

.article :deep(ul),
.article :deep(ol) {
  margin: 0.6rem 0 0.8rem;
  padding-left: 1.2rem;
  color: #374151;
}

.article :deep(ul) {
  list-style: disc;
}

.article :deep(ol) {
  list-style: decimal;
}

.article :deep(li) {
  margin: 0.25rem 0;
}

.article :deep(code) {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  padding: 0.1rem 0.35rem;
  border-radius: 0.4rem;
  font-size: 0.9em;
}

.article :deep(a) {
  color: #1d4ed8;
  text-decoration: underline;
  text-underline-offset: 3px;
}

.article :deep(strong) {
  color: #111827;
  font-weight: 800;
}

.article :deep(em) {
  color: #111827;
  font-style: italic;
}

/* spacer for blank lines */
.article :deep(.spacer) {
  height: 0.55rem;
}
</style>
