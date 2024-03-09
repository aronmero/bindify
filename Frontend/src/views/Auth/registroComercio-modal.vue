<script setup>
import Input from '@/components/comun/input.vue';
import router from '@/router/index.js';
import { ref } from 'vue';

const props = defineProps({
    show: Boolean
})

const apertura = ref('');
const cierre = ref('');
const diaSemana = ref('');
const fechaActual = new Date();


const array = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

function agregarIntervalo() {
    if (apertura.value > cierre.value && diaSemana > fechaActual) {
        alert("Se cumple");
    } else {
        alert("Error");
    }

    console.log("Se ha añadido el intervalo");
}

function volver() {
    router.push("/registro-comercio");
}
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="modal-container">
                <div class="modal-header">
                    <Input tipo="text" id="modal-default-button" @click="$emit('close')" img="/assets/icons/arrowLeft.svg"/>
                    <br/>
                    <h1>Horarios</h1>
                </div>

                <div class="modal-body">
                    <Input tipo="hora" id="input"/>
                    <Input tipo="hora" id="input"/>
                    <Input tipo="selection" class="selection" id="input" requerido="false" img="/assets/icons/expandArrow.svg" placeholder="Seleccione un dia de la semana" :opciones="array" />
                    <Input tipo="" id="input" img="/assets/icons/cancel.svg"/>
                </div>

                <div class="modal-footer">
                    <Input tipo="submit" id="footer" clase="claro" @click="agregarIntervalo" valor="Agregar Intervalo"/>
                    <Input tipo="submit" id="footer" clase="oscuro" @click="$emit('close') && volver" valor="Volver"/>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped lang="scss">
@media screen and (max-width: 600px) {
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        transition: opacity 0.3s ease;
    }

    .modal-container {
        width: 400px;
        height: 800px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 150px rgba(0, 0, 0, 1.33);
        transition: all 0.1s ease;
    }

    .modal-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .modal-body, .modal-footer {
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
    }

    .modal-body {
        width: 50%;
    }

    .modal-footer {
        margin-top: 50px;
        flex-direction: column;
        width: 100%;
        font-size: 20px;
    }

    #footer {
        margin-top: 20px;
    }
}


@media screen and (min-width: 601px) and (max-width: 800px) {
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        transition: opacity 0.3s ease;
    }

    .modal-container {
        width: 550px;
        height: 800px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 150px rgba(0, 0, 0, 1.33);
        transition: all 0.1s ease;
    }
    
    .modal-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .modal-body, .modal-footer {
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
    }

    .modal-footer {
        margin-top: 50px;
        flex-direction: column;
        width: 70%;
        font-size: 20px;
    }

    .selection {
        max-width: 700px;
    }

    .modal-body {
        width: 70%;
    }

    #input {
        margin-top: 20px;
        margin-bottom: 10px;
        margin: 15px;
        font-size: 20px;
    }

    #footer {
        margin-top: 20px;
    }
}


@media screen and (min-width: 801px) and (max-width: 900px) {
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        transition: opacity 0.3s ease;
    }

    .modal-container {
        width: 800px;
        height: 700px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 150px rgba(0, 0, 0, 1.33);
        transition: all 0.1s ease;
    }
    
    .modal-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .modal-body, .modal-footer {
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
    }

    .modal-body {
        width: 50%;
    }

    .modal-footer {
        margin-top: 50px;
        flex-direction: column;
        width: 50%;
        font-size: 20px;
    }


    #input {
        margin-top: 20px;
        margin-bottom: 10px;
        width: 60%;
        margin: 15px;
        font-size: 20px;
    }

    #footer {
        margin-top: 20px;
    }
}


@media screen and (min-width: 901px) and (max-width: 20000px) {
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        transition: opacity 0.3s ease;
    }

    .modal-container {
        width: 900px;
        height: 700px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 2px 150px rgba(0, 0, 0, 1.33);
        transition: all 0.1s ease;
    }

    .modal-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .modal-body, .modal-footer {
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
    }

    .modal-body {
        width: 80%;
    }
    
    .modal-footer {
        margin-top: 50px;
        flex-direction: column;
        font-size: 20px;
        width: 50%;
    }

    #input {
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 20px;
    }

    #footer {
        margin-top: 20px;
    }
}
</style>