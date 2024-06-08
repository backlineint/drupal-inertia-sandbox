import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

const port = 5173;
const origin = `${process.env.DDEV_PRIMARY_URL}:${port}`;

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    manifest: true,
    rollupOptions: {
      // overwrite default .html entry
      input: ["/src/main.jsx"],
    },
  },
  base: "/modules/custom/inertia_examples/app/dist/",
  plugins: [react()],
  // Adjust Vites dev server for DDEV
  // https://vitejs.dev/config/server-options.html
  server: {
    // respond to all network requests:
    host: "0.0.0.0",
    port: port,
    strictPort: true,
    // Defines the origin of the generated asset URLs during development
    origin: origin,
  },
});
