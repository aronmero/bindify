<script setup>
import { ref } from 'vue';
import { datetranslate } from "@/components/notificaciones/helpers/datetranslate.js";
const props = defineProps({ notificacion: Object });

//Hacer que si seen true se añada el estilo text-text-300
const visto=ref("seen")

if(props.notificacion.seen){
    visto.classList.add("text-text-300")
}

const pintar = (e) => {
    if (props.notificacion.seen) {

    }
  //  e.target.classList.add("text-text-300")
    console.log(visto)
}
</script>

<template>
    <div :ref="visto" class="post-header w-[100%] h-[60px] flex items-center">
        <div class="w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
            <img @click="$router.push(`/perfil/${props.notificacion.username}`)"
                class="cursor-pointer w-[100%] h-[100%] object-cover" :src="props.notificacion.avatar"
                alt="avatar_usuario" />
        </div>
        <div class="flex flex-col items-start w-[100%] h-[100%]">
            <small>{{ datetranslate(props.notificacion.created_at) }}</small>
            <!--Segun el tipo de notificacion se muestra una cosa u otra-->
            <div v-if="props.notificacion.type == `Comment`" @click="pintar" class="cursor-pointer">
                {{ props.notificacion.username }} ha comentado en tu publicacion
            </div>
            <div v-if="props.notificacion.type == `Follower`"> {{ props.notificacion.username }}te ha seguido</div>
            <div v-if="props.notificacion.type == `Review`" @click="$router.push(`/perfil/`)" class="cursor-pointer">
                {{ props.notificacion.username }} te ha dejado una reseña
            </div>
            <div v-if="props.notificacion.type == `Post`" @click="$router.push(`/post/${props.notificacion.id_link}`)"
                class="cursor-pointer">
                {{ props.notificacion.username }} ha publicado
            </div>

        </div>
    </div>
</template>
