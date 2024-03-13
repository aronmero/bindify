<script setup lang="ts">
/* Importar componentes y funciones */
import { login } from "@/Api/auth.js";
import Input from '@/components/comun/input.vue';
import router from '@/router/index.js'; //Importa el enrutador para las rutas
import { ref } from 'vue'; // Importación de ref desde vue para variables reactivas

/* Declaración de variables reactivas */
const email = ref("");
const password = ref("");
const errorMsg = ref("");
const errorEmail = ref("");
const errorPass = ref("");


/**
 *  Función para iniciar sesión.
 *
 *  Se intenta realizar el inicio de sesion. Comprueba los valores introducidos y realiza una petición a la API,
 *  almacena los datos de usuario devueltos y redirige, en caso de error muestra un mensaje.
 *  @param isValido - Indica si la información de inicio de sesión es válida o no
 *  @param emailRegex - Expresión regular para validar el formato del correo electrónico
 *  @param email - Indica como parámetro la variable reactiva con el valor del email.
 *  @param password - Indica como parámetro la variable reactiva con el valor del password.
 *  @param errorEmail - Indica como parámetro la variable reactiva con el valor del error email.
 *  @param errorPass - Indica como parámetro la variable reactiva con el valor del error password.
 */
async function tryLogin() {
    let isValido = true;    //  Variable para la validez de los campos. (tipo boolean)
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;  // Expresión regular para validar un email

    /* Validar email */
    if (!emailRegex.test(email.value)) {
        errorEmail.value = "Es necesario indicar un email para iniciar sesión.";    // Devuelve mensaje de error
        isValido = false;   // Actualiza el valor de la variable para la validez de los campos.
    } else {
        errorEmail.value = ""; // Limpia el mensaje
    }

    /* Validar contraseña */
    if (password.value == null || password.value.length < 4) {
        errorPass.value = "La contraseña es demasiado corta";   // Devuelve mensaje de error
        isValido = false;   // Actualiza el valor de la variable para la validez de los campos.
    } else {
        errorPass.value = "";   // Limpia el mensaje
    }

    /* Si los datos de inicio de sesión son válidos, se intenta iniciar sesión */
    if (isValido) {
        const data = await login(email.value, password.value); // Llama a la función para iniciar sesión
        if (data.status) {  // Condición si la solicitud es exitosa
            sessionStorage.setItem(
                "usuario",
                JSON.stringify({ usuario: data.message })
            );
            router.push("/");   // Redirige a la página principal de la aplicación
            router.go();
        } else {    // Condición si la solicitud es errónea
            errorMsg.value = "Email o contraseña incorrecta";   // Devuelve un mensaje de error
        }
    }
}


/* Función que redirecciona por ruta al modal o vista para obtener una nueva contraseña debido a que el usuario se le ha olvidado */
function OlvidarPassword() {
    router.push("/password-modal");
}


/* Función que redirecciona por la ruta a la vista registro */
function Registro() {
    router.push("/registro");
}
</script>

<template>
    <div id="container" class="mt-[15px] flex flex-col lg:flex-row justify-center items-center">
        <!-- Imagen lateral izquierda, de presentación para la página -->
        <div id="imagen-container-fondo" class="w-[40vw] lg:flex justify-center items-center hidden">
            <img src="/img/fondo.png" alt="imagen-fondo">
        </div>

        <div class="min-h-[80vh] w-[95vw] lg:w-[45vw] flex flex-col gap-0 lg:gap-5 justify-between items-center">
            <!-- Encabezado con título y un breve párrafo -->
            <header class="flex flex-col gap-y-3 w-[80%] lg:w-auto mt-5 lg:mt-0">
                <h2 class="lg:text-4xl text-2xl text-center">Inicio de sesión</h2>
                <p class="text-center lg:text-lg">Inicia sesión en la aplicación para poder ver todas las ofertas.</p>
            </header>

            <!-- Formulario para iniciar sesión -->
            <form @submit.prevent="tryLogin" class="lg:w-[60%] w-[80%] h-[50%] flex flex-col justify-evenly gap-y-5">
                <Input @datos="(nuevosDatos) => { email = nuevosDatos }" tipo="text" label="Email" :valor="email"
                    :error="errorEmail" />
                <Input @datos="(nuevosDatos) => { password = nuevosDatos }" tipo="password" label="Password"
                    class="-mt-5" :valor="password" :error="errorPass" />
                <Input tipo="submit" clase="oscuro" valor="Iniciar sesión" />
            </form>

            <!-- Redirige al usuario a la vista/modal para obtener una nueva contraseña debido que al usuario se le ha olvidado -->
            <div id="form" class="lg:w-[60%] w-[80%] h-[50%] flex flex-col justify-evenly gap-y-5">
                <button @click="OlvidarPassword" class="font-semibold lg:text-base text-sm text-right cursor-pointer">
                    ¿Olvidaste tu contraseña?
                </button>
            </div>
            
            <p class="color">{{ errorMsg }}</p> <!-- Muestra un mensaje de error -->

            <!-- Iniciar sesión por las redes sociales -->
            <div class="flex flex-col gap-y-5">
                <p class="text-center">O inicie sesión con:</p>
                <div class="social-media-buttons flex w-full justify-evenly gap-x-5">
                    <a href="https://www.google.com/?hl=es"><Input tipo="button" clase="social" img="/img/google-logo.png" /></a>
                    <a href="https://www.facebook.com/?locale=es_ES"><Input tipo="button" clase="social" img="/img/facebook-logo.png" /></a>
                    <a href="https://www.instagram.com/"><Input tipo="button" clase="social" img="/img/instagram-logo.png" /></a>
                </div>
            </div>

            <!-- Redirige al usuario a la vista de registro -->
            <div class="flex gap-x-2 items-center justify-center">
                <p>¿No tienes una cuenta?</p>
                <button @click="Registro" class="font-semibold">Regístrate</button>
            </div>
        </div>
    </div>
</template>


<style scoped lang="scss">
/* Estilos para pantallas 900 x 1700 pixeles */
@media screen and (min-width: 900px) and (max-width: 1700px) {
    #container {
        margin-top: 25px;
    }

    form, #form {
        width: 70%;
    }

    #imagen-container-fondo img {
        width: 100%;
        height: 90vh;
    }
}

</style>