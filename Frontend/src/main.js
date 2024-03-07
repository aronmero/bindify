import router from "@/router/index.js";
import { createPinia } from "pinia";
import { createApp } from "vue";
import App from "./App.vue";
import "@/style/style.scss";

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);
app.mount("#app");
