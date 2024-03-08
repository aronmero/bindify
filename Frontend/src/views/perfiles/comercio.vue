<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import imgsPerfil from "@/components/perfiles/containers/imgsPerfil.vue";
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
import btnConText from "@/components/perfiles/widgets/btnConText.vue";
import contenedorBtnsPerfilUser from "@/components/perfiles/containers/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";

import contenedorPuntuacion from "@/components/perfiles/containers/contenedorPuntuacion.vue";
import contenedorFollower from "@/components/perfiles/containers/contenedorFollower.vue";
import { users } from "@/components/perfiles/helpers/users.js";
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <div class="flex flex-col gap-6">
      <div>
        <imgsPerfil
          rutaBaner="https://placehold.co/600x400"
          altTextBaner="foto baner"
          :rutaPerfil="users[1].avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>

      <div class="flex flex-col gap-6 justify-evenly">
        <div class="flex flex-col">
          <textoEnNegrita :texto="users[1].name" class="text-base md:text-xl" />
        </div>
        <div class="flex justify-center items-start gap-6 md:gap-20">
          <div class="flex flex-col">
            <textoNormal texto="C. Jose Lopez" class="text-sm md:text-base" />
            <textoNormal texto="123-123-123" class="text-sm md:text-base" />
            <textoNormal
              texto="blooms@gmail.com"
              class="text-sm md:text-base"
            />
          </div>
          <contenedorPuntuacion puntuacion="4.1" cantidadResenias="312" />
          <div class="flex flex-col">
            <textoEnNegrita texto="Horario" class="text-sm md:text-base" />
            <textoNormal
              texto="Lun-Vier: 8:00-15:00"
              class="text-sm md:text-base"
            />
            <textoNormal
              texto="Sabado: 8:00-12:00"
              class="text-sm md:text-base"
            />
          </div>
        </div>
        <div class="flex justify-center items-center gap-6 md:gap-20">
          <div class="flex flex-col">
            <textoNormal texto="Foristería" class="text-sm md:text-base" />
          </div>
          <div class="flex flex-col">
            <textoNormal texto="#floristeria" class="text-sm md:text-base" />
            <textoNormal texto="#flores" class="text-sm md:text-base" />
          </div>
        </div>
        <div class="flex gap-6 justify-center">
          <contenedorFollower amount="10" tipo="Following" />
          <contenedorFollower amount="50" tipo="Follows" />
          <contenedorFollower amount="20" tipo="Posts" />
        </div>

        <!-- <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser> -->
        <div class="flex justify-center">
          <btnConText texto="EDIT PROFILE" class="w-48"></btnConText>
        </div>
      </div>

      <div class="flex w-full justify-center gap-6">
        <RouterLink to="/comercio/posts">
          <textoEnNegrita texto="Posts" class="text-sm md:text-base" />
        </RouterLink>
        <RouterLink to="/comercio/eventos">
          <textoEnNegrita texto="Eventos" class="text-sm md:text-base" />
        </RouterLink>
        <RouterLink to="/comercio/resenias">
          <textoEnNegrita texto="Reseñas" class="text-sm md:text-base" />
        </RouterLink>
      </div>
      <div></div>
      <RouterView></RouterView>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
