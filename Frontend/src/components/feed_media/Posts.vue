<script setup>
    // import { posts } from './mocks/posts.js';
    import Feed from './tipos_post/TipoPost.vue';
    
    import {obtener_posts, obtener_posts_seguidos} from '@/api/home/publicaciones';
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user);

    // const posts_feed = await obtener_posts_seguidos();
    //let posts = posts_feed.data;

    const posts_request = await obtener_posts();
    let posts = posts_request.data;
    console.log(posts);
    
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