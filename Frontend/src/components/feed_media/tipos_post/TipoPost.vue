<script setup>
import { onMounted, ref } from "vue";

// import { useIntersectionObserver } from "@/vueuse/core";

import StarSVG from "@public/assets/icons/star.svg";
import StarEmptySVG from "@public/assets/icons/starEmpty.svg";

import { obtener_comentarios_post } from "@/Api/home/comentarios";

import HeartSVG from "@public/assets/icons/like.svg";
import ShareSVG from "@public/assets/icons/share.svg";
import ChatSVG from "@public/assets/icons/chat.svg";
import BookmarkEmptySVG from "@public/assets/icons/bookmark_empty.png";
import BookmarkSVG from "@public/assets/icons/bookmark.png";

import MoreSVG from "@public/assets/icons/ellipsis.svg";
import UserSVG from "@public/assets/icons/user.svg";

import TipoOferta from "@public/assets/icons/tipo_oferta.svg";
import TipoEvento from "@public/assets/icons/tipo_evento.svg";

import { share } from "@/components/feed_media/helpers/share.js";

import { datetranslatesql } from "./../helpers/datetranslate.js";
import router from "../../../router";

import { en_favoritos, obtener_favoritos } from "../helpers/favoritos";

import Comentarios from "../modal/ComentariosHome.vue";
import { obtener_tipo_comercio } from "@/Api/home/publicaciones";

const props = defineProps({
  post: Object,
  tipo: String,
});

const post = ref(props.post);
const post_reference = ref(null);
const modalHandler = ref(false);
const modal = ref(null);

const modal_comentarios = ref(null);
/** Genero la referencia para abrir o cerrar el modal de comentarios */
const comentariosVisibles = ref(false);

/** Genero la referencia para obtener los favoritos del usuario, hecho en frontend por no poderse poner en back */
const favoritos = ref(JSON.parse(sessionStorage.getItem("favoritos")));

/** Abre el modal del perfil */
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
  post: " w-[100%] min-h-[200px]  flex flex-col overflow-hidden ",
  post_avatar: "",
  modal:
    " absolute bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center ",
  modal_button: " flex items-center font-medium w-[100%]  ",
  modal_superior_dcha: " top-[100px] right-[0px] ",
};

/**
 * Redirecciona a la url destino
 * */
const redirect = (url) => {
  router.push(url);
};

/** Dependiendo del tipo de ar */
const tipo = props.post.post_type_id;
let IconoTipo = "";
if (tipo == 1) IconoTipo = TipoOferta;
if (tipo == 2) IconoTipo = TipoEvento;

/**
 * Abre el modal de comentarios
 */
const abrirComentarios = () => {
  if (comentariosVisibles.value) {
    comentariosVisibles.value = false;
  } else {
    comentariosVisibles.value = true;
  }
};
/**
 * Añade un favorito se realiza desde el componente
 * para aprovechar la variable de referencia y
 * aplicar los cambiso en el Front del usuario
 * */

const aniadir_favorito = (item) => {
  if (favoritos.value.indexOf(item) == -1) {
    favoritos.value.push(item);
    post_reference.value.dataset.favorito = "true";
    console.log("agregado");
  } else {
    favoritos.value.splice(favoritos.value.indexOf(item), 1);
    post_reference.value.dataset.favorito = "false";
    console.log("borrado");
  }
  // guardamos los cambios
  sessionStorage.setItem("favoritos", JSON.stringify(favoritos.value));
};

let tipo_usuario = ref("comercio");

/** referencia los comentarios */
let comentarios = ref(null);

//console.log(tipo_usuario);
const { stop } = useIntersectionObserver(
  post_reference,
  async ([{ isIntersecting }], observerElement) => {
    if (isIntersecting) {
      let post_id = post.value.post_id;

      comentarios.value = await obtener_comentarios_post(post_id);
      console.log(comentarios.value);

      console.log("showing element ", post.value.post_id);
      console.log(post.value);
      stop();
    }
  }
);
</script>

