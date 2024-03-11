<script setup>


    defineProps({
        commerce : Object,
    })

    import starSVG from '/assets/icons/star.svg';

    import { setRandomGradient } from '@/utils/randomGradient.js';

 

</script>


<template>
    <!--
    <div class="flex items-center gap-x-2 p-2 transition-colors duration-300 ease-in hover:bg-[#eeeeee] cursor-pointer">
        <img :src="commerce.image" alt="profile-image" class="size-20 rounded-full" />
        <div class="flex flex-col flex-1 m-1">
            <div class="flex items-center gap-x-2">
                <h1 class="font-bold text-[1.6em] md:text-[1.8em]">{{ commerce.name }}</h1>
                <div class="flex items-center mt-1">
                    <img :src="starSVG" alt="star" class="size-5 md:size-7" />
                    <p class="font-bold text-[1em] md:text-[1.4em]">{{ commerce.qualification.note }}</p>
                </div>
                <small class="text-xs mt-2">{{ commerce.qualification.reviews }} votos</small>
            </div>
            <div class="flex items-center justify-between m-1">
                <div>
                    <h2 class="text-[#818181] font-semibold  text-[1.2em] md:text-[1.5em] mt-[-0.4em] md:mt-[-1.2rem]">{{ commerce.category }}</h2>
                    <div class="flex flex-wrap items-center gap-x-2 text-xs">
                        <ul v-for="(hastag, index) in commerce.hastags" :key="index" >
                            <li :style="{ background: setRandomGradient() }" class="p-1 font-bold text-white rounded-full transition duration-100 ease-in hover:scale-105">{{ hastag }}</li>
                        </ul>
                    </div>
                </div>
                <div class="flex-col text-xs items-end hidden md:flex">
                    <p class="font-semibold">Contacto </p>
                    <p>{{ commerce.phone }}</p>
                    <p>{{ commerce.email }}</p>
                    <p>{{ commerce.address }}</p>
                </div>
            </div>
        </div>
    </div>
    -->
    <h1> {{ commerce.username }}</h1>
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

