<script setup>
    import optionMenu from "@/components/search/menuOption.vue";
    import { defineProps } from "vue";

    defineProps({
        title : String,
        menuOptions : Array
    })

</script>


<template>
    <div class="w-full ">
        <div class="font-bold mb-4 text-xl tracking-wide ">filtrar por {{ title }}</div>
        <a href="#results">
            <div class="flex flex-wrap gap-x-3 gap-y-2">
                <div v-for="(option, index) in menuOptions" :key="index">
                    <optionMenu  :name="option.name" :type="title" :icon="option.icon"/>
                </div>
            </div>
        </a>
    </div>
</template>



<style scoped>
    ::-webkit-scrollbar {
        display: none;
    }

   
   
</style>
