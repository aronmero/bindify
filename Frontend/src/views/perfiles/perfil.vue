<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import comercio from "@/views/perfiles/comercio.vue";
import particular from "@/views/perfiles/particular.vue";
import ayuntamiento from "@/views/perfiles/ayuntamiento.vue";

import { ref } from "vue";
// let tipoUsuario = ref("comercio");
let tipoUsuario = ref("particular");
// let tipoUsuario = ref("ayuntamiento");
</script>

<template>
  <comercio v-if="tipoUsuario == 'comercio'"></comercio>
  <particular v-if="tipoUsuario == 'particular'"></particular>
  <ayuntamiento v-if="tipoUsuario == 'ayuntamiento'"></ayuntamiento>
</template>

<style scoped></style>
