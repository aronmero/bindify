<script setup>
import imgRectangular from '@/components/imgRectangular.vue';
import imgRedonda from '@/components/imgRedonda.vue';
    defineProps({
        "rutaBaner":String,
        "altTextBaner":String,
        "rutaPerfil":String,
        "altTextPerfil":String,
    })
</script>
<template>
    <div class="relative">

        <imgRectangular :ruta="rutaBaner" :altText="altTextBaner" />
        <div class="flex justify-center items-end absolute bottom-0 left-0 w-full">

            <imgRedonda :ruta="rutaPerfil" :altText="altTextPerfil" class=""/>
        </div>
    </div>
    
    
</template>
<style scoped>
    
</style>