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



/** Dependiendo del tipo de post, carga un icono  */
const tipo = post.value.name;


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
        >
        </PostComercio>
        <!-- Post Destacado -->
        <PostComercioDestacado 
            ref="post_reference" 
            v-if="post.userRol == 'commerce' && post.avg >= 3.5" 
            :post="post" 
            :tipo="tipo"
            :esSeguido="esSeguido"
        ></PostComercioDestacado>
        <!-- Post Ayuntamiento -->
        <PostAyuntamiento 
            ref="post_reference" 
            v-if="post.userRol == 'ayuntamiento'" 
            :post="post" 
            :tipo="tipo"
            :esSeguido="esSeguido"
        >
        </PostAyuntamiento>
        <!-- El modal de comentarios -->
        <!-- <Comentarios v-if="comentariosVisibles" :post="post" />  -->
    </div>
</template>

<style scoped lang="scss">

</style>