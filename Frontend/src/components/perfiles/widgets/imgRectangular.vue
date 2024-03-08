<script setup>
    defineProps({
        "ruta":String,
        "altText":String,
    })
</script>
<template>
    <img :src="ruta" :alt="altText" class="rounded-xl scale-75">
</template>
<style scoped>

</style>