<script setup>
  import FeedPost from "@/components/perfiles/containers/TipoPost.vue"
  import { posts } from '@/components/perfiles/helpers/posts.js';
</script>
<template>
  <FeedPost v-for="post in posts" :post="post"></FeedPost>
</template>
<style scoped></style>
