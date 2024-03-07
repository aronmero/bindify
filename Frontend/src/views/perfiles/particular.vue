<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import imgsPerfil from "@/components/imgsPerfil.vue";
import contenedorBtnsPerfilUser from "@/components/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/textoEnNegrita.vue";
import textoNormal from "@/components/textoNormal.vue";
import { users } from "@/components/users.js";
import { RouterLink, RouterView } from "vue-router";

</script>

<template >
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <div class="flex flex-col gap-6">
      <div>
        <imgsPerfil
          rutaBaner=""
          altTextBaner="foto baner"
          :rutaPerfil="users[0].avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>
      <div class="flex flex-col gap-6 justify-evenly md:flex-row">
        <div class="flex flex-col">
          <textoEnNegrita :texto="users[0].name" class="text-base md:text-xl" />
          <textoEnNegrita texto="15" class="text-base md:text-xl" />
          <textoNormal
            texto="Following"
            class="text-sm md:text-base"
          ></textoNormal>
        </div>

        <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser>
      </div>
      <div class="flex w-full justify-center gap-6">
        <RouterLink to="/particular/fidelidad">
          <textoEnNegrita texto="Fidelidad" class="text-sm md:text-base" />
        </RouterLink>
        <RouterLink to="/particular/favoritos">
          <textoEnNegrita texto="Favoritos" class="text-sm md:text-base" />
        </RouterLink>
        
      </div>
      <RouterView></RouterView>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
