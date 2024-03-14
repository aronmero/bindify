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
    async function responseCatcherFollow() {
    // console.log(userData.value.username);
    respuesta.value = await followUser(
    "post",
    `/api/follow/${props.user.username}`
  );
  console.log(respuesta.value);
}

    function unfollow(){
        console.log("unfollow " + props.user.username)
        responseCatcherFollow("get", "/api/follows");
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
        {{ seguido ? "Siguiendo" : "Seguir"}}
    </button>
</template>

<style scoped>


</style>


