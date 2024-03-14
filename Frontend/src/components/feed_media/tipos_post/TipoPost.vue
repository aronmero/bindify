<script setup>
import { ref } from 'vue';


import { obtener_favoritos } from '../helpers/favoritos';

import Comentarios from '../modal/ComentariosHome.vue';
import PostComercio from './PostComercio.vue';
import PostComercioDestacado from './PostComercioDestacado.vue';
import PostAyuntamiento from './PostAyuntamiento.vue';


const props = defineProps({
    post: Object,
    tipo: String, 
    seguidos: Object
});


const post = ref(props.post);
const post_reference = ref({ dataset: { favorito: false } });
const modalHandler = ref(false);
const modal = ref(null);

const esSeguido = ref(false);
console.log(props.seguidos);
console.log(post);
props.seguidos.forEach(seguido => {
    if(seguido.username == post.value.username) esSeguido.value = true;
});

console.log(esSeguido.value);

const modal_comentarios = ref(null);
/** Genero la referencia para abrir o cerrar el modal de comentarios */
const comentariosVisibles = ref(false);

/** Genero la referencia para obtener los favoritos del usuario, hecho en frontend por no poderse poner en back */
const favoritos = ref(obtener_favoritos());

/** Abre el modal del perfil */
const abrirModal = () => {
    if (modalHandler.value) {
        modal.value.style.display = "none";
        modalHandler.value = false;
    } else {
        modal.value.style.display = "flex";
        modalHandler.value = true;
    }
}




/** Dependiendo del tipo de post, carga un icono  */
const tipo = post.value.name;

/**Obtenemos el tipo de usuario para decidir que tipo de post se muestra */
let tipo_usuario = ref(post.userRol);

/** referencia los comentarios */
let comentarios = ref(null);

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
 * Observer para ir cargando on scroll, desactivado para evitar colapso de la base de datos 
 * */
/*
const { stop } = useIntersectionObserver(post_reference,
    async ([{ isIntersecting }], observerElement) => {
        if (isIntersecting) {
            let post_id = post.value.post_id;

            comentarios.value = await obtener_comentarios_post(post_id);
            console.log(comentarios.value)

            console.log("showing element ", post.value.post_id)
            console.log(post.value);
            stop();
        }
    },
)
*/

</script>

<template>
    <div>
        <!-- Post Comercio -->
        <PostComercio 
            ref="post_reference" 
            v-if="post.userRol == 'commerce' && post.avg < 3.5"
            :post="post" 
            :tipo="tipo"
            :esSeguido="esSeguido"
            :abrirComentarios="abrirComentarios"
        >
        </PostComercio>
        <!-- Post Destacado -->
        <PostComercioDestacado 
            ref="post_reference" 
            v-if="post.userRol == 'commerce' && post.avg >= 3.5" 
            :post="post" 
            :tipo="tipo"
            :esSeguido="esSeguido"
            :abrirComentarios="abrirComentarios"
        ></PostComercioDestacado>
        <!-- Post Ayuntamiento -->
        <PostAyuntamiento 
            ref="post_reference" 
            v-if="post.userRol == 'ayuntamiento'" 
            :post="post" 
            :tipo="tipo"
            :esSeguido="esSeguido"
            :abrirComentarios="abrirComentarios"
        >
        </PostAyuntamiento>
        <!-- El modal de comentarios -->
        <Comentarios v-if="comentariosVisibles" :post="post" :handler="abrirComentarios" /> 
    </div>
</template>

<style scoped lang="scss">


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


.rating {
    img {
        width: 20px;
        filter: drop-shadow(8px 2px 10px rgba(0, 0, 0, 0.5));
    }
}
</style>