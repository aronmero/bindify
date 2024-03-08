<script setup>
    import { ref } from 'vue';
    import Comentario from '../widgets/Comentario.vue';
    import { comentarios_por_post } from './../mocks/comentarios';
    import {encontrar_usuario_por_id} from './../mocks/users';
    import BackSVG from '@public/assets/icons/forward.svg';


    const props = defineProps({
        post: Object,
        handler: Function
    });


    const post = props.post;

    const modal = ref(null);

    /**
     * Creo una referencia para el input del chat y poder enviarlo con click
     */
    const chat_input = ref(null);

    const user = encontrar_usuario_por_id(1);

    /**
     * Obtiene el comentario por la id del post
     */

    let en_comentarios = ref(comentarios_por_post(post.id));

    /**
     * Controla la dinámica de cerrar este modal desde el hijo
     * Llama a la función padre abrirComentarios()
     */
    const cerrarModal = () => {
        props.handler();
    };

    /**
    * Enviar el comentario
    */

     const enviarComentarioPorSubmit = (post_id, user_id, event) => {
        console.log(event)
        if(event.key == "Enter") {
            let texto = event.target.value;
            if(texto != "") {
                en_comentarios.value.push({
                    id: en_comentarios.length + 1,
                    user_id: user_id,
                    post_id: post_id,
                    content: texto,
                    active: true
                });
            }
            //agregar_comentario(post_id, user_id, texto);
        }
     };

     const enviarComentarioPorClick = (post_id, user_id, texto) => {
        if(texto != "") {
            en_comentarios.value.push({
                id: en_comentarios.length + 1,
                user_id: user_id,
                post_id: post_id,
                content: texto,
                active: true
            });
        }
            //agregar_comentario(post_id, user_id, texto);
     };
</script>

<template>
    <div ref="modal" :id="`comentarios_${post.id}`" class="screen-modal flex flex-col items-center pt-[50px]">
        <!-- El wrapper para dar forma al contenedor del centro -->
        <div class="wrapper xl:w-[40%] h-[100%] lg:w-[40%] md:w-[50%] sm:w-[50%] w-[100%] mt-5 relative ">
            <!-- Header superior -->
            <nav class=" w-[100%] h-[50px] flex items-center justify-start mb-5 ">
                    <!-- Boton de cerrar -->
                    <button @click="() => cerrarModal()">
                        <img class=" w-[30px] ml-3 cursor-pointer " :src="BackSVG" alt="">
                    </button>
                    <!-- Mensaje central de comentarios -->
                    <h2 class=" w-[90%] text-center ">Comentarios</h2>
            </nav>
            <!-- El listado de comentarios -->
            <Comentario v-for="comentario in en_comentarios" :comentario="comentario"/>
            <div class=" chat w-[100%] bg-[#fff] h-[50px] flex items-center absolute bottom-[50px] sm:bottom-[50px] md:bottom-[50px] lg:bottom-0  xl:bottom-0 ">
                <!-- Avatar del usuario -->
                <img class=" w-[50px] h-[50px] bg-[#f3f3f3] rounded-full " :src="user.avatar" alt="">
                <!-- Input de Enviar datos -->
                <input ref="chat_input" @keydown="(e) => enviarComentarioPorSubmit(post.id, 1, e)" class=" w-[100%] h-[100%] p-[10px_40px] " type="text" placeholder="Agregar comentario">
                <button @click="(e) => enviarComentarioPorClick(post.id, 1, chat_input.value)">
                    Enviar
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
    .screen-modal {
        background:rgba(255, 255, 255, 1);
        position:fixed;
        width:100vw;
        height:100%;
        left:0px;
        top:0;
        backdrop-filter: blur(8px);
        overflow:hidden;
        z-index:10;
        overscroll-behavior: contain;
        .wrapper {
            nav {
                h2 {
                    font-weight:bold;
                }
            }
        }
    }
</style>