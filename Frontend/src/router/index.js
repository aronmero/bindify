import { createRouter, createWebHistory } from "vue-router";

/**
 * Definición de las rutas del enrutador.
 */
const routes = [
  { path: "/", component: () => import("@/views/example.vue") },
  /* David */
  { path: "/calendario", component: () => import("@/views/calendarioEvento.vue") }
];

/**
 * Crea y configura un enrutador utilizando las rutas definidas.
 */
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
