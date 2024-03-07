<script setup>
import textoEnNegrita from "@/components/textoEnNegrita.vue";

defineProps({
  comercio: String,
  puntos: String,
});
</script>
<template>
  <div class="flex justify-center items-center gap-20 m-4 md:gap-48">
    <textoEnNegrita :texto="comercio" />
    <textoEnNegrita :texto="puntos" />
  </div>
</template>
<style scoped></style>
