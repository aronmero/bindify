<script setup>
    defineProps({
        icon : String,
        name : String
    })
</script>

<template>
    <div class="flex flex-col items-center cursor-pointer">
        <img :src="icon" class="size-8">
        <p class="text-gray-400 text-lg">{{ name }}</p>
    </div>
</template>


<style scoped>

</style>