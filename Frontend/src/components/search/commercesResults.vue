<script setup>
    defineProps({
        comercios : Array
    })


    import commerceCard from "./commerceCard.vue";


</script>

<template>
    <section class="flex flex-col gap-y-5">
        <div v-for="comercio in comercios" >
            <commerceCard :commerce="comercio" />
        </div>        
    </section>
</template>