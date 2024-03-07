<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";

import Input from "../components/comun/input.vue";

const options = ["Ferretería", "Floristería", "Panadería", "Mecánico"];
</script>

<template>
    <Header />
    <Grid>
        <template v-slot:Left></template>
        <form @submit.prevent="" action="" class="flex flex-col gap-y-5">
            <Input tipo="text" requerido="true" label="Nombre" img="/assets/icons/user.svg"/>
            <Input tipo="texto" label="Descripcion" valor="Cuentanos tu experiencia"/>
            <Input tipo="email" requerido="true" label="Email" img="/assets/icons/schedule.svg"/>
            <Input tipo="password" requerido="true" label="Password" img="/assets/icons/settings.svg"/>
            <Input tipo="selection" requerido="true" label="Categoría" :opciones="options" valor="Selecciona una categoría"/>
            <div class="imagenes flex justify-evenly">
                <Input tipo="file" clase="perfil" label="Perfil"/>
                <Input tipo="file" clase="banner" label="Banner"/>
            </div>
            <div class="fecha-hora">
                <Input tipo="fecha" label="Fecha" img="/assets/icons/Google-Calendar.svg"/>
                <Input tipo="hora" label="Horario"/>
            </div>
            <Input tipo="submit" clase="claro" valor="Iniciar sesión"/>
        </form>
        <template v-slot:Right></template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
