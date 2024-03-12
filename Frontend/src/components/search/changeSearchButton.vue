<script setup>
    import {ref} from 'vue';

    let actualSection = ref("comercios");
    let showSection = ref("posts");

    const emit = defineEmits([
        "changeSection"
    ])

    const toggleSection = () =>{
        scrollTo(0,0);
        actualSection.value === "comercios" ? actualSection.value = "posts" : actualSection.value = "comercios";
        showSection.value === "comercios" ? showSection.value = "posts" : showSection.value = "comercios";
        emit("changeSection", actualSection.value);
    }

</script>

<template>
    <button class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-30 bg-[#eb5959] font-bold text-white p-2 md:p-3 rounded-full mb-16 md:mb-4 md:m-4 transition-all duration-300 ease-in hover:scale-105 " @click="toggleSection">
    buscar  {{ showSection }}
</button>

</template>