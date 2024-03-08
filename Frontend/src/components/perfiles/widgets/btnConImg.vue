<script setup>
defineProps({
  ruta: String,
  altText: String,
  borde: Boolean,
});
</script>
<template>
  <button v-if="borde" class="">
    <img
      :src="ruta"
      :alt="altText"
      class="min-w-8 min-h-8 border border-background-200 p-1 rounded-md"
    />
  </button>
  <button v-if="!borde" class="">
    <img :src="ruta" :alt="altText" class="min-w-8 min-h-8 p-1" />
  </button>
</template>
<style scoped></style>
