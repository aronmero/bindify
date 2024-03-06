
<script setup>
    import textoEnNegrita from '@/components/textoEnNegrita.vue';

    defineProps({
        "comercio":String,
        "puntos":String,
    })
</script>
<template>
    
    <div class="flex content-center items-center gap-4">
            <textoEnNegrita :texto="comercio" />
            <textoEnNegrita :texto="puntos" />
        </div>
    
    
</template>
<style scoped>
    
</style>