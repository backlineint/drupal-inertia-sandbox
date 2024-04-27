import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    manifest: true,
    rollupOptions: {
      // overwrite default .html entry
      input: ["/src/main.jsx"],
    },
  },
  base: "/modules/inertia/app/dist/",
  plugins: [react()],
});
