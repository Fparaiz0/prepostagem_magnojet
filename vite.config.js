import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
    laravel({
      input: ['resources/js/app.js'], 
      refresh: true,
    }),
  ],
  build: {
    manifest: true,
    outDir: 'public/build',
  },
  server: {
        host: '10.1.1.50',
        port: 8001, 
        strictPort: true,
        hmr: {
            host: '10.1.1.50', 
        }
    }
});
