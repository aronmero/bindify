<script setup>
    import StarSVG from '@public/assets/icons/star.svg';
    import { comercios } from '../mocks/comercios.js';
</script>

<template>
    <div class="trend ">
        <h1>Nuestros comercios más valorados</h1>
        <h2>Los más apoyados por la comunidad</h2>
        <div class=" listado grid grid-cols-1  gap-1 ">
            <div class=" listado " v-for="comercio in comercios">
                    <img class="avatar-tiny" :src="comercio.usuario.avatar" alt="">
                    <a href=""><b>{{ comercio.usuario.name.toLowerCase() }}</b></a>
                    <b class="rating"> 
                        <img :src="StarSVG" alt="icono-hashtag"/>
                        {{ comercio.rating }}
                    </b>
                <small>{{ comercio.votes }} votos</small>
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

        .avatar-tiny {
            width:40px;
            border-radius:50px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        }

        .listado {
            margin:10px 0px;
            .listado {
                //background:gray;
                display:flex;
                align-items: center;
                justify-content: flex-start;
                width:100%;
                padding:20px 0px;
                margin:0px 10px;
                margin-bottom:rgb(206,206,206);
                .rating {
                    display:flex;
                }

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