<template>
  <Suspense>
    <div>
      <!------------------------------------ Post NORMAL ------------------------------>
      <article
        ref="post_reference"
        v-if="tipo_usuario == 'comercio' && post.avg < 4"
        :class="` post ${estilos.post} relative `"
        :data-start_date="post.start_date"
        :data-end_date="post.end_date"
        :data-favorito="
          favoritos.indexOf(post.post_id) == -1 ? 'false' : 'true'
        "
      >
        <!-- Contenedor del header del post -->
        <div class="post-header w-[100%] h-[60px] flex items-center">
          <div
            class="avatar-wrapper w-[50px] min-w-[50px] min-h-[50px] h-[50px] rounded-full overflow-hidden mr-2"
          >
            <img
              @click="redirect(`comercio/${post.user_id}`)"
              loading="lazy"
              class="cursor-pointer w-[100%] h-[100%] object-cover"
              :src="post.avatar"
              alt="avatar_usuario"
            />
          </div>
          <div class="flex flex-col items-start w-[100%] h-[100%]">
            <b>{{ post.username }}</b>
            <small>{{ datetranslatesql(post.start_date) }}</small>
            <button
              click=""
              class="rating flex h-[fit-content] items-center justify-start"
              v-if="post.avg != null"
            >
              <img
                class="  "
                :src="StarSVG"
                v-for="index in Math.floor(post.avg)"
                alt="star"
                :title="post.avg"
                loading="lazy"
              />
              <img
                class=" "
                :src="StarEmptySVG"
                v-for="index in 5 - Math.floor(post.avg)"
                alt="star"
                :title="post.avg"
                loading="lazy"
              />
              <small>({{ post.avg.toFixed(2) }})</small>
            </button>
          </div>
          <button @click="() => abrirModal(post.id)" class="mr-4">
            <img :src="MoreSVG" alt="dots" />
          </button>
        </div>

        <!-- Contenedor de la imagen del post -->

        <div
          class="post-content w-[100%] h-[300px] sm:h-[300px] md:h-[400px] lg:h-[500px] xl:h-[600px] 2xl:h-[600px] rounded-2xl overflow-hidden mt-5"
        >
          <img
            @click="redirect(`post/${post.post_id}`)"
            class="cursor-pointer w-[100%] h-[100%] object-cover"
            :src="post.image"
            :alt="post.titulo"
          />
        </div>

        <!-- Contenedor de botones del post -->
        <div class="post-footer w-[100%] h-[50px] flex pt-5 pb-5">
          <!-- Comentarios -->

          <button
            @click="() => abrirComentarios()"
            class="flex flex-row items-center mr-3"
          >
            <img :src="ChatSVG" loading="lazy" />
            <template v-if="comentarios != null">
              {{ comentarios.comentarios.length }}</template
            >
          </button>

          <!-- Compartir -->
          <button
            @click="
              share({
                title: post.title,
                text: post.description,
                url: `post/${post.post_id}`,
              })
            "
            class="flex flex-row items-center mr-3"
          >
            <img :src="ShareSVG" loading="lazy" />
          </button>

          <!-- Quitar y aniadir de guardados -->
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-if="favoritos.indexOf(post.post_id) != -1"
            class="flex max-w-[22px] min-h-[26px] flex-row items-center ml-2"
          >
            <img class="object-scale-down" :src="BookmarkSVG" loading="lazy" />
          </button>
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-else
            class="flex max-w-[22px] min-h-[26px] flex-row items-center ml-2"
          >
            <img
              class="object-scale-down mt-0"
              :src="BookmarkEmptySVG"
              loading="lazy"
            />
          </button>
        </div>
        <!-- Contenido del Post -->
        <div class="information">
          <h1>
            <img :src="IconoTipo" alt="icono-evento" loading="lazy" />
            {{ post.title }}
          </h1>
          <span>
            {{ post.description }}
          </span>
          <div class="hashtags flex">
            <a
              class="hashtag mr-[10px] font-bold"
              :href="`busqueda/${hashtag}`"
              v-for="hashtag in post.hashtags"
            >
              #{{ hashtag }}</a
            >
          </div>
        </div>

        <!-- Modal de Ver Más -->
        <div
          ref="modal"
          :id="`modal_${post.id}`"
          :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
        >
          <!-- Botón ver perfil -->
          <button
            @click="redirect(`comercio/${post.user_id}`)"
            :class="`${estilos.modal_button} m-2 `"
          >
            <img class="w-[30px] h-[30px] mr-3" :src="UserSVG" loading="lazy" />
            Ver perfil
          </button>
          <!-- Botón ver reseñas comercio -->
          <button :class="`${estilos.modal_button} m-2 `">
            <img class="w-[30px] h-[30px] mr-3" :src="StarSVG" loading="lazy" />
            Reseñas
          </button>
        </div>
      </article>

      <!------------------------------------ Post DESTACADO ------------------------------>
      <article
        v-if="tipo_usuario == 'comercio' && post.avg >= 4"
        :class="` post ${estilos.post} relative`"
      >
        <!-- Contenedor del header del post -->
        <div class="post-header w-[100%] h-[60px] flex items-center">
          <div
            class="avatar-wrapper w-[50px] h-[50px] rounded-full overflow-hidden mr-2"
          >
            <img
              @click="redirect(`comercio/${post.user_id}`)"
              class="cursor-pointer w-[100%] h-[100%] object-cover"
              :src="post.avatar"
              alt="avatar_usuario"
            />
          </div>
          <div class="flex flex-col items-start texts w-[100%] h-[100%]">
            <b
              @click="redirect(`comercio/${post.id}`)"
              class="cursor-pointer"
              >{{ post.username }}</b
            >
            <small>{{ datetranslatesql(post.start_date) }}</small>
            <button
              click=""
              class="rating flex h-[fit-content] items-center justify-start"
              v-if="post.avg != null"
            >
              <img
                class="  "
                :src="StarSVG"
                v-for="index in Math.floor(post.avg)"
                alt="star"
                loading="lazy"
                :title="post.avg"
              />
              <img
                class=" "
                :src="StarEmptySVG"
                v-for="index in 5 - Math.floor(post.avg)"
                alt="star"
                loading="lazy"
                :title="post.avg"
              />
              <small>({{ post.avg.toFixed(2) }})</small>
            </button>
          </div>
          <button @click="() => abrirModal(post.id)" class="mr-4">
            <img :src="MoreSVG" alt="dots" />
          </button>
        </div>

        <!-- Contenedor de la imagen del post -->

        <div
          class="post-content w-[100%] h-[300px] sm:h-[300px] md:h-[400px] lg:h-[500px] xl:h-[600px] 2xl:h-[600px] rounded-2xl overflow-hidden mt-5 mb-5"
        >
          <img
            @click="redirect(`post/${post.id}`)"
            class="w-[100%] h-[100%] object-cover"
            :src="post.image"
            :alt="post.titulo"
          />
        </div>

        <!-- post footer -->
        <div class="post-footer w-[100%] h-[50px] flex pt-5 pb-5">
          <!-- Comentarios -->
          <button
            @click="() => abrirComentarios()"
            class="flex flex-row items-center mr-3"
          >
            <img :src="ChatSVG" loading="lazy" />
            <template v-if="comentarios != null">
              {{ comentarios.comentarios.length }}</template
            >
          </button>

          <!-- Quitar y aniadir de guardados -->
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-if="favoritos.indexOf(post.post_id) != -1"
            class="flex flex-row items-center mr-3"
          >
            <img :src="BookmarkSVG" loading="lazy" />
          </button>
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-else
            class="flex flex-row items-center mr-3"
          >
            <img :src="BookmarkEmptySVG" loading="lazy" />
          </button>

          <!-- Compartir -->
          <button
            @click="
              share({
                title: post.title,
                text: post.description,
                url: `post/${post.post_id}`,
              })
            "
            class="flex flex-row items-center mr-3"
          >
            <img :src="ShareSVG" loading="lazy" />
          </button>
        </div>
        <!-- Contenido del Post -->
        <div class="information">
          <h1>
            <img :src="IconoTipo" alt="icono-evento" loading="lazy" />
            {{ post.title }}
          </h1>
          <span>{{ post.description }}</span>
        </div>

        <!-- Modal de Destacados -->
        <div
          :class="` badge modal modal-izq destacado ${estilos.modal} ${estilos.modal_inferior_izq} `"
        >
          <button :class="`${estilos.modal_button} `">
            <img class="w-[20px] h-[20px] mr-3" :src="StarSVG" />
            Destacado por la comunidad
          </button>
        </div>

        <!-- Modal de Ver Más -->
        <div
          ref="modal"
          :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
        >
          <!-- Botón ver perfil -->
          <button
            @click="redirect(`comercio/${post.id}`)"
            :class="`${estilos.modal_button} m-2 `"
          >
            <img class="w-[30px] h-[30px] mr-3" :src="UserSVG" loading="lazy" />
            Ver perfil
          </button>
          <!-- Botón ver reseñas comercio -->
          <button :class="`${estilos.modal_button} m-2 `">
            <img class="w-[30px] h-[30px] mr-3" :src="StarSVG" loading="lazy" />
            Reseñas
          </button>
        </div>
      </article>

      <!------------------------------------ Post AYUNTAMIENTO ------------------------------>
      <article
        v-if="tipo_usuario == 'ayuntamiento'"
        :class="` post ${estilos.post} relative`"
      >
        <!-- post header -->
        <div
          class="post-header w-[100%] h-[fit-content] flex items-center pt-3 pb-4"
        >
          <div
            class="avatar-wrapper w-[50px] h-[50px] rounded-full overflow-hidden mr-2"
          >
            <img
              @click="redirect(`ayuntamiento/${post.user_id}`)"
              loading="lazy"
              class="cursor-pointer w-[100%] h-[100%] object-cover"
              :src="post.avatar"
              alt="avatar_usuario"
            />
          </div>
          <div
            @click="redirect(`ayuntamiento/${post.id}`)"
            class="cursor-pointer flex flex-col items-start texts w-[100%] h-[100%]"
          >
            <b>{{ post.usuario.nombre }}</b>
            <small> Organización </small>
          </div>
          <button @click="() => abrirModal(post.id)" class="mr-4">
            <img :src="MoreSVG" alt="dots" loading="lazy" />
          </button>
        </div>

        <!-- post image -->

        <div
          class="post-content w-[100%] h-[300px] sm:h-[300px] md:h-[400px] lg:h-[500px] xl:h-[600px] 2xl:h-[600px] rounded-2xl overflow-hidden"
        >
          <img
            @click="redirect(`post/${post.id}`)"
            loading="lazy"
            class="cursor-pointer w-[100%] h-[100%] object-cover"
            :src="post.image"
            :alt="post.titulo"
          />
        </div>

        <!-- post footer -->
        <div class="post-footer w-[100%] h-[50px] flex pt-5 pb-5">
          <!-- Los destacados de ayuntamiento no tienen botones de feedback salvo el de guardar -->

          <!-- Quitar y aniadir de guardados -->
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-if="en_favoritos(post.post_id)"
            class="flex flex-row items-center mr-3"
          >
            <img :src="BookmarkSVG" loading="lazy" />
          </button>
          <button
            @click="() => aniadir_favorito(post.post_id)"
            v-else
            class="flex flex-row items-center mr-3"
          >
            <img :src="BookmarkEmptySVG" loading="lazy" />
          </button>

          <!-- Comentarios -->
          <button
            @click="() => abrirComentarios()"
            class="flex flex-row items-center mr-3"
          >
            <img :src="ChatSVG" loading="lazy" />
            {{ comentarios.value.length }}
          </button>

          <!-- Compartir -->
          <button
            @click="
              share({
                title: post.title,
                text: post.description,
                url: `post/${post.post_id}`,
              })
            "
            class="flex flex-row items-center mr-3"
          >
            <img :src="ShareSVG" loading="lazy" />
          </button>
        </div>

        <!-- Contenido del Post -->
        <div class="information">
          <h1>
            <img :src="IconoTipo" alt="icono-evento" loading="lazy" />
            {{ post.title }}
          </h1>
          <span>{{ post.description }}</span>
        </div>

        <!-- Modal de Evento Institucional -->
        <div
          :class="` badge modal modal-izq ${estilos.modal}  ${estilos.modal_inferior_izq}`"
        >
          <button :class="`${estilos.modal_button} `">
            <img class="w-[20px] h-[20px] mr-3" :src="StarSVG" loading="lazy" />
            Evento Institucional
          </button>
        </div>

        <!-- Modal de Ver Más -->
        <div
          ref="modal"
          :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
        >
          <!-- Botón ver perfil -->
          <button
            @click="redirect(`ayuntamiento/${post.id}`)"
            :class="`${estilos.modal_button} m-2 `"
          >
            <img class="w-[30px] h-[30px] mr-3" :src="UserSVG" loading="lazy" />
            Ver perfil
          </button>
          <!-- Botón ver reseñas comercio -->
          <button :class="`${estilos.modal_button} m-2 `">
            <img class="w-[30px] h-[30px] mr-3" :src="StarSVG" loading="lazy" />
            Reseñas
          </button>
        </div>
      </article>

      <!-- El modal de comentarios -->
      <Comentarios
        v-if="comentariosVisibles"
        :post="post"
        :handler="abrirComentarios"
      />
    </div>
  </Suspense>
</template>

<style scoped lang="scss">
@import "./../styles/sass/variables.scss";

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

  .avatar-wrapper {
    height: 50px;
    width: 60px;
    border-radius: 50% !important;
    box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;

    img {
      transform: scale(1.5);
    }
  }

  .post-content {
    box-shadow:
      rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
      rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;

    img {
      box-shadow:
        rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
        rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
  }

  .information {
    /*estilos simples */
    display: flex;
    flex-direction: column;
    height: fit-content;

    img {
      box-shadow:
        rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
        rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }

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

  .hashtag {
    font-size: 0.9rem;
  }
}

.rating {
  img {
    width: 20px;
    filter: drop-shadow(8px 2px 10px rgba(0, 0, 0, 0.5));
  }
}
</style>
