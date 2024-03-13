<script setup>
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";

defineProps({
  comercio: String,
  puntos: String,
});
</script>
<template>
  <div class="flex justify-between items-center gap-20 m-4 lg:gap-48">
    <textoEnNegrita :texto="comercio" />
    <textoEnNegrita :texto="puntos" />
  </div>
</template>
<style scoped></style>
