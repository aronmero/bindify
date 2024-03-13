<script setup>
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { solicitarCategorias, solicitarMunicipios } from '@/Api/Auth/desplegables_registro.js';

/** Importa el Modal de Horarios */
import Horarios from '../../components/intervalos_horarios/Horarios.vue';

import { register } from '../../Api/auth';
import Input from "@/components/comun/input.vue";

let options = ref("null"); /* Cambiar por info del back */
let optionsSex = [{id: 0, name: "M"}, {id: 1, name: "H"}]; /* Cambiar por info del back */
let arrayTipos = [{id: 0, name: "Particular"}, {id: 1, name: "Comercio"}];
let optionsCategory = ref("null");
let errorIMG = ref(null);
let errorMunic = ref(null);
let errorDate = ref(null);
let errorCategory = ref(null);
let errorUsuario = ref(null);
let errorNombre = ref(null);
let errorMail = ref(null);
let errorDirec = ref(null);
let errorPhone = ref(null);
let errorType = ref(null);
let errorContra = ref(null);
let errorSche = ref(null);
const router = useRouter();
const horarioActual = ref(null);
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
const token = ref(null);
const isValid = ref(null);

/* Genera la referencia para controlar el estado de mostrado u oculto */
const controlador_modal = ref(false);

const solicitarDatosApi = async()=>{
    optionsCategory.value = await solicitarCategorias("GET").then(data => data = data.data);
    options.value = await solicitarMunicipios("GET").then(data => data = data.data);
    console.log(options.value);
}
solicitarDatosApi();
/* Falta vincular modal de editar horario y hacer las validaciones */
const tratarDatos = ()=>{
    console.log(tipoUsuario.value);
    console.log(usuario.value);
    console.log(nombre.value);
    console.log(imagenPerfil.value);
    console.log(imagenBanner.value);
    console.log(telefono.value);
    console.log(email.value);
    console.log(municipio.value);
    console.log(fechaNac.value);
    console.log(optionsSex[sexo.value]);
    console.log(horarioActual.value);
    console.log(direccion.value);
    console.log(categoria.value);
    console.log(contraNueva.value);
    console.log(repetirNueva.value);
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if(tipoUsuario.value == null){
        window.scroll({top:100, right:0, behavior: 'smooth'});
        errorType.value = "Debe seleccionar un tipo de usuario.";
    }else{
        errorType.value = null;
    }
    if(usuario.value == null || usuario.value.length == 0){
        window.scroll({top:100, right:0, behavior: 'smooth'});
        errorUsuario.value = "Es necesario indicar un usuario para registrarse.";
    }else{
        errorUsuario.value = null;
    }
    if(nombre.value == null || nombre.value.length == 0){
        window.scroll({top:100, right:0, behavior: 'smooth'});
        errorNombre.value = "Es necesario indicar tu nombre para identificarte en la aplicación.";
    }else{
        errorNombre.value = null;
    }
    if(email.value == null || email.value.length == 0){
        errorMail.value = "Es necesario indicar un email.";
    }else{
        if(!emailRegex.test(email.value)) {
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
    if((contraNueva.value == null || contraNueva.value.length == 0) && (repetirNueva.value == null || repetirNueva.value.length == 0)){
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
    if(tipoUsuario.value == 'particular'){
        if(fechaNac.value == null || fechaNac.value.length == 0){
            errorDate.value = "Debe indicar su fecha de nacimiento.";
        }else{
            errorDate.value = null;
        }
        if(errorDate.value == null && errorContra.value == null && errorType.value == null && errorUsuario.value == null && errorNombre.value == null && errorMail.value == null && errorMunic.value == null){
            let datos = {
            "email": email.value,
            "password": contraNueva.value,
            "phone": telefono.value,
            "municipality_id": municipio.value,
            "avatar": imagenPerfil.value,
            "banner": imagenBanner.value,
            "username": usuario.value,
            "name": nombre.value,
            "category_id": categoria.value,
            "empresa": 0,
            "schedule": horarioActual.value,
            "address": direccion.value,
            "gender": optionsSex[sexo.value] == undefined ? null : optionsSex[sexo.value].name,
            "birth_date": fechaNac.value,
            "password_confirmation": repetirNueva.value,
            }
            let respuesta = register(datos);
            if(respuesta.status){
                email.value = null;
                tipoUsuario.value = null;
                usuario.value = null;
                nombre.value = null;
                imagenPerfil.value = null;
                municipio.value = null;
                contraNueva.value = null;
                repetirNueva.value = null;
                fechaNac.value = null;
                sexo.value = null;
                sessionStorage.setItem(
                    "usuario",
                    JSON.stringify({ usuario: data.message })
                );
                router.push("/");
                router.go();
            }else{
                console.log("Error de back en el registro"); /* Mostrar el error en algún lado */
            }
        }else{
            console.log("Hay errores");
        }
    }else{
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
        if(horarioActual.value == null || horarioActual.value.length == 0){
            errorSche.value = "Debe indicar el horario de su negocio.";
            

        }else{
            errorSche.value = null;
            
        }
        if(categoria.value == null || categoria.value.length == 0){
            errorCategory.value = "Debe seleccionar la categoria de su negocio.";
            

        }else{
            errorCategory.value = null;
            
        }
        if(errorCategory.value == null && errorSche.value == null && errorDirec.value == null && errorPhone.value == null && errorContra.value == null && errorType.value == null && errorUsuario.value == null && errorNombre.value == null && errorMail.value == null && errorMunic.value == null){
            let datos = {
                "email": email.value,
                "password": contraNueva.value,
                "phone": telefono.value,
                "municipality_id": municipio.value,
                "avatar": imagenPerfil.value,
                "banner": imagenBanner.value,
                "username": usuario.value,
                "name": nombre.value,
                "category_id": categoria.value,
                "empresa": 1,
                "schedule": horarioActual.value,
                "address": direccion.value,
                "gender": optionsSex[sexo.value],
                "birth_date": fechaNac.value,
                "verification_token_id": token.value,
                "password_confirmation": repetirNueva.value,
            }
            let respuesta = register(datos);
            if(respuesta.status){
                email.value = null;
                tipoUsuario.value = null;
                usuario.value = null;
                nombre.value = null;
                imagenPerfil.value = null;
                municipio.value = null;
                contraNueva.value = null;
                repetirNueva.value = null;
                direccion.value = null;
                horarioActual.value = null;
                categoria.value = null;
                token.value = null;
                sessionStorage.setItem(
                    "usuario",
                    JSON.stringify({ usuario: data.message })
                );
                router.push("/");
                router.go();
            }else{
                console.log("Error de back en el registro"); /* Mostrar el error en algún lado */
            }
        }else{
            console.log("Hay errores")
        }
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


/** Controla la dinámica de mostrar y ocultar el modal
 * @author David Martín Concepción
 */
const controlarModal = () => {
    console.log("test")
    if(controlador_modal.value) {
        controlador_modal.value = false;
    } else {
        controlador_modal.value = true;
    }
}

</script>


<template>
    <div class="flex w-[99vw] justify-center xl:justify-end mb-5">
        <div class="fixed h-full hidden xl:flex items-center top-0 left-0 w-[50vw] justify-center">
            <img src="@public/img/fondo.png" alt="Imagen Fondo">
        </div>
        <div class="xl:w-[60vw] w-[90vw] flex flex-col lg:items-center mt-10">
            <h1 class="text-center text-5xl mb-7">Registro</h1>
            <form action="javascript:void(0);" class="flex flex-col gap-y-5 lg:w-[55%] xl:w-[45%]">
                <Input @datos="(nuevosDatos)=>{tipoUsuario = arrayTipos[nuevosDatos].name.toLowerCase()}" class="lg:w-[50%]" tipo="selection" requerido="true" :opciones="arrayTipos" placeholder="Tipos" v-model='tipoUsuario' label="Tipo de usuario" :valor="tipoUsuario" :error="errorType"/>
                <Input @datos="(nuevosDatos)=>{usuario = nuevosDatos}" tipo="text" requerido="true" label="Usuario" :valor="usuario" :error="errorUsuario"/>
                <Input @datos="(nuevosDatos)=>{nombre = nuevosDatos}" tipo="text" requerido="true" label="Nombre" :valor="nombre" :error="errorNombre"/>
                <div class="imagenes flex gap-x-10 xl:gap-x-20">
                    <p v-if="errorIMG != null" class="text-primary-700 text-xs xl:text-sm ms-3">{{ errorIMG }}</p>
                    <Input @datos="(nuevosDatos)=>{imagenPerfil = nuevosDatos}" tipo="file" label="Imagen de perfil" clase="perfil" :error="errorIMG" :valor="imagenPerfil"/>
                    <Input @datos="(nuevosDatos)=>{imagenBanner = nuevosDatos}" tipo="file" label="Imagen de fondo" clase="banner" :valor="imagenBanner"/>
                </div>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" label="Teléfono" :valor="telefono"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{telefono = nuevosDatos}" tipo="text" requerido="true" label="Teléfono" :valor="telefono" :error="errorPhone"/>
                <Input @datos="(nuevosDatos)=>{email = nuevosDatos}" tipo="text" requerido="true" label="Email" :valor="email" :error="errorMail"/>
                <Input @datos="(nuevosDatos)=>{municipio = nuevosDatos}" tipo="selection" requerido="true" label="Municipio" :opciones="options" placeholder="Selecciona un municipio" :error="errorMunic" :valor="municipio"/>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{fechaNac = nuevosDatos}" tipo="fechaLibre" requerido="true" label="Fecha de nacimiento" :valor="fechaNac" :error="errorDate"/>
                <Input v-if="tipoUsuario == 'particular'" @datos="(nuevosDatos)=>{sexo = nuevosDatos}" class="xl:w-[40%] w-[60%]" tipo="selection" label="Sexo" :opciones="optionsSex" placeholder="Selecciona tu sexo" :valor="sexo"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{direccion = nuevosDatos}" tipo="text" requerido="true" label="Dirección" :valor="direccion" :error="errorDirec"/>
                <Input v-if="tipoUsuario == 'comercio'" tipo="texto" requerido="true" label="Horario Actual" :valor="horarioActual" class="pointer-events-none"  :error="errorSche"/>
                <Input v-if="tipoUsuario == 'comercio'"  @click="controlarModal" tipo="submit" clase="claro" valor="Cambiar horario" class="w-[50%] self-center"/>
                <Input v-if="tipoUsuario == 'comercio'" tipo="text" label="Token (Si tienes)" :valor="token"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{categoria = nuevosDatos}" tipo="selection" requerido="true" label="Categoría" :opciones="optionsCategory" placeholder="Selecciona una categoría" :error="errorCategory" :valor="categoria"/>
                <div class="cambiocontra flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{contraNueva = nuevosDatos}" tipo="password" requerido="true" label="Contraseña Nueva" :valor="contraNueva" :error="errorContra"/>
                    <Input @datos="(nuevosDatos)=>{repetirNueva = nuevosDatos}" tipo="password" requerido="true" label="Repetir contraseña" :valor="repetirNueva" :error="errorContra"/>
                </div>
                <div class="flex flex-col items-center w-full justify-center mt-3 gap-y-10">
                    <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Registrarme" class="w-[50%]"/>
                </div>
            </form>
            <div class="flex justify-center gap-x-1 mt-3">
                <p>¿Ya tienes una cuenta?</p>
                <button @click="router.push('/login')" class="font-semibold">Inicia sesión</button>
            </div>
        </div>
    </div>
    <Horarios v-if="controlador_modal" :referencia_padre="horarioActual" :controlar_modal="controlarModal" :enviar_cambios="obtenerCambioHorario" />
</template>


<style scoped>

</style>

