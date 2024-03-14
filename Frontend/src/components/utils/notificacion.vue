<script setup>
import { ref } from 'vue';
import { vistoNotificacion, deleteNotificacion } from '@/Api/notificaciones/notificaciones_usuario.js'
import { datetranslate } from "@/components/notificaciones/helpers/datetranslate.js";
const props = defineProps({ notificacion: Object });

/**
 * Determina si esta eliminada la publicacion para ocultarla
 */
const eliminada = ref(false)

/**
 * Envia una peticion para marcar una notificacion como vista si no esta eliminada
 */
const marcarVisto = async () => {
    setTimeout(async () => {
        if (!props.notificacion.seen && !eliminada.value) {
            const data = await vistoNotificacion(props.notificacion.id_noti);
            props.notificacion.seen = true;
        }
    }, 100)


}
/**
 * Envia una peticion para eliminar una notificacion
 */
const eliminarNotificacion = async (e) => {
    // console.log(props.notificacion.id_noti);
    const data = await deleteNotificacion(props.notificacion.id_noti);
    // console.log(data)
    eliminada.value = true
}
</script>

<template>
    <div :class="{ 'text-text-300': props.notificacion.seen }" v-if="!eliminada"
        class="post-header w-[100%] h-[70px] flex items-center overflow-hidden" @click="marcarVisto">
        <div class="w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
            <img @click="$router.push(`/perfil/${props.notificacion.username}`)"
                class="cursor-pointer w-[100%] h-[100%] object-cover" :src="props.notificacion.avatar"
                alt="avatar_usuario" />
        </div>
        <div class="flex flex-col items-start w-[100%] h-[100%] justify-around">

            <!--Segun el tipo de notificacion se muestra una cosa u otra-->

            <div v-if="props.notificacion.type == `Comment`"
                @click="$router.push(`/post/${props.notificacion.id_link}`)" class="cursor-pointer">
                {{ props.notificacion.username }} ha comentado en tu publicacion
            </div>
            <div v-if="props.notificacion.type == `Follower`"
                @click="$router.push(`/perfil/${props.notificacion.username}`)" class="cursor-pointer"> {{
        props.notificacion.username }}te ha seguido</div>
            <div v-if="props.notificacion.type == `Review`" @click="$router.push(`/perfil/`)" class="cursor-pointer">
                {{ props.notificacion.username }} te ha dejado una reseña
            </div>
            <div v-if="props.notificacion.type == `Post`" @click="$router.push(`/post/${props.notificacion.id_link}`)"
                class="cursor-pointer">
                {{ props.notificacion.username }} ha publicado
            </div>
            <div><small>Hace {{ datetranslate(props.notificacion.created_at) }}</small><small
                    v-if="props.notificacion.seen">visto</small></div>
        </div>
        <div class="mr-[10px] cursor-pointer"><img src="@public/assets/icons/cancel.svg" @click="eliminarNotificacion">
        </div>
    </div>
</template>
