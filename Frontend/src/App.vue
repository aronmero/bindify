<script setup>
import { RouterView } from "vue-router";
</script>

<template>
  <RouterView :key="$route.fullPath"></RouterView>
</template>

<style scoped></style>
