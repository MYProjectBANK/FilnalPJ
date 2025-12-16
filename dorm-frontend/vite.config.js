import path from 'path';
import { defineConfig } from 'vite';

import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    vue(),
    tailwindcss(),
  ],
  resolve: {                // ✅ ต้องมี resolve
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
})
