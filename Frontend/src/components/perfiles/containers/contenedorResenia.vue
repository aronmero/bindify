<script setup>
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRedonda from "@/components/perfiles/widgets/imgRedonda.vue";
import contenedorPuntuacion from "@/components/perfiles/containers/contenedorPuntuacion.vue";

import { ref } from "vue";
const userData = JSON.parse(sessionStorage.getItem("userData"));
const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
const props = defineProps({
  rutaPerfil: String,
  nombre: String,
  texto: String,
  puntuacion: String,
  fecha: String,
  titulo: String,
  imagen: String,
  imagenAltText: String,
  id: String,
  post: Object,
});

let response = ref(null);
async function responseCatcher(metodo, subRuta) {
  response.value = await borrarPost(metodo, subRuta);
  console.log(response.value);
  router.go();
}
function clickBorrarResenia(evento) {
  if (confirm("Estas seguro de que quieres borrar la resenia ?")) {
    responseCatcher("delete", `/api/review/${evento.target.id}`);
  }
}

import { onMounted } from "vue";

import DeleteSVG from "@public/assets/icons/delete.svg";
import HeartSVG from "@public/assets/icons/like.svg";
import ShareSVG from "@public/assets/icons/share.svg";
import BookmarkSVG from "@public/assets/icons/bookmark.png";
import MoreSVG from "@public/assets/icons/ellipsis.svg";
import UserSVG from "@public/assets/icons/user.svg";
import { borrarPost } from "@/Api/perfiles/perfil.js";
import TipoOferta from "@public/assets/icons/tipo_oferta.svg";
import TipoEvento from "@public/assets/icons/tipo_evento.svg";

import { datetranslate } from "@/components/feed_media/helpers/datetranslate.js";
import router from "@/router/index.js";
import { RouterLink } from "vue-router";

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
};

/* Son estilos personalizados para acortar y mejorar la visibilidad del codigo principal */

const estilos = {
  post: " w-[100%]  flex flex-col overflow-hidden ",
  post_avatar: "",
  modal:
    " absolute bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center ",
  modal_button: " flex items-center font-medium w-[100%]  ",
  modal_superior_dcha: " top-[100px] right-[20px] ",
};

const redirect = (url) => {
  router.push(url);
};

/** Agregué que se listaran ya los tipos */
// const tipo = props.post.name;
// let IconoTipo = "";
// if (tipo == "Post") IconoTipo = TipoOferta;
// if (tipo == "Evento") IconoTipo = TipoEvento;

// function editarPost(evento) {
//   console.log(props.post);
//   sessionStorage.setItem("postData", JSON.stringify({ postData: props.post }));
//   console.log(JSON.parse(sessionStorage.getItem("postData")));
//   router.push(`/post/${props.post.post_id}/editar`);
// }
// let response = ref(null)
// async function responseCatcher(metodo, subRuta) {
//   response.value = await borrarPost(metodo, subRuta);
//   console.log(response.value);
//   router.go()
// }
// function clickBorrarPost(evento) {
//   if(confirm("Estas seguro de que quieres borrar el post ?")){

//     // responseCatcher("delete", `/api/post/${props.post.post_id}`);
//   }
// }
</script>
<template>
  <!------------------------------------ Post NORMAL ------------------------------>
  <article :class="` post ${estilos.post} relative `">
    <!-- Contenedor del header del post -->
    <div class="post-header w-[100%] h-[60px] flex items-center">
      <div class="w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
        <img
          class="w-[100%] h-[100%] object-cover"
          :src="rutaPerfil"
          alt="avatar_usuario"
        />
      </div>
      <div class="flex flex-col items-start w-[100%] h-[100%]">
        <b>{{ nombre }}</b>
        <small>{{ fecha }}</small>
      </div>
      <!-- Abrir Mas -->
      <button
        @click="() => abrirModal(id)"
        class="mr-4"
        v-if="
          userLogeado.usuario.tipo == 'customer' &&
          userLogeado.usuario.username == nombre
        "
      >
        <img :src="MoreSVG" alt="dots" />
      </button>
    </div>

    <!-- Contenedor de la imagen del post -->
    <div
      class="post-content w-[100%] h-[400px] rounded-2xl bg-slate-400 overflow-hidden mt-5 hidden"
    >
      <img
        class="cursor-pointer w-[100%] h-[100%] object-cover"
        :src="imagen"
        :alt="imagenAltText"
      />
    </div>

    <!-- Contenido del Post -->
    <div class="information">
      <h1>
        {{ texto }}
      </h1>
      <span>{{ texto }}</span>
    </div>

    <!-- Modal de Ver Más -->
    <div
      ref="modal"
      :id="`modal_${id}`"
      :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
    >
      <!-- Botón eliminar post -->

      <button
        :class="`${estilos.modal_button} m-2 `"
        @click="clickBorrarResenia"
        :id="id"
      >
        <img class="w-[30px] h-[30px] mr-3" :src="DeleteSVG" />
        Eliminar
      </button>
    </div>
  </article>
</template>
<style scoped lang="scss">
@import "@/components/perfiles/styles/sass/variables.scss";

/* fuerzo el poner el estilo */
.modal {
  width: fit-content;
  box-shadow:
    rgba(50, 50, 93, 0.25) 0px 13px 27px -5px,
    rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
  display: none;
}

.badge {
  display: flex;
}

.modal-izq {
  top: 120px;
  left: 20px;
}

.destacado {
  margin-top: -10px;
}

button {
  font-family:
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    "Segoe UI",
    Roboto,
    Oxygen,
    Ubuntu,
    Cantarell,
    "Open Sans",
    "Helvetica Neue",
    sans-serif;
}

.post {
  padding: 20px 0px;
  height: fit-content;

  .post-content {
    box-shadow:
      rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
      rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    img {
      box-shadow:
        rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
        rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    }
  }
  .information {
    /*estilos simples */
    display: flex;
    flex-direction: column;
    height: fit-content;

    h1 {
      font-size: 1.2rem;
      font-weight: 500;
      margin: 20px 0px 10px 0px;
      display: flex;
      align-items: center;

      img {
        margin-right: 10px;
        background: rgb(245, 245, 245);
        width: 35px;
        height: 35px;
        border-radius: 50px;
        padding: 3px;
        color: white;
      }
    }

    span {
      margin: 10px 0px;
      font-size: 0.85rem;
    }
  }
  .post-footer {
    button {
      font-size: 1.1rem;
      width: fit-content;
      height: fit-content;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      img {
        width: 25px;
        height: 25px;
        margin-right: 5px;
      }
    }
  }
}
</style>
