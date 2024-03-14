<script setup>
import {ref} from 'vue';

import { filtros } from './mocks/filtros';

import {obtener_followers} from '@/Api/home/users'
import { obtener_posts, obtener_posts_seguidos } from '@/Api/home/publicaciones';
import { useHomeStore } from "@/stores/home.js";
import Seguido from './widgets/Seguido.vue';
import Filtros from './widgets/Filtros.vue'
import Feed from './tipos_post/TipoPost.vue';

const user = JSON.parse(sessionStorage.getItem("usuario"));
const storePost = useHomeStore();
let post_data;
if (!storePost.isActivo) {
    let posts_request = await obtener_posts_seguidos();

    if(posts_request.data.length <= 10) posts_request = await obtener_posts();
    post_data=posts_request.data;

    storePost.add(post_data);
}else{
    post_data = storePost.data;
}
const seguidos_req = await obtener_followers();
const seguidos = seguidos_req.data;

console.log(seguidos);
const posts = post_data;
console.log(posts);
</script>

<template>
    <div class=" seguidos flex items-center justify-start w-[100%]  p-[10px_0px] m-[20px_0px]  rounded-md min-w-[100px] overflow-y-hidden overflow-y-auto ">
        <Seguido v-for="seguido in seguidos" :user="seguido"></Seguido>
    </div>
    <div class="flex filters">
        <Filtros :filtros="filtros"></Filtros>
    </div>
    <Feed v-for="post in posts" :post="post" />
</template>

<style scoped lang="scss">
    *::-webkit-scrollbar {
        display:none;
    }
    .seguidos {
        //background:linear-gradient(180deg, rgb(234, 67, 67, 1), rgb(237, 175, 74, 1));
        //background:#e4e0e0;
        //box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
</style>