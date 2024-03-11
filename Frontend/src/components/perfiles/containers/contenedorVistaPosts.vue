<script setup>
  import FeedPost from "@/components/perfiles/containers/TipoPost.vue"
  import { posts } from '@/components/perfiles/helpers/posts.js';
  import { getUserPosts } from "@/Api/perfiles/perfil.js";
  import { ref } from "vue";
  let userPosts= ref(null);
  async function responseCatcher() {
  userPosts.value = await getUserPosts("get");
  console.log(userPosts.value);
}
responseCatcher();
</script>
<template>
  <FeedPost v-for="post in userPosts" :post="post"></FeedPost>
</template>
<style scoped></style>
