<script setup>
    defineProps({
        comercios : Array
    })


    import commerceCard from "./commerceCard.vue";


</script>

<template>
    <section class="flex flex-col mb-4">
        <div v-for="comercio in comercios" >
            <commerceCard :commerce="comercio" />
        </div>        
    </section>
</template>