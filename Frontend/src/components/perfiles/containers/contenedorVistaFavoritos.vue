<script setup>
import commercesResults from "@/components/search/commercesResults.vue";
import contenedorSeguido from "@/components/perfiles/containers/contenedorSeguido.vue";
import comercios from "@/data/comerciosData";
import { getUserFollows } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs.js";
import { ref } from "vue";
import { RouterLink } from "vue-router";
let favoritosList = ref(null);
let filledFavoritos = ref([]);
async function responseCatcher(metodo, subRuta) {
  favoritosList.value = await getUserFollows(metodo, subRuta);

  favoritosList.value = setDefaultImgs(favoritosList.value);

  for (let i = 0; i < favoritosList.value.length; i++) {
    if (favoritosList.value[i].favorito) {
      filledFavoritos.value.push(favoritosList.value[i]);
    }
  }
}
responseCatcher("get", "/api/follows");
</script>
<template>
  <contenedorSeguido
    v-for="comeFavorito in filledFavoritos"
    :rutaPerfil="comeFavorito.avatar"
    :nombre="comeFavorito.username"
  ></contenedorSeguido>
</template>
<style scoped></style>
