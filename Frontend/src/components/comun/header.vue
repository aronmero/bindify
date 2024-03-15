<script setup>
import { RouterLink } from "vue-router";
import router from '@/router/index.js';
import  logo  from '@public/img/fondo.png';
import {  closeSession} from "@/Api/auth.js";
const tipo = JSON.parse(sessionStorage.getItem("usuario")).usuario.tipo;

/**
 * Cierra la sesion actual y redirige al usuario
 * @date 3/10/2024 - 10:02:05 PM
 * @author Aarón Medina Rodríguez
 */
 const closeSesion = async () => {
   
    const data= await closeSession();
    console.log(data)
    sessionStorage.clear();
    router.push("/");
    router.go();
  }
</script>

<template>
  <header class="h-[80px] bg-[#f3f3f3]  flex fixed -top-[0.75rem] justify-between sm:justify-around px-[10px] w-full z-50">
    <nav class=" flex justify-center items-center">
      <RouterLink to="/" class=" logo flex justify-center items-center "> 
        <img :src="logo" class="max-w-[55px]  max-h-[40px]  hidden xl:flex sm:flex rounded-full " />
        <h1 class="flex sm:ml-[20px]">Bindify</h1>
      </RouterLink>
    </nav>
    <div class="menu-right flex">
    <nav class="lg:w-[50px] none lg:flex justify-center items-center " v-if="tipo==`ayuntamiento` || tipo==`commerce`">
      <RouterLink to="/post/nuevo">
        <img title="Nuevo Post" src="/assets/icons/add_rounded.svg" class="max-w-[50px] max-h-[50px] hidden lg:block"
          alt="Nuevo Post" />
      </RouterLink>
    </nav>
      <nav class="lg:w-[50px] none lg:flex justify-center items-center">
        <RouterLink to="/busqueda">
          <img title="Busqueda" src="/assets/icons/search.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Busqueda" />
        </RouterLink>
      </nav>
      <nav class="lg:w-[50px] xl:[20px] none lg:flex justify-center items-center">
        <RouterLink to="/calendario">
          <img title="Calendario" src="/assets/icons/schedule.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Calendario" />
        </RouterLink>
      </nav>
      <nav class="lg:w-[50px] none lg:flex justify-center items-center">
        <RouterLink to="/perfil">
          <img title="Perfil" src="/assets/icons/user.svg" class="max-w-[30px] max-h-[30px] hidden lg:block"
            alt="Perfil" />
        </RouterLink>
      </nav>
      <nav class="w-[50px]  justify-center items-center">
        <RouterLink to="/notificaciones">
          <img src="/assets/icons/bell.svg" title="Notificaciones" class="max-w-[30px] max-h-[30px]"
            alt="Notificaciones" />
        </RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <button @click="closeSesion">
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
        background: -webkit-linear-gradient(#EC4A41, #FE822F);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
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
