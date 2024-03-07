<script setup>
import { onMounted, ref } from 'vue';

import StarSVG from '@public/assets/icons/star.svg';
import HeartSVG from '@public/assets/icons/like.svg';
import ShareSVG from '@public/assets/icons/share.svg';
import BookmarkSVG from '@public/assets/icons/bookmark.svg';
import MoreSVG from '@public/assets/icons/ellipsis.svg';
import UserSVG from '@public/assets/icons/user.svg';

import TipoOferta from '@public/assets/icons/tipo_oferta.svg'
import TipoEvento from '@public/assets/icons/tipo_evento.svg'

import { datetranslate } from './../helpers/datetranslate.js'
import router from '../../../router';

const props = defineProps({
    post: Object
});

const post = ref(props.post);
const modalHandler = ref(false);
const modal = ref(null);



const increaseLike = () => {
    //post.value.likes++;
};

const abrirModal = () => {
    if (modalHandler.value) {
        modal.value.style.display = "none";
        modalHandler.value = false;
    } else {
        modal.value.style.display = "flex";
        modalHandler.value = true;
    }
}

/* Son estilos personalizados para acortar y mejorar la visibilidad del codigo principal */

const estilos = {
    post: ' w-[100%] min-h-[800px] flex flex-col overflow-hidden ',
    post_avatar: '',
    modal: ' absolute bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center',
    modal_button: ' flex items-center font-medium w-[100%]  ',
    modal_superior_dcha: ' top-[100px] right-[20px] '
};

const redirect = (url) => {
    router.push(url)
}

const tipo = props.post.post_type_id;
let IconoTipo = "";
if (tipo == 1) IconoTipo = TipoOferta;
if (tipo == 2) IconoTipo = TipoEvento;

</script>

