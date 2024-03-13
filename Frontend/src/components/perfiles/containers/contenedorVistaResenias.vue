<script setup>
import contenedorResenia from "@/components/perfiles/containers/contenedorResenia.vue";
import FeedPost from "@/components/perfiles/containers/TipoPost.vue";
import { posts } from "@/components/perfiles/helpers/posts.js";
import { getUserReviews } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import router from "@/router/index.js";
import { ref } from "vue";
let userReviews = ref(null);
const show = ref(false);
let linkUsername = ref(router.currentRoute.value.params.username);
console.log(linkUsername.value);
async function responseCatcher() {
  userReviews.value = await getUserReviews(
    "get",
    `/api/review/${linkUsername.value}`
  );
  show.value = true;
  console.log(userReviews.value);
  userReviews.value = setDefaultImgs(userReviews.value);
}
responseCatcher();
</script>
<template>
  <template v-if="show">
    <contenedorResenia v-if="userReviews != null && userReviews.length > 0" v-for="review in userReviews"
      :rutaPerfil="review.avatarUsuario" :nombre="review.username" :texto="review.comment"></contenedorResenia>
    <div v-else class="flex justify-center">No hay reseñas</div>
  </template>
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
