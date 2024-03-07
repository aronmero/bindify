<script setup>
    defineProps({
        icon : String,
        name : String
    })

    const emit = defineEmits([
        "selectedOption"
    ]) 

    const selectedOption = (name) =>{
        emit("selectedOption", name);
    }

    
</script>

<template>
    <div class="flex flex-col items-center cursor-pointer" @click="selectedOption(name)">
        <img :src="icon" class="size-8 icon" />
        <p class="text-gray-400 text-lg">{{ name }}</p>
    </div>
</template>

<style scoped>
    
</style>