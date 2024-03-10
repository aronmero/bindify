<script setup lang="ts">
import router from '@/router/index.js';
import { ref } from 'vue';
import Input from '@/components/comun/input.vue';
import { login } from "@/api/auth.js";

const email = ref("");
const password = ref("");
const errorMsg = ref("");
const errorEmail = ref("");
const errorPass = ref("");

/**
 * Intenta realizar el inicio de sesion. Comprueba los valores introducidos y realiza una peticion a la API,
 *  almacena los datos de usuario devueltos y redirige, en caso de error muestra un mensaje.
 * @date 3/10/2024 - 9:57:22 PM
 * @author Aarón Medina Rodríguez
 *
 * @async
 */
async function tryLogin() {
    let isValido = true;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email.value)) {
        errorEmail.value = "Es necesario indicar un email para iniciar sesión.";
        isValido = false;
    } else {
        errorEmail.value = "";
    }

    if (password.value == null || password.value.length < 4) {
        errorPass.value = "La contraseña es demasiado corta";
        isValido = false;
    } else {
        errorPass.value = "";
    }

    if (isValido) {
        const data = await login(email.value, password.value);
        if (data.status) {
            sessionStorage.setItem(
                "usuario",
                JSON.stringify({ usuario: data.message })
            );
            router.push("/");
            router.go();
        } else {
            errorMsg.value = "Email o contraseña incorrecta";
        }
    }
}

function OlvidarPassword() {
    /* Funcion que redirecciona al modal o vista para recuperar la contraseña */
}

function Registro() {
    router.push("/registro");
}
</script>

<template>
    <div class="mt-[45px] flex flex-col lg:flex-row justify-center items-center">
        <div class="w-[45vw] lg:flex justify-center items-center hidden">
            <img src="/img/fondo.png" alt="imagen">
        </div>
        <div class="min-h-[80vh] w-[95vw] lg:w-[45vw] flex flex-col gap-0 lg:gap-5 justify-between items-center">
            <header class="flex flex-col gap-y-3 w-[80%] lg:w-auto mt-5 lg:mt-0">
                <h2 class="lg:text-4xl text-2xl text-center">Inicio de sesión</h2>
                <p class="text-center lg:text-lg">Inicia sesión en la aplicación para poder ver todas las ofertas.</p>
            </header>
            <form @submit.prevent="tryLogin" class="lg:w-[60%] w-[80%] h-[50%] flex flex-col justify-evenly gap-y-5">
                <Input @datos="(nuevosDatos) => { email = nuevosDatos }" tipo="text" label="Email" :valor="email"
                    :error="errorEmail" />
                <Input @datos="(nuevosDatos) => { password = nuevosDatos }" tipo="password" label="Password"
                    class="-mt-2" :valor="password" :error="errorPass" />
                <Input tipo="submit" clase="oscuro" valor="Iniciar sesión" />
                <p @click="OlvidarPassword" class="font-semibold lg:text-base text-sm text-right cursor-pointer -mt-3">
                    ¿Olvidaste tu
                    contraseña?</p>
            </form>
            <p class="color">{{ errorMsg }}</p>
            <div class="flex flex-col gap-y-5">
                <p class="text-center">O inicie sesión con:</p>
                <div class="social-media-buttons flex w-full justify-evenly gap-x-5">
                    <Input tipo="button" clase="social" img="/img/google-logo.png" />
                    <Input tipo="button" clase="social" img="/img/facebook-logo.png" />
                    <Input tipo="button" clase="social" img="/img/instagram-logo.png" />
                </div>
            </div>
            <div class="flex gap-x-2 items-center justify-center">
                <p>¿No tienes una cuenta?</p>
                <button @click="Registro" class="font-semibold">Regístrate</button>
            </div>
        </div>
    </div>
</template>

<style scoped></style>