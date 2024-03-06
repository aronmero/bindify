<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import navInfo from "@/components/utils/navInfo.vue";
import Notificacion from "@/components/utils/validarNotificacion.vue";
</script>

<template>
    <Header />
    <Grid><template v-slot:Left></template>
        <navInfo></navInfo>
        <Notificacion></Notificacion>

        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
