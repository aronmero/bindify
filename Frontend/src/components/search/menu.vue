<script setup>
    import optionMenu from "@/components/search/menuOption.vue";
    import menuOptions from "@/data/menuData.js";

    const emit = defineEmits([
        "selectedOption"
    ])

    const selectedOption = (name) =>{
        emit("selectedOption", name);
    }

</script>

<template>
    <div class="flex items-center p-2 shadow-2xl w-full bg-white gap-x-10 overflow-y-auto">
        <div v-for="(option, index) in menuOptions" :key="index" >
            <optionMenu :icon="option.icon" :name="option.name" @selectedOption="selectedOption"/>
        </div>
    </div>
</template>


<style scoped>
    ::-webkit-scrollbar {
        display: none;
    }


</style>