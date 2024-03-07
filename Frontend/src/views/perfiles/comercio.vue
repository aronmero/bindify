<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import imgsPerfil from "@/components/imgsPerfil.vue";
import btnConImg from "@/components/btnConImg.vue";
import btnConText from "@/components/btnConText.vue";
import contenedorBtnsPerfilUser from "@/components/contenedorBtnsPerfilUser.vue";
import textoEnNegrita from "@/components/textoEnNegrita.vue";
import textoNormal from "@/components/textoNormal.vue";
import contenedorPuntosFidelidad from "@/components/contenedorPuntosFidelidad.vue";
import contenedorPuntuacion from "@/components/contenedorPuntuacion.vue";
import contenedorFollower from "@/components/contenedorFollower.vue";
import { RouterLink, RouterView } from "vue-router";

</script>

<template>
  <Header />
  <Grid
    ><template v-slot:Left> Left</template>
    <div class="flex flex-col gap-6">
      <div>
        <imgsPerfil
          rutaBaner="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg"
          altTextBaner="foto baner"
          rutaPerfil="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg"
          altTextPerfil="foto perfil"
        ></imgsPerfil>
      </div>

      <div class="flex flex-col gap-6 justify-evenly">
        <div class="flex flex-col">
          <textoEnNegrita texto="Albert Flores" class="text-base md:text-xl" />
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
          <contenedorPuntuacion
            rutaIcono="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg"
            altTextoIcono="icono estella"
            puntuacion="4.1"
            cantidadResenias="312"
          />
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
        <div class="flex gap-6 justify-center" >
          <contenedorFollower amount="10" tipo="Following"/>
          <contenedorFollower amount="50" tipo="Follows"/>
          <contenedorFollower amount="20" tipo="Posts"/>
          
        </div>

        <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser>
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
      <div>
        
      </div>
      <RouterView></RouterView>
    </div>

    <template v-slot:Right> Right </template>
  </Grid>
  <Footer />
</template>

<style scoped></style>
