<script setup>
import commercesResults from "@/components/search/commercesResults.vue";
import contenedorSeguido from "@/components/perfiles/containers/contenedorSeguido.vue";
import comercios from "@/data/comerciosData";
import { getUserFollows } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import { ref } from "vue";
import { RouterLink } from "vue-router";

let followsList = ref(null); 

async function responseCatcher(metodo, subRuta) {
  followsList.value = await getUserFollows(metodo, subRuta);
  followsList.value = setDefaultImgs(followsList.value);
}
responseCatcher("get", "/api/follows");
</script>
<template>
  <contenedorSeguido
    v-for="follow in followsList"
    :rutaPerfil="follow.avatar"
    :nombre="follow.username"
  ></contenedorSeguido>
</template>
<style scoped></style>
