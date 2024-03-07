<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";


</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>

        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
