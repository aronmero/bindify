<script setup>
    import { defineProps, ref } from 'vue';
    import { setRandomGradient } from '@/utils/randomGradient.js';
    import useSearchLogic from '@/utils/searchLogic.js';

    const props = defineProps({
        name: String,
        type : String
    });

    const { selectedOption } = useSearchLogic();
  
    function toggleSelection(name, type, event) {
        event.currentTarget.classList.toggle('selected');
        document.querySelectorAll(`.${type}`).forEach((option) => {
            if (option !== event.currentTarget) {
                option.classList.remove('selected');
            }
        });
     
      selectedOption(name, type);
    }

</script>

<template>
    <div :style="{ background: setRandomGradient() }" class="random-gradient p-1 text-sm rounded-md text-white font-bold transition duration-100 ease-in hover:scale-105 cursor-pointer " @click="toggleSelection(name, type, $event)">
        #{{ name }}
    </div>
</template>

<style scoped>
    .selected {
      transform: scale(1.1);
    }
</style>