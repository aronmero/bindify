<script setup>
    defineProps({
        post: Object
    })
    import { datetranslatesql } from '@/components/feed_media/helpers/datetranslate.js'
    import StarSVG from '@public/assets/icons/star.svg';
import StarEmptySVG from '@public/assets/icons/starEmpty.svg';

import ShareSVG from '@public/assets/icons/share.svg';
import ChatSVG from '@public/assets/icons/chat.svg';
import BookmarkEmptySVG from '@public/assets/icons/bookmark_empty.png'
import BookmarkSVG from '@public/assets/icons/bookmark.png';

import MoreSVG from '@public/assets/icons/ellipsis.svg';
import UserSVG from '@public/assets/icons/user.svg';


const redirect = (url) => {
    router.push(url)
}

import router from '@/router';
</script>


<template>
    <div class=" post-header w-[100%] h-[60px] flex items-center ">
                    <div class=" avatar-wrapper w-[50px] h-[50px] rounded-full overflow-hidden mr-2 ">
                        <img @click="redirect(`perfil/${post.username}`)"
                            class=" cursor-pointer w-[100%] h-[100%] object-cover  " :src="post.avatar"
                            alt="avatar_usuario">
                    </div>
                    <div class=" flex flex-col items-start texts w-[100%]  h-[100%]  ">
                        <b @click="redirect(`perfil/${post.username}`)" class="cursor-pointer">{{ post.username }}</b>
                        <small>{{ datetranslatesql(post.start_date) }}</small>
                        <button click="" class=" rating flex h-[fit-content] items-center justify-start "
                            v-if="post.avg != null">
                            <img class="  " :src="StarSVG" v-for="index in Math.floor(post.avg)" alt="star"
                                loading="lazy" :title="post.avg" />
                            <img class=" " :src="StarEmptySVG" v-for="index in (5 - Math.floor(post.avg))" alt="star"
                                loading="lazy" :title="post.avg" />
                            <small>({{ post.avg.toFixed(2) }})</small>
                        </button>
                    </div>
                    <button @click="() => abrirModal(post.id)" class="mr-4">
                        <img :src="MoreSVG" alt="dots">
                    </button>
                </div>
                <div
                    class=" post-content w-[100%] h-[300px] sm:h-[300px] md:h-[400px] lg:h-[500px] xl:h-[600px] 2xl:h-[600px] rounded-2xl  overflow-hidden mt-5 ">
                    <img @click="redirect(`post/${post.post_id}`)"
                        class=" cursor-pointer w-[100%] h-[100%] object-cover " :src="post.image" :alt="post.titulo">
                </div>
                <!-- Contenido del Post -->
                <div class="information ">
                    <h1 class="text-sm">
                        
                        {{ post.title }}
                    </h1>
                    <span>
                        {{ post.description }}
                    </span>
                    <div class=" hashtags flex">
                        <a class=" hashtag mr-[10px] font-bold " :href="`busqueda/${hashtag}`"
                            v-for="hashtag in post.hashtags"> #{{
                hashtag }}</a>
                    </div>

                </div>

         

                    






</template>