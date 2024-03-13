<script setup lang="ts">
import { ref, onBeforeUnmount } from 'vue';
import { datetranslate } from '@/components/notificaciones/helpers/datetranslate.js'
import EnviarSVG from '@public/assets/icons/forward.svg';
import Comentario from '@/components/feed_media/widgets/Comentario.vue';
import Calendar from "@/components/utils/calendar.vue";
import { getCommentsOfPost, storeCommentsOfPost } from "@/Api/publicacion/comentarios.js";
import router from '@/router/index.js';

//https://vueuse.org/core/useClipboard/
import { useClipboard } from '@vueuse/core'

const props = defineProps({
    post_id: String,
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

let comentarios = ref(props.comentarios);
//Abre y cierra el modal
const openModal = (e) => {
    if (e.target.nextSibling.classList.contains("hidden")) {
        e.target.nextSibling.classList.remove("hidden")
    } else {
        e.target.nextSibling.classList.add("hidden")
    }
}
//Cierra el modal si se pulsa en cualquier parte de la pantalla
const closeModal = (e) => {
    const modal = document.getElementById("modalEvento");
    if (e.target != modal) {
        if (modal.compareDocumentPosition(e.target) != "20" & modal.compareDocumentPosition(e.target) != "0") {
            modal.classList.add("hidden");
        }
    }
};
window.addEventListener("mouseup", closeModal);

//Elimina el event listener antes de cambiar de ruta
onBeforeUnmount(() => {
    window.removeEventListener("mouseup", closeModal);
    clearInterval(interval);
});

const { copy } = useClipboard()
const copyModal = (e) => {
    e.target.classList.add("hidden");
    copy(props.url);
}


const id_post = props.post_id;
const apiCall = async () => {
    await getCommentsOfPost(id_post).then(data => comentarios.value = data.comentarios)
}


const chat_input = ref(null);
const posteado = ref(false);
let interval;
const enviarComentarioPorSubmit = async (post_id, event) => {
    if (event.key == 'Enter') {
        let texto = event.target.value;
        if (!posteado.value) {
            if (texto != "") {
                const body = JSON.stringify({ "content": `${texto}`, "post_id": post_id })
                const response = await storeCommentsOfPost(body)
            }

            antiSpamFunction();
            apiCall();
        }
    }
};

const enviarComentarioPorClick = async (post_id, texto) => {
    if (!posteado.value && texto != "") {
        const body = JSON.stringify({ "content": `${texto}`, "post_id": post_id })
        const response = await storeCommentsOfPost(body)
        antiSpamFunction();
        apiCall();
    }
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
            <Calendar :post="props" />
        </div>
        <div class="text-[24px] font-bold my-[30px]">Comentarios</div>
        <div>
            <div
                class=" chat w-[100%] bg-[#e6e5e5] h-[50px] flex items-center  bottom-[50px] sm:bottom-[50px] md:bottom-[50px] lg:bottom-[10px]  xl:bottom-[10px] 2xl:bottom-[10px] p-[30px_20px] rounded-full">
                <!-- Input de Enviar datos -->
                <input ref="chat_input" @keydown="(e) => enviarComentarioPorSubmit(props.post_id, e)"
                    class=" outline-none bg-[#e6e5e5] w-[100%] h-[100%] p-[30px_20px] " type="text"
                    placeholder="Agregar comentario">
                <!-- Botón de Enviar  -->
                <button class="p-[20px]" @click="(e) => enviarComentarioPorClick(props.post_id, chat_input.value)">
                    <img class="rotate-180" :src="EnviarSVG" alt="submit" />
                </button>
            </div>
            <template v-if="comentarios != null">
                <Comentario v-if="comentarios.length >= 1" v-for="comentario in comentarios" :comentario="comentario" />
                <Comentario v-else :comentario="{ content: 'No hay comentarios, ¡se el primero!' }" />
            </template>

        </div>
    </div>
</template>

<style scoped></style>
