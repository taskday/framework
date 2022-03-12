import { defineConfig } from "vite";
// @ts-ignore
import path from "path";
import vue from "@vitejs/plugin-vue";
import Components from "unplugin-vue-components/vite";
import resolveExternalsPlugin from "vite-plugin-resolve-externals";
import { nodeResolve } from "@rollup/plugin-node-resolve";

// https://vitejs.dev/config/
export default defineConfig({
  root: path.resolve(__dirname, '.'),
  server: {
    hmr: {
      protocol: "ws",
      host: "localhost",
    },
  },
  resolve: {
    alias: {
      // 'vue': 'vue/dist/vue.esm-bundler.js',
      "@": path.resolve(__dirname, "./resources"),
    },
  },
  css: {
    postcss: {
      plugins: [
        require("postcss-import"),
        require("tailwindcss/nesting"),
        require("tailwindcss")("./tailwind.config.js"),
        require("autoprefixer"),
      ],
    },
  },
  build: {
    rollupOptions: {
      input: {
        main: "./resources/main.ts",
        bootstrap: "./resources/bootstrap.ts",
        taskday: "./resources/taskday.ts",
      },
      plugins: [
        resolveExternalsPlugin({
          vue: "Vue",
        }),
      ],
    },
  },
  plugins: [
    nodeResolve({
      moduleDirectories: [path.resolve(process.cwd(), "./node_modules")],
    }),
    vue(),
    Components({
      dirs: ["./resources/components"],
      extensions: ["vue"],
      deep: true,
    }),
  ],
});
