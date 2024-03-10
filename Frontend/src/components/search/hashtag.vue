<script setup>
    import { defineProps } from 'vue';
    import { setRandomGradient } from '@/utils/randomGradient.js';

    const props = defineProps({
        name: String,
    });


</script>

<template>
    <div :style="{ background: setRandomGradient() }" class="random-gradient p-1 text-sm rounded-full text-white font-bold transition duration-100 ease-in hover:scale-105 cursor-pointer">
        {{ name }}
    </div>
</template>
