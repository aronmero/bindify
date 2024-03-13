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
import btnAtras from "@/components/perfiles/containers/btnAtras.vue";
import router from "@/router/index.js";
import { RouterLink, RouterView } from "vue-router";
import { getUserData, followUser } from "@/Api/perfiles/perfil.js";
import { ref } from "vue";

import eventos from "@/components/perfiles/containers/contenedorVistaEventos.vue";
import posts from "@/components/perfiles/containers/contenedorVistaPosts.vue";
import resenias from "@/components/perfiles/containers/contenedorVistaResenias.vue";
import fidelidad from "@/components/perfiles/containers/contenedorVistaFidelidad.vue";
import favoritos from "@/components/perfiles/containers/contenedorVistaFavoritos.vue";
import seguidos from "@/components/perfiles/containers/contenedorVistaSeguidos.vue";
let cambioAFollowed = ref(false);
let clickedLink = null;
let userData = ref(null);
let userExterno = ref(false);
let linkUsername = ref(router.currentRoute.value.params.username);
if (linkUsername.value == undefined) {
  router.push(`/perfil`);
}
const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
let isCustomer = false;
// if(userLogeado.usuario.tipo == "customer" ){
//   isCustomer = true

// }
const estilos = {
  hoverLinks: "transition ease-in-out hover:text-accent-400",
};

// Al recargar la pagina se quita la marca arregla a futuro con variables de estado
// a lo mejor
function pintar(evento) {
  if (clickedLink != null) {
    clickedLink.classList.remove("text-accent-400");
  }
  //console.log(evento.target.innerHTML);
  evento.target.classList.add("text-accent-400");
  clickedLink = evento.target;
}

async function responseCatcher(metodo, subRuta) {
  userData.value = await getUserData(metodo, subRuta);

  console.log(userData.value[0]);

  console.log(userLogeado.usuario.tipo);
  if (
    userLogeado.usuario.tipo == "customer" &&
    userData.value[0] == undefined
  ) {
    console.log("es Customer");
    isCustomer = true;
  }
  if (!isCustomer) {
    cambioAFollowed.value = userData.value[0].followed;
    userData.value = userData.value[0];
  }
  console.log(userData.value);
}

if (linkUsername.value == userLogeado.usuario.username) {
  responseCatcher("get", "/api/profile");
} else {
  //console.log(linkUsername.value);
  responseCatcher("get", `/api/user/${linkUsername.value}`);
  userExterno.value = true;
}

async function responseCatcherFollow() {
  console.log(userData.value.username);
  cambioAFollowed.value = await followUser(
    "post",
    `/api/follow/${userData.value.username}`
  );
  console.log(cambioAFollowed.value);
}

const isEventos = ref(false);
const isPosts = ref(false);
const isResenias = ref(false);

const isFidelidad = ref(false);
const isFavoritos = ref(false);
const isSeguidos = ref(false);

/**
 * Oculta todos los componentes
 */
