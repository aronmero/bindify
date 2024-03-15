<script setup>
defineProps({
  ruta: String,
  altText: String,
  borde: Boolean,
});
</script>
<template>
  <button
    v-if="borde"
    class="hover:bg-accent-400 rounded-md border border-background-200 transition ease-linear"
  >
    <img
      :src="ruta"
      :alt="altText"
      class="w-6 h-6 p-1 rounded-md filter hover:invert transition ease-linear"
    />
  </button>
  <button v-if="!borde" class="">
    <img :src="ruta" :alt="altText" class="min-w-6 min-h-6 p-1" />
  </button>
</template>
<style scoped></style>
