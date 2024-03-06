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
</script>

<template>
    <Header />
    <Grid><template v-slot:Left> Left</template>
        <div>
            <imgsPerfil rutaBaner="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg" altTextBaner="foto baner" rutaPerfil="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg" altTextPerfil="foto perfil"></imgsPerfil>
        </div>
        <div class="flex justify-evenly">
            <div class="flex flex-col">
                <textoEnNegrita texto="Albert Flores"  class="text-xl"/>
                <textoEnNegrita texto="15" class="text-xl"/>
                <textoNormal texto="Following" class="text-base"></textoNormal>
            </div>
            
            <contenedorBtnsPerfilUser></contenedorBtnsPerfilUser>
            
        </div>
        <div class="flex w-full justify-center gap-4">
            <textoEnNegrita texto="Fidelidad" />
            <textoEnNegrita texto="Favoritos" />
        
        </div>
        <div>
            <div class="flex justify-around">
                <textoEnNegrita texto="Tus puntos" class="text-xl" />
                <btnConImg ruta="https://www.dzoom.org.es/wp-content/uploads/2020/02/portada-foto-perfil-redes-sociales-consejos.jpg" altText="icono codigo qr"></btnConImg>
            </div>
            <div class="flex-col justify-center items-center" >
                <contenedorPuntosFidelidad comercio="José Informática" puntos="500"/>
                <contenedorPuntosFidelidad comercio="José Informática" puntos="500"/>
                <contenedorPuntosFidelidad comercio="José Informática" puntos="500"/>
                <contenedorPuntosFidelidad comercio="José Informática" puntos="500"/>
                <contenedorPuntosFidelidad comercio="José Informática" puntos="500"/>
            </div>
        </div>


        <template v-slot:Right> Right </template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
