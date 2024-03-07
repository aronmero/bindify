<script setup>
    import { posts } from './posts.js';
    import Feed from './tipos_post/TipoPost.vue';
  
</script>

<template>
     <Feed 
        v-for="post in posts" 
        :post="post"
    /> 
</template>

<style scoped lang="scss">
    
</style>