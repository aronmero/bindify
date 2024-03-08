<script setup>
    import {ref} from 'vue';
    import MoreSVG from '@public/assets/icons/ellipsis.svg';
    import {encontrar_usuario_por_id} from './../mocks/users';

    const props = defineProps({
        comentario: Object,
    });

    const ref_comentario_comentario = ref("")
    const comentario = props.comentario;


    const user = encontrar_usuario_por_id(comentario.user_id);
    console.log(user);
</script>
<template>
    <!-- Contenedor Comentario -->
    <div class=" comentario flex flex-col w-[100%] p-[10px_0px]">
        <!-- Header del comentario -->
        <div class=" header-comentario flex flex ">
            <!-- Avatar del usuario -->
            <img :src="user.avatar" alt="">
            <!-- Textos del usuario -->
            <div class="textos">
                <b> {{ user.name }}</b>
            </div>
            <!-- Botón de Ver Más -->
            <button>
                <img class=" w-[50px] h-[50px] " :src="MoreSVG" alt="">
            </button>
        </div>
        <span class="">
            {{ comentario.content }}
        </span>
    </div>
</template>
<style scoped lang="scss">

.header-comentario {
    img {
        width:50px;
        height:50px;
        border-radius:50px;
    }
}

</style>