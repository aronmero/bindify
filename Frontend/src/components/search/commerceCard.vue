<script setup>


    defineProps({
        commerce : Object,
    })

    import starSVG from '/assets/icons/star.svg';
    import router from '@/router';
    import { setRandomGradient } from '@/utils/randomGradient.js';

    const redirect = (username) => {
        router.push(`perfil/${username}`);
    }
 
</script>

<template>
    
    <div class="flex items-center gap-x-2 p-2 transition-colors duration-300 ease-in hover:bg-[#eeeeee] cursor-pointer" loading="lazy" @click="redirect(commerce.username)"  >
        <img :src="commerce.avatar" alt="profile-image" class="size-20 rounded-full" />
        <div class="flex flex-col flex-1 m-1 gap-y-4">
            <div class="flex items-center gap-x-2">
                <h1 class="font-medium text-[1.3em] md:text-[1.7em]">{{ commerce.username }}</h1>
                <div class="flex items-center mt-1">
                    <img :src="starSVG" alt="star" class="size-5 md:size-7" v-if="commerce.avg >0" />
                    <p class="font-bold text-[0.8em] md:text-[1.4em]" v-if="commerce.avg >0">{{ commerce.avg }}</p>
                </div>
                <div v-if="commerce.review_count === 0">
                    Sin calificar
                </div>
                <div v-else>
                    <small class="text-[0.7em] md:text-[0.8em]">({{ commerce.review_count }} votos)</small>
                </div>
              
            </div>
                <div class="flex flex-wrap items-center gap-x-2 gap-y-2 text-xs">
                   <p v-if="commerce.hashtags.length === 0">Sin hashtags</p> 
                     <ul v-for="(hastag, index) in commerce.hashtags" :key="index" >
                        <li :style="{ background: setRandomGradient() }" class="p-1 text-[10px] font-bold text-white rounded-md">#{{ hastag }}</li>
                    </ul>
                </div>    
        </div>
    </div>
    
 
</template>


<style scoped>
    .fade-in {
        animation: fadeIn cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.75s both;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

