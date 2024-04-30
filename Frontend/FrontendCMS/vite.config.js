import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import dotenv from 'dotenv'
import vue from '@vitejs/plugin-vue'
dotenv.config()

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
  ],
  base: process.env.NODE_ENV === 'production'
    ? '/dist/' // set the base to '/dist/' when in production mode
    : '/',
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    proxy: {
      '/laravel': {
        target: process.env.VITE_BASE_URL || 'http://localhost',
        changeOrigin: true,
      },
    },
  },
})
