<script setup>
    defineProps({
        categories : Array,
    })

    import { optionSelected } from '@/stores/option.js';

    let option = optionSelected();

    const selectedOption = (event) =>{
        option.setOptionSelected(event.target.value);
    }
</script>


<template>
    <select name="category" id="categoryId" class="p-2 rounded-full  bg-[#F8FCFB] shadow-md outline-none cursor-pointer " @change="selectedOption">
        <option value="Categoría" selected>
            Categoría
        </option>
        <option v-for="(category, index) in categories" :key="index" :value="category.name">
            {{ category }} 
        </option>
    </select>

</template>
