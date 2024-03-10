<script setup>

    import { onMounted } from 'vue';

    defineProps({
        name : String,
        type: String
    })

    import useSearchLogic from '@/utils/searchLogic.js';

    const {selectedOption} = useSearchLogic();

    onMounted(() => {
        const categories = document.querySelectorAll('.categorias');
        const locations = document.querySelectorAll('.localizaciones');
        
        categories.forEach(category => {
            category.addEventListener('click', () => {
                category.classList.toggle('selected');
                categories.forEach(c => {
                    if(c !== category){
                        c.classList.remove('selected');
                    }
                })           
            })
        })

        locations.forEach(location => {
            location.addEventListener('click', () => {
                location.classList.toggle('selected'); 
                locations.forEach(l => {
                    if(l !== location){
                        l.classList.remove('selected');
                    }
                })           
            })

    })
})
        
</script>

<template>
    <div :class="[type, 'flex', 'items-center', 'justify-center',  'p-2',   'rounded-md',  'border-2',  'border-gray-300', ,'hover:bg-gray-100', 'cursor-pointer' ,'transition', 'duration-300', 'transform', 'hover:scale-105' ]" @click="selectedOption(name, type)">
    <p class="font-semibold text-md capitalize">{{ name }}</p>
    <svg class="w-6 h-6 ml-2 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
</div>

</template>

<style scoped>
    .selected{
        background-color: #eb5959 !important;
        color: white !important;
    }
    
</style>
