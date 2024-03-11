<script setup>
import Input from '@/components/comun/input.vue';
import router from '@/router/index.js';
import { ref } from 'vue';

const email = ref('');
const password = ref('');
const password_confirm = ref('');
const errorEmail = ref('');
const errorPass = ref('');

function guardarPassword() {
    let isValido = true;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email.value)) {
        errorEmail.value = "Es necesario indicar un email para iniciar sesión.";
        isValido = false;
    } else {
        errorEmail.value = "";
    }

    if (password.value == null || password.value.length < 4 && password_confirm.value == null || password_confirm.value.length < 4) {
        errorPass.value = "La contraseña es demasiado corta";
        isValido = false;
    } else {
        errorPass.value = "";
    }

    if (!isValido) {
        alert("Se ha guardado la contraseña");
    } else {
        console.log("Error");
        alert("Error");
    }
}

function volver() {
    router.push("/login");
}
</script>

<template>
    <div v-if="show" class="modal-mask">
        <div class="modal-container">
            <div class="modal-header">
                <Input tipo="text" id="modal-default-button" @click="$emit('close')" img="/assets/icons/arrowLeft.svg"/>
                <br/>
                <h1>Contraseña</h1>
            </div>

            <div class="modal-body">
                <Input tipo="mail" img="/assets/icons/mail.svg" :error="errorEmail" label="Email"/>
                <Input tipo="password" img="/assets/icons/password.svg" :error="errorPass" label="Password"/>
                <Input tipo="password" img="/assets/icons/password.svg" :error="errorPass" label="Confirmar Password"/>
            </div>

            <div class="modal-footer">
                <Input tipo="submit" id="footer" clase="claro" @click="guardarPassword" valor="Guardar Contraseña"/>
                <Input tipo="submit" id="footer" clase="oscuro" @click="$emit('close') && volver" valor="Volver"/>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>