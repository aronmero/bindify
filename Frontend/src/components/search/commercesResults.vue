<script setup>
    defineProps({
        category : String
    })

    import comercios from "@/data/comerciosData.js";
    import commerceCard from "./commerceCard.vue";
</script>

<template>
    <section class="flex flex-col gap-y-6">
        <div v-for="comercio in comercios ">
            <commerceCard :commerce="comercio" v-if="comercio.category === category"/>
        </div>
    </section>
</template>