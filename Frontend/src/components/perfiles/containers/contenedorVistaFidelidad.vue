<script setup>
import contenedorPuntosFidelidad from "@/components/perfiles/containers/contenedorPuntosFidelidad.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
</script>
<template>
  <div>
    <div class="flex justify-around">
      <textoEnNegrita texto="Tus puntos" class="text-base lg:text-xl" />
      <btnConImg
        ruta="/assets/icons/activityHistory.svg"
        altText="icono codigo qr"
        :borde="true"
        
      ></btnConImg>
    </div>
    <div class="flex-col justify-center items-center">
      <contenedorPuntosFidelidad
        comercio="José Informática"
        puntos="500"
        class="text-sm lg:text-base"
      />
      <contenedorPuntosFidelidad
        comercio="José Informática"
        puntos="500"
        class="text-sm lg:text-base"
      />
      <contenedorPuntosFidelidad
        comercio="José Informática"
        puntos="500"
        class="text-sm lg:text-base"
      />
    </div>
  </div>
</template>
<style scoped></style>
