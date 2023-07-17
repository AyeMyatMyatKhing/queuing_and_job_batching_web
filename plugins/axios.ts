import axios from "axios";
export default defineNuxtPlugin((nuxtApp) => {
  const defaultUrl = "http://127.0.0.1:8000/api";

  let api = axios.create({
    baseURL: defaultUrl,
  });
  return {
    provide: {
      axios: api,
    },
  };
});
