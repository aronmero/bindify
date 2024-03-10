<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import imgsPerfil from "@/components/perfiles/containers/imgsPerfil.vue";
import contenedorBtnsPerfilUser from "@/components/perfiles/containers/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRectangular from "@/components/perfiles/widgets/imgRectangular.vue";

import btnAtras from "@/components/perfiles/containers/btnAtras.vue";
import { users } from "@/components/perfiles/helpers/users.js";
</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <btnAtras titulo="Tarjeta Fidelidad"></btnAtras>
    <div class="flex flex-col gap-1 items-center">
      <div>
        <imgsPerfil
          rutaBaner="https://placehold.co/600x400"
          altTextBaner="foto baner"
          :rutaPerfil="users[0].avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>
      <div class="flex flex-col justify-evenly lg:flex-row">
        <textoEnNegrita :texto="users[0].name" class="text-base lg:text-xl" />
      </div>
      <imgRectangular
        ruta="/img/codigo-qr.svg"
        class="size-80"
      ></imgRectangular>
      <div class="flex flex-col justify-center gap-x-2 lg:flex-row mb-3">
        <textoNormal texto="Tu número de identificación es:"></textoNormal>
        <textoEnNegrita texto="U1hP8e4Vw9kN7Z3cE2gS"></textoEnNegrita>
      </div>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
