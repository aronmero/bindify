<script setup>
import commercesResults from "@/components/search/commercesResults.vue";
import contenedorSeguido from "@/components/perfiles/containers/contenedorSeguido.vue";
import comercios from "@/data/comerciosData";
import { getUserFollows } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs.js";
import { ref } from "vue";
import { RouterLink } from "vue-router";
let favoritosList = ref(null);

async function responseCatcher(metodo, subRuta) {
  favoritosList.value = await getUserFollows(metodo, subRuta);
  console.log(favoritosList.value);
  favoritosList.value = setDefaultImgs(favoritosList.value);
}
responseCatcher("get", "/api/follows");
</script>
<template>
  <contenedorSeguido
    v-for="follow in favoritosList"
    v-if="follow.favorito"
    :rutaPerfil="follow.avatar"
    :nombre="follow.username"
  ></contenedorSeguido>
</template>
<style scoped></style>