<template>
    <!------------------------------------ Post NORMAL ------------------------------>
    <article v-if="!post.destacado && post.usuario.tipo == 'comercio'" :class="` post ${estilos.post} relative `">

        <!-- Contenedor del header del post -->
        <div class=" post-header w-[100%] h-[60px] flex items-center ">
            <div class=" w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
                <img @click="redirect(`comercio/${post.usuario.id}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover " :src="post.usuario.avatar" alt="avatar_usuario">
            </div>
            <div class=" flex flex-col items-start w-[100%] h-[100%] ">
                <b>{{ post.usuario.nombre }}</b>
                <small>{{ datetranslate(post.fecha_publicacion) }}</small>
            </div>
            <button @click="() => abrirModal(post.id)" class="mr-4">
                <img :src="MoreSVG" alt="dots">
            </button>
        </div>

        <!-- Contenedor de la imagen del post -->
        <div class=" post-content w-[100%] h-[600px] rounded-2xl bg-slate-400 overflow-hidden mt-5 ">
            <img @click="redirect(`evento/${post.id}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover " :src="post.image" :alt="post.titulo">
        </div>

        <!-- Contenedor de botones del post -->
        <div class=" post-footer w-[100%] h-[50px] flex pt-5 pb-5 ">
            <!-- Rating -->
            <button class=" flex flex-row items-center mr-3 ">
                <img @click="redirect(`evento/${post.id}`)" :src="StarSVG" />
                {{ post.rating }}
            </button>

            <!-- Guardar -->
            <button class=" flex flex-row items-center mr-3 ">
                <img :src="BookmarkSVG" />
            </button>

            <!-- Compartir -->
            <button class=" flex flex-row items-center mr-3 ">
                <img :src="ShareSVG" />
            </button>

        </div>
        <!-- Contenido del Post -->
        <div class="information ">
            <h1>
                <img :src="IconoTipo" alt="icono-evento">
                {{ post.title }}
            </h1>
            <span>{{ post.description }}</span>
        </div>

        <!-- Modal de Ver Más -->
        <div ref="modal" :id="`modal_${post.id}`" :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`">
            <!-- Botón ver perfil -->
            <button @click="redirect(`comercio/${post.usuario.id}`)" :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px] mr-3 " :src="UserSVG" />
                Ver perfil
            </button>
            <!-- Botón ver reseñas comercio -->
            <button :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px]  mr-3 " :src="StarSVG" />
                Reseñas
            </button>
        </div>
    </article>


    <!------------------------------------ Post DESTACADO ------------------------------>
    <article v-if="post.destacado && post.usuario.tipo == 'comercio'" :class="` post ${estilos.post} relative`">

        <!-- Contenedor del header del post -->
        <div class=" post-header w-[100%] h-[60px] flex items-center ">
            <div class=" w-[50px] h-[50px] rounded-full overflow-hidden mr-2 ">
                <img @click="redirect(`comercio/${post.usuario.id}`)"  class=" cursor-pointer w-[100%] h-[100%] object-cover  " :src="post.usuario.avatar" alt="avatar_usuario">
            </div>
            <div  class=" flex flex-col items-start texts w-[100%] bg-white h-[100%]  ">
                <b @click="redirect(`comercio/${post.id}`)" class="cursor-pointer" >{{ post.usuario.nombre }}</b>
                <small>{{ datetranslate(post.fecha_publicacion) }}</small>
            </div>
            <button @click="() => abrirModal(post.id)" class="mr-4">
                <img :src="MoreSVG" alt="dots">
            </button>
        </div>

        <!-- Contenedor de la imagen del post -->
        <div class=" post-content w-[100%] h-[600px] rounded-2xl bg-slate-400 overflow-hidden mt-5 mb-5 ">
            <img @click="redirect(`evento/${post.id}`)" class=" w-[100%] h-[100%] object-cover  " :src="post.image" :alt="post.titulo">
        </div>

        <!-- post footer -->
        <div class=" post-footer w-[100%] h-[50px] flex pt-5 pb-5 ">

            <!-- Rating -->
            <button class=" flex flex-row items-center mr-3  ">
                <img :src="StarSVG" />
                {{ post.rating }}
            </button>

            <!-- Guardar -->
            <button class=" flex flex-row items-center mr-3 ">
                <img :src="BookmarkSVG" />
            </button>

            <!-- Compartir -->
            <button class=" flex flex-row items-center mr-3 ">
                <img :src="ShareSVG" />
            </button>

        </div>
        <!-- Contenido del Post -->
        <div class="information">

            <h1>
                <img :src="IconoTipo" alt="icono-evento">
                {{ post.title }}
            </h1>
            <span>{{ post.description }}</span>
        </div>

        <!-- Modal de Destacados -->
        <div :class="` badge modal modal-izq destacado ${estilos.modal} ${estilos.modal_inferior_izq} `">
            <button :class="`${estilos.modal_button} `">
                <img class=" w-[20px] h-[20px]  mr-3 " :src="StarSVG" />
                Destacado por la comunidad
            </button>
        </div>

        <!-- Modal de Ver Más -->
        <div ref="modal" :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`">
            <!-- Botón ver perfil -->
            <button @click="redirect(`comercio/${post.id}`)" :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px] mr-3 " :src="UserSVG" />
                Ver perfil
            </button>
            <!-- Botón ver reseñas comercio -->
            <button :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px]  mr-3 " :src="StarSVG" />
                Reseñas
            </button>
        </div>

    </article>

    <!------------------------------------ Post AYUNTAMIENTO ------------------------------>
    <article v-if="post.usuario.tipo == 'ayuntamiento'" :class="` post ${estilos.post} relative`">

        <!-- post header -->
        <div class=" post-header w-[100%] h-[fit-content] flex items-center pt-3 pb-4 ">
            <div class=" w-[50px] h-[50px] rounded-full overflow-hidden  mr-2 ">
                <img @click="redirect(`ayuntamiento/${post.usuario.id}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover mr-2" :src="post.usuario.avatar" alt="avatar_usuario">
            </div>
            <div @click="redirect(`ayuntamiento/${post.id}`)" class=" cursor-pointer flex flex-col items-start texts w-[100%] h-[100%] ">
                <b>{{ post.usuario.nombre }}</b>
                <small> Organización </small>
            </div>
            <button @click="() => abrirModal(post.id)" class="mr-4">
                <img :src="MoreSVG" alt="dots">
            </button>
        </div>

        <!-- post image -->
        <div class=" post-content w-[100%] h-[600px] rounded-2xl bg-slate-400 overflow-hidden ">
            <img @click="redirect(`evento/${post.id}`)" class=" cursor-pointer w-[100%] h-[100%] object-cover " :src="post.image" :alt="post.titulo">
        </div>



        <!-- post footer -->
        <div class=" post-footer w-[100%] h-[50px] flex pt-5 pb-5 ">
            <!-- Los destacados de ayuntamiento no tienen botones de feedback salvo el de guardar -->

            <!-- Guardar -->
            <button class=" flex flex-row items-center mr-3 ">
                <img :src="BookmarkSVG" />
            </button>
            <!-- Compartir -->

            <button class=" flex flex-row items-center mr-3 ">
                <img :src="ShareSVG" />
            </button>

        </div>

        <!-- Contenido del Post -->
        <div class="information">
            <h1>
                <img :src="IconoTipo" alt="icono-evento">
                {{ post.title }}
            </h1>
            <span>{{ post.description }}</span>
        </div>


        <!-- Modal de Evento Institucional -->
        <div :class="` badge modal modal-izq ${estilos.modal}  ${estilos.modal_inferior_izq}`">
            <button :class="`${estilos.modal_button} `">
                <img class=" w-[20px] h-[20px]  mr-3 " :src="StarSVG" />
                Evento Institucional
            </button>
        </div>

        <!-- Modal de Ver Más -->
        <div ref="modal" :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`">
            <!-- Botón ver perfil -->
            <button @click="redirect(`ayuntamiento/${post.id}`)" :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px] mr-3 " :src="UserSVG" />
                Ver perfil
            </button>
            <!-- Botón ver reseñas comercio -->
            <button :class="`${estilos.modal_button} m-2 `">
                <img class="w-[30px] h-[30px]  mr-3 " :src="StarSVG" />
                Reseñas
            </button>
        </div>

    </article>
</template>

<style scoped lang="scss">
@import './../styles/sass/variables.scss';

/* fuerzo el poner el estilo */
.modal {
    width: fit-content;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
    display: none;
}

.badge {
    display: flex;
}

.modal-izq {
    //background:red;
    top: 120px;
    left: 20px;
}

.destacado {
    margin-top: -10px;
}

button {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.post {
    padding: 20px 0px;
    height: fit-content;

    .post-content {
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        img {
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;;
        }
    }
    .information {
        /*estilos simples */
        display: flex;
        flex-direction: column;
        height: fit-content;

        img {}

        h1 {
            font-size: 1.2rem;
            font-weight: 500;
            margin: 20px 0px 10px 0px;
            display: flex;
            align-items: center;

            img {
                margin-right: 10px;
                background: $destacado;
                width: 35px;
                height: 35px;
                border-radius: 50px;
                padding: 3px;
                color: white;
            }
        }

        span {
            margin: 10px 0px;
            font-size: .85rem;
        }
    }
    .post-footer {
        button {
            font-size:1.1rem;
            width:fit-content;
            height:fit-content;
            font-weight:bold;
            display:flex;
            align-items: center;
            justify-content: center;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            img {
                width:25px;
                height:25px;
                margin-right:5px;
            }
        }
    }


}</style>