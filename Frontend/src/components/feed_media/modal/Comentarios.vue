<script setup>

import { ref, onBeforeUnmount } from 'vue';
import Comentario from '../widgets/Comentario.vue';
import { comentarios_por_post } from './../mocks/comentarios';
import { encontrar_usuario_por_id } from './../mocks/users';
import BackSVG from '@public/assets/icons/forward.svg';
import EnviarSVG from '@public/assets/icons/forward.svg';
import { getCommentsOfPost, storeCommentsOfPost } from "@/Api/publicacion/comentarios.js";

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

let comentarios = ref(null);
const id_post = props.post.id;
/**
 * Obtiene los comentarios de la api
 */
const apiCall = async () => {
    await getCommentsOfPost(id_post).then(data => comentarios.value = data.comentarios)
    console.log(comentarios.value);
}
apiCall();


/**
 * Obtiene el comentario por la id del post
 */

let en_comentarios = ref(comentarios_por_post(post.id));

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

//Elimina el intervalo antes de cambiar de ruta.
onBeforeUnmount(() => {
    clearInterval(interval);
});

const refrescarPosicion = () => {
    // console.log(comentario_handler.value.getBoundingClientRect());
    // console.log(comentario_handler.value.scrollHeight);
    comentario_handler.value.scrollTop = comentario_handler.value.scrollHeight;
}

/*
const agregar_comentario = async (post_id, user_id, texto) => {
    en_comentarios.value.push({
        id: en_comentarios.length + 1,
        user_id: user_id,
        post_id: post_id,
        content: texto,
        active: true
    });
}*/

/**
* Enviar el comentario
*/
const enviarComentarioPorSubmit = async (post_id, event) => {
    if (event.key == 'Enter') {
        let texto = event.target.value;
        if (!posteado.value) {
            if (texto != "") {
                const body = JSON.stringify({ "content": `${texto}`, "post_id": post_id })
                const response = await storeCommentsOfPost(body);

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

    if (!posteado.value && texto != "") {
        const body = JSON.stringify({ "content": texto, "post_id": post_id })
        const response = await storeCommentsOfPost(body)

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
    <KeepAlive>
        <div ref="modal" :id="`comentarios_${post.id}`" class="screen-modal flex flex-col items-center py-[50px]">
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
                <div style="z-index: 99 !important;"
                    class=" chat w-[100%] bg-[#fff] h-[50px] flex items-center fixed bottom-[50px] sm:bottom-[50px] md:bottom-[50px] lg:bottom-[10px]  xl:bottom-[10px] 2xl:bottom-[10px] p-[30px_20px]">
                    <!-- Avatar del usuario -->
                    <img class=" w-[50px] h-[50px] bg-[#f3f3f3] rounded-full " :src="user.avatar" alt="">
                    <!-- Input de Enviar datos -->
                    <input ref="chat_input" @keydown="(e) => enviarComentarioPorSubmit(post.id, e)"
                        class=" outline-none  w-[100%] h-[100%] p-[30px_20px] " type="text"
                        placeholder="Agregar comentario">
                    <!-- Botón de Enviar  -->
                    <button class="p-[20px]" @click="(e) => enviarComentarioPorClick(post.id, chat_input.value)">
                        <img class="rotate-180" :src="EnviarSVG" alt="submit" />
                    </button>
                </div>
            </div>
        </div>
    </KeepAlive>
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
}
</style>