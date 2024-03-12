<script setup>
    // import { posts } from './mocks/posts.js';
    import Feed from './tipos_post/TipoPost.vue';
    import { filtros } from './mocks/filtros';
    import Filtros from './widgets/Filtros.vue'
    
    import {obtener_posts, obtener_posts_seguidos} from '@/Api/home/publicaciones';
    const user = JSON.parse(sessionStorage.getItem("usuario"));

    // primero se lee los usuarios de su feed
    //const posts_feed = await obtener_posts_seguidos();
    //let posts = posts_feed.data;
    //console.log(posts);
    //if(posts_feed.data.length == 0) {
        // sino se obtienen los posts por defecto
        const posts_request = await obtener_posts();
        console.log("obtenido feed por defecto");
        const posts = posts_request.data;
    //}
    
</script>

<template>
    <div class="flex filters">
        <Filtros :filtros="filtros"></Filtros>
    </div>
    <Suspense>
        <Feed 
            v-for="post in posts" 
            :post="post"
        /> 
    </Suspense>
</template>

<style scoped lang="scss">
    
</style>