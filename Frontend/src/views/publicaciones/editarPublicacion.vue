<script setup>
import router from "@/router/index.js";
import { onMounted, ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";
import {actualizar_posts} from '@/Api/home/publicaciones.js';
const postData = ref(JSON.parse(sessionStorage.getItem("postData")));
console.log(postData.value.postData);
let options = [{id: 1, name: "Publicación"}, {id: 2, name: "Evento"}];
let opciones_activo = [{id: 1, name: "Activo"}, {id: 0, name: "Inactivo"}];
let tipo = ref(null);
if(postData.value.postData.name == "Post"){
    tipo.value = options[0].id;
}else{
    tipo.value = options[1].id;
}
console.log(postData.value);
let errorDesc = ref(null);
let errorIMG = ref(null);
let errorType = ref(null);
let errorDate = ref(null);
let errorTitle = ref(null);
const titulo = ref(postData.value.postData.title);
const descripcion = ref(postData.value.postData.description);
const imagen = ref(postData.value.postData.image);
const publiTipo = ref(tipo.value);
const fechaInicio = ref(postData.value.postData.start_date);
const fechaFin = ref(postData.value.postData.end_date);
const activo = ref(postData.value.postData.active);
console.log(activo.value);
const colaboradores = ref(null);

const mostrarInformacion = (e)=>{
    let opciones = [...e.target.children];
    let opcionSeleccionada = opciones.filter(opcion => opcion.selected == true);
    if(opcionSeleccionada[0].textContent != null){
        tipo.value = opcionSeleccionada[0].textContent;
    }
}
const tratarDatos = async ()=>{
    console.log(titulo.value);
    console.log(descripcion.value);
    console.log(imagen.value);
    console.log(publiTipo.value);
    console.log(fechaInicio.value);
    console.log(fechaFin.value);
    console.log(activo.value);
    console.log((descripcion.value == null || descripcion.value.length == 0) && imagen.value == null);
    if(titulo.value != null && titulo.value.length > 0){
        /* Revisar error en el que cuando pones una descripcion y luego la quitas te deja de aparecer el error, comprobar el length del value */
        if(descripcion.value == null || descripcion.value.length == 0){
            errorTitle.value = null;
            errorDesc.value = "Es necesario una descripción para la publicación.";
        /*}else if(data.image != null && imagen == null){
             Crear boton de eliminar imagen y comprobar si se elimina en la edición */
        }else if(publiTipo.value == null){
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = "Es obligatorio seleccionar un tipo de evento para crear una publicación.";
        }else if(publiTipo.value == "2" && (fechaInicio.value == null || fechaFin.value == null) ){ /* Cambiar el tipo cuando llegue la info del back */
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = "Debe seleccionar las fechas de inicio y fin del evento.";
        } 
        // else if(activo.value != 1 | activo.value != 0) {
        //     console.log(activo.value);
        //     errorActivo.value = "Debes introducir un campo de activo que esté dentro del rango";
        // } 
        else{
            console.log(imagen.value);
            const body = ref(null);
            if(publiTipo.value == "2"){
                body.value = {
                    image: imagen.value,
                    title: titulo.value,
                    description: descripcion.value,
                    post_type_id: publiTipo.value,
                    start_date: fechaInicio.value, 
                    end_date: fechaFin.value,
                    active: activo.value
                };
            }else{
                body.value = {
                    image: imagen.value,
                    title: titulo.value,
                    description: descripcion.value,
                    post_type_id: publiTipo.value,
                    active: activo.value
                };

            }
            console.log("enviando", body.value)

            console.log("actualizando")

            await actualizar_posts(postData.value.postData.post_id, body.value).then((data) => {
                router.go(-1)
                /* console.log("se ha actualizado todo");
                console.log(data); */
            }).catch(err => {
                console.error(err);
            });

            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = null;
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
        <template class="flex flex-col items-center justify-center">
            <header class="flex items-center relative w-[90vw] justify-center mt-[1rem] mb-[0.5rem]">
                <button @click="$router.back()" class="absolute lg:-translate-x-[21rem] -translate-x-[11rem]">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="lg:text-xl">Editar publicación</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" requerido="true" label="Título" :valor="titulo" :error="errorTitle"/>
                    <Input @datos="(nuevosDatos)=>{descripcion = nuevosDatos}" tipo="texto" label="Descripción" requerido="true" :error="errorDesc" :valor="descripcion"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen del post" requerido="true" clase="banner" :error="errorIMG" :valor="imagen"/>
                    <Input @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Tipo de publicación" :opciones="options" placeholder="Tipos" :error="errorType" :valor="publiTipo"/>
                    <Input @datos="(nuevosDatos)=>{activo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="¿Activar Post?" :opciones="opciones_activo" placeholder="¿Estará activado?" :error="errorActivo" :valor="activo"/>
                    <div v-if="tipo == 'Publicación'" class="datos flex flex-col items-center">
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div v-if="tipo == 'Evento' || tipo == 2" class="datosEvento flex flex-col items-center">
                        <p v-if="errorDate != null" class="mb-1 text-primary-700 text-sm">{{ errorDate }}</p>
                        <div class="flex justify-center gap-x-5 mb-5">
                            <Input @datos="(nuevosDatos)=>{fechaInicio = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de inicio" :valor="fechaInicio"/>
                            <Input @datos="(nuevosDatos)=>{fechaFin = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de finalización" :valor="fechaFin"/>
                        </div>
                        <Input tipo="button" valor="Colaboradores" img="/assets/icons/addUser.svg"/>
                    </div>
                    <div class="flex flex-col items-center w-full justify-center ">
                        <Input @click="(e) => tratarDatos(e)" tipo="submit" clase="oscuro" valor="Guardar Cambios" class="w-[50%]"/>
                    </div>
                </form>
            </section>
        </template>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
