<script setup>
import { ref,onBeforeUnmount } from 'vue';
// import Comentario from '../widgets/Comentario.vue';
import router from '@/router/index.js'
import BackSVG from '@public/assets/icons/forward.svg';
import notificacion from "@/components/utils/notificacion.vue";
import { getNotificacion } from '@/Api/notificaciones/notificaciones_usuario.js'
/** Creamos un handler referenciado para el contenedor de comentarios así al refrescar hacemos scrollTop */
const comentario_handler = ref(null);

/**
 * Creo una referencia para el modal
 */
const modal = ref(null);
const user = JSON.parse(sessionStorage.getItem("usuario"));

/**
 * Redirecciona a Home
 * */
const back = () => {
    router.push('/');
}

let data = ref({status:false});

const callApi = async () => {
    data.value = await getNotificacion();
    if(data.value==undefined){
        data.value={data:[]};
    }
}
callApi();

</script>

<template>
    <KeepAlive>

        <div ref="modal" class="screen-modal flex flex-col items-center py-[50px] ">
            <!-- El wrapper para dar forma al contenedor del centro -->
            <div
                class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5relative ">
                <!-- Header superior -->
                <nav class="w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                    <!-- Boton de cerrar -->
                    <button @click="back()">
                        <img class="w-[30px] ml-3 cursor-pointer" :src="BackSVG" alt="">
                    </button>
                    <!-- Mensaje central de comentarios -->
                    <h2 class="w-[90%] text-center">Notificaciones</h2>
                </nav>
                <!-- El listado de comentarios -->
                <div v-if="data.status" ref="comentario_handler"
                    class="comentarios  max-h-[80%] sm:max-h-[84%] md:max-h-[84%] lg:max-h-[100%] xl:max-h-[100%] 2xl:max-h-[100%] flex gap-[25px] flex-col pr-[15px] pl-[15px]">
                    <notificacion v-if=" data.data !=undefined" v-for="not in data.data" :notificacion="not"></notificacion>
                    
                </div>
                    <div v-if=" data.data !=undefined && data.data.length==0" class="flex justify-center">No hay notificaciones en este momento</div>

            </div>
        </div>
    </KeepAlive>
</template>

<style scoped lang="scss">


.screen-modal {
    width: 100%;
    height: 100%;
    left: 0px;
    top: 0;
    z-index: 50;

    .wrapper {
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