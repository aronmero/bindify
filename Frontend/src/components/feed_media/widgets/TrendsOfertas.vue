<script setup>
    import HashtagSVG from '@public/assets/icons/hashtag.svg';
    import { etiquetas } from '../mocks/etiquetas.js';
</script>

<template>
    <div class="trend ">
        <!-- Muestra las etiquetas -->
        <h1>Etiquetas en tendencia</h1>
        <h2>Lo más popular, más visto en nuestras ofertas, eventos y promociones</h2>
        <div class=" etiquetas grid-two grid 2xl:grid-cols-2 xl:grid-cols-1 lg:grid-cols-1 gap-1 ">
            <div class="etiqueta" v-for="etiqueta in etiquetas">
                <img :src="HashtagSVG" alt="icono-hashtag"/>
                    <a href=""><b>#{{ etiqueta.name }}</b></a>
                <small>{{ etiqueta.posts }} votos</small>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

    .trend {
        width:100%;
        height:fit-content;
        padding:20px 0px;


        h1 {
            font-size:1.2rem;
            font-weight:bold;
            /*letter-spacing:1rem;*/
        }
        h2 {
            font-size: .9rem;
            margin-top: 5px;
        }

        .etiquetas {
            margin:10px 0px;
            .etiqueta {
                //background:gray;
                display:flex;
                align-items: center;
                justify-content: flex-start;
                width:100%;
                padding:20px 0px;
                margin:0px 5px;
                margin-bottom:rgb(206,206,206);

                b {
                    margin:0px 10px;
                    font-size:1.1rem;
                }

                small {
                    font-size:.9rem;
                }

            }
        }
        
    }
</style>