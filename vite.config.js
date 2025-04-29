import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import VitePluginVueDevTools from 'vite-plugin-vue-devtools'

export default defineConfig({
  plugins: [
    vue(),
    VitePluginVueDevTools({
      appendTo: 'app.js',
    }),
    laravel({
      input: [ 'resources/css/app.css', 'resources/js/app.js' ],
      refresh: true,
    }),
    tailwindcss(),
  ],
})
