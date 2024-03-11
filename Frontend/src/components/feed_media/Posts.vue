<script setup>
    // import { posts } from './mocks/posts.js';
    import Feed from './tipos_post/TipoPost.vue';
    
    import {obtener_posts} from '@/api/home/publicaciones';
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user);

    const posts_request = await obtener_posts();
    const posts = posts_request;

    console.log(posts_request);
</script>

<template>
    <Suspense>
        <Feed 
            v-if="posts.length >= 1" 
            v-for="post in posts" 
            :post="post"
        /> 
    </Suspense>
</template>

<style scoped lang="scss">
    
</style>