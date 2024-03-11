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
import { users } from "@/components/perfiles/helpers/users.js";
import { RouterLink, RouterView } from "vue-router";
import { getUserData } from "@/api/perfiles/perfil.js";
import { ref } from "vue";
let clickedLink = null;
let userData = ref(null);
let userExterno = ref(false);
const estilos = {
  hoverLinks: "transition ease-in-out hover:text-accent-400",
};
// Al recargar la pagina se quita la marca arregla a futuro con variables de estado
// a lo mejor
function pintar(evento) {
  if (clickedLink != null) {
    clickedLink.classList.remove("text-accent-400");
  }
  console.log(evento.target.innerHTML);
  evento.target.classList.add("text-accent-400");
  clickedLink = evento.target;
}

async function responseCatcher() {
  userData.value = await getUserData("get", "http://127.0.0.1:8000/api/user/");
  console.log(userData.value);
}

responseCatcher();
</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left></template>
    <btnAtras titulo="Perfil"></btnAtras>
    <div class="flex flex-col gap-6" v-if="userData != null">
      <div>
        <imgsPerfil
          :rutaBaner="userData[0].banner"
          altTextBaner="foto baner"
          :rutaPerfil="userData[0].avatar"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>

      <div class="flex flex-col gap-10 justify-evenly">
        <div class="flex flex-col">
          <textoEnNegrita
            :texto="userData[0].username"
            class="text-base lg:text-xl"
          />
        </div>
        <div
          class="flex flex-col justify-center lg:items-start gap-10 lg:gap-20 lg:flex-row"
        >
          <div class="flex justify-center lg:items-start gap-28 lg:gap-20">
            <div class="flex flex-col">
              <textoNormal
                :texto="userData[0].addess"
                class="text-sm lg:text-base"
              />
              <textoNormal
                :texto="userData[0].phone"
                class="text-sm lg:text-base"
              />
              <textoNormal
                :texto="userData[0].email"
                class="text-sm lg:text-base"
              />
            </div>
            <contenedorPuntuacion puntuacion="4.1" cantidadResenias="312" />
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
        <div class="flex justify-center items-center gap-40 lg:gap-20">
          <div class="flex flex-col">
            <textoNormal
              :texto="userData[0].categories_name"
              class="text-sm lg:text-base"
            />
          </div>
          <div class="flex flex-col">
            <textoNormal
              v-for="hashtag in userData[0].hashtags"
              :texto="hashtag"
              class="text-sm lg:text-base"
            />
          </div>
        </div>
        <div class="flex gap-6 justify-center">
          <contenedorFollower amount="10" tipo="Following" />
          <contenedorFollower amount="50" tipo="Follows" />
          <contenedorFollower amount="20" tipo="Posts" />
        </div>

        <!-- <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser> -->
        <div class="flex justify-center">
          <RouterLink to="/perfil/edit">
            <btnConText
              texto="EDIT PROFILE"
              class="transition hover:bg-accent-400 ease-linear hover:text-text-50 w-48"
            ></btnConText>
          </RouterLink>
          <RouterLink to="" v-if="userExterno">
            <btnConText
              texto="Segir"
              class="transition hover:bg-accent-400 ease-linear hover:text-text-50 w-48"
            ></btnConText>
          </RouterLink>
        </div>
      </div>

      <div class="flex w-full justify-center gap-6">
        <RouterLink to="/perfil/comercio/posts">
          <textoEnNegrita
            @click="pintar"
            texto="Posts"
            class="text-sm lg:text-base"
            :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
          />
        </RouterLink>
        <RouterLink to="/perfil/comercio/eventos">
          <textoEnNegrita
            @click="pintar"
            texto="Eventos"
            class="text-sm lg:text-base"
            :class="`text-sm lg:text-base  ${estilos.hoverLinks}`"
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
