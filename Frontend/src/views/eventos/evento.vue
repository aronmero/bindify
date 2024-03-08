<script setup>
import Grid from "@/components/comun/layout.vue";
import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import Evento from "@/components/utils/evento.vue";



</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <Evento :titulo="BLANK" :ubicacion="BLANK" :fechaInicio="BLANK" :fechaFin="BLANK" :dias="BLANK"
            :descripcion="BLANK" />
        <template v-slot:Right> </template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
