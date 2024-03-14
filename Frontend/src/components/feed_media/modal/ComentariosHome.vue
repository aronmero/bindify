<script setup>
import { ref, onBeforeUnmount } from 'vue';
import Comentario from '../widgets/ComentarioHome.vue';

import BackSVG from '@public/assets/icons/forward.svg';
import EnviarSVG from '@public/assets/icons/forward.svg';
//import { obtener_comentarios_post, agregar_comentario_post } from '@/Api/home/comentarios'
import { getCommentsOfPost, storeCommentsOfPost } from "@/Api/publicacion/comentarios.js";
import { obtener_datos_usuario } from '@/Api/home/users';
import { obtener_comentarios, guardar_comentario } from '@/Api/home/comentarios';

/**
 * Define props
 */

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

const user_session = JSON.parse(sessionStorage.getItem("usuario"))
const user_req = await obtener_datos_usuario(user_session.usuario.username);

/** 
 * Corrección del 13/03 por David, por cambiar el tipo de respuesta del Backend, devuelve ahora un array en vez de un dato concreto, 
 * Han estado haciendo cambios, así que hago la comprobación para que se ajuste dependiendo de la versión
 * 
 * */

const user =  (!Array.isArray(user_req.data)) ? user_req.data : user_req.data[0];

let comentarios = ref(null);
const id_post = props.post.post_id;
/**
 * Obtiene el comentario por la id del post
 */
const apiCall = async () => {
    await obtener_comentarios(id_post).then(data => comentarios.value = data.comentarios)
}
apiCall();

let interval;

/**
 * Controla la dinámica de cerrar este modal desde el hijo
 * Llama a la función padre abrirComentarios()
 * Limpia el intervalo para evitar bugs
 * Cambia el estilo de overflow para volver a permitir el scroll en background
 */

const cerrarModal = () => {
    props.handler();
    clearInterval(interval);
    document.body.style.overflow = "scroll"
};


/**
 * Refresca la posición del modal de comentarios
 */

const refrescarPosicion = () => {
    comentario_handler.value.scrollTop = comentario_handler.value.scrollHeight;
}

/**
 * Elimina el intervalo antes de cambiar de ruta.
 * */
onBeforeUnmount(() => {
    clearInterval(interval);
    document.body.style.overflow = "auto";
});

/**
* Enviar el comentario
*/
const enviarComentarioPorSubmit = async (post_id, event) => {
    /* Si pulsa enter */
    if (event.key == 'Enter') {
        let texto = event.target.value;
        if (!posteado.value) {
            if (texto != "") {
                const body = JSON.stringify({ "content": `${texto}`, "post_id": post_id })
                const response = await guardar_comentario(body);

                if (response.status) {
                    refrescarPosicion()
                }

            }

            antiSpamFunction();
            apiCall();
        }
    }
};

const enviarComentarioPorClick = async (post_id, texto) => {
    /* si no ha posteado previamente */
    if (!posteado.value && texto != "") {
        const body = JSON.stringify({ "content": texto, "post_id": post_id })
        const response = await guardar_comentario(body)
        if (response.status) {
            refrescarPosicion()
        }
    }
    antiSpamFunction();
    apiCall();
};

/**
* Función que se encarga de evitar que el usuario desde el front envíe las peticiones que quiera
* */
const antiSpamFunction = () => {
    chat_input.value.value = ""
    chat_input.value.readonly = true;

    let secs = 0;
    posteado.value = true;

    interval = setInterval(() => {
        secs++;
        chat_input.value.placeholder = `Debes esperar ${60 - secs} segundos para enviar otro comentario.`;

        if (secs == 60) {
            clearInterval(interval);
            posteado.value = false;
            chat_input.value.placeholder = `Agregar comentario.`;

        };
    }, 1000);
}
/**
 * Bloqueamos overflow en background
 * */

document.body.style.overflow = "hidden";

</script>

<template>

        <div ref="modal" :id="`comentarios_${post.post_id}`" class="screen-modal flex flex-col items-center py-[50px]">
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
                    <h2 class="w-[90%] text-center">Comentarios</h2>
                </nav>
                <!-- El listado de comentarios -->
                <div ref="comentario_handler"
                    class="comentarios  max-h-[80%] sm:max-h-[84%] md:max-h-[84%] lg:max-h-[100%] xl:max-h-[100%] 2xl:max-h-[100%]  overflow-y-scroll">
                    <template v-if="comentarios != null">
                        <Comentario v-if="comentarios.length >= 1" v-for="comentario in comentarios"
                            :comentario="comentario" />
                        <Comentario v-else :comentario="{ content: 'No hay comentarios, ¡se el primero!' }" />
                    </template>
                </div>

                <!-- Formulario para enviar comentario -->
                <div style="z-index: 99 !important;  max-width: 700px;"
                    class=" chat w-[100%] bg-[#fff] h-[50px] flex items-center absolute bottom-[50px] sm:bottom-[50px] md:bottom-[50px] lg:bottom-[10px] xl:bottom-[10px] 2xl:bottom-[10px] p-[20px_20px]">
                    <!-- Avatar del usuario -->
                    <img class=" w-[50px] h-[50px] bg-[#f3f3f3] rounded-full " :src="user.avatar" alt="">
                    <!-- Input de Enviar datos -->
                    <input ref="chat_input" @keydown="(e) => enviarComentarioPorSubmit(post.post_id, e)"
                        class=" outline-none  w-[100%] h-[100%] p-[30px_20px] " type="text"
                        placeholder="Agregar comentario">
                    <!-- Botón de Enviar  -->
                    <button class="p-[20px]" @click="(e) => enviarComentarioPorClick(post.post_id, chat_input.value)">
                        <img class="rotate-180" :src="EnviarSVG" alt="submit" />
                    </button>
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

    *::-webkit-scrollbar {
        display:none;
    }

    .chat {
        z-index: 99 !important;
        input {
            background:#fff;
            width:100%;
        }
       
    }
}
</style>