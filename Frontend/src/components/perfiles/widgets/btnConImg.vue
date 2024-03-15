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
      class="w-8 h-8 p-1 rounded-md filter hover:invert transition ease-linear"
    />
  </button>
  <button v-if="!borde" class="w-8 h-8">
    <img :src="ruta" :alt="altText" class="min-w-8 min-h-8 p-1 cursor-default" />
  </button>
</template>
<style scoped></style>
