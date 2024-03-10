<script setup>
    import router from '@/router/index.js';
    import { ref } from 'vue';
    import Input from '../../components/comun/input.vue';

    const email = ref(null);
    const password = ref(null);
    const errorEmail = ref(null);
    const errorPass = ref(null);

    function Login() {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        console.log(emailRegex.test(email.value));
        if (!emailRegex.test(email.value)) {
            errorEmail.value = "Es necesario indicar un email para iniciar sesión.";
        } else if (password.value == null || password.value.length < 4){
            errorEmail.value = null;
            errorPass.value = "La contraseña es demasiado corta";
        }else{
            errorEmail.value = null;
            errorPass.value = null;
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
    <div class="flex flex-col lg:flex-row justify-center items-center">
        <div class="w-[45vw] lg:flex justify-center items-center hidden">
            <img src="/img/fondo.png" alt="imagen">
        </div>
        <div class="lg:h-[80vh] h-[95vh] w-[95vw] lg:w-[45vw] flex flex-col gap-y-5 justify-between items-center">
            <header class="flex flex-col gap-y-3 w-[80%] lg:w-auto mt-5 lg:mt-0">
                <h2 class="lg:text-4xl text-2xl text-center">Inicio de sesión</h2>
                <p class="text-center lg:text-lg">Inicia sesión en la aplicación para poder ver todas las ofertas.</p>
            </header>
            <form @submit.prevent="Login" class="lg:w-[60%] w-[80%] h-[50%] flex flex-col justify-evenly gap-y-5">
                <Input @datos="(nuevosDatos)=>{email = nuevosDatos}" tipo="text" label="Email" :valor="email" :error="errorEmail"/> 
                <Input @datos="(nuevosDatos)=>{password = nuevosDatos}" tipo="password" label="Password" class="-mt-2" :valor="password" :error="errorPass"/>
                <Input tipo="submit" clase="oscuro" valor="Iniciar sesión" />     
                <p @click="OlvidarPassword" class="font-semibold lg:text-base text-sm text-right cursor-pointer lg:-mt-8 -mt-4">¿Olvidaste tu contraseña?</p>
            </form>
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

<style scoped>
</style>