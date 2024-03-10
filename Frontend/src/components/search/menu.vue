<script setup>
    import optionMenu from "@/components/search/menuOption.vue";
    import { defineProps } from "vue";

    defineProps({
        title : String,
        menuOptions : Array
    })

</script>


<template>
    <div class="w-full">
        <div class="text-[#EB5959] font-extrabold mb-4 text-xl tracking-wide">{{ title.toUpperCase() }}</div>
        <a href="#results">
            <div class="flex flex-wrap gap-x-3 gap-y-2">
                <div v-for="(option, index) in menuOptions" :key="index">
                    <optionMenu  :name="option.name" :type="title" />
                </div>
            </div>
        </a>
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
