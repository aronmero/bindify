<script setup>
    defineProps({
        "ruta":String,
        "altText":String,
    })
</script>
<template>
    <div class="rounded-full overflow-hidden flex justify-center items-center max-w-24 max-h-24 border-2">

        <img :src="ruta" :alt="altText" class="scale-150">
    </div>
    
    
</template>
<style scoped>
    
</style>