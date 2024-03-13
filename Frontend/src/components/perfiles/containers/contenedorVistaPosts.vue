<script setup>
import FeedPost from "@/components/perfiles/containers/TipoPost.vue";
import { posts } from "@/components/perfiles/helpers/posts.js";
import { getUserPosts } from "@/Api/perfiles/perfil.js";
import router from "@/router/index.js";
import { ref } from "vue";
let userPosts = ref(null);
const show = ref(false);
let linkUsername = ref(router.currentRoute.value.params.username);
console.log(linkUsername.value);
async function responseCatcher() {
  userPosts.value = await getUserPosts(
    "get",
    `/api/user/${linkUsername.value}/posts`
  );
  show.value = true;
  console.log(userPosts.value.length);
}
responseCatcher();
</script>
<template>
  <template v-if="show">
    <FeedPost v-if="userPosts != null && userPosts.length > 0" v-for="post in userPosts" :post="post"></FeedPost>
    <div v-else class="flex justify-center">No hay publicaciones</div>
  </template>
</template>
<style scoped></style>
