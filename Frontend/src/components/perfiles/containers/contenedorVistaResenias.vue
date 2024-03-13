<script setup>
import contenedorResenia from "@/components/perfiles/containers/contenedorResenia.vue";
import FeedPost from "@/components/perfiles/containers/TipoPost.vue";
import { posts } from "@/components/perfiles/helpers/posts.js";
import { getUserReviews } from "@/Api/perfiles/perfil.js";
import router from "@/router/index.js";
import { ref } from "vue";
let userReviews = ref(null);
let linkUsername = ref(router.currentRoute.value.params.username);
console.log(linkUsername.value);
async function responseCatcher() {
  userReviews.value = await getUserReviews(
    "get",
    `/api/review/${linkUsername.value}`
  );
  console.log(userReviews.value);
}
responseCatcher();
</script>
<template>
  <contenedorResenia
    v-for="review in userReviews"
    :rutaPerfil="review.avatarUsuario"
    :nombre="review.username"
    :texto="review.comment"
    :puntuacion="review.note"
  ></contenedorResenia>
</template>
<style scoped></style>

<!-- <script setup>
  import contenedorResenia from '@/components/perfiles/containers/contenedorResenia.vue';
  import {users} from "@/components/perfiles/helpers/users.js"
</script>
<template>
  <contenedorResenia v-for="user in users" :rutaPerfil="user.avatar" :nombre="user.name" titulo="Muy bien"  texto="asjdasljd ljasdjasldj lakjsdlasjddasd da dasd adadasd  adsdadasd d dsda askdjals kdjaskj daksjdasdjad j  dajdja lkjdasjdas jdlaslkdjaldjlakdjajdkas" fecha="12/12/2002" imagen="https://png.pngtree.com/background/20230610/original/pngtree-landscapes-wallpaper-images-picture-image_3021437.jpg" imagenAltText="tal"></contenedorResenia>
</template>
<style scoped></style> -->
