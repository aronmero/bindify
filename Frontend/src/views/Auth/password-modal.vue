<script setup>
import Input from '@/components/comun/input.vue';
import router from '@/router/index.js';
import { ref } from 'vue';

const email = ref('');
const errorEmail = ref('');

function validarEmail() {
    let isValido = true;
    const emailRegex = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/;

    if (!emailRegex.test(email.value) /* && email.value != "" */) {
        errorEmail.value = "Error: es necesario indicar un email.";
        alert(errorEmail.value);
        isValido = false;
    }

    if (!isValido) {
        generarPassword();
    } else {
        alert("Error");
    }
}

function generarPassword() {
    const minus = "abcdefghijklmnñopqrstuvwxyz";
    const mayus = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";

    let contraseña = "";
    for (let i = 0; i < 20; i++) {
        let eleccion = Math.floor(Math.random() * 3 + 1);
        if (eleccion == 1) {
            let caracter1 = minus.charAt(Math.floor(Math.random() * minus.length));
            contraseña += caracter1;
        } else if (eleccion == 2) {
            const caracter2 = mayus.charAt(Math.floor(Math.random() * mayus.length));
            contraseña += caracter2;
        } else {
            let num = Math.floor(Math.random() * 10);
            contraseña += num;
        }
    }

    alert("Éxito: " + contraseña);
}

function volver() {
    router.push("/login");
}
</script>


<template>
    <div ref="modal" class="screen-modal flex flex-col items-center pl-3 m-auto py-[50px]">
        <div class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5">
            <div class="modal-header w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                <button @click="volver()">
                    <img id="modal-imagen" class="w-[30px] ml-3 cursor-pointer" alt="imagen-flecha-izquierda" src="/assets/icons/arrowLeft.svg"/>
                </button>
                <h1 id="titulo" class="w-[90%] text-center">Generar Contraseña</h1>
            </div>

            <div class="modal-body">
                <Input tipo="text" class="mb-5" img="/assets/icons/mail.svg" v-modal="email" :error="errorEmail" label="Email"/>
                <Input tipo="submit" class="mb-3" id="footer" clase="claro" @click="validarEmail()" valor="Generar Contraseña"/>
                <Input tipo="submit" id="footer" clase="oscuro" @click="/*$emit('close') && */volver()" valor="Volver"/>
            </div>
        </div>
    </div>
</template>


<style scoped lang="scss">
@media screen and (min-width: 200px) and (max-width: 400px) {
    .modal-container {
        width: 50%;
        margin: 0 auto;
        margin-top: 50px;
    }

    h1 {
        font-size: 25px;
    }

    .modal-header {
        margin-bottom: 100px;
    }

    .modal-body {
        margin: 0 auto;
        width: 90%;
    }

    #footer {
        margin: 0 auto;
        width: 70%;
    }
}


@media screen and (min-width: 400px) and (max-width: 1000px) {
    .modal-container {
        width: 70%;
        margin: 0 auto;
        margin-top: 50px;
    }

    .modal-header {
        margin-bottom: 100px;
    }

    .modal-body {
        margin: 0 auto;
        width: 90%;
    }

    #footer {
        margin: 0 auto;
        width: 70%;
    }
}

@media screen and (min-width: 1000px) and (max-width: 2000px) {
    .modal-container {
        width: 70%;
        margin: 0 auto;
        margin-top: 50px;
    }

    .modal-header {
        margin-bottom: 100px;
    }

    .modal-body {
        margin: 0 auto;
        width: 90%;
    }

    #footer {
        margin: 0 auto;
        width: 70%;
    }
}
</style>