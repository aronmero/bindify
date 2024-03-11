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
console.log(user.usuario.tipo);
let tipoUsuario = ref(user.usuario.tipo);

const username=router.currentRoute.value.params.username

console.log(username)

if(username ==undefined){
  switch(tipoUsuario.value){
    case "commerce":
        router.push("/perfil/comercio")
      break;
    case "customer":
      router.push("/perfil/customer")
      break;
    case "ayuntamiento":
      router.push("/perfil/ayuntamiento")
      break;
  }

}else{
  console.log("ver perfil otro usuario")
}

</script>

<template>

</template>

<style scoped></style>
