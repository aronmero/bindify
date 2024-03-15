<script setup>
import router from "@/router/index.js";
import { ref } from "vue";
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "@/components/comun/input.vue";

import Horarios from '@/components/intervalos_horarios/Horarios.vue';
import { solicitarCategorias, solicitarMunicipios } from '@/Api/Auth/desplegables_registro.js';
import { updateUserData } from "../../Api/perfiles/perfil";

/* Genera la referencia para controlar el estado de mostrado u oculto */
const controlador_modal = ref(false);

let options = ref(null);
let optionsCategory = ref(null);
let optionsSex = [{id: "M", name: "M"}, {id: "H", name: "H"}];
const solicitarDatosApi = async()=>{
    optionsCategory.value = await solicitarCategorias("GET").then(data => data = data.data);
    options.value = await solicitarMunicipios("GET").then(data => data = data.data);
}
solicitarDatosApi();
let errorIMG = ref(null);
let errorMunic = ref(null);
let errorDate = ref(null);
let errorCategory = ref(null);
let errorNombre = ref(null);
let errorMail = ref(null);
let errorDirec = ref(null);
let errorPhone = ref(null);
let errorContra = ref(null);
let errorSche = ref(null);
const imagenPerfilDefault = '/public/img/placeholderPerfil.webp';
const imagenBannerDefault = '/public/img/placeholderBanner.webp';
const userType = ref(JSON.parse(sessionStorage.getItem("usuario")));
userType.value = userType.value.usuario;
//console.log(userType.value);
const tipoUsuario = ref(userType.value.tipo);
const user = ref(JSON.parse(sessionStorage.getItem("userData")));
if(tipoUsuario.value == 'customer'){
    user.value = user.value.userData;
}else{
    user.value = user.value.userData[0];
}
//console.log(user.value);
const nombre = ref(user.value.name);
const imagenPerfil = ref(user.value.avatar);
const imagenBanner = ref(user.value.banner);
const telefono = ref(user.value.phone);
const email = ref(user.value.email);
const municipio = ref(user.value.municipality_name);
const contraNueva = ref(null);
const repetirNueva = ref(null);
const direccion = ref(user.value.address);
const horarioActual = ref(null);
if(user.value.schedule != null && user.value.schedule != "null"){
    horarioActual.value = user.value.schedule;
}
const categoria = ref(user.value.categories_name);
const hashtags = ref("");
const fechaNac = ref(user.value.birth_date);
const sexo = ref(user.value.gender);
if(userType.value.tipo == 'commerce'){
    user.value.hashtags.forEach(hashtag =>{
        hashtags.value = hashtags.value+" "+hashtag;
    });
}
if(imagenPerfil.value == 'default'){
    imagenPerfil.value = imagenPerfilDefault;
}
if(imagenBanner.value == 'default'){
    imagenBanner.value = imagenBannerDefault;
}
const isValid = ref(null);
const tratarDatos = async ()=>{
    /*
    //console.log(nombre.value);
    //console.log(imagenPerfil.value);
    //console.log(imagenBanner.value);
    //console.log(telefono.value);
    //console.log(email.value.length);
    //console.log(municipio.value);
    //console.log(fechaNac.value);
    //console.log(sexo.value);
    //console.log(horarioActual.value);
    //console.log(direccion.value);
    //console.log(categoria.value);
    //console.log(contraNueva.value);
    //console.log(repetirNueva.value);
    //console.log(tipoUsuario.value);*/
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if(nombre.value == null || nombre.value.length == 0){
        window.scroll({top:50, right:0, behavior: 'smooth'});
        errorNombre.value = "Es necesario indicar tu nombre para identificarte en la aplicación.";
    }else{
        errorNombre.value = null;
    }
    if(email.value == null || email.value.length == 0){
        window.scroll({top:500, right:0, behavior: 'smooth'});
        errorMail.value = "Es necesario indicar un email.";
    }else{
        if(!emailRegex.test(email.value)) {
        window.scroll({top:500, right:0, behavior: 'smooth'});
        errorMail.value = "El email indicado no es válido.";
        }else{
            errorMail.value = null;
        }
    }
    if(municipio.value == null || municipio.value.length == 0){
        errorMunic.value = "Debes seleccionar el municipio en el que vives.";
    }else{
        errorMunic.value = null;
    }
   /*  if((contraNueva.value != null && contraNueva.value.length > 0)){
        if(repetirNueva.value == null || repetirNueva.value.length == 0){
            errorContra.value = "Debe indicar y repetir una contraseña.";
        }else{
            if(contraNueva.value != repetirNueva.value){
                errorContra.value = "Las contraseñas no coinciden.";
                contraNueva.value = null;
                repetirNueva.value = null;
            }else{
                errorContra.value = null;
            }
        }
    }else{
        errorContra.value = null;
    } */
    if(tipoUsuario.value == 'customer'){
        if(fechaNac.value == null || fechaNac.value.length == 0){
            errorDate.value = "Debe indicar su fecha de nacimiento.";
        }else{
            errorDate.value = null;
        }
        if(errorDate.value == null /* && errorContra.value == null */ && errorNombre.value == null && errorMail.value == null && errorMunic.value == null){
            if(imagenBanner.value == imagenBannerDefault){
                imagenBanner.value = null;
            }
            if(imagenPerfil.value == imagenPerfilDefault){
                imagenPerfil.value = null;
            }
            if(municipio.value != null && municipio.value != user.value.municipality_name){
                municipio.value = options.value[municipio.value-1].name;
            } 
            let datos =  {
                "email": email.value,
                /* "password": contraNueva.value, */
                "phone": telefono.value,
                "municipality": municipio.value,
                "avatar": imagenPerfil.value,
                "banner": imagenBanner.value,
                "name": nombre.value,
                "category": categoria.value,
                "empresa": false,
                "schedule": horarioActual.value,
                "address": direccion.value,
                "gender": sexo.value,
                "birth_date": fechaNac.value,
                /* "password_confirmation": repetirNueva.value, */
            }
            console.log(datos);
            let respuesta = await updateUserData("POST", datos, userType.value.username);
            console.log(respuesta);
            if(respuesta.status){
                email.value = null;
                nombre.value = null;
                imagenPerfil.value = null;
                municipio.value = null;
                contraNueva.value = null;
                repetirNueva.value = null;
                fechaNac.value = null;
                sexo.value = null;
                sessionStorage.setItem(
                    "userData",
                    JSON.stringify({ usuario: respuesta.data })
                    );
                    router.go(-1);
            }else{
            //console.log("Error de back en el registro");
            }
        }
    }else{

        let auxFechaNacBack = null;

        if(fechaNac.value == undefined){
            //console.log('No esta definida la fechaNac');
        }else{
            //console.log("Al fin usas la fechaNac");
            //console.log(fechaNac);
            //console.log(fechaNac.value);
            auxFechaNacBack = fechaNac.value;
        }

        if(telefono.value == null || telefono.value.length == 0){
            errorPhone.value = "Debe indicar el teléfono de su negocio.";

        }else{
            errorPhone.value = null;

        }
        if(direccion.value == null || direccion.value.length == 0){
            errorDirec.value = "Debe indicar la dirección de su negocio.";

        }else{
            errorDirec.value = null;

        }
        if(categoria.value == null || categoria.value.length == 0){
            errorCategory.value = "Debe seleccionar la categoria de su negocio.";

        }else{
            errorCategory.value = null;

        }
        if(errorCategory.value == null && errorDirec.value == null && errorPhone.value == null /* && errorContra.value == null */ && errorNombre.value == null && errorMail.value == null && errorMunic.value == null){
            if(imagenBanner.value == imagenBannerDefault){
                imagenBanner.value = null;
            }
            if(imagenPerfil.value == imagenPerfilDefault){
                imagenPerfil.value = null;
            }
            if(municipio.value != null && municipio.value != user.value.municipality_name){
                municipio.value = options.value[municipio.value-1].name;
            }
            if(categoria.value != null && categoria.value != user.value.categories_name){
                categoria.value = optionsCategory.value[categoria.value-1].name;
            }
            let datos = {
                "email": email.value,
                /* "password": contraNueva.value, */
                "phone": telefono.value,
                "municipality": municipio.value,
                "avatar": imagenPerfil.value,
                "banner": imagenBanner.value,
                "name": nombre.value,
                "category": categoria.value,
                "description": hashtags.value,
                "empresa": true,
                "schedule": horarioActual.value,
                "address": direccion.value,
                "gender": sexo.value,
                "birth_date": auxFechaNacBack,
                /* "password_confirmation": repetirNueva.value, */
            }
            console.log(datos);
            let respuesta = await updateUserData("POST", datos, userType.value.username);
            //console.log(respuesta)
            if(respuesta.status){
                email.value = null;
                nombre.value = null;
                imagenPerfil.value = null;
                municipio.value = null;
                contraNueva.value = null;
                repetirNueva.value = null;
                direccion.value = null;
                horarioActual.value = null;
                categoria.value = null;
                sessionStorage.setItem(
                    "userData",
                    JSON.stringify({ usuario: respuesta.data })
                );
                router.go(-1);
            }else{
                //console.log("Error de back en el registro");
            } 
        }
    }
}
/** Controla la apertura del modal de horarios */
const controlarModal = () => {
    //console.log(horarioActual)
    //console.log(controlador_modal.value)
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
    //console.log("obtenido cambio")
    controlador_modal.value = false;
}

