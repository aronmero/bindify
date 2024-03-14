<script setup>

    const props=defineProps({
        commerce : Object,
    })

    if(props.commerce.avatar=="default"){
        props.commerce.avatar="public/img/placeholderPerfil.webp";
}
    import router from '@/router';
    import { setRandomGradient } from '@/utils/randomGradient.js';

    const redirect = (username) => {
        router.push(`perfil/${username}`);
    }

    import StarSVG from '@public/assets/icons/star.svg';
    import StarEmptySVG from '@public/assets/icons/starEmpty.svg';
 
</script>

<template>
    <div class="flex items-center gap-x-2 p-2 transition-colors duration-300 ease-in hover:bg-[#eeeeee] cursor-pointer" loading="lazy" @click="redirect(props.commerce.username)"  >
        <img :src="props.commerce.avatar" alt="profile-image" class="size-20 rounded-full" />
        <div class="flex flex-col flex-1 m-1 gap-y-4">
            <div class="flex flex-col md:flex-row  items-start md:items-center gap-x-2">
                <h1 class="font-medium text-[1.3em] md:text-[1.7em]">{{ props.commerce.username }}</h1>
                <div class="flex gap-x-2 items-center">
                    <div class="flex items-center mt-1 rating h-[fit-content] justify-start " v-if="props.commerce.avg != null">
                <img class="size-4" :src="StarSVG" v-for="index in Math.floor(props.commerce.avg)" alt="star" loading="lazy"
                    :title="props.commerce.avg" />
                <img class="size-3.5" :src="StarEmptySVG" v-for="index in (5 - Math.floor(props.commerce.avg))" alt="star" loading="lazy"
                    :title="props.commerce.avg" />
                <small class="ml-1 text-xs">({{ props.commerce.avg.toFixed(2) }})</small>  
            </div>
        </div>
                
        </div>
            <div class="flex flex-wrap items-center gap-x-2 gap-y-2 text-xs">
                <p v-if="props.commerce.hashtags.length === 0">Sin hashtags</p> 
                    <ul v-for="(hastag, index) in props.commerce.hashtags" :key="index" >
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

