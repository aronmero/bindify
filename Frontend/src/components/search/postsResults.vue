<script setup>
    defineProps({
        posts : Array
    })

    import postCard from './postCard.vue';


</script>

<template>
    
    <section class="flex  flex-col gap-y-2">
        <postCard v-for="post in posts" :post="post" :tipo="post.post_type" />
    </section>
</template>