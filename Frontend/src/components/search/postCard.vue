<script setup>
    defineProps({
        post: Object
    })
    import { datetranslatesql } from '@/components/feed_media/helpers/datetranslate.js'
    import StarSVG from '@public/assets/icons/star.svg';
    import StarEmptySVG from '@public/assets/icons/starEmpty.svg';



const redirect = (url) => {
    router.push(url)
}


import router from '@/router';

import TipoOferta from '@public/assets/icons/tipo_oferta.svg'
import TipoEvento from '@public/assets/icons/tipo_evento.svg'
import { setRandomGradient } from '@/utils/randomGradient.js';




</script>


<template>
   
    <div class=" post-header w-[100%] h-[60px] flex items-center">
        <div class=" avatar-wrapper w-[50px] h-[50px] rounded-full overflow-hidden mr-2 ">
            <img @click="redirect(`perfil/${post.username}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover  "
                :src="post.avatar" alt="avatar_usuario">
        </div>
        <div class=" flex flex-col items-start texts w-[100%]  h-[100%]  ">
            <b @click="redirect(`perfil/${post.username}`)" class="cursor-pointer">{{ post.username }}</b>
            <small>{{ datetranslatesql(post.start_date) }}</small>
            <button click="" class=" rating flex h-[fit-content] items-center justify-start " v-if="post.avg != null">
                <img class="" :src="StarSVG" v-for="index in Math.floor(post.avg)" alt="star" loading="lazy"
                    :title="post.avg" />
                <img class=" " :src="StarEmptySVG" v-for="index in (5 - Math.floor(post.avg))" alt="star" loading="lazy"
                    :title="post.avg" />
                <small>({{ post.avg.toFixed(2) }})</small>
            </button>
        </div>
    </div>
    <div
        class=" post-content w-[100%] h-[300px] sm:h-[300px] md:h-[400px] lg:h-[500px] xl:h-[600px] 2xl:h-[600px] rounded-2xl  overflow-hidden  ">
        <img @click="redirect(`post/${post.post_id}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover "
            :src="post.image" :alt="post.titulo">
    </div>
    <!-- Contenido del Post -->
    <div class="information">
        <h2 class="flex items-center gap-x-2 font-medium mt-3 mb-3 text-[18px]">
            <img :src="post.post_type === 'Post' ? TipoOferta : TipoEvento" alt="icono-evento" loading="lazy"
                class="size-8 rounded-full bg-[#fe822f] p-1">
            {{ post.title }}
        </h2>
        <span >
            {{ post.description }}
        </span>
        <div class=" hashtags flex mb-10 mt-3">
            <a :style="{ background: setRandomGradient() }" class="hashtag mr-[10px] font-bold text-white rounded-md text-xs p-1 hover:text-white"  v-for="hashtag in post.hashtags"> #{{
                hashtag }}</a>
        </div>

    </div>
    
</template>