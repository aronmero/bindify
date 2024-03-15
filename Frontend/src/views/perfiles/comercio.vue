<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import imgsPerfil from "@/components/perfiles/containers/imgsPerfil.vue";
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
import btnConText from "@/components/perfiles/widgets/btnConText.vue";
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import contenedorPuntuacion from "@/components/perfiles/containers/contenedorPuntuacion.vue";
import contenedorFollower from "@/components/perfiles/containers/contenedorFollower.vue";
import btnAtras from "@/components/perfiles/containers/btnAtras.vue";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import router from "@/router/index.js";
import { RouterLink } from "vue-router";
import {
  getUserData,
  followUser,
  aniadirFavorito,
} from "@/Api/perfiles/perfil.js";
import { ref } from "vue";
import eventos from "@/components/perfiles/containers/contenedorVistaEventos.vue";
import posts from "@/components/perfiles/containers/contenedorVistaPosts.vue";
import resenias from "@/components/perfiles/containers/contenedorVistaResenias.vue";
import fidelidad from "@/components/perfiles/containers/contenedorVistaFidelidad.vue";
import FollowedFeed from "@/components/seguidos/followedFeed.vue";
import FavoriteFeed from "@/components/seguidos/FavoriteFeed.vue";

let cambioAFollowed = ref(false);
let cambioAFavorito = ref(false);
let clickedLink = null;
let userData = ref(null);
let userExterno = ref(false);
let linkUsername = ref(router.currentRoute.value.params.username);

if (linkUsername.value == undefined) {
  router.push(`/perfil`);
}
const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
let isCustomer = false;

const estilos = {
  hoverLinks: "transition ease-in-out hover:text-accent-400",
};

function pintar(evento) {
  if (clickedLink == null) {
    clickedLink = document.querySelector("#linkPost");
  }
  if (clickedLink != null) {
    clickedLink.classList.remove("text-accent-400");
  }

  evento.target.classList.add("text-accent-400");
  clickedLink = evento.target;
}

async function responseCatcher(metodo, subRuta) {
  userData.value = await getUserData(metodo, subRuta);

  if (userData.value[0] == undefined) {
    isCustomer = true;
    isPosts.value = false;
  }
  if (!isCustomer) {
    cambioAFollowed.value = userData.value[0].followed;
    cambioAFavorito.value = userData.value[0].favorite;
    userData.value = userData.value[0];
  }

  userData.value = setDefaultImgs(userData.value);
}

if (linkUsername.value == userLogeado.usuario.username) {
  responseCatcher("get", "/api/profile");
} else {
  responseCatcher("get", `/api/user/${linkUsername.value}`);
  userExterno.value = true;
}

async function responseCatcherFollow() {
  cambioAFollowed.value = await followUser(
    "post",
    `/api/follow/${userData.value.username}`
  );
}

async function responseCatcherFavoritos() {
  cambioAFavorito.value = await aniadirFavorito(
    "post",
    `/api/favorite/${userData.value.username}`
  );
}

const isEventos = ref(false);
const isPosts = ref(true);
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

