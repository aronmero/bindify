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
import fidelidad from "@/components/perfiles/containers/contenedorVistaFidelidad.vue";
import favoritos from "@/components/perfiles/containers/contenedorVistaFavoritos.vue";
import seguidos from "@/components/perfiles/containers/contenedorVistaFavoritos.vue";

let linkUsername = ref(router.currentRoute.value.params.username);
const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
let userExterno = ref(false);
let userData = ref(null);

async function responseCatcher(metodo, subRuta) {
  userData.value = await getUserData(metodo, subRuta);
  
}

if (linkUsername.value == userLogeado.usuario.username) {
  responseCatcher("get", "/api/profile");
} else {
  responseCatcher("get", `/api/user/${linkUsername.value}`);
  userExterno.value = true;
}

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

const isFidelidad = ref(false);
const isFavoritos = ref(false);
const isSeguidos = ref(false);

/**
 * Oculta todos los componentes
 */
function ocultar() {
  isFidelidad.value = false;
  isFavoritos.value = false;
  isSeguidos.value = false;
}

/**
 * Ejecuta una serie de funciones que requieren de un evento.
 * Cambia un estilo, oculta todos los contenedores, y muestra uno en concreto
 * @param {*} evento
 */
function manipulacion(evento) {
  pintar(evento);

  ocultar();
  switch (evento.target.value) {
    case "1":
      isFidelidad.value = true;
      break;
    case "2":
      isFavoritos.value = true;
      break;
    case "3":
      isSeguidos.value = true;
      break;
    default:
      break;
  }
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
        <textoEnNegrita
          @click="manipulacion"
          texto="Fidelidad"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="1"
        />

        <textoEnNegrita
          @click="manipulacion"
          texto="Favoritos"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="2"
        />

        <textoEnNegrita
          @click="manipulacion"
          texto="Seguidos"
          :class="`text-sm lg:text-base ${estilos.hoverLinks}`"
          value="3"
        />
      </div>
      <fidelidad v-if="isFidelidad"></fidelidad>
      <favoritos v-if="isFavoritos"></favoritos>
      <seguidos v-if="isSeguidos"></seguidos>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
