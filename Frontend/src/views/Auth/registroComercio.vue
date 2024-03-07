<script setup>
import Input from '@/components/input.vue';
import router from '@/router/index.js';
import { ref } from 'vue';

const usuario = ref('');
const nombre = ref('');
const email = ref('');
const telefono = ref('');
const municipio = ref('');
const avatar = ref('');
const password = ref('');
const password_confirm = ref('');
const direccion = ref('');
const descripcion = ref('');
const token = ref('');
const categoria = ref('');
const horarios = ref('');

function registro() {
    const emailRegex = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/;
    const telefonoRegex = /^\d{3}-\d{3}-\d{3}$/;

    if (usuario.value.length <= 5) {
        alert("Usuario debe tener al menos 6 caracteres");
        return;
    } else {
        console.log(usuario.value);
    }

    if (nombre.value.length <= 5) {
        alert("Nombre debe tener al menos 6 caracteres");
        return;
    } else {
        console.log(nombre.value);
    }

    if (!emailRegex.test(email.value)) {
        alert("Email inválido");
        return;
    } else {
        console.log(email.value);
    }

    if (!telefonoRegex.test(telefono.value)) {
        alert("Teléfono inválido");
        return;
    } else {
        console.log(telefono.value);
    }

    if (password.value !== password_confirm.value) {
        alert("Las contraseñas no coinciden");
        return;
    } else {
        console.log("coinciden: " + password.value + " = " + password_confirm.value);
    }

    if(direccion.value.length <= 5) {
        alert("Dirección debe tener al menos 6 caracteres");
        return;
    } else {
        console.log(direccion.value);
    }

    if(descripcion.value.length <= 15) {
        alert("Descripcion debe tener al menos 16 caracteres");
        return;
    } else {
        console.log(descripcion.value);
    }

    if(token.value.length <= 10) {
        alert("Token debe tener al menos 11 caracteres");
        return;
    } else {
        console.log(token.value);
    }

    alert("Registro exitoso");
}

function login() {
    router.push("/login");
}

function Horarios() {
    //router.push("/horarios-modal");
    console.log("nada aun");
}

const array = ["S/C de La Palma", "Villa de Mazo", "Los Llanos de Aridane", "Fuencaliente", "El Paso"];
const categoriasArray = ["Pera", "Manzana", "Plátano", "Mandarina", "Naranja", "Limón"];
</script>


<template>
    <h1 class="title">Título</h1>
    <div class="container">
        <form @submit.prevent="registro" class="form max-w-[1500px]">
            <div class="formulario-container">
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/person.svg" v-model='usuario' label="Usuario"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/person.svg" v-model='nombre' label="Nombre"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="email" requerido="true" img="/assets/icons/mail.svg" v-model='email' label="Email"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="tel" requerido="true" img="/assets/icons/phone.svg" v-model='telefono' label="Teléfono"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="selection" requerido="true" :opciones=array img="/assets/icons/cityHall.svg" valor="Selecciona el municipio en el que vives" v-model='municipio' label="Municipio"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="file" clase="perfil" requerido="true" img="/assets/icons/user.svg" valor="Haz click para seleccionar una imagen" v-model='avatar' label="Avatar"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="password" requerido="true" img="/assets/icons/password.svg" v-model='password' label="Contraseña"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="password" requerido="true" img="/assets/icons/password.svg" v-model='password_confirm' label="Confirmar Contraseña"/>
                </div>
            </div>
        
            <div class="formulario-container-comercio">
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/person.svg" v-model='direccion' label="Dirección"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="texto" img="/assets/icons/comments.svg" valor="Escribe una descripción" v-model='descripcion' label="Descripcion"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/token.svg" v-model='token' label="Token"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="selection" requerido="true" :opciones=categoriasArray img="/assets/icons/sorting.svg" valor="Selecciona una categoría" v-model='categoria' label="Categoria"/>
                </div>
                <br/><br/>
                <div class="grupo">
                    <Input tipo="submit" @click="Horarios" clase="oscuro" valor="Horarios"/>
                </div>
            </div>
        </form>
    </div>
    <br/><br/>
    <div class="registrarse">
        <Input tipo="submit" @click="registro" clase="oscuro" valor="Registrarse"/>
    </div>
    <div class="volver">
        <p>¿Ya tienes una cuenta?</p>
        <button @click="login" class="login-button">Login</button>
    </div>
</template>


<style scoped lang="scss">
@media screen and (min-width: 100px) and (max-width: 450px) {

}


@media screen and (min-width: 451px) and (max-width: 1050px) {
    
}


@media screen and (min-width: 1051px) and (max-width: 1250px) {
    
}


@media screen and (min-width: 1251px) and (max-width: 1450px) {
    
}


@media screen and (min-width: 1451px) and (max-width: 1750px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        font-family: 'Inter', 'Times New Roman', Times, serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        margin-top: 20px;
    }

    form {
        display: flex;
        justify-content: space-around;
    }

    .formulario-container {
        width: 100%;
    }

    .formulario-container-comercio {
        width: 100%;
    }

    h1 {
        margin-top: 50px;
        text-align: center;
        font-size: 50px;
        font-weight: bold;
    }

    .grupo {
        font-size: 15px;
        width: 90%;
    }

    .registrarse {
        border-radius: 15px;
        font-size: 20px;
        width: 50%;
        margin: 0 auto;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;
        font-size: 20px;
        width: 50%;
        margin: 0 auto;
        margin-bottom: 35px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }

}


@media screen and (min-width: 1751px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        font-family: 'Inter', 'Times New Roman', Times, serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        margin-top: 20px;
    }

    form {
        display: flex;
        justify-content: space-around;
    }

    .formulario-container {
        width: 100%;
    }

    .formulario-container-comercio {
        width: 100%;
    }

    h1 {
        margin-top: 50px;
        text-align: center;
        font-size: 50px;
        font-weight: bold;
    }

    .grupo {
        font-size: 15px;
        width: 90%;
    }

    .registrarse {
        border-radius: 15px;
        font-size: 20px;
        width: 50%;
        margin: 0 auto;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;
        font-size: 20px;
        width: 50%;
        margin: 0 auto;
        margin-bottom: 35px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}
</style>

