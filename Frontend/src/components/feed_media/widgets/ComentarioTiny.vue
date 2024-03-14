<script setup>
import {ref} from 'vue';
import UserSVG from '@public/assets/icons/user.svg';
import MoreSVG from '@public/assets/icons/ellipsis.svg';
import ModalReutilizable from '../modal/ModalReutilizable.vue';
const props = defineProps({
    comentario: Object
});
const comentario = props.comentario;

//const user = comentario.username;

const abrirModal = () => {
    if (modalHandler.value) {
        modalHandler.value = false;
    } else {
        modalHandler.value = true;
    }


    /**
     * Obtenemos el usuario para poder mostrar el avatar 
     * */

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
            action: `/comentario/${comentario.comment_id}/delete`,
            icon: DeleteSVG
        },
        {
            name: "Ver perfil",
            action: `/perfil/${comentario.username}`,
            icon: UserSVG
        },
        {
            name: "Reseñas",
            action: `/perfil/${comentario.username}`,
            icon: StarSVG
        }
    ];
}

</script>
<template>
    <div class="comentario w-[100%]  flex">
        <div class="left flex flex-col items-center justify-center mr-[30px] max-w-[100px]">
            <img class="w-[50px] h-[50px] rounded-full bg-slate-400 mr-[10px]" :src="comentario.avatar" alt="">
            <b class=" username"> {{comentario.username}}</b>
        </div>

        <span class="max-w-[80%]">{{ comentario.content}}</span>
        <button v-if="comentario.username" class="absolute right-0 "  @click="() => abrirModal()">
            <img :src="MoreSVG" alt="">
        </button>
        <ModalReutilizable v-if="modalHandler" :options="opcionesModal" :status="modal_status" :info="comentario"
            :handler="abrirModal" />
    </div>
</template>
<style scoped lang="scss">
.comentario {
    //box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    border-bottom: 1px solid rgba(206, 206, 206);
    padding: 10px 0px;
    margin: 10px 0px;

    .username {
        margin-top:10px;
        font-size: .9rem;
        text-align:center;
        width:100%;
    }
}</style>