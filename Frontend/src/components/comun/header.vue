<script setup>
import { RouterLink } from "vue-router";
import router from '@/router/index.js';

/**
 * Cierra la sesion actual y redirige al usuario
 * @date 3/10/2024 - 10:02:05 PM
 * @author Aarón Medina Rodríguez
 */
 const closeSession = () => {
    sessionStorage.clear();
    router.push("/");
    router.go();
  }
</script>

<template>
  <header class="h-[50px] bg-background-300 flex fixed top-0 justify-between px-[10px] w-full z-50">
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/"> <img src="https://placehold.co/35x35/png" class="max-w-[35px] max-h-[35px] rounded-full" />
      </RouterLink>
    </nav>
    <div class="flex">
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/busqueda">
          <img title="Busqueda" src="/assets/icons/search.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Busqueda" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/calendario">
          <img title="Calendario" src="/assets/icons/schedule.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Calendario" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/">
          <img title="Perfil" src="/assets/icons/user.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Perfil" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/notificaciones">
          <img src="/assets/icons/bell.svg" title="Notificaciones" class="max-w-[30px] max-h-[30px]"
            alt="Notificaciones" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <button @click="closeSession">
          <img title="Cerrar sesion" src="/assets/icons/settings.svg" class="max-w-[30px] max-h-[30px]"
            alt="Cerrar sesion" />
        </button>
      </nav>
    </div>
  </header>
</template>

<style scoped></style>
