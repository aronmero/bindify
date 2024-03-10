<script setup>
defineProps({
  texto: String,
});
</script>
<template>
  <button
    class="px-10 border border-background-200 min-h-8 rounded-lg text-xs lg:text-base p-1 lg:min-h-8"
  >
    {{ texto }}
  </button>
</template>
<style scoped></style>
