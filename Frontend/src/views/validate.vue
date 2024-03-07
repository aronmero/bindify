<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import navInfo from "@/components/utils/navInfo.vue";
import Notificacion from "@/components/utils/validarNotificacion.vue";
import { ref, onMounted } from "vue";

const notificaciones = ref([]);
onMounted(async () => {
    notificaciones.value = await funcionApi();
})

//Falta añadir el fetch a la api y eliminar del array el elemento
const tryValidateComercio = async (parametro) => {
    try {
        //const response = await fetch("api/v1/usuarios");
        //const data = await response.json();
        console.log(parametro)
    } catch (error) {

    }
};


/**
 * Funcion placeholder hasta tener una api
 */
function funcionApi(){
    const array = [];
    for (let index = 0; index < 40; index++) {
         array.push(index);
    }
    return array
};
</script>

<template>
    <Header />
    <Grid><template v-slot:Left></template>
        <navInfo></navInfo>
        <div>
            <Notificacion v-for="notificacion in notificaciones" @submit="tryValidateComercio" />
        </div>


        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
