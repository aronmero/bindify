<script setup>
    defineProps({
        "ruta":String,
        "altText":String,
    })
</script>
<template>
    
    <button class=""><img :src="ruta" :alt="altText" class="w-8 h-8 border border-background-200 "></button>
    
    
</template>
<style scoped>
    
</style>