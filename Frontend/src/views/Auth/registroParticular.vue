<script setup>
import { useRouter } from 'vue-router';
import { ref } from 'vue';

import Input from "@/components/comun/input.vue";

let options = ["Los Llanos de Aridane", "Santa Cruz de la Palma", "Tijarafe", "El Paso", "Puntagorda", "Villa de Mazo"]; /* Cambiar por info del back */
let optionsSex = ["M", "H"]; /* Cambiar por info del back */
let arrayTipos = ["Particular", "Comercio"]; 
let errorIMG = ref(null);
let errorMunic = ref(null);
let errorDate = ref(null);
let errorCategory = ref(null);
let errorUsuario = ref(null);
let errorNombre = ref(null);
let errorMail = ref(null);
let errorDirec = ref(null);
let errorPhone = ref(null);
const router = useRouter();
const horarioActual = ref("No tienes un horario registrado");
const tipoUsuario = ref(null);
const usuario = ref(null);
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
    console.log(contraNueva.value);
    console.log(repetirNueva.value);
    if(nombre.value.length == 0){
        errorNombre.value = "El nombre no puede estar vacío.";
    }else if(tipoUsuario.value == 'comercio' && telefono.value.length == 0){
        errorNombre.value = null;
        errorPhone.value = "Es necesario indicar un teléfono de contacto para tu negocio.";
    }
}
</script>


<template>
    <div class="flex w-[99vw] justify-center lg:justify-end mb-5">
        <div class="fixed hidden lg:flex items-center top-0 left-16">
            <img src="@public/img/fondo.png" alt="Imagen Fondo">
        </div>
        <div class="lg:w-[60vw] w-[90vw] flex flex-col lg:items-center mt-10">
            <h1 class="text-center text-5xl mb-7">Registro</h1>
            <form action="javascript:void(0);" class="flex flex-col gap-y-5 lg:w-[45%]">
                <Input @datos="(nuevosDatos)=>{tipoUsuario = arrayTipos[nuevosDatos].toLowerCase()}" class="w-[40%]" tipo="selection" requerido="true" :opciones=arrayTipos placeholder="Tipos" v-model='tipoUsuario' label="Tipo de usuario" :valor="tipoUsuario"/>
                <Input @datos="(nuevosDatos)=>{usuario = nuevosDatos}" tipo="text" requerido="true" label="Usuario" :valor="usuario" :error="errorUsuario"/>
                <Input @datos="(nuevosDatos)=>{nombre = nuevosDatos}" tipo="text" requerido="true" label="Nombre" :valor="nombre" :error="errorNombre"/>
                <div class="imagenes flex gap-x-10 lg:gap-x-20">
                    <p v-if="errorIMG != null" class="text-primary-700 text-xs lg:text-sm ms-3">{{ errorIMG }}</p>
                    <Input @datos="(nuevosDatos)=>{imagenPerfil = nuevosDatos}" tipo="file" label="Imagen de perfil" requerido="true" clase="perfil" :error="errorIMG" :valor="imagenPerfil"/>
                    <Input @datos="(nuevosDatos)=>{imagenBanner = nuevosDatos}" tipo="file" label="Imagen de fondo" clase="banner" :valor="imagenBanner"/>
                </div>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" label="Teléfono" :valor="telefono"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" requerido="true" label="Teléfono" :valor="telefono" :error="errorPhone"/>
                <Input @datos="(nuevosDatos)=>{email = nuevosDatos}" tipo="email" requerido="true" label="Email" :valor="email" :error="errorMail"/>
                <Input @datos="(nuevosDatos)=>{municipio = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Municipio" :opciones="options" placeholder="Selecciona un municipio" :error="errorMunic" :valor="municipio"/>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{fechaNac = nuevosDatos}" tipo="fecha" requerido="true" label="Fecha de nacimiento" :valor="fechaNac" :error="errorDate"/>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{sexo = nuevosDatos}" class="lg:w-[40%] w-[60%]" @change="mostrarInformacion" tipo="selection" label="Sexo" :opciones="optionsSex" placeholder="Selecciona tu sexo" :valor="sexo"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{direccion = nuevosDatos}" tipo="text" requerido="true" label="Dirección" :valor="direccion" :error="errorDirec"/>
                <Input v-if="tipoUsuario == 'comercio'" tipo="texto" requerido="true" label="Horario Actual" :valor="horarioActual" class="pointer-events-none"/>
                <Input v-if="tipoUsuario == 'comercio'" @click="mostrarModal" tipo="submit" clase="claro" valor="Cambiar horario" class="w-[50%] self-center"/>
                <Input v-if="tipoUsuario == 'comercio'" tipo="text" label="Token (Si tienes)" :valor="token"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{categoria = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Categoría" :opciones="optionsCategory" placeholder="Selecciona una categoría" :error="errorCategory" :valor="categoria"/>
                <div class="cambiocontra flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{contraNueva = nuevosDatos}" tipo="password" label="Contraseña Nueva" :valor="contraNueva" :error="errorContra"/>
                    <Input @datos="(nuevosDatos)=>{repetirNueva = nuevosDatos}" tipo="password" label="Repetir contraseña" :valor="repetirNueva" :error="errorContra"/>
                </div>
                <div class="flex flex-col items-center w-full justify-center mt-3 gap-y-10">
                    <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Guardar Cambios" class="w-[50%]"/>
                </div>
            </form>
            <div class="flex justify-center gap-x-1 mt-3">
                <p>¿Ya tienes una cuenta?</p>
                <button @click="router.push('/login')" class="font-semibold">Inicia sesión</button>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>

