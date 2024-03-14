<script setup>

    import {defineProps } from 'vue';
    import { userFollowed } from '@/stores/userFollowed';

    const followedListAux = userFollowed();

    const props = defineProps({
        user: Object,
    })


    const toogleButton = (user) =>{ //funcion que cambia el estado del boton, y emite el evento correspondiente
        user.state = !user.state; 
        user.state ? followedListAux.follow(user) : followedListAux.unfollow(user); //si el estado es true, emitimos el evento follow, si es false, emitimos el evento unfollow
    }



</script>

<template>
 
    <button :class="[user.state ? ' bg-[#828181]' : 'bg-[#EB5959]', 'px-2', 'p-1', 'rounded-md', 'font-semibold', 'text-white', 'text-sm', 'rounded-md', 'transition-transform', 'duration-100', 'hover:scale-110']" @click="toogleButton(user)">
        {{ user.state ? "Siguiendo" : "Seguir"}}
    </button>
</template>

<style scoped>


</style>


