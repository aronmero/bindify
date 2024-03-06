<script setup>
//DE LA VISTA VALIDAR COMERCIO
const array = ["Notificaciones", "Solicitudes verificación"];
</script>

<template>
    <div><img src="@public/assets/icons/arrowLeft.svg" class="lg:hidden absolute left-[20px]">
        <div class="ml-[10px] gap-[25px] flex justify-center"><div v-for=" item in array" class="text-[12px] font-semibold">{{ item }}</div></div>
    </div>
</template>

<style scoped></style>
