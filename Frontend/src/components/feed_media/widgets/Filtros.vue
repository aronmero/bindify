<script setup>

    import { date_is_active } from '../helpers/datetranslate';
    import {obtener_favoritos, purgarFavoritos} from '../helpers/favoritos';
    import {onMounted} from 'vue';
    let props = defineProps({
        filtros: Array, 
    });

    //purgarFavoritos();

    let favoritos = obtener_favoritos();

    let currentTags = props.filtrado;


    let action = (filtro) => {
        let posts = Array.from(document.getElementsByClassName("post"))
        console.log(posts);
        if(filtro == 'Cercanos') {
            console.log("cercanos");
        }

        if(filtro == "Activos") {
            const today = new Date().toLocaleDateString();
            console.log(today);
            posts.forEach(post => {
                if(date_is_active(post.dataset.start_date, post.dataset.end_date)) {
                    post.style.display = "flex";
                } else {
                    post.style.display = "none";
                }
            });
        }

        if(filtro == "Para tí") {
            posts.forEach(post => {
                post.style.display = "flex";
            });
        }

        if(filtro == "Guardados") {
            posts.forEach(post => {
                if(post.dataset.favorito == "true") {
                    post.style.display = "flex";
                } else {
                    post.style.display = "none";
                }
                
            });
        }
            
    };

</script> 
<template>
    <button class="p-[6px_20px_6px_0px]" v-for="filtro in filtros" @click="() => action(filtro)" :value="filtro">
        <h6 class="title">{{filtro}}</h6>
    </button>
</template>
<style scoped lang="scss">
    .title {
        padding-left:10px;
        font-weight:bold;
        font-size:1rem;
    }
    .filters {
        border-radius:10px;
        display:flex;
        flex-wrap:wrap;
        margin:0px 5px 5px 0px;
    }
    .filters:last-of-type {
        margin-bottom:20px;

    }
    .filter {
        padding:10px 15px;
        width:fit-content;
        border:none;
        text-transform:uppercase;
        font-size:.9rem;
        margin:5px;
        color:#8496A8;
        font-weight:normal;
        border-radius:5px;
        background:#fff;
        width:clamp(20%, fit-content, 50%);
        font-weight:bold;
        transition:all .4s ease-in-out;
        border-bottom:3px solid transparent;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    }

    .selected {
        background:#80ED99;
        color:white;
    }
</style>