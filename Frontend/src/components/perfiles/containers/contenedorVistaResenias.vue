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

async function responseCatcher() {
  userReviews.value = await getUserReviews(
    "get",
    `/api/review/${linkUsername.value}`
  );
  show.value = true;

  userReviews.value = setDefaultImgs(userReviews.value);
}
responseCatcher();
</script>
<template>
  <template v-if="show">
    <contenedorResenia
      v-if="userReviews != null && userReviews.length > 0"
      v-for="review in userReviews"
      :rutaPerfil="review.avatarUsuario"
      :nombre="review.username"
      :texto="review.comment"
      :puntuacion="review.note"
      :id="review.id"
    ></contenedorResenia>
    <div v-else class="flex justify-center">No hay reseñas</div>
  </template>
</template>
<style scoped></style>
