<script setup>
import comercio from "@/views/perfiles/comercio.vue";

import router from "@/router/index.js";

const user = JSON.parse(sessionStorage.getItem("usuario"));

let username = router.currentRoute.value.params.username;

if (username == undefined) {
  username = user.usuario.username;
  router.push(`/perfil/${username}`);
}

</script>

<template>
  <template v-if="router.currentRoute.value.params.username != undefined">
    <comercio></comercio>
    
  </template>
</template>

<style scoped></style>
