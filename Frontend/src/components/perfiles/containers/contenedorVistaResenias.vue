<script setup>
  import contenedorResenia from '@/components/perfiles/containers/contenedorResenia.vue';
  import {users} from "@/components/perfiles/helpers/users.js"
</script>
<template>
  <contenedorResenia v-for="user in users" :rutaPerfil="user.avatar" :nombre="user.name" titulo="Muy bien"  texto="asjdasljd ljasdjasldj lakjsdlasjddasd da dasd adadasd  adsdadasd d dsda askdjals kdjaskj daksjdasdjad j  dajdja lkjdasjdas jdlaslkdjaldjlakdjajdkas" fecha="12/12/2002" imagen="https://png.pngtree.com/background/20230610/original/pngtree-landscapes-wallpaper-images-picture-image_3021437.jpg" imagenAltText="tal"></contenedorResenia>
</template>
<style scoped></style>
