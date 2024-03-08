<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import imgsPerfil from "@/components/perfiles/containers/imgsPerfil.vue";
import contenedorBtnsPerfilUser from "@/components/perfiles/containers/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRectangular from "@/components/perfiles/widgets/imgRectangular.vue"
import { users } from "@/components/perfiles/helpers/users.js";


</script>

<template >
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <div class="flex flex-col gap-6">
      <div>
        <imgsPerfil
          rutaBaner="https://placehold.co/600x400"
          altTextBaner="foto baner"
          :rutaPerfil="users[0].avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>
      <div class="flex flex-col gap-6 justify-evenly md:flex-row">
        <textoEnNegrita :texto="users[0].name" class="text-base md:text-xl" />
      </div>
      <imgRectangular ruta=""></imgRectangular>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
