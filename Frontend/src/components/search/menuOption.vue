<script setup>
    defineProps({
        icon : String,
        name : String
    })

    import { optionSelected } from '@/stores/option.js';

    let option = optionSelected();

    const selectedOption = (name) =>{

        option.setOptionSelected(name);
    }

    
</script>

<template>
    <div class="flex flex-col items-center cursor-pointer" @click="selectedOption(name)">
        <img :src="icon" class="size-7 icon" />
        <p class="text-gray-400 text-md">{{ name }}</p>
    </div>
</template>

<style scoped>
    
</style>