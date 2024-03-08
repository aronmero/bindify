<script setup>
//DE LA VISTA VALIDAR COMERCIO
const array = ["Notificaciones", "Solicitudes verificación"];
</script>

<template>
    <div><a @click="$router.back()"><img src="@public/assets/icons/arrowLeft.svg" class="lg:hidden absolute left-[20px]  cursor-pointer"></a>
        <div class="ml-[10px] gap-[25px] flex justify-center">
            <div v-for=" item in array" class="text-[12px] font-semibold cursor-pointer">{{ item }}</div>
        </div>
    </div>
</template>

<style scoped></style>
