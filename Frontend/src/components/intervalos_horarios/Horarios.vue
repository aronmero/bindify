<script setup>
    import BackSVG from '@public/assets/icons/forward.svg';
import { ref } from 'vue';

    import { comercios, filtrar_rango_horarios, pasar_a_string_horario } from '../feed_media/mocks/comercios';
import Intervalo from './widgets/Intervalo.vue';

    const props = defineProps({
        referencia_padre: String,
        controlar_modal: Function,
        enviar_cambios: Function
    });

    const datos_padre = ref(props.referencia_padre)
    const comercio = comercios[0];

    /**
     * Creo una referencia para el modal
     */
    const modal = ref(null);

    /**
     * Obtengo el rango de horarios de ese comercio
     * */

    //let horario =   ref(obtener_rango_horarios(1));
    let horario = ref(filtrar_rango_horarios(datos_padre.value));

    console.log(horario);
    /* *
    * Borrar el intervalo
    * @param index - index del elemento a borrar
    * */
    const borrar_intervalo = (index) => {
        console.log(`borrando ${index}`);
        horario.value.splice(index, 1);
        horario.value = horario.value;
    }

    /**
     * Crear intervalo nuevo
     * */
    const crear_intervalo = () => {
        horario.value.push({
            hora_apertura: '00:00',
            hora_cierre: '00:00',
            dia: 'Lunes'
        })
    }
    /**
     * Cambiar el intervalo ya existente
     * @param index - index del elemento a cambiar
     * @param campo - campo a cambiar
     * @param valor - valor del campo a cambiar
     * */

    const cambiar_intervalo = (index, hora_apertura, hora_cierre, dia) => {
        horario.value[index].hora_apertura = hora_apertura;
        horario.value[index].hora_cierre = hora_cierre;
        horario.value[index].dia = dia;
        console.log(horario.value[index])
    }

    /**
     * Cierra el modal
     * */
    const cerrarModal = () => {
        document.body.style.overflow = "scroll";
        props.controlar_modal();
    };

    /**
     *
     * Enviar cambios
     *
     * */
     //const enviar_cambios = () => {
     //   datos_padre.value = horario.value;
     //   cerrarModal()
     //}
</script>

<template>
    <div ref="modal" :id="`horarios_${comercio.id}`" class="screen-modal flex flex-col items-center py-[50px]">
        <!-- El wrapper para dar forma al contenedor del centro -->
        <div
            class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5">
            <!-- Header superior -->
            <nav class="w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                <!-- Boton de cerrar -->
                <button @click="() => cerrarModal()">
                    <img class="w-[30px] ml-3 cursor-pointer" :src="BackSVG" alt="">
                </button>
                <!-- Mensaje central de texto -->
                <h2 class="w-[90%] text-center">Intervalos de Horario</h2>
            </nav>
            <!-- El listado de intervalos -->
            <div ref="handler"
                class="comentarios flex flex-col items-center max-h-[100%] overflow-y-scroll">
                <h2 class=" flex items-center ">
                    Intervalos horarios actuales
                </h2>
                <Intervalo v-for="(intervalo, index) in horario" :intervalo="intervalo" :index="index"
                    :borrar_intervalo="borrar_intervalo" :cambiar_intervalo="cambiar_intervalo" />
                <b v-if="horario.length == 0" class="p-[20px]">Aún no has añadido ningún horario.</b>
                <div id="footer" class="w-[100%] flex flex-col items-center justify-start w-[200px]">
                    <button @click="() => crear_intervalo()" class=" bg-[#FE822F] w-[100%]  h-[50px] rounded-xl">Agregar intervalo</button>
                
                    <button @click="() => props.enviar_cambios(pasar_a_string_horario(horario))" class="mt-[10px] bg-[#404040] text-white w-[100%] h-[50px] rounded-xl">Aplicar y volver</button>
                </div>
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
            //scroll-behavior: smooth;

            nav {
                h2 {
                    font-weight: bold;
                }
            }
        }

        .chat {
            z-index: 99 !important;
        }
    }
</style>