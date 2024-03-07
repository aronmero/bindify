import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";

/**
 * Definición de las rutas del enrutador.
 */
const routes = [
  { path: "/", name: "Login", component: Login }
];

/**
 * Crea y configura un enrutador utilizando las rutas definidas.
 */
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
