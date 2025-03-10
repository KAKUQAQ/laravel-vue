import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import UnoCSS from 'unocss/vite';
import tailwindcss from '@tailwindcss/vite'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    UnoCSS(),
    tailwindcss(),
    AutoImport({
      resolvers: [ElementPlusResolver()],
    }),
    Components({
      resolvers: [ElementPlusResolver()],
    }),
  ],
  server: {
    https: false, // 避免本地 HTTPS 认证问题
    headers: {
      'Cache-Control': 'no-store'
    },
    proxy: {
      // 代理 API 请求到 Laravel
      '/api': {
        target: 'http://laravel-vue.local',
        changeOrigin: true,
        rewrite: path => path.replace(/^\/api/, '')
      },
      // 代理 Sanctum CSRF 认证请求
      '/sanctum/csrf-cookie': {
        target: 'http://laravel-vue.local',
        changeOrigin: true
      }
    }
  },
  build: {
    outDir: 'dist',
  }

})
