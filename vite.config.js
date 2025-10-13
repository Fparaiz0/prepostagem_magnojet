import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    tailwindcss(),
    laravel({
      input: ["resources/js/app.js"],
      refresh: true,
    }),
  ],
  build: {
    manifest: true,
    outDir: "public/build",
  },
  server: {
    host: "127.0.0.1",
    port: 8001,
    strictPort: true,
    hmr: {
      host: "127.0.0.1",
    },
  },
});
