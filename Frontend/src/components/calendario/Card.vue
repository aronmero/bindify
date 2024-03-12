<script setup>
import {ref} from 'vue';
import { obtener_municipio } from './mocks/municipios';
import LocationSVG from '@public/assets/icons/location.svg';
import EnlaceSVG from '@public/assets/icons/external.svg';
import DiaSVG from '@public/assets/icons/time.svg';
import MenuSVG from '@public/assets/icons/ellipsis.svg';
import StarSVG from '@public/assets/icons/star.svg';
import ShareSVG from '@public/assets/icons/share.svg';
import UserSVG from '@public/assets/icons/user.svg';
import router from '@/router/index';
import {share} from '@/components/calendario/helpers/share'


const props = defineProps({
    post: Object,
    municipios: Object
});

const modalHandler = ref(false);
const modal = ref(null);

const post = props.post;
//const municipio = obtener_municipio(post.usuario.municipality_id).name;


/** 
 * Redirecciona hasta la url objetivo
 */
const redirect = (url) => {
    router.push(url)
};

/** 
 * Abrir modal  
 * */

const abrirModal = () => {
    if (modalHandler.value) {
        modal.value.style.display = "none";
        modalHandler.value = false;
    } else {
        modal.value.style.display = "flex";
        modalHandler.value = true;
    }
}
</script>
<template>
    <div class=" card w-[100%] p-4 rounded-xl relative " :data-start_date="post.start_date" :data-end_date="post.end_date">
        <!-- Imagen del post -->
        <div class=" img-wrapper w-[110px] h-[150px] overflow-hidden rounded-xl mr-2">
            <img class=" img min-w-[100%] cursor-pointer  " :src="post.image" alt="" @click="() => redirect(`evento/${post.post_id}`)">
        </div>
        <!-- Contenido del Post -->
        <div class=" wrapper ">
            <!-- Título -->
            <h2 class=" primary ">{{ post.title }}</h2>
            <!-- Descripcion -->
            <p class=" description  sm:block md:block hidden xl:block" :title="post.description">{{ post.description }}</p>
            <!-- Campo Municipio -->
            <p class=" campo mt-3 h-[20px] flex items-center  ">
                <img :src="LocationSVG" class=" w-[20px] mr-1 " alt="Ubicacion:">
                {{ post.municipality }}
            </p>
            <p class=" campo mt-3 h-[20px] flex items-center  " >
                <img :src="DiaSVG" class=" w-[20px] mr-1 " alt="Fecha de inicio:"> <b>Inicio: {{ post.start_date }}  </b>
                <img :src="DiaSVG" class=" ml-2 w-[20px] mr-1 " alt="Fecha de fin:"> <b>Fin: {{ post.end_date }}</b>
            </p>
        </div>
        <div class="">
            <button class="p-2 absolute top-[0px] right-[20px] " @click="() => abrirModal(post.post_id)">
                <img :src="MenuSVG" alt="">
            </button>
        </div>

          <!-- Modal de Ver Más -->
          <div ref="modal" :id="`modal_${post.post_id}`" :class="`modal absolute  top-[50px] right-[20px]  bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center`">
            <!-- Botón ver perfil -->
            <button @click="redirect(`perfil/${post.username}`)" :class="`flex items-center font-medium w-[100%] m-2 `">
                <img class="w-[30px] h-[30px] mr-3 " :src="UserSVG" />
                Ver perfil
            </button> 
            <!-- Botón ver reseñas comercio -->
            <button @click="share(post.title, post.description, `post/${post.post_id}`)" :class="`flex items-center font-medium w-[100%] m-2 `">
                <img class="w-[30px] h-[30px]  mr-3 " :src="ShareSVG" />
                Compartir
            </button>
        </div>
    </div>
</template>

<style scoped lang="scss">
    @import './styles/sass/variables';

    .card {
        margin: 10px 0px;
        display: flex;
        width: clamp(20px, 620px, 900px);

        //background:red;
        .img-wrapper {
            img {
                width: 400px;
                height: 400px;
                object-position: center;
                object-fit: cover;
                background: #f3f3f3;
            }
        }

        h2 {
            font-size: 1.3rem;
            max-width:500px;
            overflow:hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: $primario;
            font-weight: bold;
        }

        .wrapper {
            margin-left: 10px;

            .description {
                height: calc(100px - 60px) !important;
                //background:red;
                overflow: hidden;
                max-width: 400px;
                font-size:.9rem;
                text-overflow: ellipsis;
                white-space:unset;

            }

            .campo {
                font-size:.85rem;
                font-weight:500;
            }

        }
    };

    .modal {
        width: fit-content;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        display: none;
    }

    @media screen and (max-width: 650px) {
        .card {
            width: clamp(300px, 450px, 550px);
            margin: 10px 0px;

            .img-wrapper {
                max-width: 120px;
            }
        }
    }

    @media screen and (max-width: 450px) {
        .card {
            h2 {
                font-size: 1.1rem;
            }

            width:clamp(300px, 350px, 430px);
            margin:10px 0px;

            .img-wrapper {
                max-width: 100px;
            }

            .wrapper {
                .campo {
                    font-size: .9rem;

                    img {
                        width: 18px;
                    }
                }
            }
        }
    }

    @media screen and (max-width: 345px) {
        .card {
            h2 {
                font-size: 1.1rem;
            }

            width:clamp(250px, 340px, 300px);
            margin:10px 0px;

            .img-wrapper {
                max-width: 100px;
                max-height:70px;
                img{
                    object-fit:cover;
                }
                
            }

            .wrapper {
                .campo {
                    font-size: .9rem;

                    img {
                        width: 18px;
                    }
                }
            }
        }
    }

    @media screen and (max-width: 320px) {
        .img-wrapper {
            max-width: 50px;
            max-height:70px;
            img{
                object-fit:cover;
            }
            
        }
        
    }
</style>