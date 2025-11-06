import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import dotenv from "dotenv";

dotenv.config();

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
    host: process.env.VITE_HMR_HOST,
    port: 8001,
    strictPort: true,
    cors: true,
    hmr: {
      host: process.env.VITE_HMR_HOST,
    },
  },
});
