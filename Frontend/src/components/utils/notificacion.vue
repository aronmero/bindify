<script setup>
import { ref } from 'vue';
import { vistoNotificacion } from '@/Api/notificaciones/notificaciones_usuario.js'
import { datetranslate } from "@/components/notificaciones/helpers/datetranslate.js";
const props = defineProps({ notificacion: Object });

const marcarVisto = async () => {
    if (!props.notificacion.seen) {
        const data = await vistoNotificacion(props.notificacion.id_noti);
        console.log(data)
        props.notificacion.seen = true;
    }
}
</script>

<template>
    <div :class="{ 'text-text-300': props.notificacion.seen }" class="post-header w-[100%] h-[60px] flex items-center"
        @click="marcarVisto">
        <div class="w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
            <img @click="$router.push(`/perfil/${props.notificacion.username}`)"
                class="cursor-pointer w-[100%] h-[100%] object-cover" :src="props.notificacion.avatar"
                alt="avatar_usuario" />
        </div>
        <div class="flex flex-col items-start w-[100%] h-[100%]">
            <small>{{ datetranslate(props.notificacion.created_at) }}</small>
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

        </div>
    </div>
</template>
