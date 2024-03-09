<script setup>
    import optionMenu from "@/components/search/menuOption.vue";
    import menuOptions from "@/data/menuData.js";
    import arrowRightSVG from "/assets/icons/arrow-right.svg";
    import arrowLeftSVG from "/assets/icons/arrow-left.svg";
    import { ref } from "vue";

    const scrollContainer = ref(null); //referencia al container donde haremos el scroll

    const scrollLeft = () => {
        scrollContainer.value.scrollLeft -= 200; 
    };

    const scrollRight = () => {
        scrollContainer.value.scrollLeft += 200; 
    };
</script>


<template>
    <div class="relative w-full overflow-hidden shadow-2xl">
        <div class="absolute sm:hidden left-0  flex items-center h-full" @click="scrollLeft">
            <img :src="arrowLeftSVG" class="size-6 cursor-pointer">
        </div>

        <div class="absolute sm:hidden right-0  flex items-center h-full" @click="scrollRight">
            <img :src="arrowRightSVG" class="size-6 cursor-pointer">
        </div>

        <div class="flex items-center p-3  w-full bg-white gap-x-5 overflow-x-auto" ref="scrollContainer" style="scroll-behavior: smooth;">
            <div v-for="(option, index) in menuOptions" :key="index">
                <optionMenu :icon="option.icon" :name="option.name" />
            </div>
        </div>
    </div>
</template>



<style scoped>
    ::-webkit-scrollbar {
        display: none;
    }

   
    .scroll-container {
        scroll-behavior: smooth;
    }
</style>
