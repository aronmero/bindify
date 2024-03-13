<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import comercio from "@/views/perfiles/comercio.vue";
import particular from "@/views/perfiles/particular.vue";
import ayuntamiento from "@/views/perfiles/ayuntamiento.vue";
import router from "@/router/index.js";
import { ref } from "vue";
const user = JSON.parse(sessionStorage.getItem("usuario"));
let tipoUsuario = ref(user.usuario.tipo);

let username = router.currentRoute.value.params.username;

if (username == undefined) {
  username = user.usuario.username;
  router.push(`/perfil/${username}`)
}
/*
switch (tipoUsuario.value) {
  case "commerce":
    router.push(`/perfil/${username}/comercio`);
    break;
  case "customer":
    router.push(`/perfil/${username}/particular`);
    break;
  
  case "ayuntamiento":
     router.push(`/perfil/${username}/ayuntamiento`);
     break;
  }
  */
</script>

<template>
  <template v-if="router.currentRoute.value.params.username != undefined">
    <particular v-if="tipoUsuario == 'customer'"></particular>
    <comercio v-if="tipoUsuario == 'commerce' || tipoUsuario == 'ayuntamiento'"></comercio>
  </template>
</template>

<style scoped></style>
