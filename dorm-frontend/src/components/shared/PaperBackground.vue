<template>
    <!-- Decorative background -->
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden -z-10">
        <!-- Base tint -->
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 via-white to-gray-100"></div>

        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1440 900" preserveAspectRatio="none">
            <defs>
                <filter id="softShadow" x="-25%" y="-25%" width="150%" height="150%">
                    <feDropShadow dx="0" dy="12" stdDeviation="18" flood-color="#000" flood-opacity="0.10" />
                </filter>

                <!-- Paper gradients -->
                <linearGradient id="paperA" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#ffffff" />
                    <stop offset="100%" stop-color="#eef2f7" />
                </linearGradient>

                <linearGradient id="paperB" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#fbfbfb" />
                    <stop offset="100%" stop-color="#e7edf6" />
                </linearGradient>

                <linearGradient id="paperC" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95" />
                    <stop offset="100%" stop-color="#e5e7eb" stop-opacity="0.90" />
                </linearGradient>

                <radialGradient id="spot" cx="70%" cy="20%" r="70%">
                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.75" />
                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                </radialGradient>
            </defs>

            <!-- soft highlight -->
            <rect x="0" y="0" width="1440" height="900" fill="url(#spot)" />

            <!-- ========================= -->
            <!-- TOP WAVES (ใหม่) -->
            <!-- ========================= -->

            <!-- Top Layer 1 (ไกลสุด) -->
            <path filter="url(#softShadow)" fill="url(#paperB)" opacity="0.95"
                d="M-60,210 C160,120 360,95 560,125 C760,155 980,110 1180,70 C1380,30 1540,70 1600,95 L1600,-60 L-60,-60 Z" />

            <!-- Top Layer 2 -->
            <path filter="url(#softShadow)" fill="url(#paperA)" opacity="0.92"
                d="M-60,260 C200,180 400,200 600,240 C800,280 1020,240 1210,170 C1400,100 1540,135 1600,160 L1600,-60 L-60,-60 Z" />

            <!-- Top Layer 3 (บางๆ) -->
            <path filter="url(#softShadow)" fill="#ffffff" opacity="0.86"
                d="M-60,310 C220,260 450,285 640,320 C830,355 1040,330 1230,280 C1420,230 1540,250 1600,265 L1600,-60 L-60,-60 Z" />

            <!-- ========================= -->
            <!-- BOTTOM WAVES (เดิม) -->
            <!-- ========================= -->

            <path filter="url(#softShadow)" fill="url(#paperB)"
                d="M-60,520 C170,390 380,340 610,380 C840,420 1010,330 1200,240 C1390,150 1540,210 1600,250 L1600,940 L-60,940 Z" />

            <path filter="url(#softShadow)" fill="url(#paperA)"
                d="M-60,585 C210,475 420,490 640,540 C860,590 1040,510 1210,400 C1380,290 1540,340 1600,380 L1600,940 L-60,940 Z" />

            <path filter="url(#softShadow)" fill="url(#paperC)"
                d="M-60,640 C230,620 440,690 640,735 C840,780 1040,720 1215,615 C1390,510 1540,555 1600,585 L1600,940 L-60,940 Z" />

            <path filter="url(#softShadow)" fill="#f6f7fb"
                d="M-60,705 C240,690 470,735 665,780 C860,825 1060,780 1230,700 C1400,620 1540,650 1600,675 L1600,940 L-60,940 Z" />

            <path filter="url(#softShadow)" fill="#ffffff" opacity="0.90"
                d="M-60,760 C260,745 490,790 690,830 C890,870 1080,835 1245,775 C1410,715 1540,735 1600,750 L1600,940 L-60,940 Z" />
        </svg>

        <!-- Top-right paper rings -->
        <div class="absolute -top-32 -right-32 w-[520px] h-[520px] rounded-full bg-white
             shadow-[0_35px_90px_rgba(0,0,0,0.10)]"></div>
        <div class="absolute -top-16 -right-16 w-[380px] h-[380px] rounded-full bg-gray-50
             shadow-[0_26px_70px_rgba(0,0,0,0.08)]"></div>

        <!-- Grain / Noise -->
        <div class="absolute inset-0 opacity-[0.07] mix-blend-multiply">
            <div class="absolute inset-0" style="
          background-image:
            radial-gradient(rgba(0,0,0,0.35) 0.5px, transparent 0.5px),
            radial-gradient(rgba(0,0,0,0.25) 0.5px, transparent 0.5px);
          background-size: 3px 3px, 5px 5px;
          background-position: 0 0, 20px 10px;
        "></div>
        </div>

        <!-- Vignette -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/55 via-transparent to-white/50"></div>
    </div>
</template>
