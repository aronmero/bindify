<script setup>
/* Importar componentes y funciones */
import Input from "@/components/comun/input.vue";
import { useRouter } from 'vue-router';
import { ref } from 'vue';  // Importación de ref desde vue para variables reactivas
import Horarios from '../../components/intervalos_horarios/Horarios.vue';   // Importa el Modal de Horarios


/* Array de opciones */
let options = ["Los Llanos de Aridane", "Santa Cruz de la Palma", "Tijarafe", "El Paso", "Puntagorda", "Villa de Mazo"] /* Array de municipios. Otros municipios: "Fuencaliente", "Puntallana", "Garafía", "Barlovento", "Breña Alta", "Breña Baja", "San Andrés y Sauces", "Tazacorte" */
let optionsSex = ["M", "H"];    // Array de opciones según el género: M = mujer y H = hombre.
let arrayTipos = ["Particular", "Comercio"];    // Array del tipo de usuario: particular o de comercio.


/* Declaración de variables reactivas para los errores */
let errorIMG = ref(null);
let errorMunic = ref(null);
let errorDate = ref(null);
let errorCategory = ref(null);
let errorUsuario = ref(null);
let errorNombre = ref(null);
let errorMail = ref(null);
let errorDirec = ref(null);
let errorPhone = ref(null);


const router = useRouter();     // Variable para el uso del router.


/* Declaración de variables reactivas */
const horarioActual = ref("No tienes un horario registrado");   // Valor por defecto: No tienes un horario registrado
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



/* Genera la referencia para controlar el estado de mostrado u oculto */
const controlador_modal = ref(false);

/* Muestra la información del array de opciones */
const mostrarInformacion = (e)=>{
    let opciones = [...e.target.children];
    let opcionSeleccionada = opciones.filter(opcion => opcion.selected == true);
    if(opcionSeleccionada[0].textContent != null){
        tipo.value = opcionSeleccionada[0].textContent;
    }
}


/* Falta vincular modal de editar horario y hacer las validaciones */
const tratarDatos = ()=>{
    /* Devuelve por consola los valores obtenidos de las variables reactivas */
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
    
    // Condición if/else; devuelve valores erróneos según la condición para valores del nombre, tipoUsuario y teléfono.
    if (nombre.value.length == 0) {
        errorNombre.value = "El nombre no puede estar vacío.";  // Mensaje de error nombre
    } else if (tipoUsuario.value == 'comercio' && telefono.value.length == 0) {
        errorNombre.value = null;   // Mensaje de error nombre
        errorPhone.value = "Es necesario indicar un teléfono de contacto para tu negocio.";     // Mensaje de error teléfono
    }
}


/* Agrega el cambio de horario */
const obtenerCambioHorario = (cambio) => {
    horarioActual.value = cambio;
    console.log("obtenido cambio");     // Devuelve por consola el mensaje 'obtenido cambio'
    controlador_modal.value = false;
}


/* Controla la dinámica de mostrar y ocultar el modal */
const controlarModal = () => {
    console.log("test");    // Devuelve por consola el mensaje 'test'
    if(controlador_modal.value) {
        controlador_modal.value = false;    // Oculta el modal
    } else {
        controlador_modal.value = true;     // Muestra el modal
    }
}
</script>


<template>
    <div class="flex w-[99vw] justify-center lg:justify-end mb-5">
        <!-- Sección de la imagen de fondo en la parte izquierda de la página -->
        <div id="imagen-container-fondo" class="fixed hidden lg:flex items-center top-0 left-10">
            <img src="@public/img/fondo.png" id="imagen" alt="Imagen Fondo">    <!-- Imagen de fondo -->
        </div>

        <div id="container" class="lg:w-[60vw] w-[90vw] flex flex-col lg:items-center mt-10">
            <h1 class="text-center text-5xl mb-7">Registro</h1>     <!-- Título de introducción -->
            <!-- Formulario para la recogida de los datos del usuario a registrarse -->
            <form action="javascript:void(0);" class="flex flex-col gap-y-5 lg:w-[45%]">
                <!-- Componentes Input -->
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
                <Input v-if="tipoUsuario == 'comercio'"  @click="(e) => controlarModal(e)" tipo="submit" clase="claro" valor="Cambiar horario" class="w-[50%] self-center"/>
                <Input v-if="tipoUsuario == 'comercio'" tipo="text" label="Token (Si tienes)" :valor="token"/>
                <Input v-if="tipoUsuario == 'comercio'" @datos="(nuevosDatos)=>{categoria = nuevosDatos}" @change="mostrarInformacion" tipo="selection" requerido="true" label="Categoría" :opciones="optionsCategory" placeholder="Selecciona una categoría" :error="errorCategory" :valor="categoria"/>
                
                <!-- Sección para la nueva contraseña -->
                <div class="cambiocontra flex flex-col gap-y-5">
                    <Input @datos="(nuevosDatos)=>{contraNueva = nuevosDatos}" tipo="password" label="Contraseña Nueva" :valor="contraNueva" :error="errorContra"/>
                    <Input @datos="(nuevosDatos)=>{repetirNueva = nuevosDatos}" tipo="password" label="Repetir contraseña" :valor="repetirNueva" :error="errorContra"/>
                </div>

                <!-- Sección para guardar los datos recogidos en los campos de los componentes Input -->
                <div class="flex flex-col items-center w-full justify-center mt-3 gap-y-10">
                    <Input @click="tratarDatos" tipo="submit" clase="oscuro" valor="Guardar Cambios" class="w-[50%]"/>
                </div>
            </form>

            <!-- Sección para volver al inicio de sesión -->
            <div class="flex justify-center gap-x-1 mt-3">
                <p>¿Ya tienes una cuenta?</p>
                <button @click="router.push('/login')" class="font-semibold">Inicia sesión</button>
            </div>
        </div>
    </div>
    <!-- Componente Horarios -->
    <Horarios v-if="controlador_modal" :referencia_padre="horarioActual" :controlar_modal="controlarModal" :enviar_cambios="obtenerCambioHorario" />
</template>


<style scoped lang="scss">
/* Estilos para pantallas 900 x 1400 pixeles */
@media screen and (min-width: 900px) and (max-width: 1400px) {
    #imagen-container-fondo {
        display: none;
    }

    #container {
        margin: 0 auto;
        width: 100%;

        form {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            margin-top: 50px;
        }
    }

}
</style>

