<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";
import { crearPublicacion } from "../../Api/publicacion/publicacion";
let options = [{id: 1, name: "Publicación"}, {id: 2, name: "Evento"}];
let tipo = ref(null);
let errorDesc = ref(null);
let errorType = ref(null);
let errorDate = ref(null);
let errorTitle = ref(null);
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
const tratarDatos = async()=>{
    console.log(titulo.value);
    console.log(descripcion.value);
    console.log(imagen.value);
    console.log(publiTipo.value);
    console.log(fechaInicio.value);
    console.log(fechaFin.value);
    if(titulo.value != null && titulo.value.length > 0){

        /* Revisar error en el que cuando pones una descripcion y luego la quitas te deja de aparecer el error, comprobar el length del value */
        if((descripcion.value == null || descripcion.value.length == 0) && imagen.value == null){
            errorTitle.value = null;
            errorDesc.value = "Es necesario indicar una imagen o una descripción para la publicación.";
        }else if(publiTipo.value == null){
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = "Es obligatorio seleccionar un tipo de evento para crear una publicación.";

            //Apaño de Rengifo

        }else if(publiTipo.value == "2" && (fechaInicio.value == null || fechaFin.value == null) ){ /* Cambiar el tipo cuando llegue la info del back */
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = "Debe seleccionar las fechas de inicio y fin del evento.";
        }else{
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = null;
            if(publiTipo.value == 1){
                let datos = {
                    "title": titulo.value, 
                    "image": imagen.value, 
                    "description": descripcion.value,
                    "post_type_id": publiTipo.value,
                };
                let respuesta = await crearPublicacion("POST", datos);
                console.log(respuesta);
            }else{
                let datos = {
                    "title": titulo.value, 
                    "image": imagen.value,
                    "description": descripcion.value,
                    "post_type_id": publiTipo.value,
                    "start_date": fechaInicio.value, 
                    "end_date": fechaFin.value
                };
                let respuesta = await crearPublicacion("POST", datos);
                console.log(respuesta);
            }
        }
    }else{
        errorTitle.value = "Es necesario indicar el título de la publicación";
    }
}
</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>
        <template class="flex flex-col items-center justify-center lg:mt-10">
            <header class="flex items-center relative w-[90vw] justify-center mt-[1rem] mb-[0.5rem]">
                <button @click="router.back()" class="absolute lg:-translate-x-[21rem]">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="lg:text-xl">Crear publicación</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" label="Título" requerido="true" :error="errorTitle" :valor="titulo"/>
                    <Input @datos="(nuevosDatos)=>{descripcion = nuevosDatos}" tipo="texto" label="Descripción" requerido="true" :error="errorDesc" :valor="descripcion"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen del post" requerido="true" clase="banner" :error="errorDesc" />
                    <Input @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Tipo de publicación" :opciones="options" placeholder="Tipos" :error="errorType"/>
                    <div v-if="tipo == 'Publicación'" class="datos flex flex-col items-center">
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div v-if="tipo == 'Evento'" class="datosEvento flex flex-col items-center">
                        <p v-if="errorDate != null" class="mb-1 text-primary-700 text-sm">{{ errorDate }}</p>
                        <div class="flex justify-center gap-x-5 mb-5">
                            <Input @datos="(nuevosDatos)=>{fechaInicio = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de inicio"/>
                            <Input @datos="(nuevosDatos)=>{fechaFin = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de finalización"/>
                        </div>
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div class="flex flex-col items-center w-full justify-center ">
                        <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Publicar" class="w-[50%]"/>
                    </div>
                </form>
            </section>
        </template>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
