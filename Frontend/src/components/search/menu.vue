<script setup>
    import optionMenu from "@/components/search/menuOption.vue";
    import menuOptions from "@/data/menuData.js";
    //import arrowRightSVG from "/assets/icons/arrow-right.svg";
    //import arrowLeftSVG from "/assets/icons/arrow-left.svg";
    import { ref } from "vue";

    const scrollContainer = ref(null); 

    /*const scrollLeft = () => {
        scrollContainer.value.scrollLeft -= 100; 
    };

    const scrollRight = () => {
        scrollContainer.value.scrollLeft += 100; 
    };*/
</script>


<template>
    <div class="w-full overflow-hidden">
        <!--<div class="absolute left-0  flex items-center h-full" @click="scrollLeft">
            <img :src="arrowLeftSVG" class="size-6 cursor-pointer ">
        </div>-->

        <!--<div class="absolute right-0  flex items-center h-full" @click="scrollRight">
            <img :src="arrowRightSVG" class="size-6 cursor-pointer">
        </div> -->

        <div class="flex items-center p-3 shadow-2xl w-full bg-white gap-x-10 " ref="scrollContainer" >
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

    
</style>
