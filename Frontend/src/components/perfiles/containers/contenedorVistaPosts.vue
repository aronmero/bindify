<script setup>
import FeedPost from "@/components/perfiles/containers/TipoPost.vue";
import { posts } from "@/components/perfiles/helpers/posts.js";
import { getUserPosts } from "@/Api/perfiles/perfil.js";
import router from "@/router/index.js";
import { ref } from "vue";
let userPosts = ref(null);
let linkUsername = ref(router.currentRoute.value.params.username);
console.log(linkUsername.value);
async function responseCatcher() {
  userPosts.value = await getUserPosts(
    "get",
    `/api/user/${linkUsername.value}/posts`
  );
  console.log(userPosts.value);
}
responseCatcher();
</script>
<template>
  <FeedPost v-if="userPosts!=null" v-for="post in userPosts" :post="post"></FeedPost>
</template>
<style scoped></style>