/* <div class="cambiocontra flex flex-col gap-y-5">
    <p v-if="errorContra != null" class="text-primary-700 text-xs lg:text-sm ms-3">{{ errorContra }}</p>
    <Input @datos="(nuevosDatos)=>{contraNueva = nuevosDatos}" tipo="password" label="Contraseña Nueva" :valor="contraNueva" />
    <Input @datos="(nuevosDatos)=>{repetirNueva = nuevosDatos}" tipo="password" label="Repetir contraseña" :valor="repetirNueva" />
</div> */
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
                <h3 class="lg:text-xl">Editar perfil</h3>
            </header>
            <section class="w-full mt-5 mb-5">
                <form action="javascript:void(0);" class="flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{nombre = nuevosDatos}" tipo="text" requerido="true" label="Nombre" :valor="nombre" :error="errorNombre"/>
                    <div class="imagenes flex gap-x-10 lg:gap-x-32">
                        <p v-if="errorIMG != null" class="text-primary-700 text-xs lg:text-sm ms-3">{{ errorIMG }}</p>
                        <Input @datos="(nuevosDatos)=>{imagenPerfil = nuevosDatos}" tipo="file" label="Imagen de perfil" clase="perfil" :error="errorIMG" :valor="imagenPerfil"/>
                        <Input @datos="(nuevosDatos)=>{imagenBanner = nuevosDatos}" tipo="file" label="Imagen de fondo" clase="banner" :valor="imagenBanner"/>
                    </div>
                    <Input v-if="tipoUsuario == 'customer'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" label="Teléfono" :valor="telefono"/>
                    <Input v-if="tipoUsuario == 'commerce'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" requerido="true" label="Teléfono" :valor="telefono" :error="errorPhone"/>
                    <Input @datos="(nuevosDatos)=>{municipio = nuevosDatos}" tipo="selection" requerido="true" label="Municipio" :opciones="options" placeholder="Selecciona un municipio" :error="errorMunic" :valor="municipio"/>
                    <Input v-if="tipoUsuario == 'customer'" @datos="(nuevosDatos)=>{fechaNac = nuevosDatos}" tipo="fechaLibre" requerido="true" label="Fecha de nacimiento" :valor="fechaNac" :error="errorDate"/>
                    <Input v-if="tipoUsuario == 'customer'" @datos="(nuevosDatos)=>{sexo = nuevosDatos}" tipo="selection" label="Sexo" :opciones="optionsSex" placeholder="Selecciona tu sexo" :valor="sexo"/>
                    <Input v-if="tipoUsuario == 'commerce'" @datos="(nuevosDatos)=>{direccion = nuevosDatos}" tipo="text" requerido="true" label="Dirección" :valor="direccion" :error="errorDirec"/>
                    <Input v-if="tipoUsuario == 'commerce'" @datos="(nuevosDatos)=>{hastags = nuevosDatos}" tipo="text" label="Hashtags" :valor="hashtags"/>
                    <Input v-if="tipoUsuario == 'commerce'" tipo="texto" label="Horario Actual" :valor="horarioActual"/>
                    <Input v-if="tipoUsuario == 'commerce'" @click="controlarModal" tipo="submit" clase="claro" valor="Cambiar horario" class="w-[50%] self-center"/>
                    <Input v-if="tipoUsuario == 'commerce'" @datos="(nuevosDatos)=>{categoria = nuevosDatos}" tipo="selection" requerido="true" label="Categoría" :opciones="optionsCategory" placeholder="Selecciona una categoría" :error="errorCategory" :valor="categoria"/>
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
