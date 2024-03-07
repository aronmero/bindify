<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/input.vue";
let options = ["Evento", "Publicación"]; /* Cambiar por info del back */
let tipo = ref(null);
let error = ref(null);
const titulo = ref(null);
const descripcion = ref(null);
const imagen = ref(null);
const publiTipo = ref(null);
const fechaInicio = ref(null);
const fechaFin = ref(null);
const colaboradores = ref(null);
const diaActual = new Date().getFullYear()+"-"+("0" + new Date().getMonth()).slice(-2)+"-"+("0" + new Date().getDate()).slice(-2);
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
    console.log(new Date(fechaInicio.value) < new Date(diaActual));
    if(descripcion.value == null && imagen.value == null){
        console.log("error 1");
    }else if(publiTipo.value == null){
        console.log("error 2");
    }else if(publiTipo.value == "0" && (fechaInicio.value == null || fechaFin.value == null) ){
        console.log("error 3");
    }else if(fechaInicio.value < diaActual || fechaFin.value < diaActual){
        console.log("error 4");
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
                <h3>Crear Publicación</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" requerido="true" label="Título"/>
                    <Input @datos="(nuevosDatos)=>{descripcion = nuevosDatos}" tipo="texto" label="Descripción"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen del post" clase="banner"/>
                    <Input @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Tipo de publicación" :opciones="options" valor="Tipos"/>
                    <div v-if="tipo == 'Publicación'" class="datos flex flex-col items-center">
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div v-if="tipo == 'Evento'" class="datosEvento flex flex-col items-center">
                        <div class="flex justify-center gap-x-5 mb-5">
                            <Input @datos="(nuevosDatos)=>{fechaInicio = nuevosDatos}" tipo="fecha" label="Fecha de inicio"/>
                            <Input @datos="(nuevosDatos)=>{fechaFin = nuevosDatos}" tipo="fecha" label="Fecha de finalización"/>
                        </div>
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div class="flex items-center w-full justify-center">
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
