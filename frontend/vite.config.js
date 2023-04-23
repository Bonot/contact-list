import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      '/api/contacts-list': 'http://localhost:90',
      '/api/contacts-list/types': 'http://localhost:90',
    }
  }
})
