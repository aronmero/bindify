<script setup>
    defineProps({
        commerce : Object,
    })

    import viewProfileButton from './viewProfileButton.vue';

</script>


<template>
    <div class="w-full flex items-center gap-x-3">
        <img :src="commerce.image" alt="profile-picture" class="size-[120px] rounded-full">
        <div class="flex flex-col justify-center">
            <h1 class="text-[35px]">{{ commerce.name }}</h1>
            <h3 class="text-[20px]">{{ commerce.description }}</h3>
            <div class="flex flex-col flex-start text-sm">
                <h5 class="font-semibold">Horario</h5>
                <p>Lunes a Viernes:</p>
                <p>Sábados:</p>
                <p>Domingos:</p>
            </div>
        </div>
        <div class="flex flex-col items-end text-sm flex-grow">
            <viewProfileButton />
            <p class="font-bold ">Correo: {{ commerce.email }}</p>
            <p class="truncate">{{ commerce.address }}</p>
            <h6 class="font-semibold text-lg">{{ commerce.phone }}</h6>
        </div>
    </div>
</template>