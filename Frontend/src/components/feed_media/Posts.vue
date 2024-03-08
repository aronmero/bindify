<script setup>
    import { posts } from './mocks/posts.js';
    import Feed from './tipos_post/TipoPost.vue';
  
</script>

<template>
    <Suspense>
        <Feed 
                v-for="post in posts" 
                :post="post"
        /> 
    </Suspense>
</template>

<style scoped lang="scss">
    
</style>