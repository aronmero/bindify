<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import imgsPerfil from "@/components/perfiles/containers/imgsPerfil.vue";
import contenedorBtnsPerfilUser from "@/components/perfiles/containers/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import { users } from "@/components/perfiles/helpers/users.js";
import btnAtras from "@/components/perfiles/containers/btnAtras.vue";
import { RouterLink, RouterView } from "vue-router";
import { getUserData } from "@/Api/perfiles/perfil.js";
import { ref } from "vue";
import router from "@/router/index.js";
let linkUsername = ref(router.currentRoute.value.params.username);
let userData = ref(null);

// console.log(getUserData("get"));

async function responseCatcher(metodo,subRuta) {
  userData.value = await getUserData(metodo, subRuta);
  console.log(userData.value);
}
responseCatcher("get","/api/profile");

let clickedLink = null;
const estilos = {
  hoverLinks: "transition ease-in-out hover:text-accent-400",
};

function pintar(evento) {
  if (clickedLink != null) {
    clickedLink.classList.remove("text-accent-400");
  }
  evento.target.classList.add("text-accent-400");
  clickedLink = evento.target;
}
</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <btnAtras titulo="Perfil"></btnAtras>
    <div class="flex flex-col gap-10" v-if="userData != null">
      <div>
        <imgsPerfil
          :rutaBaner="userData.banner"
          altTextBaner="foto baner"
          :rutaPerfil="userData.avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>
      <div class="flex flex-col gap-6 justify-evenly lg:flex-row">
        <div class="flex flex-col">
          <textoEnNegrita
            :texto="userData.username"
            class="text-base lg:text-xl"
          />

          <textoEnNegrita texto="15" class="text-base lg:text-xl" />
          <textoNormal
            texto="Following"
            class="text-sm lg:text-base"
          ></textoNormal>
        </div>

        <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser>
      </div>
      <div class="flex w-full justify-center gap-6">
        <RouterLink :to="`/perfil/${linkUsername}/particular/fidelidad`">
          <textoEnNegrita
            @click="pintar"
            texto="Fidelidad"
            :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          />
        </RouterLink>
        <RouterLink :to="`/perfil/${linkUsername}/particular/favoritos`">
          <textoEnNegrita
            @click="pintar"
            texto="Favoritos"
            :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          />
        </RouterLink>
        <RouterLink :to="`/perfil/${linkUsername}/particular/seguidos`">
          <textoEnNegrita
            @click="pintar"
            texto="Seguidos"
            :class="`text-sm lg:text-base ${estilos.hoverLinks}`"
          />
        </RouterLink>
      </div>
      <RouterView></RouterView>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
