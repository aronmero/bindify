<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";
import {posts} from '@/scripts/posts.js';
let data = posts[0];
let options = ["Evento", "Publicación"]; /* Cambiar por info del back */
let tipo = ref(null);
let errorDesc = ref(null);
let errorType = ref(null);
let errorDate = ref(null);
const titulo = ref(null);
const descripcion = ref(null);
const imagen = ref(null);
const publiTipo = ref(null);
const fechaInicio = ref(null);
const fechaFin = ref(null);
const colaboradores = ref(null);
const mostrarInformacion = (e)=>{
    let opciones = [...e.target.children];
    let opcionSeleccionada = opciones.filter(opcion => opcion.selected == true);
    if(opcionSeleccionada[0].textContent != null){
        tipo.value = opcionSeleccionada[0].textContent;
    }
}
const tratarDatos = ()=>{
    console.log(titulo.value);
    console.log(descripcion.value);
    console.log(imagen.value);
    console.log(publiTipo.value);
    if(titulo.value != null){
        /* Revisar error en el que cuando pones una descripcion y luego la quitas te deja de aparecer el error, comprobar el length del value */
        if(descripcion.value == null && imagen.value == null){
            errorDesc.value = "Es necesario indicar una imagen o una descripción para la publicación.";
        }else if(publiTipo.value == null){
            errorDesc.value = null;
            errorType.value = "Es obligatorio seleccionar un tipo de evento para crear una publicación.";
        }else if(publiTipo.value == "0" && (fechaInicio.value == null || fechaFin.value == null) ){
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = "Debe seleccionar las fechas de inicio y fin del evento.";
        }else{
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = null;
        }
    }
}
</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>
        <tempalte class="flex flex-col items-center justify-center">
            <header class="flex items-center relative w-[90vw] justify-center">
                <button class="lg:hidden absolute left-0">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="lg:text-xl">Editar Publicación</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" requerido="true" label="Título"/>
                    <Input @datos="(nuevosDatos)=>{descripcion = nuevosDatos}" tipo="texto" label="Descripción" :error="errorDesc"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen del post" clase="banner" :error="errorDesc" />
                    <Input @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Tipo de publicación" :opciones="options" valor="Tipos" :error="errorType"/>
                    <div v-if="tipo == 'Publicación'" class="datos flex flex-col items-center">
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div v-if="tipo == 'Evento'" class="datosEvento flex flex-col items-center">
                        <p v-if="errorDate != null" class="mb-1 text-primary-700 text-sm">{{ errorDate }}</p>
                        <div class="flex justify-center gap-x-5 mb-5">
                            <Input @datos="(nuevosDatos)=>{fechaInicio = nuevosDatos}" tipo="fecha" label="Fecha de inicio"/>
                            <Input @datos="(nuevosDatos)=>{fechaFin = nuevosDatos}" tipo="fecha" label="Fecha de finalización"/>
                        </div>
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div class="flex flex-col items-center w-full justify-center ">
                        <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Publicar" class="w-[50%]"/>
                    </div>
                </form>
            </section>
        </tempalte>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
