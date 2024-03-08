<script setup>
    import Filtros from '@/components/calendario/widgets/Filtros.vue';
    import Calendario from '@/components/calendario/widgets/Calendar.vue';
    import Card from './calendario/Card.vue';
    import { posts } from '@/components/calendario/mocks/posts';
    import { filtros } from './calendario/mocks/filtros';
    import {exportar_dia} from './calendario/helpers/exportardia'
    
    const hoy = new Date();
    let dia = exportar_dia(hoy);

</script>
<template>
    <div class="flexible flex flex-col ">
        <div class="flex justify-center items-center  w-[100%] rounded-xl">
            <Filtros v-for="filtro in filtros" :text="filtro"></Filtros>
        </div>
        <Calendario></Calendario>
        <p id="fecha" class="fecha">{{dia}}</p>
        <div class="grid grid-cols-1">
            <Card v-for="post in posts" :post="post"/>
        </div>
    </div>
   
</template>
<style scoped lang="scss">
    /* borrar cuando se pueda corregir el grid */
   .flexible {
    align-items: center;
   }
</style>