<script setup>
defineProps({
  ruta: String,
  altText: String,
});
</script>
<template>
  <div
    class="rounded-full overflow-hidden flex justify-center items-center max-w-24 max-h-24 border-2"
  >
    <img :src="ruta" :alt="altText" class="size-24 object-cover bg-slate-100" />
  </div>
</template>
<style scoped></style>
