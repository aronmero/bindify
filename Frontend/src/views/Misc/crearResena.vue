<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";
import { useRouter } from "vue-router";
import { postUserReview } from "@/Api/perfiles/perfil.js";
let options = ["Publicación", "Evento"]; /* Cambiar por info del back */
let tipo = ref(null);
let errorTitle = ref(null);
let errorDesc = ref(null);
let errorButtons = ref(null);
const router = useRouter();
const titulo = ref(null);
const descripcion = ref(null);
const imagen = ref(null);
const fecha = ref(null);
const textoResenia = ref("Elige una puntuación");
const puntuacion = ref(null);
const estrella1 = ref('/assets/icons/starEmpty.svg');
const estrella2 = ref('/assets/icons/starEmpty.svg');
const estrella3 = ref('/assets/icons/starEmpty.svg');
const estrella4 = ref('/assets/icons/starEmpty.svg');
const estrella5 = ref('/assets/icons/starEmpty.svg');
const valoraciones = {
    "estrella1": "Mala",
    "estrella2": "No muy buena",
    "estrella3": "Normal",
    "estrella4": "Buena",
    "estrella5": "Muy buena"
}

const tratarDatos = async()=>{ 
    console.log(titulo.value);
    console.log(descripcion.value);
    console.log(imagen.value);
    console.log(fecha.value);
    console.log(puntuacion.value);
    if(titulo.value != null){
        if(descripcion.value == null){
            errorTitle.value = null;
            errorDesc.value = "Es necesario explicar un poco tu experiecia.";
        }else if(fecha.value == null || puntuacion.value == null){
            errorTitle.value = null;
            errorDesc.value = null;
            if(fecha.value == null){
                errorButtons.value = "Es necesario indicar la fecha en la que visitaste el comercio.";
            }else{
                errorButtons.value = "Es obligatorio puntuar tu experiencia con el comercio.";
            }
        }else{
            errorTitle.value = null;
            errorDesc.value = null;
            errorButtons.value = null;
            let datos = {
                "title": titulo.value,
                "description": descripcion.value,
                "image": imagen.value,
                "date": fecha.value,
                "nota": puntuacion.value
            }
            let respuesta = await postUserReview("POST", datos);
        }
    }else{
        window.scroll({top:50, right:0, behavior: 'smooth'});
        errorTitle.value = "Es necesario indicar un breve título para la reseña";
    }
}
/* Poner el apratado de puntuar (Modal) visible por defecto ya que es obligatorio */
/* const openModal = (e) => {
    const modal = document.getElementById("modalResenia");
    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    } else {
        console.log(modal.classList);
        modal.classList.remove("flex");
        modal.classList.add("hidden");
    }
}
window.addEventListener("mouseup", (e) => {
    const modal = document.getElementById("modalResenia");
    if (e.target != modal.previousSibling) {
        if (modal.compareDocumentPosition(e.target) != "20" & modal.compareDocumentPosition(e.target) != "0") {
            modal.classList.add("hidden");
        }
    }
}); */
const modificarPuntuacion = (e)=>{
    let imagenEstrellaCompleta = '/assets/icons/star.svg';
    let estrella1 = document.getElementById("estrella1");
    let estrella2 = document.getElementById("estrella2");
    let estrella3 = document.getElementById("estrella3");
    let estrella4 = document.getElementById("estrella4");
    let estrella5 = document.getElementById("estrella5");
    let estrellas = [estrella1, estrella2, estrella3, estrella4, estrella5];
    let idSplit = e.target.id.split("");
    let numero = idSplit[idSplit.length-1];
    for (let i = 0; i < numero; i++) {
        estrellas[i].src = imagenEstrellaCompleta;
    }
    textoResenia.value = valoraciones[e.target.id];
}
const resetPuntuacion = (e)=>{
    let imagenEstrellaVacia = '/assets/icons/starEmpty.svg';
    let estrella1 = document.getElementById("estrella1");
    let estrella2 = document.getElementById("estrella2");
    let estrella3 = document.getElementById("estrella3");
    let estrella4 = document.getElementById("estrella4");
    let estrella5 = document.getElementById("estrella5");
    let estrellas = [estrella1, estrella2, estrella3, estrella4, estrella5];
    if(puntuacion.value == null){
        estrellas.forEach(estrella => {
            estrella.src = imagenEstrellaVacia;
        });
        textoResenia.value = "Elige una puntuacion";
    }else{
        estrellas.forEach((valor, clave) => {
            if(clave > puntuacion.value-1){
                valor.src = imagenEstrellaVacia;
            }
        });
        textoResenia.value = valoraciones[estrellas[puntuacion.value-1].id];
    }
}
const setearPuntuacion = (e)=>{
    let imagenEstrellaVacia = '/assets/icons/starEmpty.svg';
    let estrella1 = document.getElementById("estrella1");
    let estrella2 = document.getElementById("estrella2");
    let estrella3 = document.getElementById("estrella3");
    let estrella4 = document.getElementById("estrella4");
    let estrella5 = document.getElementById("estrella5");
    let estrellas = [estrella1, estrella2, estrella3, estrella4, estrella5];
    estrellas.forEach((valor, clave) => {
        if(clave > estrellas.indexOf(e.target)){
            valor.src = imagenEstrellaVacia;
        }
    });
    textoResenia.value = valoraciones[estrellas[estrellas.indexOf(e.target)].id];
    puntuacion.value = estrellas.indexOf(e.target)+1;
}
</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>
        <tempalte class="flex flex-col items-center justify-center">
            <header class="flex items-center relative w-[90vw] justify-center">
                <button @click="router.go(-1)" class="lg:hidden absolute left-0">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="lg:text-xl">Crear una reseña</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" requerido="true" label="Título" :error="errorTitle" :valor="titulo"/>
                    <Input @datos="(nuevosDatos)=>{descripcion = nuevosDatos}" tipo="texto" requerido="true" label="Cuéntanos un poco más" :error="errorDesc" :valor="descripcion"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Incluye una imágen" clase="banner"/>
                    <div class="buttons flex flex-col gap-y-5">
                        <p v-if="errorButtons != null" class="mb-1 text-primary-700 text-sm">{{ errorButtons }}</p>
                        <div class="row flex flex-col lg:flex-row gap-y-6 gap-x-10 relative">
                            <Input @datos="(nuevosDatos)=>{fecha = nuevosDatos}" tipo="fechaLibre" label="¿Cuándo fue?" requerido="false"/>
                            <div id="modalResenia"
                            class="bg-background-50 rounded-xl font-normal flex-col gap-[5px] justify-evenly items-start lg:items-center cursor-pointer flex h-[4rem] lg:h-[5.5rem]">
                                <p>{{ textoResenia }}</p>
                                <div class="estrellas flex">
                                    <img @mouseover="modificarPuntuacion" @mouseleave="resetPuntuacion" @click="setearPuntuacion" id="estrella1" :src="estrella1" class="w-[2rem]"> 
                                    <img @mouseover="modificarPuntuacion" @mouseleave="resetPuntuacion" @click="setearPuntuacion" id="estrella2" :src="estrella2" class="w-[2rem]"> 
                                    <img @mouseover="modificarPuntuacion" @mouseleave="resetPuntuacion" @click="setearPuntuacion" id="estrella3" :src="estrella3" class="w-[2rem]"> 
                                    <img @mouseover="modificarPuntuacion" @mouseleave="resetPuntuacion" @click="setearPuntuacion" id="estrella4" :src="estrella4" class="w-[2rem]"> 
                                    <img @mouseover="modificarPuntuacion" @mouseleave="resetPuntuacion" @click="setearPuntuacion" id="estrella5" :src="estrella5" class="w-[2rem]"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center w-full justify-center">
                        <Input @click.prevent="tratarDatos" tipo="submit" clase="oscuro" valor="Publicar" class="w-[50%] mt-3"/>
                    </div>
                </form>
            </section>
        </tempalte>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
