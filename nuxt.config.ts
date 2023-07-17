// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  // devtools: { enabled: true },
  css: ["bootstrap/dist/css/bootstrap.min.css"],
  script: [
    {
      src: "bootstrap/dist/js/bootstrap.bundle.min.js",
    },
  ],
  vite: {
    define: {
      "process.env.DEBUG": false,
    },
  },
  loading: {
    color: 'blue',
    height: '5px'
  },
});
