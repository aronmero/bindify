<script setup>
import { onMounted, ref } from "vue";

import DeleteSVG from "@public/assets/icons/delete.svg";
import EditSVG from "@public/assets/icons/edit_pen.svg";
import DetallesSVG from "@public/assets/icons/eye.svg";
import HeartSVG from "@public/assets/icons/like.svg";
import ShareSVG from "@public/assets/icons/share.svg";
import BookmarkSVG from "@public/assets/icons/bookmark.png";
import MoreSVG from "@public/assets/icons/ellipsis.svg";
import UserSVG from "@public/assets/icons/user.svg";
import { borrarPost } from "@/Api/perfiles/perfil.js";
import TipoOferta from "@public/assets/icons/tipo_oferta.svg";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import TipoEvento from "@public/assets/icons/tipo_evento.svg";
const userData = JSON.parse(sessionStorage.getItem("userData"));

const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
userData.userData[0] = setDefaultImgs(userData.userData[0]);

import { datetranslate } from "@/components/feed_media/helpers/datetranslate.js";
import router from "@/router/index.js";
import { RouterLink } from "vue-router";
const props = defineProps({
  post: Object,
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
const tipo = props.post.name;
let IconoTipo = "";
if (tipo == "Post") IconoTipo = TipoOferta;
if (tipo == "Evento") IconoTipo = TipoEvento;

function editarPost(evento) {
  sessionStorage.setItem("postData", JSON.stringify({ postData: props.post }));
  router.push(`/post/${props.post.post_id}/editar`);
}
let response = ref(null);
async function responseCatcher(metodo, subRuta) {
  response.value = await borrarPost(metodo, subRuta);

  router.go();
}
function clickBorrarPost(evento) {
  if (confirm("Estas seguro de que quieres borrar esta publicación ?")) {
    responseCatcher("delete", `/api/post/${props.post.post_id}`);
  }
}
</script>

<template>
  <!------------------------------------ Post NORMAL ------------------------------>
  <article :class="` post ${estilos.post} relative `">
    <!-- Contenedor del header del post -->
    <div class="post-header w-[100%] h-[60px] flex items-center">
      <div class="w-[50px] h-[50px] rounded-full overflow-hidden mr-2">
        <img
          class="w-[100%] h-[100%] object-cover"
          :src="userData.userData[0].avatar"
          alt="avatar_usuario"
        />
      </div>
      <div class="flex flex-col items-start w-[100%] h-[100%]">
        <b>{{ userData.userData[0].username }}</b>
        <small>{{ datetranslate(post.start_date) }}</small>
      </div>
      <button @click="() => abrirModal(post.post_id)" class="mr-4">
        <img :src="MoreSVG" alt="dots" />
      </button>
    </div>

    <!-- Contenedor de la imagen del post -->
    <div
      class="post-content w-[100%] h-[400px] rounded-2xl bg-slate-400 overflow-hidden mt-5"
    >
      <img
        @click="redirect(`/post/${post.post_id}`)"
        class="cursor-pointer w-[100%] h-[100%] object-cover"
        :src="post.image"
        :alt="post.title"
      />
    </div>

    <!-- Contenedor de botones del post -->
    <div class="post-footer w-[100%] h-[50px] flex pt-5 pb-5 hidden">
      <!-- Rating -->
      <button class="flex flex-row items-center mr-3 hidden">
        <img @click="redirect(`evento/${post.post_id}`)" :src="StarSVG" />
        {{ post.rating }}
      </button>

      <!-- Guardar -->
      <button class="flex flex-row items-center mr-3">
        <img :src="BookmarkSVG" />
      </button>

      <!-- Compartir -->
      <button class="flex flex-row items-center mr-3">
        <img :src="ShareSVG" />
      </button>
    </div>
    <!-- Contenido del Post -->
    <div class="information">
      <h1>
        <img :src="IconoTipo" alt="icono-evento" />
        {{ post.title }}
      </h1>
      <span>{{ post.description }}</span>
    </div>

    <!-- Modal de Ver Más -->
    <div
      ref="modal"
      :id="`modal_${post.id}`"
      :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
    >
      <!-- Botón ver post -->
      <RouterLink :to="`/post/${post.post_id}`">
        <button :class="`${estilos.modal_button} m-2 `">
          <img class="w-[30px] h-[30px] mr-3" :src="DetallesSVG" />
          Detalles
        </button>
      </RouterLink>
      <!-- Botón editar post -->

      <button
        :class="`${estilos.modal_button} m-2 `"
        @click="editarPost"
        :id="post.post_id"
        v-if="
          (userLogeado.usuario.tipo == 'commerce' ||
            userLogeado.usuario.tipo == 'ayuntamiento') &&
          userLogeado.usuario.username == userData.userData[0].username
        "
      >
        <img class="w-[30px] h-[30px] mr-3" :src="EditSVG" />
        Editar
      </button>
      <!-- Botón eliminar post -->

      <button
        :class="`${estilos.modal_button} m-2 `"
        @click="clickBorrarPost"
        :id="post.post_id"
        v-if="
          (userLogeado.usuario.tipo == 'commerce' ||
            userLogeado.usuario.tipo == 'ayuntamiento') &&
          userLogeado.usuario.username == userData.userData[0].username
        "
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
  //background:red;
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
