<script setup>
    import {ref} from 'vue';

    let actualSection = ref("comercios");
    let showSection = ref("hashtags");

    const emit = defineEmits([
        "changeSection"
    ])

    const toggleSection = () =>{
        actualSection.value === "comercios" ? actualSection.value = "hashtags" : actualSection.value = "comercios";
        showSection.value === "comercios" ? showSection.value = "hashtags" : showSection.value = "comercios";
        emit("changeSection", actualSection.value);
    }

</script>

<template>
    <button class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-30 bg-[#eb5959] font-bold text-white p-3 rounded-full m-4 transition-all duration-300 ease-in hover:scale-105 " @click="toggleSection">
    buscar por {{ showSection }}
</button>

</template>