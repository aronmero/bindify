<script setup>
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRedonda from "@/components/perfiles/widgets/imgRedonda.vue";
import contenedorPuntuacion from "@/components/perfiles/containers/contenedorPuntuacion.vue";
import { RouterLink } from "vue-router";
import router from "@/router/index.js"
defineProps({
  rutaPerfil: String,
  nombre: String,
  texto: String,
  fecha: String,
  titulo: String,
  imagen: String,
  imagenAltText: String,
});

function irAPerfil(evento){
  router.push(`/perfil/${evento.target.id}/`)
  setTimeout(()=>{router.go()},100)
}
</script>
<template>
  <div class="flex flex-col border-b">
    <div class="flex justify-start">
      <imgRedonda :ruta="rutaPerfil"></imgRedonda>
      <div class="flex flex-col">

          <textoEnNegrita  @click="irAPerfil"  :id="nombre" :texto="nombre" class="text-base lg:text-xl" />
        

        <textoNormal :texto="fecha" class="text-sm lg:text-base"></textoNormal>
      </div>
      <div class="flex justify-end w-full hidden">
        <contenedorPuntuacion puntuacion="4"></contenedorPuntuacion>
      </div>
    </div>
    <div class="flex flex-col">
      <textoEnNegrita :texto="titulo" class="text-base lg:text-xl" />
      <textoNormal
        :texto="texto"
        class="text-sm lg:text-base pb-2"
      ></textoNormal>
      <img :src="imagen" :alt="imagenAltText" class="scale-90" />
    </div>
  </div>
</template>
<style scoped></style>
