<script setup>
import { ref } from 'vue';
import BackSVG from '@public/assets/icons/forward.svg';
import { comercios, obtener_rango_horarios } from '../feed_media/mocks/comercios';
import Intervalo from './widgets/Intervalo.vue';

const comercio = comercios[0];

const schedule = comercio.schedule;
/**
 * Creo una referencia para el modal
 */
const modal = ref(null);

/**
 * Obtengo el rango de horarios
 * */

const horario = ref(obtener_rango_horarios(1));

const borrar_intervalo = (index) => {
    console.log(`borrando ${index}`);
    horario.value.splice(index, 1);
    console.log(horario.value);
}

const crear_intervalo = () => {
    horario.value.push({
        hora_apertura: '00:00',
        hora_cierre: '00:00',
        dia: 'Lunes'
    })
}

const cambiar_intervalo = (index, campo, valor) => {
    if(campo == 'hora_apertura') horario.value[index].hora_apertura = valor;
    if(campo == 'hora_cierre') horario.value[index].hora_cierre = valor;
    if(campo == 'dia') horario.value[index].dia = valor;
    console.log("cambiado");
    console.log(horario.value[index]);
}

</script>
<template>
    <div ref="modal" :id="`horarios_${comercio.id}`" class="screen-modal flex flex-col items-center py-[50px]">
        <!-- El wrapper para dar forma al contenedor del centro -->
        <div
            class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5relative ">
            <!-- Header superior -->
            <nav class="w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                <!-- Boton de cerrar -->
                <button @click="() => cerrarModal()">
                    <img class="w-[30px] ml-3 cursor-pointer" :src="BackSVG" alt="">
                </button>
                <!-- Mensaje central de comentarios -->
                <h2 class="w-[90%] text-center">Intervalos de Horario</h2>
            </nav>
            <!-- El listado de comentarios -->
            <div ref="comentario_handler"
                class="comentarios  max-h-[80%] sm:max-h-[84%] md:max-h-[84%] lg:max-h-[100%] xl:max-h-[100%] 2xl:max-h-[100%]  overflow-y-scroll">
                <h2>Actualmente:</h2>

                <textarea class="w-[100%] h-[400px]" :value="schedule"></textarea>
                <Intervalo v-for="(intervalo, index) in horario" :intervalo="intervalo" :index="index"
                    :borrar_intervalo="borrar_intervalo" 
                    :cambiar_intervalo="cambiar_intervalo"
                    />

            </div>

            <div>
                <button @click="() => crear_intervalo()" class="bg-[#FE822F] w-[200px] h-[50px] rounded-xl">Agregar intervalo</button>
            </div>

            <!-- Formulario para enviar comentario -->
            <div style="z-index: 99 !important;" class=" chat w-[100%] bg-[#fff] h-[50px] flex items-center fixed bottom-[50px] sm:bottom-[50px] md:bottom-[50px] lg:bottom-[10px]  xl:bottom-[10px] 2xl:bottom-[10px] p-[30px_20px]">

            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
body {
    overflow: hidden;
}

.screen-modal {
    background: rgba(255, 255, 255, 1);
    position: fixed;
    width: 100%;
    height: 100%;
    left: 0px;
    top: 0;
    overflow: hidden;
    z-index: 50;
    overscroll-behavior: contain;

    .wrapper {
        scroll-behavior: smooth;

        nav {
            h2 {
                font-weight: bold;
            }
        }
    }

    .chat {
        z-index: 99 !important;
    }
}</style>