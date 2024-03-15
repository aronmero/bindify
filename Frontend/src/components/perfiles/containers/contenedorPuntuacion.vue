<script setup>
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";

defineProps({
  puntuacion: String,
  cantidadResenias: String,
});
</script>
<template>
  <div
    class="flex flex-col justify-center items-center bg-slate-200 rounded-md px-2 pt-1 h-fit"
  >
    <div class="flex flex-row justify-center items-center w-14">
      <btnConImg
        ruta="/assets/icons/christmasStar.svg"
        altText="icono de estrella"
      ></btnConImg>
      <textoEnNegrita :texto="puntuacion" class="text-lg lg:text-2xl" />
    </div>
    <textoNormal :texto="cantidadResenias" class="lg:text-lg"></textoNormal>
  </div>
</template>
<style scoped></style>