function manipulacion(evento) {
  pintar(evento);

  ocultar();
  switch (evento.target.value) {
    case "1":
      isPosts.value = true;
      break;
    case "2":
      isEventos.value = true;
      break;
    case "3":
      isResenias.value = true;
      break;
    case "4":
      isFidelidad.value = true;
      break;
    case "5":
      isFavoritos.value = true;
      break;
    case "6":
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
            class="text-base lg:text-xl cursor-default"
          />
          <textoNormal
            :texto="userData.name"
            class="text-sm lg:text-base bg-transparent"
          ></textoNormal>
        </div>
        <div
          class="flex flex-col justify-center lg:items-start gap-10 lg:gap-10 lg:flex-row border-b pb-5"
          v-if="!isCustomer"
        >
          <div class="flex justify-center lg:items-start gap-5 lg:gap-10">
            <div class="flex flex-col items-end w-44 lg:w-48">
              <textoNormal
                :texto="userData.address"
                class="text-sm lg:text-base m-1"
              />
              <textoNormal
                :texto="userData.phone"
                class="text-sm lg:text-base m-1"
              />
              <textoNormal
                :texto="userData.email"
                class="text-xs sm:text-sm lg:text-base m-1"
              />
            </div>
            <div class="wid-32">
              <contenedorPuntuacion
                v-if="userData.tipo != 'ayuntamiento'"
                :puntuacion="userData.avg"
                :cantidadResenias="userData.review_count"
              />
            </div>
          </div>
          <div
            class="flex flex-row gap-4 justify-center lg:flex-col lg:gap-0 lg:w-48"
          >
            <textoEnNegrita texto="Horario:" class="text-sm lg:text-base" />
            <div
              class="flex flex-col"
              v-if="
                userData.schedule != null &&
                userData.schedule != 'null' &&
                userData.schedule != 'undefined' &&
                userData.schedule != undefined
              "
            >
              <textoNormal
                :texto="userData.schedule"
                class="text-sm lg:text-base"
              />
            </div>
            <div class="flex flex-col" v-else>
              <textoNormal
                texto="No hay horario"
                class="text-sm lg:text-base"
              />
            </div>
          </div>
        </div>
        <div
          class="flex justify-center items-center gap-5 lg:gap-10 border-b pb-5"
          v-if="!isCustomer"
        >
          <div class="flex flex-col items-end w-40 lg:w-56">
            <textoNormal
              :texto="userData.categories_name"
              class="text-sm lg:text-base w-fit"
            />
          </div>
          <div
            class="flex flex-col items-start lg:w-56"
            v-if="userData.hashtags.length != 0"
          >
            <textoNormal
              v-for="hashtag in userData.hashtags"
              :texto="hashtag"
              class="text-xs sm:text-sm lg:text-base m-1"
            />
          </div>
        </div>
        <div class="flex gap-6 justify-center hidden">
          <contenedorFollower amount="10" tipo="Following" />
          <contenedorFollower amount="50" tipo="Follows" />
          <contenedorFollower amount="20" tipo="Posts" />
        </div>

        <div class="flex justify-center items-center gap-2 lg:gap-3">
          <RouterLink to="/perfil/edit" v-if="!userExterno">
            <btnConText
              texto="EDIT PROFILE"
              class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48"
            >
            </btnConText>
          </RouterLink>
          <RouterLink
            to="/resenia"
            v-if="
              userExterno &&
              !isCustomer &&
              userData.tipo != 'ayuntamiento' &&
              userLogeado.usuario.tipo != 'commerce'
            "
          >
            <btnConText
              texto="Añadir Reseña"
              class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48"
            >
            </btnConText>
          </RouterLink>
          <RouterLink to="/tarjeta-fidelidad" v-if="!userExterno && isCustomer">
            <btnConImg
              ruta="/assets/icons/qrCode.svg"
              altText="icono codigo qr"
              :borde="true"
            ></btnConImg>
          </RouterLink>

          <btnConText
            @click="responseCatcherFollow"
            v-if="userExterno && !isCustomer && !cambioAFollowed"
            texto="Segir"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48 font-semibold"
          >
          </btnConText>

          <btnConText
            @click="responseCatcherFollow"
            v-if="userExterno && !isCustomer && cambioAFollowed"
            texto="Dejar de Seguir"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48 font-semibold"
          >
          </btnConText>
          <btnConText
            @click="responseCatcherFavoritos"
            v-if="
              userExterno && !isCustomer && !cambioAFavorito && cambioAFollowed
            "
            texto="Añadir a Favoritos"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48 font-semibold"
          >
          </btnConText>
          <btnConText
            @click="responseCatcherFavoritos"
            v-if="
              userExterno && !isCustomer && cambioAFavorito && cambioAFollowed
            "
            texto="Quitar de Favoritos"
            class="transition hover:bg-accent-400 ease-linear hover:text-text-50 lg:w-48 font-semibold"
          >
          </btnConText>
        </div>
      </div>

      <div class="flex w-full justify-evenly gap-6 flex-wrap">
        <textoEnNegrita
          v-if="!isCustomer"
          @click="manipulacion"
          texto="Posts"
          :class="`text-sm lg:text-lg text-accent-400  ${estilos.hoverLinks}`"
          value="1"
          id="linkPost"
        />
        <textoEnNegrita
          v-if="!isCustomer"
          @click="manipulacion"
          texto="Eventos"
          :class="`text-sm lg:text-lg ${estilos.hoverLinks}`"
          value="2"
        />
        <textoEnNegrita
          v-if="userData.tipo != 'ayuntamiento' && !isCustomer"
          @click="manipulacion"
          texto="Reseñas"
          :class="`text-sm lg:text-lg  ${estilos.hoverLinks}`"
          value="3"
        />
        <textoEnNegrita
          v-if="isCustomer && !userExterno"
          @click="manipulacion"
          texto="Fidelidad"
          :class="`text-sm lg:text-lg  ${estilos.hoverLinks}`"
          value="4"
        />
        <textoEnNegrita
          v-if="!userExterno"
          @click="manipulacion"
          texto="Seguidos"
          :class="`text-sm lg:text-lg  ${estilos.hoverLinks}`"
          value="6"
        />
        <textoEnNegrita
          v-if="!userExterno"
          @click="manipulacion"
          texto="Favoritos"
          :class="`text-sm lg:text-lg  ${estilos.hoverLinks}`"
          value="5"
        />
      </div>

      <posts v-if="isPosts"></posts>
      <eventos v-if="isEventos"></eventos>
      <resenias v-if="isResenias"></resenias>
      <fidelidad v-if="isFidelidad"></fidelidad>
      <FollowedFeed v-if="isSeguidos"></FollowedFeed>
      <FavoriteFeed v-if="isFavoritos"></FavoriteFeed>
    </div>

    <template v-slot:Right></template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
