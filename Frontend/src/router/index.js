import { createRouter, createWebHistory } from "vue-router";

/**
 * Definición de las rutas del enrutador.
 */
const routes = [
 // { path: "/", component: () => import("@/views/example.vue") },
  { path: "/", component: () => import("@/views/home.vue") },
  { path: "/login", component: () => import("@/views/Auth/login.vue") },
  { path: "/registro", component: () => import("@/views/Auth/registroParticular.vue") },
  { path: "/registro-comercio", component: () => import("@/views/Auth/registroComercio.vue") },
  { path: "/horarios-modal", component: () => import("@/views/Auth/horarios.vue") },
  
  { path: "/evento", component: () => import("@/views/eventos/evento.vue") },
  { path: "/eventos", component: () => import("@/views/eventos/eventos.vue") },
  { path: "/eventos/new", component: () => import("@/views/eventos/crearEvento.vue") },
  { path: "/eventos/edit", component: () => import("@/views/eventos/editarEvento.vue") },
  { path: "/calendario", component: () => import("@/views/eventos/calendarioEvento.vue") },

  { path: "/busqueda", component: () => import("@/views/Misc/search.vue") },
  { path: "/resenia", component: () => import("@/views/Misc/crearResena.vue") },
  { path: "/validar", component: () => import("@/views/Misc/validarComercio.vue") },
  
  //Sprint 2
  { path: "/notificaciones", component: () => import("@/views/Misc/notificaciones.vue") },

  //Estas tres se deberian reducir a una vista con 3 modos segun el tipo de usuario
  { path: "/ayuntamiento", component: () => import("@/views/perfiles/ayuntamiento.vue") },

  { path: "/comercio", component: () => import("@/views/perfiles/comercio.vue"),
   children:[
    {path:"posts", component:() => import("@/components/perfiles/containers/contenedorVistaPosts.vue")},
    {path:"eventos", component:() => import("@/components/perfiles/containers/contenedorVistaEventos.vue")},
    {path:"resenias", component:() => import("@/components/perfiles/containers/contenedorVistaResenias.vue")}
  ]},

  { path: "/particular", component: () => import("@/views/perfiles/particular.vue"), 
  children:[
    {path:"fidelidad", component:() => import("@/components/perfiles/containers/contenedorVistaFidelidad.vue")},
    {path:"favoritos", component:() => import("@/components/perfiles/containers/contenedorVistaFavoritos.vue")}
  ]},
  { path: "/tarjeta-fidelidad", component: () => import("@/views/perfiles/tarjetaFidelidad.vue")},
  { path: "/perfil/edit", component: () => import("@/views/perfiles/editarPerfil.vue") },

  { path: "/publicacion/new", component: () => import("@/views/publicaciones/crearPublicacion.vue") },
  { path: "/publicacion/edit", component: () => import("@/views/publicaciones/editarPublicacion.vue") },
  { path: "/validate", component: () => import("@/views/Misc/validate.vue") }
];

/**
 * Crea y configura un enrutador utilizando las rutas definidas.
 */
const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
