<script setup>
  import FeedPost from "@/components/perfiles/containers/TipoPost.vue"
  import { posts } from '@/components/perfiles/helpers/posts.js';
  import { getUserData } from "@/api/perfiles/perfil.js";
  
  async function responseCatcher() {
  userData.value = await getUserData("get", "http://127.0.0.1:8000/api/user/");
  console.log(userData.value);
}
responseCatcher();
</script>
<template>
  <FeedPost v-for="post in posts" :post="post"></FeedPost>
</template>
<style scoped></style>
