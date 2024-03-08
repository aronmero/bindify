<script setup>
    import { ref } from 'vue';
    const state = ref(true)
    const toogleButton = () =>{
        state.value = !state.value;
    }
</script>

<template>
    <button class="bg-[#EB5959] px-2 p-1 ronded-md font-semibold text-white text-sm rounded-md transition-transform duration-100 hover:scale-110" @click="toogleButton">
        {{ state ? "Dejar de seguir" : "Seguir"}}
    </button>
</template>

<style scoped>


</style>