<script setup>
import { RouterLink } from "vue-router";
import router from '@/router/index.js';
import  logo  from '@public/img/fondo.png';

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
  <header class="h-[80px] bg-[#f3f3f3]  flex fixed top-0 justify-around px-[10px] w-full z-50">
    <nav class="w-[55px] flex justify-center items-center">
      <RouterLink to="/" class=" logo flex justify-center items-center "> 
        <img :src="logo" class="max-w-[55px]  max-h-[40px]  hidden xl:flex sm:flex rounded-full " />
        <h1 class="flex">Bindify</h1>
      </RouterLink>
    </nav>
    <div class="menu-right flex">
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/busqueda">
          <img title="Busqueda" src="/assets/icons/search.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Busqueda" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] xl:[20px] flex justify-center items-center">
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
          <img title="Cerrar sesion" src="/assets/icons/logout.svg" class="max-w-[30px] max-h-[30px]"
            alt="Cerrar sesion" />
        </button>
      </nav>
    </div>
  </header>
</template>

<style scoped lang="scss">
  header {
    border-bottom: 1px solid rgb(206,206,206);
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    .logo {
      //background: red;
      h1 {
        font-size:1.6rem;
        font-weight:bolder;
        margin-left:20px;
        background: -webkit-linear-gradient(#EC4A41, #FE822F);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 5px 9px 9px rgba(0,0,0,0.25);
      }
      
    }
    .menu-right {

      nav {
        a, button {
          border-radius:5px;
          padding:4px;
          transition:.2s ease-in-out;
        }
        
        a:hover, button:hover {
          background:#FE822F;
         
        }
      }
     
      
  
  }

    
  }
</style>
