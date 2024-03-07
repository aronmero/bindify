<script setup>
    defineProps({
        commerce : Object,
    })

    import viewProfileButton from './viewProfileButton.vue';
    import starSVG from '/assets/icons/star.svg';

</script>


<template>
    <div class="w-full flex items-center gap-x-2 md:gap-x-3  md:mt-0 mb-2 md:mb-4 fade-in">
        <img :src="commerce.image" alt="profile-picture" class="size-[60px] md:size-[130px] rounded-full">
        <div class="flex flex-col justify-center">
            <div class="flex items-center gap-x-1"><h1 class="text-[22px] md:text-[28px] font-semibold ">{{ commerce.name }}</h1><span class="flex inline-items  md:mt-2"><img :src="starSVG" class="size-5 mt-2 md:mt-0 md:size-8"><p class="text-[18px] md:text-[25px] font-bold mt-[6px] md:mt-0">{{ commerce.qualification.note }}</p> <p class="text-[9px] md:text-xs mt-4 cursor-pointer hover:underline">({{ commerce.qualification.reviews }})</p> </span></div>
            <h3 class="text-[17px] md:text-[20px] text-[#7d7d7d] mt-[-5px] md:mt-[-10px] truncate">{{ commerce.description }}</h3>
            <div class="md:flex flex-col flex-start text-sm hidden">
                <h5 class="font-bold">Horario</h5>
                <p>Lunes a Viernes:</p>
                <p>Sábados:</p>
                <p>Domingos:</p>
            </div>
        </div>
        <div class="flex flex-col items-end text-sm flex-grow">
            <viewProfileButton />
            <p class="font-bold hidden md:block">Correo: {{ commerce.email }}</p>
            <p class="md:flex items-center truncate hidden">{{ commerce.address }}</p>
            <h6 class="font-semibold text-lg  hidden md:block">{{ commerce.phone }}</h6>
        </div>
    </div>
    <hr>
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