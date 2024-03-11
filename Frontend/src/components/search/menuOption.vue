<script setup>

    import { onMounted } from 'vue';

    defineProps({
        name : String,
        type: String,
        icon : String
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
    <div :class="[type, 'flex', 'gap-x-1', 'items-center', 'justify-center',  'p-3', 'bg-[#e5e5e5]', 'text-[#404040]','rounded-full', 'cursor-pointer' ,'transition-all', 'duration-300', 'transform', 'hover:scale-105' ]" @click="selectedOption(name, type)">
        <img :src="icon" class="size-5" alt="icon" v-if="type==='categorias'">
        <p class="font-semibold text-md capitalize">{{ name }}</p>
</div>

</template>

<style scoped>
    .selected{
        background-color:  #eb5959 !important;
        color : white !important;
        font-weight: bold !important;
        
        
        
    }
    
</style>
