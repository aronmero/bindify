<script setup>
    import Filtros from '@/components/calendario/widgets/Filtros.vue';
    import Calendario from '@/components/calendario/widgets/Calendar.vue';
    import { posts } from '@/components/calendario/mocks/posts';
    import { filtros } from './calendario/mocks/filtros';
</script>
<template>
    <div>
        <Filtros v-for="filtro in filtros" :text="filtro"></Filtros>
    </div>
    <Calendario></Calendario>
    <div class="grid grid-cols-1">
        
    </div>
</template>
<style scoped lang="scss">
    .card {
        margin:10px 0px;
        display:flex;

        .img {
            min-width:150px;
            height:150px;
            border-radius:10px;
            overflow:hidden;

            img {
                width:100%;
                height:100%;
                object-fit: cover;
            }
        }

        
        h2 {
            font-size:1.8rem ;
        }
        .wrapper {
            margin-left:10px;
            .description {
                
                height:50px;
                overflow:hidden;
                background:red;
            }
            
        }
    };
</style>