<!--
<script setup>
import Input from '@/components/comun/input.vue';
import router from '@/router/index.js';

import { ref } from 'vue';

/** Importa el Modal de Horarios */
import Horarios from '../../components/intervalos_horarios/Horarios.vue';


/* Genera la referencia para controlar el estado de mostrado u oculto */
const controlador_modal = ref(false);

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


/* Funciones */
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

/*
function Horarios() {
    //router.push("/horarios-modal");
    console.log("nada aun");
}
*/

/** Controla la dinámica de mostrar y ocultar el modal */
const controlarModal = (e) => {
    e.preventDefault();
    if(controlador_modal.value) {
        controlador_modal.value = false;
    } else {
        controlador_modal.value = true;
    }
}

const array = ["S/C de La Palma", "Villa de Mazo", "Los Llanos de Aridane", "Fuencaliente", "El Paso", "Puntagorda", "Puntallana", "Breña Baja", "Breña Alta", "Garafía", "Barlovento", "San Andrés y Sauces", "Tazacorte"];
const categoriasArray = ["Pera", "Manzana", "Plátano", "Mandarina", "Naranja", "Limón"];
const horarioActual = ref(" 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo ");


/** Agrega el cambio de horario */
const obtenerCambioHorario = (cambio) => {
    horarioActual.value = cambio;
    console.log("obtenido cambio")
    controlador_modal.value = false;
}
</script>


<template>
    <h1 class="title">Título</h1>
    <div class="container">
        <!-- <form @submit.prevent="registro"> ->
        <form>
            <div class="formulario-container">
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
                    <Input tipo="selection" requerido="false" :opciones=array img="/assets/icons/cityHall.svg" placeholder="Selecciona el municipio en el que vives" v-model='municipio' label="Municipio"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="file" clase="perfil" requerido="false" img="/assets/icons/user.svg" placeholder="Haz click para seleccionar una imagen" v-model='avatar' label="Avatar"/>
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
                    <Input tipo="text" requerido="true" img="/assets/icons/location.svg" v-model='direccion' label="Dirección"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="texto" img="/assets/icons/comments.svg" placeholder="Introduce una descripción" v-model='descripcion' label="Descripcion"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="text" requerido="false" img="/assets/icons/token.svg" v-model='token' label="Token"/>
                </div>
                <br/>
                <div class="grupo">
                    <Input tipo="selection" requerido="true" :opciones=categoriasArray img="/assets/icons/sorting.svg" placeholder="Selecciona una categoría" v-model='categoria' label="Categoria"/>
                </div>
                <div class="grupo">
                    <Input tipo="texto" requerido="true" label="Horario Actual" :valor="horarioActual"/>
                </div>
                <br/><br/>
                <br/><br/>
                <div class="grupo">
                    <Input tipo="submit" requerido="true" @click="(e) => controlarModal(e)" style="font-size: 20px;" clase="oscuro" valor="Horarios"/>

                    <!-- Modal de Intervalos Horarios -->
                
                    <!-- <Teleport to="body">
                        <modal :show="showModal" @close="showModal = false">
                            <template #header>
                            </template>
                        </modal>
                    </Teleport> ->
                </div>
            </div>
        </form>
        <Horarios v-if="controlador_modal" :referencia_padre="horarioActual" :controlar_modal="controlarModal" :enviar_cambios="obtenerCambioHorario" />
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
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        font-family: 'Inter', 'Times New Roman', Times, serif;
    }

    .container {
        width: 85%;
        margin: 0 auto;
        margin-top: 20px;
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
        font-size: 20px;
        width: 100%;
    }

    .registrarse {
        border-radius: 15px;
        font-size: 20px;
        width: 85%;
        margin: 0 auto;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 7px;
        margin-right: 15px;
        font-size: 20px;
        width: 80%;
        margin: 0 auto;
        margin-bottom: 35px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}


@media screen and (min-width: 451px) and (max-width: 1050px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        font-family: 'Inter', 'Times New Roman', Times, serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        margin-top: 20px;
    }

    .formulario-container {
        width: 100%;
    }

    .formulario-container-comercio {
        width: 100%;
    }

    form {
        max-width: 1500px;
    }

    h1 {
        margin-top: 50px;
        text-align: center;
        font-size: 50px;
        font-weight: bold;
    }


    .grupo {
        font-size: 15px;
        width: 100%;
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
        width: 80%;
        margin: 0 auto;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;
        font-size: 20px;
        width: 80%;
        margin: 0 auto;
        margin-bottom: 35px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
}



@media screen and (min-width: 1051px) and (max-width: 1450px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
        font-family: 'Inter', 'Times New Roman', Times, serif;
    }

    .container {
        width: 85%;
        margin: 0 auto;
        margin-top: 20px;
    }

    .formulario-container {
        width: 100%;
        margin-right: 15px;
    }

    .formulario-container-comercio {
        width: 100%;
        margin-left: 15px;
    }

    h1 {
        margin-top: 50px;
        text-align: center;
        font-size: 50px;
        font-weight: bold;
    }

    form {
        display: flex;
        justify-content: space-around;
        max-width: 1500px;
    }

    .grupo {
        font-size: 15px;
        width: 100%;
    }
    
    .registrarse {
        border-radius: 15px;
        font-size: 20px;
        width: 85%;
        margin: 0 auto;
    }

    .volver {
        display: flex;
        justify-content: end;
        letter-spacing: 0.02em;
        margin-top: 5px;
        margin-right: 15px;
        font-size: 20px;
        width: 80%;
        margin: 0 auto;
        margin-bottom: 35px;

        button {
            font-weight: bold;
            margin-left: 7px;
        }
    }
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
        max-width: 1500px;
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
        width: 90%;
        margin: 0 auto;
        margin-top: 20px;
    }

    form {
        display: flex;
        justify-content: space-around;
        min-width: 1600px;
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
*/


