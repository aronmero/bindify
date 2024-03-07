<script setup>
import btnConImg from "@/components/btnConImg.vue";
import textoEnNegrita from "@/components/textoEnNegrita.vue";
import textoNormal from "@/components/textoNormal.vue";

defineProps({
  puntuacion: String,
  cantidadResenias: String,
});
</script>
<template>
  <div class="flex flex-col justify-center items-center">
    <div class="flex flex-row justify-center items-center">
      <btnConImg ruta="/assets/icons/christmasStar.svg" altText="icono de estrella"></btnConImg>
      <textoEnNegrita :texto="puntuacion" class="text-lg md:text-xl" />
    </div>
    <textoNormal :texto="cantidadResenias"></textoNormal>
  </div>
</template>
<style scoped></style>
