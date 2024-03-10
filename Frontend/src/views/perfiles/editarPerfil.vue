<script setup>
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";

import Horarios from '@/components/intervalos_horarios/Horarios.vue'

/* Genera la referencia para controlar el estado de mostrado u oculto */
const controlador_modal = ref(false);

let options = ["Los Llanos de Aridane", "Santa Cruz de la Palma", "Tijarafe", "El Paso", "Puntagorda", "Villa de Mazo"]; /* Cambiar por info del back */
let optionsSex = ["M", "H"]; /* Cambiar por info del back */
let errorIMG = ref(null);
let errorMunic = ref(null);
let errorDate = ref(null);
let errorCategory = ref(null);
let errorNombre = ref(null);
let errorMail = ref(null);
let errorDirec = ref(null);
let errorPhone = ref(null);
const horarioActual = ref(" 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo ");
const tipoUsuario = ref("comercio");
const nombre = ref(null);
const imagenPerfil = ref(null);
const imagenBanner = ref(null);
const telefono = ref(null);
const email = ref(null);
const municipio = ref(null);
const fechaNac = ref(null);
const sexo = ref(null);
const direccion = ref(null);
const categoria = ref(null);
const contraActual = ref(null);
const contraNueva = ref(null);
const repetirNueva = ref(null);

const mostrarInformacion = (e)=>{
    let opciones = [...e.target.children];
    let opcionSeleccionada = opciones.filter(opcion => opcion.selected == true);
    if(opcionSeleccionada[0].textContent != null){
        tipo.value = opcionSeleccionada[0].textContent;
    }
}
/* Falta vincular modal de editar horario y hacer las validaciones */
const tratarDatos = ()=>{
    console.log(tipoUsuario.value);
    console.log(nombre.value);
    console.log(imagenPerfil.value);
    console.log(imagenBanner.value);
    console.log(telefono.value);
    console.log(email.value);
    console.log(municipio.value);
    console.log(fechaNac.value);
    console.log(sexo.value);
    console.log(horarioActual.value);
    console.log(direccion.value);
    console.log(categoria.value);
    console.log(contraActual.value);
    console.log(contraNueva.value);
    console.log(repetirNueva.value);
    if(nombre.value.length == 0){
        errorNombre.value = "El nombre no puede estar vacío.";
    }else if(tipoUsuario.value == 'comercio' && telefono.value.length == 0){
        errorNombre.value = null;
        errorPhone.value = "Es necesario indicar un teléfono de contacto para tu negocio.";
    }
}
/** Controla la apertura del modal de horarios */
const controlarModal = () => {
    console.log(horarioActual)
    console.log(controlador_modal.value)
    if(controlador_modal.value) {
        controlador_modal.value = false;
    } else {
        controlador_modal.value = true;
    }
   
}
/**
 * Agrega el cambio de horario
 * @author 'David'
 * */
const obtenerCambioHorario = (cambio) => {
    horarioActual.value = cambio;
    console.log("obtenido cambio")
    controlador_modal.value = false;
}

</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>
        <template class="flex flex-col items-center justify-center">
            <header class="flex items-center relative w-[90vw] justify-center">
                <button  class="lg:hidden absolute left-0">
                    <img src="/assets/icons/forward.svg" alt="Boton para volver atras">
                </button>
                <h3 class="text-xl lg:text-2xl">Editar Perfil</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{nombre = nuevosDatos}" tipo="text" requerido="true" label="Nombre" :valor="nombre" :error="errorNombre"/>
                    <div class="imagenes flex gap-x-10 lg:gap-x-32">
                        <p v-if="errorIMG != null" class="text-primary-700 text-xs lg:text-sm ms-3">{{ errorIMG }}</p>
                        <Input @datos="(nuevosDatos)=>{imagenPerfil = nuevosDatos}" tipo="file" label="Imagen de perfil" requerido="true" clase="perfil" :error="errorIMG" :valor="imagenPerfil"/>
                        <Input @datos="(nuevosDatos)=>{imagenBanner = nuevosDatos}" tipo="file" label="Imagen de fondo" clase="banner" :valor="imagenBanner"/>
                    </div>
                    <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" label="Teléfono" :valor="telefono"/>
                    <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" requerido="true" label="Teléfono" :valor="telefono" :error="errorPhone"/>
                    <Input @datos="(nuevosDatos)=>{email = nuevosDatos}" tipo="email" requerido="true" label="Email" :valor="email" :error="errorMail"/>
                    <Input @datos="(nuevosDatos)=>{municipio = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Municipio" :opciones="options" placeholder="Selecciona un municipio" :error="errorMunic" :valor="municipio"/>
                    <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{fechaNac = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de nacimiento" :valor="fechaNac" :error="errorDate"/>
                    <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{sexo = nuevosDatos}" @change="mostrarInformacion" tipo="selection" label="Sexo" :opciones="optionsSex" placeholder="Selecciona tu sexo" :valor="sexo"/>
                    <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{direccion = nuevosDatos}" tipo="text" requerido="true" label="Dirección" :valor="direccion" :error="errorDirec"/>
                    <Input v-if="tipoUsuario == 'comercio'" tipo="texto" requerido="true" label="Horario Actual" :valor="horarioActual"/>
                    <Input @click="controlarModal" tipo="submit" clase="claro" valor="Cambiar horario" class="w-[50%] self-center"/>
                    <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{categoria = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Categoría" :opciones="optionsCategory" placeholder="Selecciona una categoría" :error="errorCategory" :valor="categoria"/>
                    <div class="cambiocontra flex flex-col gap-y-5">
                        <Input @datos="(nuevosDatos)=>{contraActual = nuevosDatos}" tipo="password" label="Contraseña Actual" :valor="contraActual" :error="errorContra"/>
                        <Input @datos="(nuevosDatos)=>{contraNueva = nuevosDatos}" tipo="password" label="Contraseña Nueva" :valor="contraNueva" :error="errorContra"/>
                        <Input @datos="(nuevosDatos)=>{repetirNueva = nuevosDatos}" tipo="password" label="Repetir contraseña" :valor="repetirNueva" :error="errorContra"/>
                    </div>
                    <div class="flex flex-col items-center w-full justify-center mt-3 gap-y-10">
                        <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Guardar Cambios" class="w-[50%]"/>
                    </div>
                </form>
                
            </section>
            <!-- Modal de Intervalos Horarios -->
            <Horarios v-if="controlador_modal" :referencia_padre="horarioActual" :controlar_modal="controlarModal" :enviar_cambios="obtenerCambioHorario" />
        </template>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
