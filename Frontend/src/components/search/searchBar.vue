<script setup>
    import { ref  } from 'vue';

    defineProps({
      placeholder : String
    })

    let searchValue = ref(""); //almacena el valor del input de busqueda

    import { inputSearch } from '@/stores/inputSearch.js'; //store que almacena el valor del input de busqueda
  
    const searchElement = () => { 
        inputSearch().setInputSearch(searchValue.value); //cada vez que se escribe en el input de busqueda se actualiza el valor del store
    };

    const scrollToSectionResults = () => { //funcion que hace scroll hasta la seccion de resultados
        const results = document.getElementById('results');
        results.scrollIntoView({ behavior: 'smooth' });
    };

</script>

<template>
    <div class="relative w-full">
    <input class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 bg-[#f3f2f2]" type="search" :placeholder="placeholder" v-model="searchValue" @input="searchElement" @keyup.enter="scrollToSectionResults">
    <button class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-700 bg-[#eb5959] border border-gray-300 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" @click="scrollToSectionResults">
    <svg class="size-5" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.795 13.408l5.204 5.204a1 1 0 01-1.414 1.414l-5.204-5.204a7.5 7.5 0 111.414-1.414zM8.5 14A5.5 5.5 0 103 8.5 5.506 5.506 0 008.5 14z" />
    </svg>
  </button>
</div>


</template>

<style scoped>

</style>