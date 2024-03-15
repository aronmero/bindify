<script setup>
    import {
  getUserData,
  followUser,
  aniadirFavorito,
} from "@/Api/perfiles/perfil.js";
    import {defineProps, ref } from 'vue';
    import { userFollowed } from '@/stores/userFollowed';
    let seguido = ref(true)
    let respuesta = ref(true)

    

    const props = defineProps({
        user: Object
    })


async function responseCatcherFavoritos() {
  
  respuesta.value = await aniadirFavorito(
    "post",
    `/api/favorite/${props.user.username}`
  );
  
}

    function unfollow(){
        
        responseCatcherFavoritos("get", "/api/favorite");
    }


    const toogleButton = () =>{ //funcion que cambia el estado del boton, y emite el evento correspondiente
        
        seguido.value = !seguido.value; 
        unfollow(); //si el estado es true, emitimos el evento follow, si es false, emitimos el evento unfollow
        
    }



</script>

<template>
    <!-- <button class=" bg-[#EB5959] px-2 p-1 rounded-md font-semibold text-white text-sm rounded-md transition-transform duration-100 hover:scale-110" @click="toogleButton">
        {{ "Unfollow" }}
    </button> -->

    <button :class="[seguido ? ' bg-[#828181]' : 'bg-[#EB5959]', 'px-2', 'p-1', 'rounded-md', 'font-semibold', 'text-white', 'text-sm', 'rounded-md', 'transition-transform', 'duration-100', 'hover:scale-110']" @click="toogleButton()">
        {{ seguido ? "En Favoritos" : "Add a Favoritos"}}
    </button>
</template>

<style scoped>


</style>


