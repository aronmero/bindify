<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import Evento from "@/components/utils/evento.vue";

import absoluteURL from "@/scripts/getFullUrl.js";
import router from "@/router/index.js";
import { ref, onMounted } from "vue";
import { postId } from "@/Api/publicacion/publicacion.js";

const datos = ref([])

const id=router.currentRoute.value.params.id
onMounted(async () => {
    datos.value = await postId("get",id);
    console.log(datos.value)
})


</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <section v-if="datos.data !== undefined">
            <Evento :url="absoluteURL()" :banner="datos.data.post.image" :titulo="datos.data.post.title" :ubicacion="BLANK" :fechaInicio="datos.data.post.start_date"
                :fechaFin="datos.data.post.end_date" :dias="BLANK" :descripcion="datos.data.post.description" :tipo="datos.data.post.post_type_name" :user="datos.data.users" :fecha_publicacion="datos.data.post.fecha_creacion"/>
        </section>
        <template v-slot:Right> </template>

    </Grid>
    <Footer />
</template>

<style scoped></style>
