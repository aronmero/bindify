<script setup>
    import Input from '@/components/comun/input.vue';
    import router from '@/router/index.js';     //Importa un enrutador para las rutas
    import { ref } from 'vue';      // Importación de ref desde vue para la variables reactivas

    /* Declaración de variables reactivas */
    const email = ref('');
    const errorEmail = ref('');

    /**
    *  Función para validar el email.
    *
    *  Se comprueba el email recibido según la expresión regular, guardando como valor booleano si es válido o inválido (true o false).
    *      · Si es válido (true) llama a la función generarPassword para obtener un nueva contraseña.
    *      · Si es inválido (false) muestra una alerta con mensaje de error.
    *  @param isValido - Indica si la información de inicio de sesión es válida o no.
    *  @param emailRegex - Expresión regular para validar el formato del correo electrónico.
    *  @param email - Indica como parámetro la variable reactiva con el valor del email.
    *  @param errorEmail - Indica como parámetro la variable reactiva con el valor del error email.
    */
    function validarEmail() {
        let isValido = true;    //  Variable para la validez de los campos. (tipo boolean)
        const emailRegex = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/;   // Expresión regular para validar un email

        if (!emailRegex.test(email.value) /* && email.value != "" */) {     // Valida el email y se comentó la condición, en caso de que el email sea un valor vacío
            errorEmail.value = "Error: es necesario indicar un email.";     // Devuelve un mensaje de error
            alert(errorEmail.value);    // Devuelve una alerta con mensaje de error
            isValido = false;   // Actualiza el valor de la variable para la validez de los campos
        }

        /* Comprueba si los datos son válidos */
        if (!isValido) {
            generarPassword();  // Llama a la función de generar contraseña
        } else {
            alert("Error");     // Devuelve una alerta con mensaje de error
        }
    }

    /**
    *  Función para generar una contraseña.
    *
    *  Se genera una contraseña de 20 caracteres de forma aleatoria con letras mayúsculas y minúsculas incluidos números del 0 al 9.
    *  @param minus - Indica como valor las letras del abecedario en minúsculas.
    *  @param mayus - Indica como valor las letras del abecedario en mayúsculas.
    *  @param password - Se genera como valor en un bucle de hasta 20 caracteres aleatorios con letras minúsculas y mayúsculas además de números del 0 al 9 para obtener una nueva contraseña.
    *  @param eleccion - Indica como valor aleatorio un número del 1 al 3 para las condiciones del bucle y formar una contraseña de 20 caracteres.
    *  @param caracter1 - Recoge aleatoriamente como valor una letra del abecedario en minúsculas.
    *  @param caracter2 - Recoge aleatoriamente como valor una letra del abecedario en mayúsculas.
    *  @param num - Recoge aleatoriamente como valor un número del 0 al 9.
    */
    function generarPassword() {
        const minus = "abcdefghijklmnñopqrstuvwxyz";    // Declarar variable de las letras minúsculas del abecedario como valor
        const mayus = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";    // Declarar variable de las letras mayúsculas del abecedario como valor

        let password = "";    // Declarar variable para la nueva contraseña
        for (let i = 0; i < 20; i++) {  // Bucle para formar una contraseña con 20 caracteres aleatorios de letras minúsculas y mayúsculas del abecedario incluyendo números del 0 al 9.
            let eleccion = Math.floor(Math.random() * 3 + 1);   // Recoge un valor del 1 al 3 para las condiciones y establecer los valores según la posición de cada caracter de la contraseña
            
            // Condiciones para establecer un valor en la elección de un número aleatorio del 1 al 3 para un caracter de la contraseña.
            if (eleccion == 1) {    // Obtiene para la contraseña una letra minúscula
                let caracter1 = minus.charAt(Math.floor(Math.random() * minus.length));
                password += caracter1;
            } else if (eleccion == 2) {     // Obtiene para la contraseña una letra mayúscula
                const caracter2 = mayus.charAt(Math.floor(Math.random() * mayus.length));
                password += caracter2;
            } else {    // Obtiene para la contraseña un número del 0 al 9
                let num = Math.floor(Math.random() * 10);
                password += num;
            }
        }

        alert("Éxito: " + password);  // Devuelve una alerta con mensaje exitoso y la nueva contraseña
    }

    /* Función que redirige por ruta a la vista de inicio de sesión (Login) */
    function volver() {
        router.push("/login");
    }
</script>


<template>
    <!-- Contenedor del modal -->
    <div ref="modal" class="screen-modal flex flex-col items-center pl-3 m-auto py-[50px]">
        <div class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5">
            <!-- Cabecera del modal -->
            <div class="modal-header w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                <button @click="volver()">
                    <img id="modal-imagen" class="w-[30px] ml-3 cursor-pointer" alt="imagen-flecha-izquierda" src="/assets/icons/arrowLeft.svg"/>   <!-- Icono de flecha a la izquierda -->
                </button>
                <!-- Título del modal -->
                <h1 id="titulo" class="w-[90%] text-center">Reiniciar contraseña</h1>
            </div>

            <div class="mb-[40px]"><label class="flex justify-center w-full">Introduce el correo electronico</label></div>
            <!-- Contenido del modal -->
            <div class="modal-body">
                <Input tipo="text" class="mb-5" img="/assets/icons/mail.svg" v-modal="email" :error="errorEmail" label="Email"/>
                <Input tipo="submit" class="mb-3" id="footer" clase="claro" valor="Generar Contraseña"/>    <!-- Botón para validar email y generar una contraseña -->
                <Input tipo="submit" id="footer" clase="oscuro" @click="/*$emit('close') && */volver()" valor="Volver"/>    <!-- Botón para volver a la vista de inicio de sesión -->
            </div>
        </div>
    </div>
</template>


<style scoped lang="scss">
/* Estilos para pantallas 200 x 400 pixeles */
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

/* Estilos para pantallas 400 x 1000 pixeles */
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

/* Estilos para pantallas 1000 x 2000 pixeles */
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