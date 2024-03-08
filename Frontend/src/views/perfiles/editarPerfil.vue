<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";
let options = ["Los Llanos de Aridane", "Santa Cruz de la Palma", "Tijarafe", "El Paso", "Puntagorda", "Villa de Mazo"]; /* Cambiar por info del back */
let optionsSex = ["M", "H"]; /* Cambiar por info del back */
let errorDesc = ref(null);
let errorIMG = ref(null);
let errorType = ref(null);
let errorDate = ref(null);
let errorTitle = ref(null);
const tipoUsuario = ref("particular");

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
    console.log(fechaInicio.value);
    console.log(fechaFin.value);
    console.log((descripcion.value == null || descripcion.value.length == 0) && imagen.value == null);
    if(titulo.value != null && titulo.value.length > 0){
        /* Revisar error en el que cuando pones una descripcion y luego la quitas te deja de aparecer el error, comprobar el length del value */
        if(descripcion.value == null || descripcion.value.length == 0){
            errorTitle.value = null;
            errorDesc.value = "Es necesario una descripción para la publicación.";
        }else if(data.image != null && imagen == null){
            /* Crear boton de eliminar imagen y comprobar si se elimina en la edición */
        }else if(publiTipo.value == null){
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = "Es obligatorio seleccionar un tipo de evento para crear una publicación.";
        }else if(publiTipo.value == "1" && (fechaInicio.value == null || fechaFin.value == null) ){ /* Cambiar el tipo cuando llegue la info del back */
            errorTitle.value = null;
            errorDesc.value = null;
            errorType.value = null;
            errorDate.value = "Debe seleccionar las fechas de inicio y fin del evento.";
        }else{
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
        <tempalte class="flex flex-col items-center justify-center">
            <header class="flex items-center relative w-[90vw] justify-center">
                <button class="lg:hidden absolute left-0">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="lg:text-xl">Editar Perfil</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" requerido="true" label="Nombre" :valor="nombre" :error="errorNombre"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen de perfil" requerido="true" clase="perfil" :error="errorIMG" :valor="imagenPerfil"/>
                    <Input @datos="(nuevosDatos)=>{imagen = nuevosDatos}" tipo="file" label="Imagen de fondo" clase="banner" :valor="imagenBanner"/>
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="text" label="Teléfono" :valor="telefono"/>
                    <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="email" requerido="true" label="Email" :valor="email" :error="errorMail"/>
                    <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de nacimiento" :valor="fechaNac" :error="errorDate"/>
                    <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" label="Sexo" :opciones="optionsSex" placeholder="Selecciona tu sexo" :valor="sexo"/>
                    <Input @datos="(nuevosDatos)=>{publiTipo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Municipio" :opciones="options" placeholder="Selecciona un municipio" :error="errorMunic" :valor="municipio"/>
                        <div class="cambiocontra flex flex-col gap-y-5">
                            <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="password" label="Contraseña Actual" :valor="contraActual" :error="errorContra"/>
                            <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="password" label="Contraseña Nueva" :valor="contraNueva" :error="errorContra"/>
                            <Input @datos="(nuevosDatos)=>{titulo = nuevosDatos}" tipo="password" label="Repetir contraseña" :valor="repetirNueva" :error="errorContra"/>
                        </div>
                    <div class="flex flex-col items-center w-full justify-center mt-3">
                        <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Guardar Cambios" class="w-[50%]"/>
                    </div>
                </form>
            </section>
        </tempalte>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