function ocultar() {
  isEventos.value = false;
  isPosts.value = false;
  isResenias.value = false;

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
      console.log(evento.target.value);
      isEventos.value = true;
      break;
    case "2":
      console.log(evento.target.value);
      isPosts.value = true;
      break;
    case "3":
      console.log(evento.target.value);
      isResenias.value = true;
      break;
    case "4":
      console.log(evento.target.value);
      isFidelidad.value = true;
      break;
    case "5":
      console.log(evento.target.value);
      isFavoritos.value = true;
      break;
    case "6":
      console.log(evento.target.value);
      isSeguidos.value = true;
      break;

    default:
      break;
  }
}
//console.log(userData.value)
</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <btnAtras titulo="Perfil"></btnAtras>

    <div class="flex flex-col gap-6" v-if="userData != null">
      <div>
        <imgsPerfil
          :rutaBaner="userData.banner"
          altTextBaner="foto baner"
          :rutaPerfil="userData.avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>

      <div class="flex flex-col gap-10 justify-evenly">
        <div class="flex flex-col">
          <textoEnNegrita
            :texto="userData.username"
            class="text-base lg:text-xl"
          />
        </div>
        <div
          class="flex flex-col justify-center lg:items-start gap-10 lg:gap-20 lg:flex-row"
          v-if="!isCustomer"
        >
          <div class="flex justify-center lg:items-start gap-28 lg:gap-20">
            <div class="flex flex-col">
              <textoNormal
                :texto="userData.address"
                class="text-sm lg:text-base"
              />
              <textoNormal
                :texto="userData.phone"
                class="text-sm lg:text-base"
              />
              <textoNormal
                :texto="userData.email"
                class="text-sm lg:text-base"
              />
            </div>
            <contenedorPuntuacion
              v-if="userData.tipo != 'ayuntamiento'"
              :puntuacion="userData.avg"
              :cantidadResenias="userData.review_count"
            />
          </div>
          <div class="flex flex-row gap-4 justify-center lg:flex-col lg:gap-0">
            <textoEnNegrita texto="Horario:" class="text-sm lg:text-base" />
            <div class="flex flex-col">
              <textoNormal
                texto="Lun-Vier: 8:00-15:00"
                class="text-sm lg:text-base"
              />
              <textoNormal
                texto="Sabado: 8:00-12:00"
                class="text-sm lg:text-base"
              />
            </div>
          </div>
        </div>
        <div
          class="flex justify-center items-center gap-40 lg:gap-20"
          v-if="!isCustomer"
        >
          <div class="flex flex-col">
            <textoNormal
              :texto="userData.categories_name"
              class="text-sm lg:text-base"
            />
          </div>
          <div class="flex flex-col">
            <textoNormal
              v-for="hashtag in userData.hashtags"
              :texto="hashtag"
              class="text-sm lg:text-base"
            />
          </div>
        </div>
        <div class="flex gap-6 justify-center hidden">
          <contenedorFollower amount="10" tipo="Following" />
          <contenedorFollower amount="50" tipo="Follows" />
          <contenedorFollower amount="20" tipo="Posts" />
        </div>

        <!-- <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser> -->
        <div class="flex justify-center">
          <RouterLink to="/perfil/edit" v-if="!userExterno">
            <btnConText
              texto="EDIT PROFILE"
              class="transition hover:bg-accent-400 ease-linear hover:text-text-50 w-48"
            >
            </btnConText>
          </RouterLink>

          <btnConText
            @click="responseCatcherFollow"
            v-if="userExterno && !isCustomer && !cambioAFollowed"
            texto="Segir"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 w-48"
          >
          </btnConText>

          <btnConText
            @click="responseCatcherFollow"
            v-if="userExterno && !isCustomer && cambioAFollowed"
            texto="Dejar de Seguir"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 w-48"
          >
          </btnConText>
        </div>
      </div>

      <div class="flex w-full justify-center gap-6">
        <textoEnNegrita
          v-if="!isCustomer"
          @click="manipulacion"
          texto="Posts"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="1"
        />
        <textoEnNegrita
          v-if="!isCustomer"
          @click="manipulacion"
          texto="Eventos"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="2"
        />
        <textoEnNegrita
          v-if="userData.tipo != 'ayuntamiento' && !isCustomer"
          @click="manipulacion"
          texto="Reseñas"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="3"
        />
        <textoEnNegrita
          v-if="isCustomer"
          @click="manipulacion"
          texto="Fidelidad"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="4"
        />
        <textoEnNegrita
          v-if="isCustomer"
          @click="manipulacion"
          texto="Favoritos"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="5"
        />
        <textoEnNegrita
          v-if="isCustomer"
          @click="manipulacion"
          texto="Seguidos"
          class="text-sm lg:text-base"
          :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          value="6"
        />
      </div>
      <!--<RouterView></RouterView>-->
      <posts v-if="isPosts"></posts>
      <eventos v-if="isEventos"></eventos>
      <resenias v-if="isResenias"></resenias>
      <fidelidad v-if="isFidelidad"></fidelidad>
      <favoritos v-if="isFavoritos"></favoritos>
      <seguidos v-if="isSeguidos"></seguidos>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
