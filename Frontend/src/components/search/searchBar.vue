<script setup>
    import { ref, defineEmits  } from 'vue';
    let value = ref("");

    const emit = defineEmits(["searchElement"]);

    const searchElement = () => {
        emit("searchElement", value);
    };

</script>

<template>
    <input type="text" placeholder="Buscar..." v-model="value" class="rounded-full flex-1 p-2 bg-[#F8FCFB] shadow-xl text-md outline-[#EB5959]" @input="searchElement">
</template>

<style scoped>

</style>