<script setup>
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRedonda from "@/components/perfiles/widgets/imgRedonda.vue";
defineProps({
  "rutaPerfil": String,
  "nombre": String,
  
});
</script>
<template>
  <div class="flex flex-col">
            <div>
              <imgRedonda :ruta="rutaPerfil"></imgRedonda>
              <textoEnNegrita :texto="nombre" class="text-base md:text-xl" />
            </div>
            <textoNormal
              :texto="tipo"
              class="text-sm md:text-base"
            ></textoNormal>
          </div>
</template>
<style scoped></style>
