<script setup>
    let props = defineProps({
        filtrado: Array, 
        text: String
    });

    let currentTags = props.filtrado;
    const filterPost = (e, tag) => {
        let posts = document.getElementsByClassName("evento");
        Array.from(posts).forEach(post => {
            if(post.dataset.category.includes(tag) || tag == "Todos") {
                post.style.display = "flex";
            } else {
                post.style.display = "none";
            };

        })

        let filters = document.getElementsByClassName("filter");
        Array.from(filters).forEach(boton => {
            if(boton == e.target) {
                boton.classList.add("selected")
            } else {
                boton.classList.remove("selected")
            }
        })
    };
</script> 
<template>
    <h6 class="title">{{props.text}}</h6>
    <div class="filters">
        <button :class="(tag == 'Home')?'selected filter':'filter'" @click="(e) => filterPost(e, tag)" v-for="tag in currentTags"> {{ tag }} </button>
    </div>
</template>
<style scoped lang="scss">
    .title {
        padding-left:10px;
        font-weight:bold;
        margin:20px 0px;
        font-size:.9rem;
    }
    .filters {
        border-radius:10px;
        display:flex;
        flex-wrap:wrap;
        margin:0px 5px 5px 5px;
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