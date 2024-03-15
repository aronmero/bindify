<script setup>
defineProps({
  texto: String,
});
</script>
<template>
  <button
    class="px-1 border border-background-200 h-8 rounded-lg text-xs lg:text-base p-0 pb-1 lg:p-1 lg:min-h-8 lg:px-6"
  >
    {{ texto }}
  </button>
</template>
<style scoped></style>
