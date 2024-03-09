<script setup>
import Input from '@/components/comun/input.vue';
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

    alert("Registro exitoso");
}

function login() {
    router.push("/login");
}

const array = ["S/C de La Palma", "Villa de Mazo", "Los Llanos de Aridane", "Fuencaliente", "El Paso", "Puntagorda", "Puntallana", "Breña Baja", "Breña Alta", "Garafía", "Barlovento", "San Andrés y Sauces", "Tazacorte"];
</script>


<template>
    <div class="container">
        <div class="imagen-container">
            <img src="@public/img/fondo.png" alt="Imagen Fondo">
        </div>
        <div class="formulario-container">
            <h1 class="title">Título</h1>
            <form @submit.prevent="registro" class="form max-w-[700px]">
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/maleUser.svg" v-model='usuario' label="Usuario"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="text" requerido="true" img="/assets/icons/maleUser.svg" v-model='nombre' label="Nombre"/>
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
                    <Input tipo="selection" requerido="true" :opciones=array img="/assets/icons/cityHall.svg" placeholder="Selecciona el municipio en el que vives" v-model='municipio' label="Municipio"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="file" clase="perfil" requerido="true" img="/assets/icons/user.svg" placeholder="Haz click para seleccionar una imagen" v-model='avatar' label="Avatar"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="password" requerido="true" img="/assets/icons/password.svg" v-model='password' label="Contraseña"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="password" requerido="true" img="/assets/icons/password.svg" v-model='password_confirm' label="Confirmar Contraseña"/>
                </div>
                <br/><br/>
                <div class="registrarse">
                    <Input tipo="submit" @click="registro" clase="oscuro" valor="Registrarse"/>
                </div>
                <div class="volver">
                    <p>¿Ya tienes una cuenta?</p>
                    <button @click="login" class="login-button">Login</button>
                </div>
            </form>
        </div>
    </div>
</template>


<style scoped lang="scss">
@media screen and (min-width: 100px) and (max-width: 450px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 90%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        display: none;
    }

    .formulario-container {
        padding: 10px;

        h1 {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
        }
    }

    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}


@media screen and (min-width: 451px) and (max-width: 1050px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 70%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        display: none;
    }

    .formulario-container {
        margin-top: 50px;
        width: 100%;
        padding: 10px;

        h1 {
            text-align: center;
        }
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}


@media screen and (min-width: 1051px) and (max-width: 1250px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 100%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        img {
            width: 1250px;
            height: 1250px;
        }
    }

    .formulario-container {
        margin-top: 50px;
        width: 100%;
        padding: 10px;

        h1 {
            text-align: center;
        }
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}


@media screen and (min-width: 1251px) and (max-width: 1450px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 100%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        margin-right: 50px;
        
        img {
            width: 1000px;
            height: 1250px;
        }
    }

    .formulario-container {
        margin-top: 50px;
        width: 100%;
        padding: 10px;

        h1 {
            text-align: center;
        }
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
            text-decoration: underline;
        }
    }
}


@media screen and (min-width: 1451px) and (max-width: 1750px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 100%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        margin-right: 50px;
        
        img {
            width: 1000px;
            height: 1250px;
        }
    }

    .formulario-container {
        margin-top: 50px;
        width: 100%;
        padding: 10px;

        h1 {
            text-align: center;
        }
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
            text-decoration: underline;
        }
    }
}


@media screen and (min-width: 1751px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        font-family: 'Inter', 'Times New Roman', Times, serif;
        display: flex;
        width: 80%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .imagen-container {
        margin-right: 50px;
        
        img {
            width: 1000px;
            height: 1250px;
        }
    }

    .formulario-container {
        margin-top: 50px;
        width: 80%;
        padding: 10px;

        h1 {
            text-align: center;
        }
    }

    .registrarse {
        border-radius: 15px;
        font-size: 20px;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        font-size: 20px;
        margin-top: 5px;
        margin-right: 15px;

        button {
            font-weight: bold;
            margin-left: 7px;
            text-decoration: underline;
        }
    }
}
</style>

