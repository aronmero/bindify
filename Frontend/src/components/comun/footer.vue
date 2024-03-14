<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
  <footer
    class="h-[50px] w-full bg-background-50 flex px-[10px] justify-around fixed bottom-0 lg:hidden z-50"
  >
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/">
        <img title="Inicio" alt="Inicio" 
          src="/assets/icons/home.svg"
          class="max-w-[20px] max-h-[20px]"
        />
      </RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/busqueda">
        <img title="Busqueda" 
          src="/assets/icons/search.svg"
          class="max-w-[20px] max-h-[20px]"
          alt="Busqueda" /></RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/post/nuevo">
        <img  title="Nuevo Post" alt="Nuevo Post"
          src="/assets/icons/add_rounded.svg"
          class="max-w-[20px] max-h-[20px] "
      /></RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/calendario">
        <img title="Calendario"  alt="Calendario"
          src="/assets/icons/schedule.svg"
          class="max-w-[20px] max-h-[20px] "
      /></RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/perfil/">
        <img  title="Perfil" alt="Perfil"
          src="/assets/icons/user.svg"
          class="max-w-[20px] max-h-[20px] "
      /></RouterLink>
    </nav>
   

  </footer>
</template>

<style scoped></style>
