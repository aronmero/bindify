import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "@/router/index.js";
import App from "./App.vue";
import "./style.scss";

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);
app.mount("#app");
