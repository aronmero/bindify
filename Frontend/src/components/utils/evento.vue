<script setup lang="ts">
import { datetranslate } from '@/components/notificaciones/helpers/datetranslate.js'

import Comentario from '@/components/feed_media/widgets/Comentario.vue';
import Calendar from "@/components/utils/calendar.vue";
//https://vueuse.org/core/useClipboard/
import { useClipboard } from '@vueuse/core'

const props = defineProps({
    url: { type: String, default: "" },
    banner: { type: String, default: "https://placehold.co/320x230/png" },
    titulo: { type: String, default: "Título evento" },
    ubicacion: { type: String, default: null },
    fechaInicio: { type: String, default: null },
    fechaFin: { type: String, default: null },
    dias: { type: String, default: "25" },
    descripcion: { type: String, default: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in tempus lorem. Donec eu felis erat. Aenean eu augue congue, congue ligula vitae, accumsan neque. Mauris auctor lobortis tempor. In hac habitasse platea dictumst. Ut egestas eget nunc quis convallis. Suspendisse potenti. Vivamus commodo lectus quis maximus facilisis. " },
    tipo: { type: String, default: "Evento" },
    user: Object,
    fecha_publicacion: String,
    comentarios: Array,
});

//Abre y cierra el modal
const openModal = (e) => {
    if (e.target.nextSibling.classList.contains("hidden")) {
        e.target.nextSibling.classList.remove("hidden")
    } else {
        e.target.nextSibling.classList.add("hidden")
    }
}
//Cierra el modal si se pulsa en cualquier parte de la pantalla
window.addEventListener("mouseup", (e) => {
    const modal = document.getElementById("modalEvento");

    if (e.target != modal.previousSibling) {

        //Esto es cosa de antonio si falla es su culpa
        if (modal.compareDocumentPosition(e.target) != "20" & modal.compareDocumentPosition(e.target) != "0") {
            modal.classList.add("hidden");
        }
    }
})

const { copy } = useClipboard()
const copyModal = (e) => {
    e.target.classList.add("hidden");
    copy(props.url);
}
</script>

<template>
    <div class=" post-header w-[100%] h-[60px] flex items-center ">
        <div class=" w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
            <img v-for="user in props.user" @click="$router.push(`/usuario/${user.id}`)"
                class=" cursor-pointer w-[100%] h-[100%] object-cover " :src="user.avatar" alt="avatar_usuario">
        </div>
        <div class=" flex flex-col items-start w-[100%] h-[100%] ">
            <b v-for="user in props.user">{{ user.name }}</b>
            <small>{{ datetranslate(props.fecha_publicacion) }}</small>
        </div>
    </div>

    <div>
        <div class="flex justify-center mx-[-10px]"><img :src="banner"
                class="max-w-[680px] max-h-[440px] min-w-[320px] min-h-[230px] w-full"></div>
    </div>
    <div class="flex m-[20px] flex-col">
        <div class="flex justify-between w-full font-bold pb-[40px] relative">
            <div>{{ props.titulo }}</div>
            <div class="cursor-pointer" @click="openModal">...</div>
            <div id="modalEvento" @click="copyModal"
                class="top-[30px] right-0 absolute bg-background-50 drop-shadow-sm rounded-[5px] font-normal p-[5px] flex gap-[5px] items-center cursor-pointer hidden">
                <img src="@public/assets/icons/share.svg">Compartir
            </div>
        </div>
        <div>
            <div class="flex" v-if="tipo == 'Evento' && props.ubicacion != null"><img
                    src="@public/assets/icons/location.svg" class="w-[20px] mr-[5px]">{{ props.ubicacion
                    }}
            </div>
            <div class="flex" v-if="tipo == 'Evento' && props.fechaInicio != null && props.fechaFin != null"><img
                    src="@public/assets/icons/schedule.svg" class="w-[20px] mr-[5px]">{{
                        props.fechaInicio }}
                al {{ props.fechaFin }}</div>
        </div>
        <div> {{ props.descripcion }}</div>
        <div class="text-[24px] font-bold my-[30px]" v-if="tipo == 'Evento'">Periodo del evento</div>
        <div v-if="tipo == 'Evento'">
            <Calendar />
        </div>
        <div class="text-[24px] font-bold my-[30px]">Comentarios</div>
        <div>
            <template v-if="props.comentarios != null">
                <Comentario v-if="props.comentarios.length >= 1" v-for="comentario in props.comentarios"
                    :comentario="comentario" />
                <Comentario v-else :comentario="{ content: 'No hay comentarios, ¡se el primero!' }" />
            </template>
        </div>
    </div>
</template>

<style scoped></style>
