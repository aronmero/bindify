<script setup>
import { ref } from 'vue';
import MoreSVG from '@public/assets/icons/ellipsis.svg';
import { encontrar_usuario_por_id } from './../mocks/users';
import StarSVG from '@public/assets/icons/star.svg';
import StarEmptySVG from '@public/assets/icons/starEmpty.svg';

import DeleteSVG from '@public/assets/icons/delete.svg';
import UserSVG from '@public/assets/icons/user.svg';
import ModalReutilizable from '../modal/ModalReutilizable.vue';

/**
 * Obtengo el comentario del padre
 * */
const props = defineProps({
    comentario: Object,
});

const comentario = props.comentario;
/**
 * Obtenemos el usuario para poder mostrar el avatar 
 * */
const user = encontrar_usuario_por_id(comentario.user_id);

/**
 * Creo la referencia para poder utilizar ocultar y mostrar el modal
 * */
const modalHandler = ref(false);

/**
 * Instauro las opciones que le voy a pasar al componente del modal reutilizable
 * */
const opcionesModal = [
    {
        name: "Borrar Comentario",
        action: `comentario/${comentario._id}/delete`,
        icon: DeleteSVG
    },
    {
        name: "Ver perfil",
        action: `perfil/${user._id}`,
        icon: UserSVG
    },
    {
        name: "Reseñas",
        action: `perfil/${user._id}`,
        icon: StarSVG
    }
];

/**
 * Asignamos la función modal para controlar el modal de Ver Más (···)
 * 
 * */

const abrirModal = () => {
    if (modalHandler.value) {
        modalHandler.value = false;
    } else {
        modalHandler.value = true;
    }
}

</script>
<template>
    <!-- Contenedor Comentario -->
    <div class=" comentario flex flex-col w-[100%] p-[10px] rounded-lg relative my-4   ">
        <!-- Header del comentario -->
        <div class=" header-comentario flex ">
            <!-- Avatar del usuario -->
            <img class=" mr-[10px] " :src="user.avatar" alt="">
            <!-- Textos del usuario -->
            <div class="textos m-l">
                <b> {{ user.name }}</b>
                <button click="" class=" mt-[-15px] rating flex h-[fit-content] items-center justify-start "
                    v-if="user.rating != null">
                    <img class="  " :src="StarSVG" v-for="index in Math.floor(user.rating)" alt="star"
                        :title="user.rating" />
                    <img class=" " :src="StarEmptySVG" v-for="index in (5 - Math.floor(user.rating))" alt="star"
                        :title="user.rating" />
                    <small>({{ user.rating }})</small>
                </button>
            </div>
            <!-- Botón de Ver Más -->
            <button @click="() => abrirModal()" class="w-[20px] h-[20px] absolute right-10">
                <img class="  " :src="MoreSVG" alt="">
            </button>
        </div>
        <!-- Contenido del comentario -->
        <span class=" mt-3 ">
            {{ comentario.content }}
        </span>
        <!-- Modal de Ver Más -->
        <ModalReutilizable v-if="modalHandler" :options="opcionesModal" :status="modal_status" :handler="abrirModal" />
    </div>
</template>
<style scoped lang="scss">
.header-comentario {
    img {
        width: 50px;
        height: 50px;
        border-radius: 50px;
    }

    .rating {
        img {
            width: 20px;
        }
    }
}</style>