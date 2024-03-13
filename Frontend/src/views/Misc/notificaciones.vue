<script setup>
    import { ref } from 'vue';
    // import Comentario from '../widgets/Comentario.vue';
    import router from '@/router/index.js'
    import { comentarios_por_post } from '@/components/notificaciones/mocks/comentarios';
    import {encontrar_usuario_por_id} from '@/components/notificaciones/mocks/users';
    import BackSVG from '@public/assets/icons/forward.svg';
    import EnviarSVG from '@public/assets/icons/forward.svg';


    const props = defineProps({
        post: Object,
        handler: Function
    });

    /** Referencia que controla que el usuario no pueda enviar mensajes a disposición */
    const posteado = ref(false);

    /** Obtenemos el post por props */
    const post = props.post;

    /** Creamos un handler referenciado para el contenedor de comentarios así al refrescar hacemos scrollTop */ 
    const comentario_handler = ref(null);

    /**
     * Creo una referencia para el modal
     */
    const modal = ref(null);

    /**
     * Creo una referencia para el input del chat y poder enviarlo con click
     */
    const chat_input = ref(null);

    const user = encontrar_usuario_por_id(1);

    /**
     * Bloqueamos overflow en background
     * */

    document.body.style.overflow= "hidden";
    /**
     * Redirecciona a Home
     * */
    const back = () => {
        router.push('/');
        document.body.style.overflow= "scroll";
    }

</script>

<template>
    <KeepAlive>
        <div ref="modal" :id="`notificaciones_${user.id}`" class="screen-modal flex flex-col items-center py-[50px]">
            <!-- El wrapper para dar forma al contenedor del centro -->
            <div class="wrapper h-[90%] sm:h-[80%] md:h-[90%] xl:h-[85%] 2xl:w-[40%] xl:w-[60%] lg:w-[60%] md:w-[100%] sm:w-[100%] w-[100%] mt-5relative ">
                <!-- Header superior -->
                <nav class="w-[100%] 2xl:h-[100px] h-[80px] flex items-center justify-start mb-5">
                        <!-- Boton de cerrar -->
                        <button @click="back()">
                            <img class="w-[30px] ml-3 cursor-pointer" :src="BackSVG" alt="">
                        </button>
                        <!-- Mensaje central de comentarios -->
                        <h2 class="w-[90%] text-center">Notificaciones</h2>
                </nav>
                <!-- El listado de notificaciones -->
                <div ref="comentario_handler" class="comentarios  max-h-[80%] sm:max-h-[84%] md:max-h-[84%] lg:max-h-[100%] xl:max-h-[100%] 2xl:max-h-[100%]  overflow-y-scroll">

                </div>
                
            
            </div>
        </div>
    </KeepAlive>
</template>

<style scoped lang="scss">


    body {
        overflow:hidden;
    }
    .screen-modal {
        background:rgba(255, 255, 255, 1);
        position:fixed;
        width:100%;
        height:100%;
        left:0px;
        top:0;
        overflow:hidden;
        z-index:50;
        overscroll-behavior: contain;
        .wrapper {
            scroll-behavior: smooth;
            nav {
                h2 {
                    font-weight:bold;
                }
            }
        }
        .chat {
            z-index: 99 !important;
        }
    }
</style>